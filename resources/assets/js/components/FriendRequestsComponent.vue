<template>
    <div>
        <h3>Friend Requests Component</h3>

        <div v-for="request in requests" class="row align-items-center my-4">
            <div class="col">{{ request.name }}</div>
            <div class="col"><button class="btn btn-info">Accept Request</button></div>
        </div>
    </div>
</template>

<script>
    import http from '../mixins/http';
    export default {
        data (){
            return {
                requests: []
            }
        },
        mounted: function () {
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
                        data.forEach((request) => {
                            http.get('users/user/' + request.sender_id).then(
                                (data) => {
                                    this.requests.push(data);
                                },
                                (error) => {
                                    console.log(error);
                                }
                            )
                        });
                        console.log(this.requests);
                    },
                    (error) => {
                        console.log(error)
                    }
                )
            }
        }
    }
</script>