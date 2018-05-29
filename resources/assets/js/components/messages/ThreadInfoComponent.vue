<template>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thread Information  Subject: {{ thread.subject }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div v-for="participant in participants" class="row align-items-center my-4">
                    <div class="col">
                        <router-link :to=" '/profile/' + participant.user.id">
                            <div class="row align-items-center">
                                <div class="col profile">
                                    <img src="/images/avatar.png" class="img-fluid rounded-circle"/>
                                </div>
                                <div class="col">{{ participant.user.name }}</div>
                            </div>
                        </router-link>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</template>

<script>
    import http from '../../mixins/http';

    export default {
        data() {
            return {
                participants: [],
                thread: {}
            }
        },
        created() {
            this.fetchThreadParticipants();
        },
        methods: {
            fetchThreadParticipants: function () {
                http.get('messages/thread/participants/' + this.$route.params.id).then(
                    (threadInfo) => {
                        this.participants = threadInfo.participants;
                        this.thread = threadInfo.thread;
                    },
                    (error) => {
                        console.log(error);
                    }
                )
            }
        }

    }
</script>

<style scoped>
    .profile {
        height: 50px;
    }

    .img-fluid {
        max-height: 100%;
    }
</style>