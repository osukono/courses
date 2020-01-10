<template>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4" v-text="title"></h5>
            <div class="mx-md-4 py-2" style="min-height: 8rem;">
                <div v-for="sentence in sentences">
                    <span style="font-size: 1rem;" v-html="sentence"></span>
                </div>
                <div v-if="state === states.mounted">
                    <span style="font-size: 1rem;">
                        {{ this.locale['instruction'] }}
                    </span>
                </div>
            </div>
            <div class="mt-4 d-flex">
                <div>
                    <button @click="actionClicked" v-text="actionLabel"
                            class="btn btn-link btn-upper text-info"></button>
                    <button v-if="state === states.listeningFinished" @click="practiceClicked"
                            class="btn btn-link btn-upper text-info">
                        {{ this.locale['practice'] }}
                    </button>
                    <button v-if="state === states.practiceFinished && continueUrl !== undefined"
                            @click="continueClicked"
                            class="btn btn-link btn-upper text-info">
                        {{ this.locale['continue'] }}
                    </button>
                </div>
                <div class="form-inline ml-auto">
                    <transition name="fade">
                        <input style="max-width: 100px" type="range" class="form-control-range form-control-sm"
                               id="volume" :value="volume * 100" @input="changeVolume" @change="saveVolume"
                               v-show="showVolume">
                    </transition>
                    <button class="btn btn-sm btn-link text-info mr-1" @click="showVolume = !showVolume">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-volume-2">
                            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                            <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                        </svg>
                    </button>
                    <button class="btn btn-sm btn-link btn-upper text-info" @click="changeSpeed"
                            v-text="speedLabel"></button>
                </div>
            </div>
            <audio ref="player" @canplay="audioCanPlay" @ended="audioEnded">
                <source :src=audioSrc>
            </audio>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CoursePlayer",

        data() {
            return {
                audio: [],
                state: '',
                states: {
                    mounted: 'mounted',
                    started: 'started',
                    paused: 'paused',
                    listeningFinished: 'listeningFinished',
                    practiceFinished: 'practiceFinished'
                },
                actions: {
                    print: 'print',
                    load: 'load',
                    play: 'play',
                    wait: 'wait',
                    pause: 'pause',
                    clear: 'clear',
                    finish: 'finish'
                },
                speeds: {
                    slower: 'slower',
                    normal: 'normal',
                    faster: 'faster'
                },
                activities: {
                    listening: 'listening',
                    practice: 'practice'
                },
                sentences: [],

                commands: [],
                listening: [],
                practice: [],

                progress: 0,
                waiting: false,

                audioSrc: '',
                audioDuration: 0,
                audioDurations: [],

                showVolume: false,

                volume: undefined,
                speed: undefined,
            }
        },

        props: {
            title: String,
            exercises: String,
            review: String,
            progressUrl: String,
            continueUrl: String,
            storageUrl: String,
            settingsUrl: String,
            encodedLocale: String,
            initialVolume: String,
            initialSpeed: String,
        },

        computed: {
            locale: function() {
                return JSON.parse(this.encodedLocale);
            },

            actionLabel: function () {
                switch (this.state) {
                    case this.states.mounted:
                        return this.locale['start'];
                    case this.states.started:
                        return this.locale['pause'];
                    case this.states.paused:
                        return this.locale['resume'];
                    case this.states.listeningFinished:
                    case this.states.practiceFinished:
                        return this.locale['repeat'];
                }
            },

            speedLabel: function () {
                switch (this.speed) {
                    case this.speeds.slower:
                        return this.locale['speed.slower'];
                    case this.speeds.normal:
                        return this.locale['speed.normal'];
                    case this.speeds.faster:
                        return this.locale['speed.faster'];
                }
            },

            volumeLevel: function () {
                if (this.volume === 0)
                    return 'volume-x';
                else if (this.volume <= 0.5)
                    return 'volume-1';
                else return 'volume-2';
            },

            speedMultiplier: function () {
                switch (this.speed) {
                    case this.speeds.slower:
                        return 1.35;
                    case this.speeds.normal:
                        return 1;
                    case this.speeds.faster:
                        return 0.65;
                    default:
                        return 1;
                }
            }
        },

        methods: {
            actionClicked: function () {
                switch (this.state) {
                    case this.states.mounted:
                        this.start();
                        break;
                    case this.states.started:
                        this.pause();
                        break;
                    case this.states.paused:
                        this.resume();
                        break;
                    case this.states.listeningFinished:
                    case this.states.practiceFinished:
                        this.repeat();
                        break;
                }
            },

            practiceClicked: function () {
                this.commands = this.practice;
                this.start();
            },

            continueClicked: function () {
                window.location.href = this.continueUrl;
            },

            changeSpeed: function () {
                switch (this.speed) {
                    case this.speeds.slower:
                        this.speed = this.speeds.normal;
                        break;
                    case this.speeds.normal:
                        this.speed = this.speeds.faster;
                        break;
                    case this.speeds.faster:
                        this.speed = this.speeds.slower;
                        break;
                }

                this.saveSpeed();
            },

            saveSpeed: function () {
                if (this.settingsUrl !== undefined) {
                    axios.post(this.settingsUrl, {
                        speed: this.speed
                    });
                }
            },

            changeVolume: function (event) {
                this.volume = event.target.value / 100;
                this.$refs.player.volume = this.volume;
            },

            saveVolume: function () {
                if (this.settingsUrl !== undefined) {
                    axios.post(this.settingsUrl, {
                        volume: this.volume
                    });
                }
            },

            audioCanPlay: function () {
                this.audioDuration = this.$refs.player.duration;
                this.next();
            },

            audioEnded: function () {
                if (this.audioDurations[this.audioSrc] === undefined) {
                    this.audioDurations[this.audioSrc] = this.$refs.player.duration;
                }
                this.next();
            },

            start: function () {
                this.progress = 0;
                this.state = this.states.started;
                this.next();
            },

            pause: function () {
                this.state = this.states.paused;
            },

            resume: function () {
                this.state = this.states.started;
                if (!this.waiting)
                    this.next();
            },

            finishListening: function () {
                this.state = this.states.listeningFinished;
            },

            finishPractice: function () {
                if (this.progressUrl !== undefined) {
                    axios.get(this.progressUrl)
                        .catch(error => {
                            this.messages = [
                                this.locale['progress.fail'],
                                error.response
                            ];
                        })
                        .finally(() => {
                            this.state = this.states.practiceFinished;
                        });
                }
            },

            repeat: function () {
                this.start();
            },

            next: function () {
                if (this.state !== this.states.started || this.progress >= this.commands.length) {
                    return;
                }

                let command = this.commands[this.progress++];

                switch (command.action) {
                    case this.actions.print:
                        this.sentences.push(command.text);
                        this.next();
                        break;
                    case this.actions.load:
                        this.audioSrc = command.audio;
                        this.$refs.player.load();
                        break;
                    case this.actions.play:
                        this.$refs.player.play();
                        break;
                    case this.actions.wait:
                        let duration = this.audioDurations[this.audioSrc] !== undefined ? this.audioDurations[this.audioSrc] : this.audioDuration;
                        setTimeout(function () {
                            this.waiting = false;
                            this.next();
                        }.bind(this), duration * 1000 * command.coefficient * this.speedMultiplier);
                        this.waiting = true;
                        break;
                    case this.actions.pause:
                        setTimeout(function () {
                            this.waiting = false;
                            this.next();
                        }.bind(this), command.duration * this.speedMultiplier);
                        this.waiting = true;
                        break;
                    case this.actions.clear:
                        this.sentences = [];
                        this.next();
                        break;
                    case this.actions.finish:
                        if (command.activity === this.activities.listening)
                            this.finishListening();
                        else if (command.activity === this.activities.practice)
                            this.finishPractice();
                        break;
                }
            },

            normalize: function (str) {
                str = str.replace(/(.*?)(\[)(.*?)(])(.*?)/g, '$1<strong>$3</strong>$5');
                str = str.replace(/(^- )/, '\u2014 ');
                str = str.replace(/( - )/g, ' \u2013 ');

                return str;
            },

            showText: function (commands, text) {
                commands.push({action: this.actions.print, text: this.normalize(text)});
            },

            playAudio: function (commands, audio) {
                commands.push({action: this.actions.load, audio: this.storageUrl + audio});
                commands.push({action: this.actions.play});
                commands.push({action: this.actions.wait, coefficient: 0.4});
            },

            addListening: function (exercise) {
                this.listening.push({action: this.actions.clear});

                exercise['fields'].forEach(function (field) {
                    this.showText(this.listening, field['value']);
                    this.playAudio(this.listening, field['audio']);

                    if (field['identifier'] === 'translation') {
                        this.showText(this.listening, field['translation']['value']);
                        this.playAudio(this.listening, field['translation']['audio']);
                    }
                }.bind(this));

                this.listening.push({action: this.actions.pause, duration: 700});
            },

            addPractice: function (exercise, delay) {
                this.practice.push({action: this.actions.clear});

                exercise['fields'].forEach(function (field) {
                    if (field['identifier'] === 'translation') {
                        this.showText(this.practice, field['translation']['value']);
                        this.playAudio(this.practice, field['translation']['audio']);

                        this.practice.push({action: this.actions.load, audio: this.storageUrl + field['audio']});
                        this.practice.push({action: this.actions.wait, coefficient: delay});
                        this.showText(this.practice, field['value']);
                        this.practice.push({action: this.actions.play});
                        this.practice.push({action: this.actions.wait, coefficient: 0.4});
                    } else {
                        this.showText(this.practice, field['value']);
                        this.playAudio(this.practice, field['audio']);
                    }
                }.bind(this));

                this.practice.push({action: this.actions.pause, duration: 700});
            },

            shuffle: function (array) {
                let j, x, i;

                for (i = array.length - 1; i > 0; i--) {
                    j = Math.floor(Math.random() * (i + 1));
                    x = array[i];
                    array[i] = array[j];
                    array[j] = x;
                }

                return array;
            },

            preloadAudio: function (array) {
                //https://stackoverflow.com/questions/31060642/preload-multiple-audio-files
                for (let x = 0; x < array.length; x++) {
                    array[x]['fields'].forEach(async function (field) {
                        this.audio[field['audio']] = new Audio();
                        this.audio[field['audio']].src = this.storageUrl + field['audio'];
                        // this.audio[field['audio']] = await fetch(this.storageUrl + field['audio']).then(r => r.blob());

                        if (field['identifier'] === 'translation') {
                            this.audio[field['audio']] = new Audio();
                            this.audio[field['audio']].src = this.storageUrl + field['translation']['audio'];
                        }
                        // this.audio[field['translation']['audio']] = await fetch(this.storageUrl + field['translation']['audio']).then(r => r.blob());
                    }.bind(this));
                }
            }
        },

        mounted() {
            let review = this.review !== undefined ? JSON.parse(this.review) : [];
            let exercises = this.exercises !== undefined ? JSON.parse(this.exercises) : [];

            // this.preloadAudio(review);
            // this.preloadAudio(exercises);

            for (let x = 0; x < review.length; x++) {
                this.addListening(review[x]);

                let array = [];
                array.push(review[(x + 1) % review.length]);
                array.push(review[(x + 2) % review.length]);
                this.shuffle(array);
                array.forEach(function (exercise) {
                    this.addListening(exercise);
                }.bind(this));

                this.addListening(review[(x + 3) % review.length]);
            }

            for (let x = 0; x < exercises.length; x++) {
                this.addListening(exercises[x]);

                let array = [];
                array.push(exercises[(x + 1) % exercises.length]);
                array.push(exercises[(x + 2) % exercises.length]);
                array.push(exercises[(x + 3) % exercises.length]);
                this.shuffle(array);
                array.forEach(function (exercise) {
                    this.addListening(exercise);
                }.bind(this));

                this.addListening(exercises[(x + 4) % exercises.length]);
            }

            this.listening.push({action: this.actions.finish, activity: this.activities.listening});

            let delays = [];
            for (let x = 0; x < exercises.length; x++)
                delays.push(2.3);

            for (let x = 0; x < exercises.length; x++) {
                this.addPractice(exercises[x], delays[x]);
                delays[x] -= 0.15;
                this.addPractice(exercises[(x + 2) % exercises.length], delays[(x + 2) % exercises.length]);
                delays[(x + 2) % exercises.length] -= 0.15;
                this.addPractice(exercises[(x + 5) % exercises.length], delays[(x + 5) % exercises.length]);
                delays[(x + 5) % exercises.length] -= 0.15;
            }

            review.forEach(function (exercise) {
                this.addPractice(exercise, 2.0);
            }.bind(this));

            this.practice.push({action: this.actions.finish, activity: this.activities.practice});

            this.commands = this.listening;
            // this.commands = this.practice;

            this.volume = (this.initialVolume !== undefined) ? this.initialVolume : 0.7;
            this.$refs.player.volume = this.volume;

            this.speed = (this.initialSpeed !== undefined) ? this.initialSpeed : this.speeds.normal;

            this.state = 'mounted';
        }
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
