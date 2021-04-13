<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>{{ createTopic ? 'Create Topic' : 'Topics' }}</h4>
            <button @click="toggleTopicForm" class="btn btn-outline-primary">
                {{ createTopic ? 'Back' : 'Create Topic' }}
            </button>
        </div>

        <new-topic @topic-created="topicCreated" v-if="createTopic"></new-topic>

        <div v-else>
            <div class="card-body d-flex w-100 pb-0" v-for="topic in topics" :key="topic.id">
                <div class="topic-widget">
                    <p>{{ topic.votes_sum }} <br><span>Votes</span></p>
                    <p>{{ topic.answers_count }} <br><span>Answers</span></p>
                    <p>{{ topic.views }} <br><span>Views</span></p>
                </div>
                <div class="w-100">
                    <h4><a :href="`topics/${topic.id}`">{{ topic.title }}</a></h4>
                    <p class="topics-body">{{ topic.body.substr(0, 100) }}...</p>
                    <div class="d-flex justify-content-between">
                        <p>by {{ topic.user.name }}</p>
                        <p> {{ topic.created_at }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import NewTopic from "./NewTopic";
import eventBus from "../event-bus";

export default {
    components: { NewTopic },
    data() {
        return {
            topics: [],
            createTopic: false,
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
    },
    methods: {
        toggleTopicForm() {
            this.createTopic = !this.createTopic;
            this.$emit('new-topic', ! this.createTopic);
        },
        topicCreated(topic) {
            this.toggleTopicForm()
            this.topics.push(topic);
        }
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
