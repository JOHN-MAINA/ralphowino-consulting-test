<template>
    <div>
        <h3>User Profile Component</h3>
        <div v-for="user in blockedUsers" class="row align-items-center my-4">
            <div class="col">{{ user.name }}</div>
            <div class="col"><button class="btn btn-info" @click="unblockFriend(user.id)">Unblock</button></div>
        </div>
    </div>
</template>

<script>
    import http from '../mixins/http';
    export default {
        data() {
            return {
                blockedUsers: []
            }
        },
        created:function () {
            this.fetchBlockedUsers();
        },
        methods: {
            fetchBlockedUsers: function () {
                http.get('friends/blocked').then(
                    (data) => {
                        data.forEach((blockedFriendship) => {
                            http.get('users/user/' + blockedFriendship.recipient_id).then(
                                (data) => {
                                    this.blockedUsers.push(data);
                                },
                                (error) => {

                                }
                            )
                        });
                    },
                    (error) => {
                        console.log(error);
                    }
                )
            },
            unblockFriend: function (friend_id) {
                http.get('friends/unblocked/' + friend_id).then(
                    (data) => {
                        this.blockedUsers = [];
                        console.log(data);
                        data.forEach((blockedFriendship) => {
                            http.get('users/user/' + blockedFriendship.recipient_id).then(
                                (data) => {
                                    this.blockedUsers.push(data);
                                },
                                (error) => {
                                    console.log(error);
                                }
                            )
                        });
                    },
                    (error) => {

                    }
                )
            }
        }
    }
</script>