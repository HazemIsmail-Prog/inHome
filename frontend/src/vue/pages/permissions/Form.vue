<script setup lang="ts">
import FormSingleError from '@/vue/components/FormSingleError.vue'
import Input from '@/vue/components/Input.vue'
import Label from '@/vue/components/Label.vue'
import { ref, inject, watch } from 'vue'
import type { PermissionForm } from '@/ts/types'
import FormContainer from '@/vue/components/FormContainer.vue'

// Constants
const sharedCrud = inject('sharedCrud')
const { 
    formErrors,
    selectedRecord, 
} = sharedCrud as any

const emptyForm = (): PermissionForm => ({
    id: undefined,
    name_en: '',
    name_ar: '',
})

const form = ref<PermissionForm>(emptyForm())
    
// Watchers
watch(selectedRecord, (value) => {
    form.value = value ? { ...value } : emptyForm()
}, { immediate: true, deep: true })

</script>

<template>

    <FormContainer :title="form.id ? $t('Edit Permission') : $t('Add New Permission')" :form="form">

        <div>
            <Label for="name" :text="$t('Name')"/>
            <Input :trailing-text="$t('en')" dir="ltr" class="text-left" type="text" id="name_en" v-model="form.name_en"/>
            <Input :trailing-text="$t('ar')" dir="rtl" class="text-right" type="text" id="name_ar" v-model="form.name_ar"/>
            <FormSingleError :for="formErrors.name_en" />
            <FormSingleError :for="formErrors.name_ar" />
        </div>

    </FormContainer>

</template>
