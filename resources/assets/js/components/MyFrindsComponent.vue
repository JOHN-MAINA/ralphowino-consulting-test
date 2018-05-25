<template>
    <div>
        <h3 class="h3">My Friends</h3>
        <!--<div v-for="friend in friends" class="row align-items-center my-4">-->
            <!--<div class="col">{{ friend.name }}</div>-->
            <!--<div class="col"><button class="btn btn-info">Send Request</button></div>-->
        <!--</div>-->

        {{ friends }}
    </div>
</template>

<script>
    import http from '../mixins/http';
    export default {
        created: function () {
            this.fetchFriends();
        },
        computed: {
            friends () {
                this.$store.state.friends;
            }
        },
        methods: {
            fetchFriends: function () {
                http.get('friends').then(
                     (data) => {
                        this.$store.state.friends = data;
                        console.log(this.$store.state.friends);
                    },
                    (error) => {
                        console.log(error)
                    }
                )
            }
        }
    }
</script>