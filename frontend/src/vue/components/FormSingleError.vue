<script setup lang="ts">
const props = defineProps<{
    for?: string[] | undefined
}>()
</script>

<template>
    <div v-if="Array.isArray(props.for) && props.for.length" class="mt-1 text-sm leading-snug text-danger">
        {{ props.for[0] }}
    </div>
</template>