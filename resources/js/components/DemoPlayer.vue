<template>
    <div style="background-color: #405FD3;">
        <div class="row">
            <div class="col-auto">
                <h5 class="card-title mb-4" v-text="title + ' › ' + exercisesSet.title"></h5>
            </div>
            <div class="col text-right">
                <div class="btn-group">
                    <button role="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        {{ exercisesSet.title }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#" v-for="set in exercisesSets"
                           @click="changeExercisesSet(set)">
                            {{ set.title }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
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
        <div class="mt-4 d-flex align-items-center">
            <div>
                <button @click="actionClicked" v-text="actionLabel"
                        class="btn btn-link btn-upper text-info"></button>
            </div>
            <div class="progress flex-grow-1 ml-1 ml-md-3 mr-2 mr-md-4" style="height: 2px;">
                <div class="progress-bar" style="background-color: #adb5bd;" role="progressbar"
                     :style="'width:' + (progress / progressMax) * 100  + '%;'" :aria-valuenow="progress"
                     aria-valuemin="0" :aria-valuemax="progressMax"></div>
            </div>
            <div class="form-inline ml-auto">
                <input style="max-width: 100px" type="range" class="custom-range"
                       id="volume" :value="volume * 100" @input="changeVolume"
                       v-show="showVolume">
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
</template>

<script>
    export default {
        name: "CoursePlayer",

        data() {
            return {
                audio: [],
                state: '',
                exercisesSets: [],
                exercisesSet: undefined,

                states: {
                    mounted: 'mounted',
                    started: 'started',
                    paused: 'paused',
                    finished: 'finished',
                },
                actions: {
                    print: 'print',
                    load: 'load',
                    play: 'play',
                    wait: 'wait',
                    pause: 'pause',
                    clear: 'clear',
                    finish: 'finish',
                },
                speeds: {
                    slower: 'slower',
                    normal: 'normal',
                    faster: 'faster'
                },
                sentences: [],

                progress: 0,
                waiting: false,

                audioSrc: '',

                showVolume: false,

                volume: undefined,
                speed: undefined,
            }
        },

        props: {
            translations: String,
            encodedLocale: String,
        },

        computed: {
            locale: function () {
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
                    case this.states.finished:
                        return this.locale['repeat'];
                }
            },

            speedLabel: function () {
                switch (this.speed) {
                    case this.speeds.slower:
                        return "½×";
                    case this.speeds.normal:
                        return "1×";
                    case this.speeds.faster:
                        return "1½×";
                }
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
            },

            progressMax: function () {
                return this.exercisesSet.commands.length;
            },
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
                    case this.states.finished:
                        this.repeat();
                        break;
                }
            },

            changeExercisesSet: function (set) {
                this.sentences = [];
                this.exercisesSet = set;
                this.progress = 0;
                this.state = this.states.mounted;
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
            },

            changeVolume: function (event) {
                this.volume = event.target.value / 100;
                this.$refs.player.volume = this.volume;
            },

            audioCanPlay: function () {
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

            repeat: function () {
                this.start();
            },

            next: function () {
                if (this.state !== this.states.started || this.progress >= this.exercisesSet.length) {
                    return;
                }

                let command = this.exercisesSet.commands[this.progress++];

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
                        }.bind(this), command.duration * command.coefficient * this.speedMultiplier);
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
                        this.state = this.states.finished;
                        break;
                }
            },

            normalize: function (str) {
                str = str.replace(/(.*?)(\[)(.*?)(])(.*?)/g, '$1<strong>$3</strong>$5');
                str = str.replace(/(^- )/, '\u2014 ');
                str = str.replace(/( - )/g, ' \u2013 ');

                return str;
            },

            showText: function (set, text) {
                set.commands.push({action: this.actions.print, text: this.normalize(text)});
            },

            playAudio: function (set, audio, duration) {
                set.commands.push({action: this.actions.load, audio: this.storageUrl + audio});
                set.commands.push({action: this.actions.play});
                set.commands.push({action: this.actions.wait, duration: duration, coefficient: 0.4});
            },

            addListening: function (set, exercise) {
                set.commands.push({action: this.actions.clear});

                exercise['data'].forEach(function (data) {
                    this.showText(set, data['value']);
                    this.playAudio(set, data['audio'], data['duration']);

                    if ('translation' in data) {
                        this.showText(set, data['translation']['value']);
                        this.playAudio(set, data['translation']['audio'], data['translation']['duration']);
                    }
                }.bind(this));

                set.commands.push({action: this.actions.pause, duration: 700});
            },

            addPractice: function (set, exercise, delay) {
                set.commands.push({action: this.actions.clear});

                exercise['data'].forEach(function (data) {
                    if ('translation' in data) {
                        this.showText(set, data['translation']['value']);
                        this.playAudio(set, data['translation']['audio'], data['translation']['duration']);

                        set.commands.push({action: this.actions.load, audio: this.storageUrl + data['audio']});
                        set.commands.push({action: this.actions.wait, duration: data['duration'], coefficient: delay});
                        this.showText(set, data['value']);
                        set.commands.push({action: this.actions.play});
                        set.commands.push({action: this.actions.wait, duration: data['duration'], coefficient: 0.4});
                    } else {
                        this.showText(set, data['value']);
                        this.playAudio(set, data['audio'], data['duration']);
                    }
                }.bind(this));

                set.commands.push({action: this.actions.pause, duration: 700});
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

            pattern_1: function (set, exercises) {
                for (let x = 0; x < exercises.length; x++) {
                    this.addListening(set, exercises[x]);

                    let array = [];
                    array.push(exercises[(x + 1) % exercises.length]);
                    array.push(exercises[(x + 2) % exercises.length]);
                    this.shuffle(array);
                    array.forEach(function (exercise) {
                        this.addListening(set, exercise);
                    }.bind(this));

                    this.addListening(set, exercises[(x + 3) % exercises.length]);
                }
            },

            pattern_2: function (set, exercises) {
                for (let x = 0; x < exercises.length; x++) {
                    this.addListening(set, exercises[x]);

                    let array = [];
                    array.push(exercises[(x + 1) % exercises.length]);
                    array.push(exercises[(x + 2) % exercises.length]);
                    array.push(exercises[(x + 3) % exercises.length]);
                    this.shuffle(array);
                    array.forEach(function (exercise) {
                        this.addListening(set, exercise);
                    }.bind(this));

                    this.addListening(set, exercises[(x + 4) % exercises.length]);
                }
            },

            pattern_3: function (set, exercises) {
                let delays = [];
                for (let x = 0; x < exercises.length; x++)
                    delays.push(2.3);

                for (let x = 0; x < exercises.length; x++) {
                    this.addPractice(set, exercises[x], delays[x]);
                    delays[x] -= 0.15;
                    this.addPractice(set, exercises[(x + 2) % exercises.length], delays[(x + 2) % exercises.length]);
                    delays[(x + 2) % exercises.length] -= 0.15;
                    this.addPractice(set, exercises[(x + 5) % exercises.length], delays[(x + 5) % exercises.length]);
                    delays[(x + 5) % exercises.length] -= 0.15;
                }
            },

            pattern_4: function (set, exercises) {
                exercises.forEach(function (exercise) {
                    this.addPractice(set, exercise, 2.0);
                }.bind(this));
            },

            buildCommands: function (set, exercises) {
                if ('review' in exercises)
                    this.pattern_1(set, exercises['review']);
                if ('exercises' in exercises) {
                    this.pattern_2(set, exercises['exercises']);
                    this.pattern_3(set, exercises['exercises']);
                }
                if ('review' in exercises)
                    this.pattern_4(set, exercises['review']);
            },
        },

        created() {
            let exercises = JSON.parse(this.exercises);
            for (const [key, content] of Object.entries(exercises)) {
                let set = {
                    title: content.title,
                    commands: []
                };
                this.buildCommands(set, content);
                set.commands.push({action: this.actions.finish});
                this.exercisesSets.push(set);
            }

            this.volume = 0.7;
            this.speed = this.speeds.normal;
            this.changeExercisesSet(this.exercisesSets[0]);
        },

        mounted() {
            this.$refs.player.volume = this.volume;
            this.state = this.states.mounted;
        }
    }
</script>

<style scoped>
</style>
