<template>
    <div>
        <div v-for="user in users.data" class="row align-items-center my-4">
            <div class="col">{{ user.name }}</div>
            <div class="col"><button class="btn btn-info" @click="sendRequest(user.id)" :disabled="isFriendRequestSent(user.id)">Send Request</button></div>
        </div>

        <div class="row">

        </div>
    </div>
</template>

<script>
    import http from '../mixins/http';
    export default {
        data () {
            return {
                users: {},
                friendRequests: []
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
                        console.log(data);
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
            sendRequest: (recipient_id) => {
                http.get('friends/request/' + recipient_id). then (
                    (data) => {
                        console.log(data)
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