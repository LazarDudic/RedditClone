<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            {{ createTopic ? "Create Topic" : '' }}
            <sort v-if="!createTopic" @sort="sortTopics"></sort>
            <div>
                <button @click="toggleTopicForm" class="btn btn-outline-primary">
                    {{ createTopic ? 'Back' : 'Create Topic' }}
                </button>
            </div>
        </div>

        <new-topic @topic-created="topicCreated" v-if="createTopic"></new-topic>

        <div v-else>
            <div class="card-body d-flex w-100 pb-0" v-for="topic in showTopics" :key="topic.id">
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
            <div v-if="paginate < topics.length" class="text-center p-2">
                <button @click.prevent="paginate += 5" class="btn btn-outline-secondary">
                    Load More
                </button>
            </div>
        </div>



    </div>
</template>

<script>
import NewTopic from "./NewTopic";
import Sort from "./Sort";
import eventBus from "../event-bus";

export default {
    components: { NewTopic, Sort },
    data() {
        return {
            topics: [],
            paginate: 5,
            createTopic: false,
            category_id: '',
            url: `/api/topics`
        };
    },
    computed: {
        showTopics() {
            return this.topics.filter((topic, index) => {
                return index < this.paginate;
            });
        }
    },
    created() {
        this.sortTopics();
        eventBus.$on('changeCategory', id => {
            this.category_id = id;
            this.sortTopics();
        });
    },
    methods: {
        getTopics() {
            axios.get(this.url)
                .then(res => {
                    this.topics = res.data;
                })
                .catch(err => {
                })
        },
        sortTopics() {
            let field = localStorage.getItem('sortField') ?? 'created_at';
            let direction = localStorage.getItem('sortDirection') ?? 'desc';
            this.url = `/api/topics?sort_field=${field}&direction=${direction}&category_id=${this.category_id}`;

            this.getTopics()
        },
        toggleTopicForm() {
            this.createTopic = !this.createTopic;
            this.$emit('new-topic', ! this.createTopic);
        },
        topicCreated(topic) {
            this.toggleTopicForm()
            this.topics.unshift(topic);
        },
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
