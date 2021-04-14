<template>
    <div class="d-lg-flex">
        <div class="form-group">
            <select @change="sort" v-model="sortField" class="form-control">
                <option value="views">Views</option>
                <option value="answers_count">Answers</option>
                <option value="votes_sum">Votes</option>
                <option value="created_at">Date</option>
            </select>
        </div>

        <div class="sort-direction">
            <a @click.prevent="sortDirection('asc')" >
                <i :class="arrowUp"></i>
            </a>
            <a @click.prevent="sortDirection('desc')">
                <i class="fas fa-arrow-circle-down" :class="arrowDown"></i>
            </a>
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            direction: 'desc',
            sortField: 'created_at',
        }
    },
    computed: {
        arrowUp() {
            return this.direction === 'asc'
                ? 'text-success fas fa-arrow-circle-up'
                : 'text-secondary fas fa-arrow-circle-up';
        },
        arrowDown() {
            return this.direction === 'desc'
                ? 'text-success fas fa-arrow-circle-down'
                : 'text-secondary fas fa-arrow-circle-down';
        }
    },
    methods: {
        sortDirection(direction) {
            this.direction = direction;
            this.sort();
        },
        sort() {
            this.$emit('sort', this.sortField, this.direction);
        }
    }
}
</script>

<style scoped>
.sort-direction {
    margin-left: 10px;
}
i {
    cursor: pointer;
    font-size: 2rem;
}
</style>
