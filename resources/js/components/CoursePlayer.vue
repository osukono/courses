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
            <div class="mt-4">
                <button @click="actionClicked" v-text="actionLabel"
                        class="btn btn-link btn-upper text-info"></button>
                <button v-if="state === states.listeningFinished" @click="practiceClicked"
                        class="btn btn-link btn-upper text-info">
                    {{ this.locale['practice'] }}
                </button>
                <button v-if="state === states.practiceFinished && continueUrl !== undefined" @click="continueClicked"
                        class="btn btn-link btn-upper text-info">
                    {{ this.locale['continue'] }}
                </button>
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
                locale: [],
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
            }
        },

        props: {
            title: String,
            exercises: String,
            review: String,
            progressUrl: String,
            continueUrl: String,
            storageUrl: String,
            localization: String,
        },

        computed: {
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

            audioCanPlay: function () {
                this.audioDuration = this.$refs.player.duration;
                this.next();
            },

            audioEnded: function () {
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
                        setTimeout(function () {
                            this.waiting = false;
                            this.next();
                        }.bind(this), this.audioDuration * 1000 * command.coefficient);
                        this.waiting = true;
                        break;
                    case this.actions.pause:
                        setTimeout(function () {
                            this.waiting = false;
                            this.next();
                        }.bind(this), command.duration);
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

            addPractice: function (exercise) {
                this.practice.push({action: this.actions.clear});

                exercise['fields'].forEach(function (field) {
                    if (field['identifier'] === 'translation') {
                        this.showText(this.practice, field['translation']['value']);
                        this.playAudio(this.practice, field['translation']['audio']);

                        this.practice.push({action: this.actions.load, audio: this.storageUrl + field['audio']});
                        this.practice.push({action: this.actions.wait, coefficient: 2});
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
                        this.audio[field['audio']]  = new Audio();
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
            this.locale = JSON.parse(this.localization);
            let review = this.review !== undefined ? JSON.parse(this.review) : [];
            let exercises = this.exercises !== undefined ? JSON.parse(this.exercises) : [];

            this.preloadAudio(review);
            this.preloadAudio(exercises);

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

            for (let x = 0; x < exercises.length; x++) {
                this.addPractice(exercises[x]);
                this.addPractice(exercises[(x + 2) % exercises.length]);
                this.addPractice(exercises[(x + 5) % exercises.length]);
            }

            review.forEach(function (exercise) {
                this.addPractice(exercise);
            }.bind(this));

            this.practice.push({action: this.actions.finish, activity: this.activities.practice});

            this.commands = this.listening;

            this.$refs.player.volume = 1;

            this.state = 'mounted';
        }
    }
</script>

<style scoped>

</style>
