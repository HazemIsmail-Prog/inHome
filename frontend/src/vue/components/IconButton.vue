<script setup lang="ts">
import { computed, type Component } from 'vue'
import { LoaderCircle } from '@lucide/vue';
import type { ButtonVariant } from '@/ts/types';
const props = withDefaults(defineProps<{
    type?: 'button' | 'submit'
    icon?: Component
    processing?: boolean
    variant?: ButtonVariant
    rounded?: boolean
}>(), {
    variant: 'accent',
    type: 'button',
    processing: false,
    rounded: true
})
const variantClasses = computed(() => {
    let baseClasses = [
        'flex min-h-9 items-center justify-center gap-2 px-3.5 py-2 text-sm font-normal leading-snug disabled:opacity-50',
    ]
    if (props.rounded) {
        baseClasses.push('rounded-lg')
    }
    switch (props.variant) {
        case 'accent':
            baseClasses.push(
                [
                    'relative overflow-hidden bg-accent text-accent-text',
                    '[background-image:var(--gradient-control-active)]',
                    'shadow-[var(--control-inset-bevel)] ring-1 ring-inset ring-white/15 dark:ring-white/10',
                    'hover:brightness-[1.03] active:brightness-[0.94]',
                ].join(' '),
            )
            break
        case 'secondary':
            baseClasses.push('bg-gray-500')
            break
        case 'danger':
            baseClasses.push(
                [
                    'relative overflow-hidden bg-danger text-danger-text',
                    'shadow-[inset_0_1px_0_0_rgba(255,255,255,0.14)]',
                    'ring-1 ring-inset ring-white/15 dark:ring-white/10',
                    'hover:bg-danger/88 active:brightness-[0.96]',
                ].join(' '),
            )
            break
        case 'warning':
            baseClasses.push('bg-warning')
            break
        case 'info':
            baseClasses.push('bg-info')
            break
        case 'success':
            baseClasses.push('bg-success')
            break
        case 'link':
            baseClasses.push('bg-transparent')
            break
        case 'outline':
            baseClasses.push('border border-blue-500')
            break
        case 'ghost':
            baseClasses.push('bg-transparent text-text-muted hover:text-text')
            break
        case 'text':
            baseClasses.push('text-blue-500')
            break
    }
    return baseClasses.join(' ')
    
})
</script>

<template>
    <button 
        :type="type" 
        :class="variantClasses"
        :disabled="processing"
    >
    <!-- scale-x-[-1] is for rtl languages to flip the icon -->
    <component :is="icon" v-if="icon && !processing" class="size-4 stroke-1 shrink-0 rtl:scale-x-[-1]" />
    <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
    </button>
</template>