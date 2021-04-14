<template>
    <div class="edit-topic">
        <form @submit.prevent="update">
            <div class="form-group">
                <label>Title</label>
                <input type="text" v-model="formData.title" class="form-control">
                <p class="text-danger">{{ error.title }}</p>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select class="form-control" v-model="formData.category_id">
                    <option :value="category.id" v-for="category in categories" :key="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label>Body</label>
                <textarea v-model="formData.body" rows="10" class="form-control"></textarea>
                <p class="text-danger">{{ error.body }}</p>
            </div>

            <button class="btn btn-outline-primary">Update</button>
        </form>
    </div>
</template>

<script>

export default {
    props: ['topic'],
    data() {
        return {
            formData: {
                title: this.topic.title,
                category_id: this.topic.category_id,
                body: this.topic.body,
                user_id: window.authUser.id
            },
            categories: [],
            error: {
                title: '',
                body: ''
            }
        };
    },
    created() {
        axios.get('/api/categories')
            .then(res => {
                this.categories = res.data
            });

    },

    methods: {
        update() {
            axios.put(`/api/topics/${this.topic.id}`, this.formData)
            .then(res => {
                this.$toast.success('Topic updated successfully.', 'Success!');
                this.$emit('topic-updated', res.data);
            })
            .catch(err => {
                this.error.title = err.response.data.errors.title
                    ? err.response.data.errors.title[0] : '';

                this.error.body = err.response.data.errors.body
                    ? err.response.data.errors.body[0] : '';
            })
        }
    }
}
</script>

<style>
.edit-topic {
    padding: 15px;
}
</style>
