<template>
    <div class="display_flex justify_center" v-if="isLoading">
        <pulse-loader
            :loading="isLoading"
            :color="color"
            :size="size"
        ></pulse-loader>
    </div>
</template>

<script>
import PulseLoader from "vue-spinner/src/PulseLoader.vue";
export default {
    mounted() {},
    components: {
        PulseLoader
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