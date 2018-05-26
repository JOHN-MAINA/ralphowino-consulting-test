<template>
    <div>
        <div class="row my-4">
            <div class="col-3">
                <friends-nav></friends-nav>
            </div>
            <div class="col-9">
                <div v-for="user in users.data" class="row align-items-center my-4">
                    <div class="col">{{ user.name }}</div>
                    <div class="col"><button class="btn btn-info" @click="sendRequest(user.id)" :disabled="isFriendRequestSent(user.id)">Send Request</button></div>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li v-bind:class="[{disabled: !users.prev_page_url}]" class="page-item">
                            <a class="page-link" @click="paginateUsers('friends/find?page=' + (users.current_page - 1))" href="#">
                                Previous
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link text-dark" href="#"> {{ users.current_page }} of {{ users.last_page }}</a></li>
                        <li v-bind:class="[{disabled: !users.next_page_url}]" class="page-item">
                            <a class="page-link" @click="paginateUsers('friends/find?page=' + (users.current_page + 1))" href="#">
                                Next
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>

        </div>
    </div>
</template>

<script>
    import http from '../mixins/http';
    import FriendsNav from './templates/FriendsNavComponent.vue';
    export default {
        components: {
           'friends-nav': FriendsNav
        },
        data () {
            return {
                users: {},
                friendRequests: [],
            }
        },
        created: function () {
            this.fetchUsers(this);
        },

        methods: {
            paginateUsers: function (url) {
                http.get(url).then(
                    (data) => {
                        this.fetchFriendRequests();
                        this.users = data;
                    },
                    (error) => {
                        console.log(error)
                    }
                );
            },
            fetchUsers: function () {
                http.get('friends/find').then(
                    (data) => {
                        this.fetchFriendRequests();
                        this.users = data;
                    },
                    (error) => {
                        console.log(error)
                    }
                );
            },

            fetchFriendRequests: function () {
                let user = JSON.parse(localStorage.getItem('user'));
                http.get('friends/pending_friendships/' + user.identifier ).then(
                    (data) => {
                        this.friendRequests = data;
                    },
                    (error) => {
                        console.log(error)
                    }
                )
            },
            sendRequest: function (recipient_id) {
                http.get('friends/request/' + recipient_id). then (
                    (data) => {
                        // Re-fetch friendrequests to force dom to re-render
                        this.fetchFriendRequests();
                    },
                    (error) => {
                        console.log(error)
                    }
                )
            },
            isFriendRequestSent: function (id) {
                let requestSent = false;
                this.friendRequests.forEach((request) => {
                        if(request.recipient_id === id){
                            requestSent = true;
                        }
                });
                return requestSent;
            }
        }
    }
</script>