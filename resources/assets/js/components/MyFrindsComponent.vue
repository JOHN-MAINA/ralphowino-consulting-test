<template>
    <h3>My Friends Component</h3>
</template>

<script>
    import http from '../mixins/http';
    export default {
        created: function () {
            this.fetchFriends();
        },
        methods: {
            fetchFriends: function () {
                http.get('friends').then(
                     (data) => {
                        this.$store.state.friends = data;
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