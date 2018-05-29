<template>
    <div>
        <div class="row my-4">
            <div class="col-3">
                <friends-nav></friends-nav>
            </div>
            <div class="col-9">
                <h3>Friend Requests</h3>
                <div v-for="request in requests" class="row align-items-center my-4">
                    <div class="col">{{ request.name }}</div>
                    <div class="col"><button class="btn btn-info" @click="acceptRequest(request.id)">Accept Request</button></div>
                    <div class="col"><button class="btn btn-info" @click="denyRequest(request.id)">Deny Request</button></div>
                    <div class="col"><button class="btn btn-info" @click="blockRequest(request.id)">Block User</button></div>
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
        data (){
            return {
                requests: []
            }
        },
        mounted: function () {
            this.fetchFriendRequests();
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
                    },
                    (error) => {
                        console.log(error)
                    }
                )
            },
            acceptRequest: function (id) {

                http.get('friends/request/accept/' + id).then(
                    (data) => {
                        this.requests = data;
                    },
                    (error) => {
                        console.log(error);
                    }
                );
            },
            denyRequest: function (id) {
                http.get('friends/request/deny/' + id).then(
                    (data) => {
                        this.requests = data;
                    },
                    (error) => {
                        console.log(error);
                    }
                );
            },
            blockRequest: function (id) {
                http.get('friends/block/' + id).then(
                    (data) => {
                        this.requests = data;
                    },
                    (error) => {
                        console.log(error);
                    }
                );
            }
        }
    }
</script>