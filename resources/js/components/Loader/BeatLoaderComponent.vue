<template>
    <div class="d-flex justify-content-center" v-if="isLoading">
        <beat-loader
            :loading="isLoading"
            :color="color"
            :size="size"
        ></beat-loader>
    </div>
</template>

<script>
import BeatLoader from "vue-spinner/src/BeatLoader.vue";
export default {
    mounted() {},
    components: {
        BeatLoader
    },
    props: {
        isLoading: {},
        size: {
            default: "20px"
        },
        color: { default: "#3490dc" }
    },
    data() {
        return {};
    }
};
</script>