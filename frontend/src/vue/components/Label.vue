<script setup lang="ts">
defineProps<{
    for?: string
    text: string
}>()
</script>

<template>
    <label :for="for" class="mb-0.5 mx-1 truncate block select-none text-sm font-medium leading-snug text-text-muted">
        <slot>{{ text }}</slot>
    </label>
</template>