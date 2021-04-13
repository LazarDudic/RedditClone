<template>
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h3>Your Answer</h3>
            </div>
            <hr>
            <form @submit.prevent="create">
                <div class="form-group">
                    <textarea v-model="body" class="form-control" rows="7" name="body"></textarea>
                </div>
                <p class="text-danger">{{ error }}</p>
                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-outline-primary">Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: ['topicId'],
    data() {
        return {
            body: '',
            url: `/api/topics/${this.topicId}/answers`,
            error: ''
        };
    },
    methods: {
        create() {
            if (! window.authUser) {
                this.$toast.warning('You need to login to post an answer.', 'Warning!')
                return;
            }

            if (this.body.length < 20) {
                this.error = 'Min number of characters for answer is 20.';
                return;
            }
            axios.post(this.url, {
                body: this.body,
                user_id: window.authUser.id
            })
            .then(res => {
                this.$emit('answer-created', res.data);
                this.error = '';
                this.body = '';
            })
            .catch(err => {})
        }
    }
}
</script>
