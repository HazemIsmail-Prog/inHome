<script setup lang="ts">
import Topbar from '@/vue/components/Topbar.vue'
import Modal from '@/vue/components/Modal.vue'
import { useModalsStore } from '@/ts/stores/modals'
import { onMounted } from 'vue'
import Sidebar from '@/vue/components/Sidebar.vue'
const { leftModal, rightModal, setModalState } = useModalsStore()
import { isMobile } from '@/ts/composables/windowSize'

const applySidebarFromLocalStorage = () => {
    const currentSidebarState = isMobile.value
        ? 'false'
        : localStorage.getItem('sidebar-open') || 'true'
    leftModal.width = '270px'
    if (currentSidebarState === 'true') {
        setModalState(leftModal, true, Sidebar)
        localStorage.setItem('sidebar-open', 'true')
    } else {
        setModalState(leftModal, false, null)
        localStorage.setItem('sidebar-open', 'false')
    }
}
        
onMounted(() => {    
    // Apply sidebar from localStorage after a short delay to ensure the DOM is fully rendered
    // This is a workaround to avoid the sidebar snapping to the wrong width when the page is loaded
    setTimeout(() => {
        applySidebarFromLocalStorage()
    }, 1)
})

</script>


<template>

    <div class="flex bg-secondary-background">

        <Modal 
            :isOpen="leftModal.isOpen"
            :component="leftModal.component" 
            :width="leftModal.width"
            @dismiss="setModalState(leftModal, false, null)"
            position="start"
        />

        <div
            class="flex-1 flex overflow-auto h-dvh gap-[var(--space-page)] p-[var(--space-page)]"
            :class="isMobile ? 'flex-col-reverse' : 'flex-col'"
        >

            <Topbar>
                <div class="flex min-h-10 items-center justify-between gap-3">
                    <slot name="header" />
                </div>
            </Topbar>
            
            <main class="flex-1 overflow-y-auto bg-background p-[var(--space-page)] rounded-xl border border-border">
                <slot />
            </main>

        </div>

        <Modal 
            :isOpen="rightModal.isOpen"
            :component="rightModal.component" 
            :width="rightModal.width"
            @dismiss="setModalState(rightModal, false, null)"
            position="end"
        />

    </div>

</template>