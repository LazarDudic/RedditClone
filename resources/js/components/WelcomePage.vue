<template>
    <div class="container">
        <div class="row justify-content-center">
            <div v-if="showSidebar" class="col-md-4">
                <categories></categories>
            </div>
            <div class="col-md-8">
                <topics @new-topic="toggleSidebar"></topics>
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
            showSidebar: true
        };
    },
    methods: {
        toggleSidebar(showSidebar) {
            this.showSidebar = showSidebar;
        }
    }
}
</script>
