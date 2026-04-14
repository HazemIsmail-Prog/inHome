import { ref, onMounted, type Component, watch, onUnmounted } from 'vue'
import axiosInstance from '@/ts/lib/axios'
import { useModalsStore } from '@/ts/stores/modals'
import Sidebar from '@/vue/components/Sidebar.vue'
import { TRANSITION_DURATION } from './theme'
import { isMobile } from './windowSize'

export const useCrud = <T extends { id: number }>(url: string, withRelatedLists: boolean = false) => {
    
    const { rightModal, leftModal, setModalState } = useModalsStore()
    const records = ref<T[]>([])
    const selectedRecord = ref<T | null>(null)
    const recordsTotal = ref(0)
    const nextPageUrl = ref<string | null>(null)
    const loadingMore = ref(false)
    const fetchingRecords = ref(false)
    const isSubmitting = ref(false)
    const formErrors = ref<any>({})
    const filters = ref<any>({})
    const relatedLists = ref<any>({})

    onUnmounted(() => {
        closeModal()
        closeFilters()
    })
    
    onMounted(() => {
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeModal()
            }
            if (event.key === 'ArrowDown') {
                if (selectedRecord.value) {
                    const index = records.value.findIndex(r => r.id === selectedRecord.value?.id)
                    if (index < records.value.length - 1) {
                        selectedRecord.value = records.value[index + 1]
                    }
                }
            }
            if (event.key === 'ArrowUp') {
                if (selectedRecord.value) {
                    const index = records.value.findIndex(r => r.id === selectedRecord.value?.id)
                    if (index > 0) {
                        selectedRecord.value = records.value[index - 1]
                    }
                }
            }
        })
        getRecords()
        if (withRelatedLists) {
            getRelatedLists()
        }
    })

    const loadMoreRecords = async () => {
        if (!nextPageUrl.value) {
            return
        }

        loadingMore.value = true

        try {
            const response = await axiosInstance.get(nextPageUrl.value, { params: filters.value })
            records.value.push(...response.data.data)
            nextPageUrl.value = response.data.next_page_url
        } catch (error) {
            console.error(error)
        } finally {
            loadingMore.value = false
        }
    }

    const getRelatedLists = async () => {
        try {
            const response = await axiosInstance.get(`${url}/relatedLists`)
            relatedLists.value = response.data
        } catch (error) {
            console.error(error)
        }
    }

    const getRecords = async () => {
        fetchingRecords.value = true
        try {
            const response = await axiosInstance.get(url, { params: filters.value })
            records.value = response.data.data
            recordsTotal.value = response.data.total
            nextPageUrl.value = response.data.next_page_url
        } catch (error) {
            console.error(error)
        } finally {
            fetchingRecords.value = false
        }
    }

    const createRecord = async (payload: any) => {
        isSubmitting.value = true
        try {
            const response = await axiosInstance.post(url, payload)
            records.value.unshift(response.data)
            recordsTotal.value++
            closeModal()
        } catch (error: any) {
            formErrors.value = error.response.data.errors
            console.error(error)
        } finally {
            isSubmitting.value = false
        }
    }

    const updateRecord = async (payload: any) => {
        isSubmitting.value = true
        try {
            const response = await axiosInstance.put(`${url}/${payload.id}`, payload)
            records.value = records.value.map(r => r.id === payload.id ? response.data : r)
            closeModal()
        } catch (error: any) {
            formErrors.value = error.response.data.errors
            console.error(error)
        } finally {
            isSubmitting.value = false
        }
    }

    const deleteRecord = async (id: number) => {
        try {
            await axiosInstance.delete(`${url}/${id}`)
            records.value = records.value.filter(r => r.id !== id)
            recordsTotal.value--
            if (selectedRecord.value?.id === id) {
                closeModal()
            }
        } catch (error) {
            console.error(error)
        }
    }

    const openModal = (record: T | null , component: Component) => {
        if (record && record.id === selectedRecord.value?.id) {
            closeModal()
        }else{
            formErrors.value = {}
            setModalState(leftModal, false, null)
            selectedRecord.value = record
            setModalState(rightModal, true, component)
        }
    }   

    const closeModal = () => {
        setModalState(rightModal, false, null)
    }

    const openFilters = (component: Component) => {
        setModalState(leftModal, false, null)
        selectedRecord.value = null
        setModalState(rightModal, true, component)
    }
    
    const closeFilters = () => {
        setModalState(rightModal, false, null)  

    }

    watch(() => rightModal.isOpen, (value) => {
        if(value === false) {
            // remove selected record on close modal anyway, even on mobile
            setTimeout(() => {
                selectedRecord.value = null
            }, parseInt(TRANSITION_DURATION.replace('s', '')) * 1000)

            // reopen sidebar on desktop
            if(!isMobile.value) {
                if(localStorage.getItem('sidebar-open') === 'true'){
                    setModalState(leftModal, true, Sidebar)
                }
            }
        }
    })

    watch(filters, () => {
        getRecords()
    }, { deep: true })

    return { 
        records, 
        selectedRecord, 
        recordsTotal,
        nextPageUrl,
        loadingMore,
        isSubmitting,
        fetchingRecords,
        formErrors,
        filters,
        getRecords, 
        getRelatedLists,
        createRecord,
        updateRecord,
        deleteRecord,
        loadMoreRecords,
        closeModal,
        openModal,
        openFilters,
        closeFilters,
        relatedLists,
    }
}