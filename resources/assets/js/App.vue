<template>
    <div>
        <div v-if="!isAuthComponent">
            <nav class="navbar navbar-expand-lg navbar-dark bg-info">
                <a class="navbar-brand" href="#">Social Network</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <router-link class="nav-link" to="/friends">Friends <span class="sr-only"></span></router-link>
                        </li>
                        <li class="nav-item active">
                            <router-link class="nav-link" to="/messages">Messages <span class="sr-only"></span></router-link>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul v-if="userName" class="navbar-nav ml-auto">
                        <li class="nav-item active">
                           <a class="nav-link" href="#"> Messages <span class="badge badge-light">{{ unreadCount }}</span></a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ userName }}     <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <router-link class="dropdown-item" to="/logout">
                                    logout
                                </router-link>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container">
                <transition name="fade">
                    <router-view></router-view>
                </transition>
            </div>
        </div>

        <!-- Auth components -->
        <div v-if="isAuthComponent">
            <div>
                <transition name="fade">
                    <router-view></router-view>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
    import http from './mixins/http';
    let user = JSON.parse(localStorage.getItem('user'));
    export default{
        data(){
            return {
                isAuthComponent: false,
                userName: '',
                userEmail: '',
                unreadCount: 0
            }
        },
        created: function () {
            let routeName = this.$route.name;
            if (user){
                this.userName = user.name;
                this.userEmail = user.email;
            }
            if (routeName == 'Login' || routeName == 'Register'|| routeName == 'Reset_Pass' || routeName == 'Request_Token') {
                this.isAuthComponent = true;
            }
            this.getUnReadMessages();
        },
        methods: {
            getUnReadMessages: function () {
                http.get('messages/unread/' + user.identifier).then(
                    (unreadCount) => {
                        this.unreadCount = unreadCount;
                    },
                    (error) => {
                        console.log(error)
                    }
                )
            }
        }
    }
</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>