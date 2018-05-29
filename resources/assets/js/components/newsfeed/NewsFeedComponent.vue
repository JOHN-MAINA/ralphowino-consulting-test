<template>
    <div>
        <div class="row my-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="createNewPost">
                            <div class="form-row align-items-center">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="post">New Post</label>
                                        <textarea v-model="post" class="form-control" id="post"
                                                  rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-2" v-for="feed in feedActivity">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <router-link :to=" '/profile/' + feed.post.user.id">
                            <div class="row align-items-center">
                                <div class="col profile">
                                    <img src="/images/avatar.png" class="img-fluid rounded-circle"/>
                                </div>
                                <div class="col">{{ feed.post.user.name }}</div>
                            </div>
                        </router-link>

                    </div>
                    <div class="card-body">
                        <p>
                            {{ feed.post.body }}
                        </p>
                        <button v-if="feed.post.user_id == loggedInUser.identifier" class="btn btn-primary" @click="deletePost(feed.activity.id, feed.post.id)"> Delete </button>
                    </div>
                </div>
            </div>
        </div>

        <nav aria-label="navigation">
            <ul class="pagination">
                <li v-bind:class="[{disabled: next_page == 1 || next_page == 2}]" class="page-item">
                    <a class="page-link" @click="paginateActivities(-1)" href="#">
                        Previous
                    </a>
                </li>
                <li class="page-item"><a class="page-link text-dark" href="#"> Activities </a></li>
                <li v-bind:class="[{disabled: noMoreActivities}]" class="page-item">
                    <a class="page-link" @click="paginateActivities(1)" href="#">
                        Next
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</template>

<script>
    import http from '../../mixins/http';
    export default {
        data() {
            return {
                post: '',
                feedActivity: [],
                next_page: 1,
                loggedInUser: {},
                noMoreActivities: false
            }
        },
        created(){
            this.loggedInUser = JSON.parse(localStorage.getItem('user'));
            this.fetchFeedActivity();
        },
        methods: {
            deletePost: function (acticity_id, post_id) {
                http.get('post/delete/' + post_id + '/' + acticity_id + '/' + this.loggedInUser.identifier).then(
                    (data) => {
                        this.feedActivity = this.feedActivity.filter((feed) => {
                            return feed.post.id != post_id;
                        })
                    },
                    (error) => {
                        console.log(error);
                    }
                )
            },
            paginateActivities: function (direction) {
                this.next_page = this.next_page + direction;
                this.fetchFeedActivity();
            },
            fetchFeedActivity: function () {
                let user = JSON.parse(localStorage.getItem('user'));
                http.get('post/' + user.identifier + '/' + this.next_page).then(
                    (feed) => {
                        if(feed.posts.length === 0) {
                            this.noMoreActivities = !this.noMoreActivities;
                        }
                        feed.posts.forEach((post) => {
                            this.feedActivity.push(post);
                        });
                        this.next_page = feed.next_page;

                    },
                    (error) => {
                        console.log(error);
                    }
                )

            },
            createNewPost: function () {
                let user = JSON.parse(localStorage.getItem('user'));
                let data = {
                    "user_id": user.identifier,
                    "body": this.post
                };
                http.post('post', data).then (
                    (post) => {
                        console.log(post);
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
</style>e>