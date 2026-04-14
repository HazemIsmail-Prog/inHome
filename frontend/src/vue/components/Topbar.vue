<script setup lang="ts">
import { PanelRightOpen } from '@lucide/vue'
import { useModalsStore } from '@/ts/stores/modals'
const { leftModal, setModalState } = useModalsStore()
import Sidebar from '@/vue/components/Sidebar.vue'
import { TRANSITION_DURATION } from '@/ts/composables/theme'
const toggleSidebar = () => {
    if (leftModal.isOpen) { 
        setModalState(leftModal, false, null)
        localStorage.setItem('sidebar-open', 'false')
    } else {
        localStorage.setItem('sidebar-open', 'true')
        setModalState(leftModal, true, Sidebar)
    }
}
</script>

<template>
    <header
        class="flex items-center gap-3 border rounded-xl border-border bg-background px-[var(--space-page)] py-3.5 shadow-sm"
    >
        <button
            type="button"
            class="inline-flex size-10 shrink-0 items-center justify-center rounded-lg border transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring/40 active:scale-[0.97] border-accent/35 bg-accent/10 text-accent shadow-[var(--surface-inset-highlight)]"
            :aria-expanded="!!leftModal.isOpen"
            :aria-label="$t('Toggle sidebar')"
            @click="toggleSidebar"
        >
            <PanelRightOpen
                class="size-[1.35rem] stroke-[1.75] transition-transform"
                :class="
                    !leftModal.isOpen ? 'rtl:rotate-0 ltr:rotate-180' : 'rtl:rotate-180 ltr:rotate-0'
                "
                :style="{ transitionDuration: TRANSITION_DURATION }"
            />
        </button>
        <div class="min-w-0 flex-1 text-xl font-semibold leading-snug tracking-tight text-text">
            <slot />
        </div>
    </header>
</template>