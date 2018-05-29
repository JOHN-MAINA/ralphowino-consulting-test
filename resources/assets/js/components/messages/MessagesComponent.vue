<template>
    <div>
        <h2>Messages</h2>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-center"><button class="btn btn-info right" @click="fetchFriends">New Message</button></div>
                            <div v-if="fetchedFriends" class="col-md-6">
                                <div class="form-group form-control-sm">
                                    <label for="participants">Select User / Users </label>
                                    <select v-model="participants" multiple class="form-control" id="participants">
                                        <option v-for="friend in friends" :value="friend.id"> {{ friend.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="participants.length >= 1" class="row my-4 align-items-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="startThread">
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" v-model="subject" class="form-control" id="subject" placeholder="Subject" required>
                            </div>
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

        <div v-for="thread in threads.data" class="row align-items-center my-4">
            <div class="col">
                <router-link :to="'/messages/thread/' + thread.id ">
                    <div class="row align-items-center">
                        <div class="col profile">
                            <img src="/images/avatar.png" class="img-fluid rounded-circle"/>
                        </div>
                        <div class="col">{{ thread.user.name }}</div>
                        <div class="col">{{ thread.latest_message.body }}</div>
                        <div class="col">{{ thread.subject }}</div>
                    </div>
                </router-link>

            </div>
        </div>

        <nav aria-label="navigation">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !threads.prev_page_url}]" class="page-item">
                    <a class="page-link" @click="fetchThreads((users.current_page - 1))" href="#">
                        Previous
                    </a>
                </li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#"> {{ threads.current_page }} of {{ threads.last_page }}</a></li>
                <li v-bind:class="[{disabled: !threads.next_page_url}]" class="page-item">
                    <a class="page-link" @click="fetchThreads((threads.current_page + 1))" href="#">
                        Next
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</template>

<script>
    import http from '../../mixins/http';
    export default {
        data(){
            return {
                threads: [],
                participants: [],
                friends: [],
                users: [],
                messages: [],
                fetchedFriends: false,
                message: '',
                subject: ''
            }
        },
        watch: {
            // Threads thread have been updated
            //'threads': 'updateThreads'
        },
        mounted(){
            //Fetch first page
            this.fetchThreads(1);
        },
        methods: {
            fetchThreads: function (page) {
                let user = JSON.parse(localStorage.getItem('user'));
                http.get('messages/threads/' + user.identifier + '?page=' + page).then(
                    (threads) => {
                        this.threads = threads;
                    },
                    (error) => {
                        console.log(error);
                    }
                )

            },
            fetchFriends: function () {
                http.get('friends').then(
                    (data) => {
                        this.friends = data;
                        this.fetchedFriends = !this.fetchedFriends;
                    },
                    (error) => {
                        console.log(error)
                    }
                )
            },
            startThread: function () {
                let user = JSON.parse(localStorage.getItem('user'));
                let postData = {
                    message: this.message,
                    participants: this.participants,
                    sender_id: user.identifier,
                    subject: this.subject
                };

                http.post('messages/create', postData).then(
                    (data) => {
                        this.threads = data;
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