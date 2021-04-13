<template>
    <div class="text-center">
        <ul>
            <li v-for="category in categories" :key="category.id">
                <a @click.prevent="showCategory(category.id)" class="btn">
                    {{ category.name }}
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
import eventBus from "../event-bus";
export default {
    data() {
        return {
           categories: []
        };
    },
    created() {
        axios.get('/api/categories')
        .then(res => {
            this.categories = res.data
        })
        .catch(err => {})
    },
    methods: {
        showCategory(id) {
            eventBus.$emit('changeCategory', id);
        }
    }
}
</script>

<style scoped>
.card {
    padding: 0;
}
li {
    list-style: none;
}

li a {
    font-size: 1.5rem;
    color: #2c89d6;
    text-decoration: none;
}

li a:hover{
    cursor: pointer;
    text-shadow: 2px 1px grey;
}
</style>


