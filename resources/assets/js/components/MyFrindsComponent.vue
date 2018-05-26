<template>
    <div>
        <div class="row my-4">
            <div class="col-3">
                <friends-nav></friends-nav>
            </div>
            <div class="col-9">
                <h3 class="h3">My Friends</h3>
                <div v-for="friend in friends" class="row align-items-center my-4">
                    <div class="col">{{ friend.name }}</div>
                    <div class="col"><button class="btn btn-info" @click="blockFriend(friend.id)">Block</button></div>
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
        data(){
            return {
                friends: []
            }
        },
        created: function () {
            this.fetchFriends();
        },
        methods: {
            fetchFriends: function () {
                http.get('friends').then(
                     (data) => {
                        this.friends = data;
                    },
                    (error) => {
                        console.log(error)
                    }
                )
            },
            blockFriend: function (friend_id) {
                http.get('friends/block/' + friend_id).then(
                    (data) => {
                        this.friends = this.friends.filter(function(friend) {
                            return friend.id !== friend_id;
                        })
                    },
                    (error) => {
                        console.log(error)
                    }
                )
            }
        }
    }
</script>