<template>
    <div>
        <div class="card mt-4">
            <div class="card-header">Answers ({{ answersCount }})</div>

            <div :class="classes(answer)" v-for="answer in showAnswers">
                <div class="topic-widget">
                    <!-- Vote Component -->
                    <vote :model="answer" :name="'answer'"></vote>
                    <!-- Best Answer Component -->
                    <best-answer :answer="answer" :topic="topic"></best-answer>
                </div>
                <div class="w-100">
                    <p class="mt-3">{{ answer.body }}</p>
                    <div class="answers-under-body">
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
    props: ['topic', 'answersCount'],
    data() {
        return {
            answers: this.topic.answers,
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
            let answersSetBestAnswerFirst = _.orderBy(this.topic.answers, ['best_answer', 'created_at'], ['desc',
                'asc']);
            console.log(this.topic.answers)
            console.log(answersSetBestAnswerFirst)

            return answersSetBestAnswerFirst.filter((answer, index) => {
                return index < this.paginate;
            });
        },
    },
    methods: {
        classes(answer) {
            if (this.bestAnswer === answer.id) {
                return 'best-answer card-body d-flex answers';
            }
            if (! this.bestAnswer && answer.best_answer) {
                return 'best-answer card-body d-flex answers';
            }
            return 'card-body d-flex answers';
        }
    }
}
</script>

<style scoped>

.topic-widget {
    text-align: start;
    width: 60px;
}
.answers {
    border-bottom: 1px solid #c4c4c4;
    padding: 5px;
    position: relative;
    width: 100%;
}

.answers-under-body {
    position: absolute;
    bottom: 1px;
    font-size: 0.8rem;
    display: flex;
    justify-content: space-between;
    width: 70%;
}
.best-answer {
    transition: 2s background;
    background: #b6faa8;
}
</style>
