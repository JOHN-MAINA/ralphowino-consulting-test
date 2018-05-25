<template>
    <div>
        <h3>Friend Requests Component</h3>

        <div v-for="request in friendRequests" class="row align-items-center my-4">
            <div class="col">{{ request.name }}</div>
            <div class="col"><button class="btn btn-info" @click="sendRequest(request.id)">Accept Request</button></div>
        </div>
    </div>
</template>

<script>
    import http from '../mixins/http';
    export default {
        created: function () {
            this.fetchFriendRequests();
        },
        computed: {
            friendRequests () {
                return this.$store.state.friendRequests;
            }
        },
        methods: {
            fetchFriendRequests: function () {
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
            }
        }
    }
</script>