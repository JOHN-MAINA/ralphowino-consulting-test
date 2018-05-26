<template>
    <div>
        <h3 class="h3">My Friends</h3>
        <div v-for="friend in friends" class="row align-items-center my-4">
            <div class="col">{{ friend.name }}</div>
            <div class="col"><button class="btn btn-info" @click="blockFriend(friend.id)">Block</button></div>
        </div>

    </div>
</template>

<script>
    import http from '../mixins/http';
    export default {
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