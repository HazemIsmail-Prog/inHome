import { defineStore } from "pinia"
import { markRaw, shallowReactive, type Component } from "vue"
import { TRANSITION_DURATION } from "../composables/theme"

type ModalState = {
    isOpen: boolean
    dismissible: boolean
    width: string
    component: Component | null
}

export const useModalsStore = defineStore('modal', () => {

    const leftModal = shallowReactive<ModalState>({
        isOpen: false,
        dismissible: true,
        width: '350px',
        component: null,
    })

    const rightModal = shallowReactive<ModalState>({
        isOpen: false,
        dismissible: true,
        width: '350px',
        component: null,
    })

    const setModalState = (modal: ModalState, isOpen: boolean, component: Component | null , withTimeout: boolean = true) => {
        if (!isOpen) {
            // Don't do anything if already closed and no component is set
            if (!modal.isOpen && modal.component == null) return
            // Close and clear the modal
            modal.isOpen = false
            if (withTimeout) {
            setTimeout(() => {
                    modal.component = null
                }, parseFloat(TRANSITION_DURATION.replace('s', '')) * 1000)
            } else {
                modal.component = null
            }
            return
        }
        // Prepare the (possibly new) component as non-reactive (for performance/reliability)
        const next = component != null ? markRaw(component) : null
        // Do nothing if already open with the identical component
        if (modal.isOpen && modal.component === next) return
        // Open modal and set its component
        modal.isOpen = true
        modal.component = next
    }

    /** Right sheet (forms/filters): close on route change so navigation and Pinia stay in sync */
    const dismissRightModal = () => {
        setModalState(rightModal, false, null, false)
    }

    return { 
        leftModal, 
        rightModal,
        setModalState,
        dismissRightModal,
    }
})

