<script setup lang="ts">
import type { Component } from 'vue'
import { RouterLink, type RouteLocationRaw } from 'vue-router'
defineProps<{
    label: string
    icon?: Component
    isActive?: boolean
    to: RouteLocationRaw
}>()
</script>

<template>
    <RouterLink
        :to="to"
        :class="[
            'flex w-full shrink-0 items-center gap-2 rounded-lg px-3 py-2 text-sm leading-snug transition-colors',
            isActive
                ? [
                    'relative overflow-hidden border-0',
                    'bg-accent text-accent-text',
                    '[background-image:var(--gradient-control-active)]',
                    'shadow-[var(--control-inset-bevel)] ring-1 ring-inset ring-white/15 dark:ring-white/10',
                    'hover:brightness-[1.03] active:brightness-[0.94]',
                ].join(' ')
                : 'text-text-muted hover:bg-secondary-background',
        ]"
        >
            <component 
                v-if="icon" 
                :is="icon" 
                class="size-4 stroke-1 shrink-0" 
                :class="isActive ? 'text-accent-text' : 'text-text-muted'"
            />
            <span class="truncate">{{ label }}</span>
        </RouterLink>
</template>