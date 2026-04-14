<script setup lang="ts">
import FormSingleError from '@/vue/components/FormSingleError.vue'
import Input from '@/vue/components/Input.vue'
import Label from '@/vue/components/Label.vue'
import { ref, inject, watch } from 'vue'
import type { RoleForm, Permission } from '@/ts/types'
import FormContainer from '@/vue/components/FormContainer.vue'
import MultiSelector from '@/vue/components/MultiSelector.vue'
// Constants
const sharedCrud = inject('sharedCrud')
const { 
    formErrors,
    selectedRecord, 
    relatedLists,
} = sharedCrud as any

const emptyForm = (): RoleForm => ({
    id: undefined,
    name_en: '',
    name_ar: '',
    permissions: [],
})

const form = ref<RoleForm>(emptyForm())

// Watchers
watch(selectedRecord, (value) => {
    form.value = value 
        ? { 
            ...value,
            permissions: value.permissions?.map((permission: Permission) => permission.id) ?? [],
        } 
        : emptyForm()
}, { immediate: true, deep: true })

</script>

<template>

    <FormContainer :title="form.id ? $t('Edit Role') : $t('Add New Role')" :form="form">

        <div>
            <Label for="name" :text="$t('Name')"/>
            <Input :trailing-text="$t('en')" dir="ltr" class="text-left" type="text" id="name_en" v-model="form.name_en"/>
            <Input :trailing-text="$t('ar')" dir="rtl" class="text-right" type="text" id="name_ar" v-model="form.name_ar"/>
            <FormSingleError :for="formErrors.name_en" />
            <FormSingleError :for="formErrors.name_ar" />
        </div>

        <div>
            <Label for="permissions" :text="$t('Permissions')" class="mb-2"/>
            <MultiSelector
                :items="relatedLists.permissions"
                :selected-items="form.permissions"
                :placeholder="$t('Search...')"
                @update:selected-items="form.permissions = $event"
            />
            <FormSingleError :for="formErrors.permissions" />
        </div>
        
    </FormContainer>
</template>
