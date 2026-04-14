<script setup lang="ts">
import FormSingleError from '@/vue/components/FormSingleError.vue'
import Input from '@/vue/components/Input.vue'
import Label from '@/vue/components/Label.vue'
import { ref, inject, watch } from 'vue'
import type { StoreForm } from '@/ts/types'
import FormContainer from '@/vue/components/FormContainer.vue'

// Constants
const sharedCrud = inject('sharedCrud')
const { 
    formErrors,
    selectedRecord, 
} = sharedCrud as any

const emptyForm = (): StoreForm => ({
    id: undefined,
    name: '',
})

const form = ref<StoreForm>(emptyForm())
    
// Watchers
watch(selectedRecord, (value) => {
    form.value = value ? { ...value } : emptyForm()
}, { immediate: true, deep: true })

</script>

<template>

    <FormContainer :title="form.id ? $t('Edit Store') : $t('Add New Store')" :form="form">

        <div>
            <Label for="name" :text="$t('Name')"/>
            <Input type="text" id="name" v-model="form.name"/>
            <FormSingleError :for="formErrors.name" />
        </div>

    </FormContainer>

</template>
