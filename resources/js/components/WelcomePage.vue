<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <categories></categories>
            </div>
            <div class="col-md-8">
                <topics></topics>
            </div>
        </div>
    </div>
</template>

<script>
import Categories from "./Categories";
import Topics from "./Topics";

export default {
    components: {Categories, Topics},
}
</script>
