<template>
    <div v-if="status !== statuses.finished || messages.length > 0">
        <div class="h5 text-muted">{{ title }}</div>
        <div class="progress" v-if="status !== statuses.finished">
            <div class="progress-bar bg-info" role="progressbar" :style=style :aria-valuenow=progressNow
                 aria-valuemin="0" :aria-valuemax=progressMax></div>
        </div>
        <div class="overflow-auto card mt-2" v-if="messages.length > 0" style="max-height: 200px">
            <div class="card-body">
                <div v-for="message in messages">
                    <span v-text="message"></span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "JobStatus",

        data() {
            return {
                title: undefined,
                progressNow: 0,
                progressMax: 0,
                progress_percentage: 0,
                interval: 0,
                messages: [],

                statuses: {
                    queued: 'queued',
                    executing: 'executing',
                    finished: 'finished',
                    failed: 'failed'
                },
                status: undefined,
            }
        },

        props: {
            jobId: String,
            jobStatusUrl: String,
            redirectUrl: String,
        },

        computed: {
            style: function () {
                return 'width: ' + this.progress_percentage + '%';
            },
        },

        methods: {
            update: function () {
                axios.get(this.jobStatusUrl)
                    .then(response => {
                        this.title = response.data.displayName;
                        this.progressNow = response.data.progressNow;
                        this.progressMax = response.data.progressMax;
                        this.progress_percentage = response.data.progress_percentage;
                        this.messages = response.data.output;
                        this.status = response.data.status;

                        if (this.status === this.statuses.finished || this.status === this.statuses.failed) {
                            clearInterval(this.interval);
                        }

                        if (this.status === this.statuses.finished && this.redirectUrl !== undefined && this.messages.length === 0) {
                            window.location.href = this.redirectUrl;
                        }
                    });
            }
        },

        mounted() {
            this.interval = setInterval(this.update, 200);
        }
    }
</script>

<style scoped>

</style>
