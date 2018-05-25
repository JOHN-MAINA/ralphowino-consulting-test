<template>
    <div>
        <div v-for="user in users" class="row align-items-center my-4">
            <div class="col">{{ user.name }}</div>
            <div class="col"><button class="btn btn-info" @click="sendRequest(user.id)" :disabled="isFriendRequestSent(user.id)">Send Request</button></div>
        </div>
    </div>
</template>

<script>
    import http from '../mixins/http';
    export default {
        created: function () {
            this.fetchUsers(this);
        },
        computed: {
            users () {
                return this.$store.state.users.data;
            }
        },
        methods: {
            fetchUsers: (vm) => {
                console.log(vm);
                http.get('friends/find').then(
                    (data) => {
//                        vm.fetchFriendRequests();
//                        vm.$store.state.users = data;
                        console.log(vm.$store.state.users.data)
                    },
                    (error) => {
                        console.log(error)
                    }
                )
            },
            fetchFriendRequests: () => {
                http.get('friends/requests').then(
                    (data) => {
                        this.$store.state.friendRequests = [];
                        data.forEach((request) => {
                            http.get('users/user/' + request.sender_id).then(
                                (data) => {
                                    console.log(data);
                                    this.$store.state.friendRequests.push(data);
                                },
                                (error) => {

                                }
                            )
                        });
                        console.log(data);
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
            isFriendRequestSent: (id) => {
                let requestSent = false;
                this.$store.state.friendRequests.forEach((request) => {

                });
                return requestSent;
            }
        }
    }
</script>