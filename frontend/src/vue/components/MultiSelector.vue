<script setup lang="ts">
import { computed, ref } from 'vue'
import { useTranslateBackend } from '@/ts/composables/translateBackend'
import Input from '@/vue/components/Input.vue'
import Switch from '@/vue/components/Switch.vue'
const { translated } = useTranslateBackend()

const emit = defineEmits(['update:selected-items'])

const props = defineProps<{
    placeholder: string
    items: any[]
    selectedItems: any[]
}>()

const search = ref('')
const filteredItems = computed(() => {
    return props.items.filter((item: any) => {
        return translated(item.name).toLowerCase().includes(search.value.toLowerCase())
    })
})

const updateSelectedItems = (item: any) => {
    if (props.selectedItems.includes(item.id)) {
        props.selectedItems.splice(props.selectedItems.indexOf(item.id), 1)
    } else {
        props.selectedItems.push(item.id)
    }
    emit('update:selected-items', props.selectedItems)
}

const sortedItems = computed(() => {
    // sort by name_en and place selected permissions at the beginning
    return filteredItems.value
        .sort((a: any, b: any) => 
            a.name_en.localeCompare(b.name_en))
        .filter((item: any) => 
            props.selectedItems?.includes(item.id) ?? false)
        .concat(filteredItems.value
        .filter((item: any) => 
            !(props.selectedItems?.includes(item.id) ?? false)))
})

</script>

<template>
    <div class="flex flex-col gap-2 border-border border-2 rounded-lg p-1 bg-secondary-background">
        <Input type="search" class="text-[12px] py-1" :placeholder="placeholder" v-model="search"/>
        <div class="flex flex-col gap-2 max-h-[200px] overflow-y-auto p-1">
            <Switch
                v-if="filteredItems.length > 0"
                class="w-full shrink-0 rounded-lg"
                v-for="item in sortedItems"
                :key="item.id"
                :label="translated(item.name)"
                :model-value="selectedItems.includes(item.id) ?? false"
                :value="item.id"
                @update:model-value="updateSelectedItems(item)"
            />
            <p v-else class="text-center text-sm text-text-muted">{{ $t('multiSelectorNoItems') }}</p>
        </div>
    </div>
</template>