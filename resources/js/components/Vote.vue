<template>
    <div>
        <a @click="voteUp">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>
        <h5 class="text-center">{{ count }}</h5>
        <a @click="voteDown">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>
    </div>
</template>
<script>

export default {
    props: ['name', 'model'],
    data() {
        return {
            url: `/api/${this.name}s/${this.model.id}/vote`,
            count: this.model.votes_sum
        }
    },
    methods: {
        voteUp() {
            this.vote(1)
        },
        voteDown() {
            this.vote(-1)
        },

        vote(value) {
            if (! window.authUser) {
                this.$toast.error('You need to login to vote.', 'Error')
                return;
            }
            axios.post(this.url, {
                vote: value,
                user_id: window.authUser.id
            })
            .then(res => {
                this.count = res.data.votes_sum;
            })
            .catch(err => {
                console.log(err)
            });
        }
    }
}
</script>
<style scoped>
i {
    color: grey;
    font-size: 2.2rem;
    cursor: pointer;
}
i:hover {
    color: black;
}
</style>


