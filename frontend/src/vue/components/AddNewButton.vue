<script setup lang="ts">
import Button from '@/vue/components/Button.vue'
import type { Component } from 'vue'
import { TRANSITION_DURATION } from '@/ts/composables/theme'
withDefaults(defineProps<{
    show?: boolean
    label: string
    icon: Component
    onClick: () => void
}>(), {
    show: true,
})
</script>

<template>
    <Button
        class="whitespace-nowrap transition-all duration-1500"
        :style="{ 
            opacity: show ? 1 : 0,
            transitionDuration: TRANSITION_DURATION
        }"
        :leading-icon="icon"
        :label="label" 
        @click="onClick"
    />
</template>