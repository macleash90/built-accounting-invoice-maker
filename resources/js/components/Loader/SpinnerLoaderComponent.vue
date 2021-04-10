<template>
    <div class="display_flex justify_center" v-if="isLoading">
        <clip-loader
            :loading="isLoading"
            :color="color"
            :size="size"
        ></clip-loader>
    </div>
</template>

<script>
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
export default {
    mounted() {},
    components: {
        ClipLoader
    },
    props: {
        isLoading: {},
        size: {
            default: "60px"
        },
        color: { default: "#3490dc" }
    },
    data() {
        return {};
    }
};
</script>