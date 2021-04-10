<template>
    <div class="">
        <span
            class="form-text text-muted red_color"
            >
            <slot></slot>
            </span
        >
    </div>
</template>

<script>
export default {
    mounted() {
    },
    props:[]
};
</script>
<style>
.red_color{
    color:red !important;
}
</style>