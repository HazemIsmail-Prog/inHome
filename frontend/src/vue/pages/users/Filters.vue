<script setup lang="ts">
import { inject, ref, watch } from 'vue'
import Input from '@/vue/components/Input.vue'
import { refDebounced } from '@vueuse/core'
import { Search } from '@lucide/vue'
import FiltersContainer from '@/vue/components/FiltersContainer.vue'
import MultiSelector from '@/vue/components/MultiSelector.vue'
import Label from '@/vue/components/Label.vue'
import Button from '@/vue/components/Button.vue'

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

const statusOptions = [
    { id: 'all', labelKey: 'All' },
    { id: 'active', labelKey: 'Active' },
    { id: 'inactive', labelKey: 'Inactive' },
]

const clearFilters = () => {
    filters.value = {
        search: '',
        is_active: 'all',
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
            <Label for="is_active" :text="$t('Status')" class="mb-2"/>
            <div class="flex gap-2 rounded-lg bg-secondary-background p-1">
                <Button
                    v-for="opt in statusOptions"
                    :key="opt.id"
                    class="w-full text-xs"
                    :variant="filters.is_active === opt.id || (opt.id === 'all' && !filters.is_active) ? 'accent' : 'ghost'"
                    :label="$t(opt.labelKey)"
                    @click="filters.is_active = opt.id"
                />
            </div>
        </div>

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
