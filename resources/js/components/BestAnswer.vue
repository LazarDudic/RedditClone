<template>
    <div v-if="authorized">
        <a @click.prevent="create">
            <i v-if="isBest" class="fas fa-check text-success"></i>
            <i v-else class="fas fa-check text-secondary"></i>
        </a>
    </div>
</template>

<script>
import eventBus from "../event-bus";

export default {
    props: ['answer', 'topic'],
    data() {
        return {
            isBest: this.answer.best_answer === 1,
        };
    },
    computed: {
        authorized() {
            return this.isBest || this.topic.user_id === window.authUser?.id;
        }
    },
    created() {
        eventBus.$on('best-answer-updated', id => {
            this.isBest = (id === this.answer.id)
        })
    },
    methods: {
        create() {
            if (this.isBest) { return; }
            if (this.topic.user_id !== window.authUser?.id) { return; }

            axios.post(`/api/answers/${this.answer.id}/best`)
            .then(res => {
                eventBus.$emit('best-answer-updated', this.answer.id)
                this.$toast.success('You added best answer succesfuly.', "Success!")
            })
            .catch(err => {})
        }
    }
}
</script>

<style scoped>
.fa-check {
    font-size: 1.5rem;
    cursor: pointer;
}
</style>
