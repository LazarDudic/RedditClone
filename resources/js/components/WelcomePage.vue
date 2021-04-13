<template>
    <div class="container">
        <div class="row justify-content-center">
            <div v-if="showCategories" class="col-md-4">
                <categories></categories>
            </div>
            <div class="col-md-8">
                <topics @new-topic="toggleCategories"></topics>
            </div>
        </div>
    </div>
</template>

<script>
import Categories from "./Categories";
import Topics from "./Topics";

export default {
    components: {Categories, Topics},
    data() {
        return {
            showCategories: true
        };
    },
    methods: {
        toggleCategories(showCategories) {
            this.showCategories = showCategories;
        }
    }
}
</script>
