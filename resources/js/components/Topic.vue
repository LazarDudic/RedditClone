<template>
    <div class="card">
        <div class="card-header">Topic</div>

        <div class="card-body d-flex">
            <div class="topic-widget">
                <i class="fas fa-caret-up fa-3x"></i>
                <h4>5</h4>
                <i class="fas fa-caret-down fa-3x"></i><br>
                <span class="text-secondary">Views 455</span>

            </div>
            <div>
                <h4>{{ topic.title }}</h4>
                <p>{{ topic.body }}</p>
                <div class="d-flex justify-content-between">
                    <p>by {{ topic.user.name }}</p>
                    <p> {{ topic.created_at }}</p>
                </div>
            </div>

            <hr>
        </div>
    </div>
</template>

<script>

export default {
    props: ['topic']
}
</script>

<style>

.topic-widget {
    text-align: center;
    width: 150px;
    margin-right: 20px;
    padding: 0 15px;
}

.topic-widget i {
    font-size: 2.2rem;
}

</style>
