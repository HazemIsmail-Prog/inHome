<script setup lang="ts">
import { computed } from 'vue'
import { CircleCheck } from '@lucide/vue'
import { TRANSITION_DURATION } from '@/ts/composables/theme'
const props = withDefaults(defineProps<{
    modelValue: boolean
    label: string
    transitionDuration?: string
    value?: any
}>(), {
    transitionDuration: TRANSITION_DURATION
})

const emit = defineEmits(['update:modelValue'])

const switchValue = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', props.value ? props.value : val)
})
</script>

<template>
    <div 
        @click="switchValue = !switchValue" 
        class="flex w-fit cursor-pointer select-none items-center rounded-full border px-2.5 py-1 text-xs leading-normal transition-colors"
        :class="modelValue
            ? [
                'overflow-hidden text-accent-text border-transparent',
                'bg-accent',
                '[background-image:var(--gradient-control-active)]',
                'shadow-[var(--control-inset-bevel)] ring-1 ring-inset ring-white/15 dark:ring-white/10',
                'hover:brightness-[1.03] active:brightness-[0.94]',
            ].join(' ')
            : 'overflow-visible bg-secondary-background text-accent border-border'
        "
        :style="{
            transitionDuration: transitionDuration
        }"
    >

        <CircleCheck
            class="shrink-0 text-accent-text fill-none stroke-2"
            :class="modelValue ? 'me-1 size-4 opacity-100' : 'me-0 size-0 opacity-0'"
            :style="{ 
                transitionDuration: transitionDuration
            }"
        />
        {{ label }}
    </div>
</template>