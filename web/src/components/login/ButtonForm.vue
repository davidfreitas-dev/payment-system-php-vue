<script setup>
    import SpinnerLoader from '@/components/template/SpinnerLoader.vue'

    const props = defineProps(['text', 'isLoading'])
</script>

<template>
    <button @click="$emit('onClickButton')" type="button">
        <SpinnerLoader v-if="isLoading" :size="'5'" />
        {{ text }}
    </button>
</template>

<style scoped>
button {
    @apply flex flex-row justify-center items-center py-3 mt-8 w-full rounded font-medium text-lg text-light bg-brand hover:bg-success hover:shadow-lg transition-all ease-linear duration-100
}
</style>