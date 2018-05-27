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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                post: ''
            }
        },
        methods: {
            createNewPost: function () {
                console.log(this.post);
            }
        }
    }
</script>

<style scoped>

</style>