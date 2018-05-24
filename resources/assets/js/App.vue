<template>
    <div>
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
            </div>
        </nav>
        <div class="container">
            <div class="row my-4">
                <div class="col-3">
                    <div class="list-group">
                        <router-link to="/friends" class="list-group-item list-group-item-action">My Friends</router-link>
                        <router-link to="/friends/find" class="list-group-item list-group-item-action">Find Friends</router-link>
                        <router-link to="/friends/requests" class="list-group-item list-group-item-action">Friend Requests</router-link>
                        <router-link to="#" class="list-group-item list-group-item-action">N/A</router-link>
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

</template>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>

<script>
import Navbar from './components/Navbar.vue';
    export default{
        components: {
            'navbar': Navbar
        }
    }
</script>