<template>
    <div>
        <div class="card mt-4">
            <div class="card-header">Answers ({{ answersCount }})</div>

            <div :class="classes(answer)" v-for="answer in showAnswers">
                <div class="topic-widget">
                    <!-- Vote Component -->
                    <vote :model="answer" :name="'answer'"></vote>
                    <!-- Best Answer Component -->
                    <best-answer :answer="answer"></best-answer>
                </div>
                <div class="w-100">
                    <p>{{ answer.body }}</p>
                    <div class="d-flex justify-content-between">
                        <p>by {{ answer.user.name }}</p>
                        <p> {{ answer.created_at }}</p>
                    </div>
                </div>
            </div>
            <div v-if="paginate < answers.length" class="text-center p-2">
                <button @click.prevent="paginate += 5" class="btn btn-outline-secondary">
                    Load More
                </button>
            </div>
        </div>
    </div>

</template>

<script>
import Vote from "./Vote";
import BestAnswer from "./BestAnswer";
import eventBus from "../event-bus";

export default {
    components: {Vote, BestAnswer},
    props: ['answers', 'answersCount'],
    data() {
        return {
            paginate: 5,
            bestAnswer: null,
        };
    },
    created() {
        eventBus.$on('best-answer-updated', id => {
            this.bestAnswer = id;
        });
    },
    computed: {
        showAnswers() {
            let answersSetBestAnswerFirst = _.orderBy(this.answers, ['best_answer', 'created_at'], ['desc', 'asc']);
            return answersSetBestAnswerFirst.filter((answer, index) => {
                return index < this.paginate;
            });
        },
    },
    methods: {
        classes(answer) {
            if (this.bestAnswer === answer.id) {
                return 'best-answer card-body d-flex';
            }
            if (! this.bestAnswer && answer.best_answer) {
                return 'best-answer card-body d-flex';
            }
            return 'card-body d-flex';
        }
    }
}
</script>

<style scoped>

.topic-widget {
    text-align: start;
    width: 60px;
}
.best-answer {
    background: #b3ffd3;
}
</style>
