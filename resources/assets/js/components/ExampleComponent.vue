<template>
    <div class="row">
        <div class="col-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" href="#">My Friends</a>
                <a class="nav-link" href="#">Find Friends</a>
                <a class="nav-link" href="#">Friend Requests</a>
            </div>
        </div>
        <div class="col-9">
            <h2>Content will go here</h2>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'PermanentFull'
    }
</script>

<style lang="scss" scoped>
    .md-app {
        min-height: 350px;
        border: 1px solid rgba(#000, .12);
    }

    .md-drawer {
        width: 230px;
        max-width: calc(100vw - 125px);
    }
</style>