<script setup lang="ts">
import { inject } from 'vue'
import Button from '@/vue/components/Button.vue'

// Constants
const sharedCrud = inject('sharedCrud')
const { 
    closeFilters,
} = sharedCrud as any

const props = defineProps<{
    title: string
}>()

const emit = defineEmits<{
    (e: 'clear-filters'): void
}>()

</script>

<template>

    <div class="flex h-full flex-col rounded-xl border border-border bg-background gap-[var(--space-stack)] p-[var(--space-page)] overflow-y-hidden">
        
        <h2 class="text-lg font-bold leading-snug tracking-tight text-text whitespace-nowrap">
            {{ title }}
        </h2>

        <hr class="border-border">

        <div class="flex flex-1 flex-col gap-[var(--space-stack)] overflow-y-auto overflow-x-hidden">

            <slot />

        </div>

        <hr class="border-border">

        <Button
            class="mt-auto"
            variant="ghost"
            :label="$t('Clear')"
            @click="emit('clear-filters')"
        />

        <Button
            class="mt-auto"
            :label="$t('Close')"
            @click="closeFilters()"
        />

    </div>


</template>
