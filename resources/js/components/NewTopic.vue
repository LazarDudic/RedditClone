<template>
    <div class="create-topic">
        <form @submit.prevent="create">
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

            <button class="btn btn-outline-primary">Create</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            formData: {
                title: '',
                body: '',
                category_id: 1,
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
        create() {
            if (! window.authUser) {
                this.$toast.warning('You need to login to create a topic.', 'Warning!')
                return;
            }

            this.formData.user_id = window.authUser.id;

            axios.post('/api/topics', this.formData)
            .then(res => {
                this.$toast.success('Topic created successfully.', 'Success!');
                this.resetFields();

                setTimeout(() => {
                    this.$emit('topic-created', res.data);
                }, 1500);
            })
            .catch(err => {
                this.error.title = err.response.data.errors.title
                    ? err.response.data.errors.title[0] : '';

                this.error.body = err.response.data.errors.body
                    ? err.response.data.errors.body[0] : '';
            })
        },
        resetFields() {
            this.formData = {
                title: '',
                body: ''
            };
            this.error = {
                title: '',
                body: ''
            };
        }
    }

}
</script>
<style>
.create-topic {
    padding: 15px;
}
</style>
