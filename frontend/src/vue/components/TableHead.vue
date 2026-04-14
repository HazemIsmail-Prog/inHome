<script setup lang="ts">
defineProps<{
    label?: string
}>()
</script>

<template>
    <th
        class="border-b border-border px-[var(--space-page)] py-3 text-start text-xs font-semibold uppercase tracking-wider text-accent"
    >
        <slot>{{ label }}</slot>
    </th>
</template>