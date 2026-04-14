<script setup lang="ts">
import { TRANSITION_DURATION } from '@/ts/composables/theme'
withDefaults(defineProps<{
    show: boolean
    height: number
    width: number
    durationSeconds?: string
    transitionMode: 'slide-v' | 'slide-h'
}>(), {
    durationSeconds: TRANSITION_DURATION
})

</script>

<template>
    <Transition :name="transitionMode">
        <div v-if="show">
            <slot />
        </div>
    </Transition>
</template>

<style>

/* slide-v */
.slide-v-enter-active,
.slide-v-leave-active {
    transition: all ease-in-out;
    transition-duration: v-bind(durationSeconds);
    overflow: hidden;
}

.slide-v-enter-from,
.slide-v-leave-to {
    height: 0;
    opacity: 0;
}

.slide-v-enter-to,
.slide-v-leave-from {
    height: v-bind(height + 'px');
    opacity: 1;
}



/* slide-h */
.slide-h-enter-active,
.slide-h-leave-active {
    transition: all ease-in-out;
    transition-duration: v-bind(durationSeconds);
    overflow: hidden;
}

.slide-h-enter-from,
.slide-h-leave-to {
    /* width: 0; */
    transform: translateX(-100%);
    opacity: 0;
}

.slide-h-enter-to,
.slide-h-leave-from {
    /* width: v-bind(width + 'px'); */
    transform: translateX(0);
    opacity: 1;
}

</style>