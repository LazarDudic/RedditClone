<template>
    <div class="card">
        <div class="card-header">Topics</div>

        <div class="card-body d-flex" v-for="topic in topics" :key="topic.id">
            <div class="topic-widget">
                <p>5 <br><span>Votes</span></p>
                <p>{{ topic.answers_count }} <br><span>Answers</span></p>
                <p>{{ topic.views }} <br><span>Views</span></p>
            </div>
            <div>
                <h4><a :href="`topics/${topic.id}`">{{ topic.title }}</a></h4>
                <p class="topics-body">{{ topic.body.substr(0, 100) }}...</p>
                <div class="d-flex justify-content-between">
                    <p>by {{ topic.user.name }}</p>
                    <p> {{ topic.created_at }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import eventBus from "../event-bus";

export default {
    data() {
        return {
            topics: []
        };
    },
    created() {
        axios.get('/api/topics')
        .then(res => {
            this.topics = res.data;
        })
        .catch(err => {
        })

        eventBus.$on('changeCategory', id => {
            axios.get(`/api/categories/${id}`)
                .then(res => {
                    this.topics = res.data.topics;
                })
                .catch(err => {
                })
        })
    }
}
</script>

<style scoped>
.card-header {
    text-align: center;
}
a {
    color: #000000;
    font-size: 1.5rem;
    text-decoration: none;
}

a:hover{
    text-shadow: 2px 1px grey;
}
.topics-body {
    color: #797979;
}

.card-body {
    border-bottom: 1px solid #d2d2d2;
}

.topic-widget {
    text-align: center;
    width: 150px;
    margin-right: 20px;
}

.topic-widget span {
    font-size: 0.6rem;
}

.topic-widget i {
    font-size: 2rem;
}

</style>
