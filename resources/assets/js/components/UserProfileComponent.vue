<template>
    <div>
        <div class="row my-4 justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card">
                    <div class="card-header">
                        <h3>User Profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 text-center">
                                <div class="avatar-div">
                                    <img src="/images/avatar.png" class="img-fluid"/>
                                </div>
                                <div>
                                    {{ user.name }}
                                    {{ user.email }}
                                </div>
                            </div>
                            <div class="col-6">
                                <span v-if="friendsCount > 1">
                                    {{ friendsCount }} Friends
                                </span>
                                <span v-else="">
                                    {{ friendsCount }} Friend
                                </span>
                            </div>
                        </div>
                        <button @click="goBack" class="btn btn-primary">Go Back</button>
                        <button @click="fetchFriends" class="btn btn-info">View Friends</button>

                        <div v-for="friend in friends" class="row align-items-center my-4">
                            <div class="col">
                                <router-link :to="'/profile/' + friend.id">
                                    <div class="row align-items-center">
                                        <div class="col profile">
                                            <img src="/images/avatar.png" class="img-fluid rounded-circle"/>
                                        </div>
                                        <div class="col">{{ friend.name }}</div>
                                    </div>
                                </router-link>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import http from '../mixins/http';
    export default {
        data(){
            return {
                user: {},
                friends: [],
                friendsCount: 0
            }
        },
        mounted() {
           this.fetchUser();
        },
        watch: {
            // call again the method if the route changes forcing the component to re-render
            '$route': 'fetchUser'
        },
        methods: {
            goBack: function () {
                this.$router.go(-1)
            },
            fetchUser: function(){
                http.get('users/user/' + this.$route.params.id).then(
                    (user) => {
                        this.user = user;
                        this.friends = [];
                        this.getFriendsCount();
                    },
                    (error) => {
                        console.log(error);
                    }
                )
            },
            fetchFriends: function () {
                http.get('friends/' + this.$route.params.id).then(
                    (friends) => {
                        this.friends = friends;
                    },
                    (error) => {
                        console.log(error);
                    }
                )
            },
            
            getFriendsCount: function () {
                http.get('friends/count/' + this.$route.params.id).then(
                    (friendsCount) => {
                        this.friendsCount = parseInt(friendsCount);
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