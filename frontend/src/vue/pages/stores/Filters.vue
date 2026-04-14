<script setup lang="ts">
import { inject, ref, watch } from 'vue'
import Input from '@/vue/components/Input.vue'
import { refDebounced } from '@vueuse/core'
import { Search } from '@lucide/vue'
import FiltersContainer from '@/vue/components/FiltersContainer.vue'

// Constants
const sharedCrud = inject('sharedCrud')
const { 
    recordsTotal, 
    filters,
} = sharedCrud as any

const debouncedSearch = refDebounced(ref(filters.value?.search), 500)
watch(debouncedSearch, () => {
    filters.value.search = debouncedSearch.value
})

const clearFilters = () => {
    filters.value = {
        search: '',
    }
}

</script>

<template>

    <FiltersContainer :title="$t('Filters')" @clear-filters="clearFilters">

        <Input
            type="search"
            id="search"
            v-model="filters.search"
            :leading-icon="Search"
            :placeholder="$t('Search...')"
            :trailing-text="`${recordsTotal} ${$t('Records')}`"
        />

    </FiltersContainer>

</template>
