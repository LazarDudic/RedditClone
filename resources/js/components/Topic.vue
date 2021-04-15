<template>
    <div>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div>
                    {{ edit ? 'Update Topic' : 'Topic' }}
                </div>
                <button v-if="edit" @click.prevent="edit = !edit" class="btn btn-outline-secondary btn-sm">
                    Cancel
                </button>
            </div>

            <div class="card-body">
                <div v-if="edit">
                    <!-- Edit Topic Component -->
                    <edit-topic @topic-updated="topicUpdated" :topic="topic"></edit-topic>
                </div>
                <div v-else class="d-flex">
                    <div class="topic-widget">
                        <vote :model="topic" :name="'topic'"></vote>
                        <span class="text-secondary">Views {{ topic.views }}</span>
                    </div>
                    <div class="w-100">
                        <h4>{{ topic.title }}</h4>
                        <p>{{ topic.body }}</p>
                        <div class="d-flex justify-content-between">
                            <p>by {{ topic.user.name }}</p>
                            <p> {{ topic.created_at }}</p>
                        </div>
                        <div class="d-flex" v-if="authenticated">
                            <a @click.prevent="edit = !edit" class="btn btn-warning mr-2">Edit</a>
                            <form @submit.prevent="destroy">
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!edit">
            <!-- Answers Component -->
            <answers :topic="topic" :answers-count="answersCount"></answers>
            <!-- New Answer Component -->
            <new-answer @answer-created="newAnswerCreated" :topic-id="topic.id"></new-answer>
        </div>
    </div>

</template>

<script>
import Answers from "./Answers";
import Vote from "./Vote";
import NewAnswer from "./NewAnswer";
import EditTopic from "./EditTopic";

export default {
    components: {Vote, Answers, NewAnswer, EditTopic},
    props: ['topic'],
    data() {
        return {
            mutableTopic: this.topic,
            answers: this.topic.answers,
            answersCount: this.topic.answers_count,
            edit: false
        }
    },
    computed: {
        authenticated() {
            return this.topic.user_id === window.authUser?.id
        }
    },
    methods: {
         refreshTopicData() {
             axios.get(`/api/topics/${this.topic.id}`)
                .then(res => {
                    this.mutableTopic = res.data;
                    this.user = res.data.user;
                    this.answers = res.data.answers;
                    this.answersCount = res.data.answers_count;
                });
        },
        newAnswerCreated(answer) {
            this.answers.push(answer);
            this.answersCount++;
        },
        topicUpdated(topic) {
            this.edit = !this.edit;
            this.topic = topic;
        },
        destroy() {
            this.$toast.question('Are you sure?','Confirm', {
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', (instance, toast) => {
                        this.deleteTopic();
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ],
            });
        },

        deleteTopic() {
            axios.delete(`/api/topics/${this.topic.id}`)
                .then(res => {
                    this.$toast.success('Topic deleted successfully.', 'Success!');
                    setTimeout(() => window.location.href = '/', 2000)
                })
                .catch(err => {});
        }

    }
}
</script>

<style>
.topic-widget {
    text-align: center;
    width: 100px;
    margin-right: 20px;
    padding: 0 15px;
}

.topic-widget i {
    font-size: 2.2rem;
}
</style>
