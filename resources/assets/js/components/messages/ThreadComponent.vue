<template>
    <div>
        <div class="row my-2">
            <div class="col">
                <button class="btn btn-info" data-toggle="modal" data-target="#threadInfo">Thread Info</button>
            </div>
            <div class="modal fade" id="threadInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <thread-info></thread-info>
            </div>
            <div class="col">
                <button class="btn btn-info" @click="leaveConversation" :disabled="leftConvo">Leave Conversation</button>
            </div>
        </div>
        <div class="card my-2" v-for="message in messages">
            <div class="card-body py-1">
                <div class="row align-items-center">
                    <div class="col profile">
                        <router-link :to="'/profile/' + message.user.id"><img src="/images/avatar.png" class="img-fluid rounded-circle"/></router-link>
                    </div>
                    <div class="col"><router-link :to="'/profile/' + message.user.id">{{ message.user.name }}</router-link></div>
                    <div class="col">{{ message.body}}</div>
                </div>
            </div>
        </div>

        <div v-if="!leftConvo" class="row my-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body py-1">
                        <form @submit.prevent="sendMessage">
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea v-model="message" class="form-control" id="message" rows="3" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    import http from '../../mixins/http';
    import ThreadInfo from './ThreadInfoComponent.vue';
    export default {
        data(){
            return{
                messages: [],
                pagination: {},
                message: '',
                leftConvo: false
            }
        },
        components: {
            'thread-info': ThreadInfo
        },
        created(){
            this.fetchMessages(1)
        },
        methods: {
            leaveConversation: function () {
                let user = JSON.parse(localStorage.getItem('user'));
                http.get('participant/remove/' + this.$route.params.id + '/' + user.identifier).then(
                    (participants) => {
                        this.leftConvo = true;
                        this.$router.push({name: 'Messages'});
                    },
                    (error) => {
                        console.log(error);
                    }
                )
            },
            sendMessage: function () {
                let user = JSON.parse(localStorage.getItem('user'));
                let postData = {
                    "thread_id": this.$route.params.id,
                    "message": this.message,
                    "user_id": user.identifier
                };
                http.post('messages', postData).then(
                    (message) => {
                        this.messages.push(message);
                    },
                    (error) => {
                        console.log(error);
                    }
                )
            },
            fetchMessages: function (pageNumber) {
                let user = JSON.parse(localStorage.getItem('user'));
                http.get('messages/'+ this.$route.params.id + '/' + user.identifier + '?page=' + pageNumber).then(
                    (messages) => {
                        messages.data.reverse();
                        messages.data.forEach((message) => {
                            this.messages.push(message);
                        });
                        this.pagination = {
                            current_page: messages.current_page,
                            last_page: messages.last_page,
                            next_page_url: messages.next_page_url,
                            prev_page_url: messages.prev_page_url
                        };

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