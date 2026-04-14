<script setup lang="ts">
import { inject, ref, watch } from 'vue'
import Input from '@/vue/components/Input.vue'
import { refDebounced } from '@vueuse/core'
import { Search } from '@lucide/vue'
import FiltersContainer from '@/vue/components/FiltersContainer.vue'
import MultiSelector from '@/vue/components/MultiSelector.vue'
import Label from '@/vue/components/Label.vue'

// Constants
const sharedCrud = inject('sharedCrud')
const { 
    recordsTotal, 
    relatedLists,
    filters,
} = sharedCrud as any

const debouncedSearch = refDebounced(ref(filters.value?.search), 500)
watch(debouncedSearch, () => {
    filters.value.search = debouncedSearch.value
})

const clearFilters = () => {
    filters.value = {
        search: '',
        permissions: [],
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

        <div>
            <Label for="permissions" :text="$t('Permissions')" class="mb-2"/>
            <MultiSelector
                :items="relatedLists.permissions"
                :selected-items="filters.permissions || []"
                :placeholder="$t('Search...')"
                @update:selected-items="filters.permissions = $event"
            />
        </div>

    </FiltersContainer>

</template>
