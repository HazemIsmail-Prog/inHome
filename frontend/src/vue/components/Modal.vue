<script setup lang="ts">
import { type Component } from 'vue'
import { TRANSITION_DURATION } from '@/ts/composables/theme'
import { isMobile } from '@/ts/composables/windowSize'

const emit = defineEmits(['dismiss'])

const props = withDefaults(defineProps<{
    isOpen?: boolean
    width: string
    component: Component | null
    durationSeconds?: string
    position: 'start' | 'end'
}>(), {
    isOpen: false,
    durationSeconds: TRANSITION_DURATION
})

const dismiss = () => {
    emit('dismiss')
}
</script>

<template>


    <template v-if="isMobile">

        <div
            class="fixed p-[var(--space-page)] inset-0 z-50 flex items-end justify-center bg-black/40 backdrop-blur-[2px] transition-opacity duration-300"
            :style="{ 
                transitionDuration: durationSeconds,
                transitionProperty: 'opacity',
                opacity: isOpen ? 1 : 0,
                pointerEvents: isOpen ? 'auto' : 'none'
            }"
            @click.self="dismiss()"
        >
            <div
                class="rounded-xl ease-in-out border border-border bg-background shadow-[var(--shadow-elevated)] flex-shrink-0 overflow-hidden"
                :class="position === 'start' ? 'me-auto' : 'ms-auto'"
                :style="{ 
                    width: isOpen ? width : '0px',
                    transitionDuration: durationSeconds,
                    transitionProperty: 'width',
                    transitionTimingFunction: 'cubic-bezier(0.4, 0, 0.2, 1)',
                }"
            >
                <component
                    class="max-h-[calc(100dvh-(var(--space-page)*2))] overflow-y-auto z-10"
                    v-if="component"
                    :is="component"
                />
            </div>
        </div>

    </template>   

    <template v-else>
        
        <div
            class="overflow-hidden h-dvh ease-in-out flex-shrink-0"
            :style="{ 
                flexBasis: isOpen ? width : '0px',
                opacity: isOpen ? 1 : 0,
                transitionDuration: durationSeconds,
                transitionProperty: 'flex-basis, opacity',
                transitionTimingFunction: 'cubic-bezier(0.4, 0, 0.2, 1)',
            }"
        >
            <component
                v-if="component"
                :is="component"
            />
        </div>

    </template>


</template>