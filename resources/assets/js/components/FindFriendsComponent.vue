<template>
    <div>
        <div v-for="user in users.data" class="row align-items-center my-4">
            <div class="col">{{ user.name }}</div>
            <div class="col"><button class="btn btn-info" @click="sendRequest(user.id)" :disabled="isFriendRequestSent(user.id)">Send Request</button></div>
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
            fetchUsers: function () {
                http.get('friends/find').then(
                    (data) => {
                        this.fetchFriendRequests();
                        this.users = data;
                    },
                    (error) => {
                        console.log(error)
                    }
                )
            },

            fetchFriendRequests: function () {
                http.get('friends/requests').then(
                    (data) => {
                        data.forEach((request) => {
                            http.get('users/user/' + request.recipient_id).then(
                                (data) => {
                                    this.friendRequests.push(data);
                                },
                                (error) => {

                                }
                            )
                        });
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
                console.log(this.friendRequests)
                let requestSent = false;
                this.friendRequests.forEach((request) => {
                        if(request.id === id){
                            requestSent = true;
                        }
                });
                return requestSent;
            }
        }
    }
</script>