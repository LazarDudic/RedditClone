<template>
    <div>
        <div class="card mt-4">
            <div class="card-header">Answers ({{ answersCount }})</div>

            <div class="card-body d-flex" v-for="answer in showAnswers">
                <div class="topic-widget">
                    <vote :model="answer" :name="'answer'"></vote>
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
export default {
    components: {Vote},
    props: ['answers', 'answersCount'],
    data() {
        return {
            paginate: 5,
        };
    },
    computed: {
        showAnswers() {
            return this.answers.filter((answer, index) => {
                return index < this.paginate;
            });
        }
    },
}
</script>

<style scoped>
.card-body {
    border-bottom: 1px solid #b1b1b1;
}

.topic-widget {
    text-align: start;
    width: 60px;
}


</style>
