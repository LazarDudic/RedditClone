<template>
    <div>
        <div class="card">
            <div class="card-header">Topic</div>

            <div class="card-body d-flex">
                <div class="topic-widget">
                    <vote :model="topic" :name="'topic'"></vote>
                    <span class="text-secondary">Views {{ topic.views }}</span>

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

        <answers :answers="topic.answers" :answers-count="topic.answers_count"></answers>
    </div>

</template>

<script>
import Answers from "./Answers";
import Vote from "./Vote";

export default {
    components: {Vote, Answers},
    props: ['topic'],
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
