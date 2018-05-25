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
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ userName }}     <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">
                                    logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container">
                <div class="row my-4">
                    <div class="col-3">
                        <div class="list-group">
                            <router-link to="/friends" class="list-group-item list-group-item-action">My Friends</router-link>
                            <router-link to="/friends/find" class="list-group-item list-group-item-action">Find Friends</router-link>
                            <router-link to="/friends/requests" class="list-group-item list-group-item-action">Friend Requests</router-link>
                            <router-link to="/friends/blocked" class="list-group-item list-group-item-action">Blocked Users</router-link>
                        </div>
                    </div>
                    <div class="col-9">
                        <div>
                            <transition name="fade">
                                <router-view></router-view>
                            </transition>
                        </div>
                    </div>
                </div>
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
    let user = JSON.parse(localStorage.getItem('user'));
    export default{
        data(){
            return {
                isAuthComponent: false,
                userName: user.name,
                userEmail: user.email
            }
        },
        created: function () {
            var routeName = this.$route.name;

            if (routeName == 'Login' || routeName == 'Register'|| routeName == 'Reset_Pass' || routeName == 'Request_Token') {
                this.isAuthComponent = true;
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