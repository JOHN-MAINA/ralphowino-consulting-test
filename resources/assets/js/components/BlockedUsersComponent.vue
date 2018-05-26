<template>
    <div>
        <div class="row my-4">
            <div class="col-3">
                <friends-nav></friends-nav>
            </div>
            <div class="col-9">
                <h3>Blocked Users</h3>
                <div v-for="user in blockedUsers" class="row align-items-center my-4">
                    <div class="col">{{ user.name }}</div>
                    <div class="col"><button class="btn btn-info" @click="unblockFriend(user.id)">Unblock</button></div>
                </div>
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