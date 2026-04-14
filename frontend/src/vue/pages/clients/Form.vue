<script setup lang="ts">
import FormSingleError from '@/vue/components/FormSingleError.vue'
import Input from '@/vue/components/Input.vue'
import Label from '@/vue/components/Label.vue'
import { ref, inject, watch } from 'vue'
import type { ClientForm } from '@/ts/types'
import FormContainer from '@/vue/components/FormContainer.vue'

// Constants
const sharedCrud = inject('sharedCrud')
const { 
    formErrors,
    selectedRecord, 
} = sharedCrud as any

const emptyForm = (): ClientForm => ({
    id: undefined,
    name: '',
    phone: '',
    address: '',
    notes: '',
})

const form = ref<ClientForm>(emptyForm())
    
// Watchers
watch(selectedRecord, (value) => {
    form.value = value ? { ...value } : emptyForm()
}, { immediate: true, deep: true })

</script>

<template>

    <FormContainer :title="form.id ? $t('Edit Client') : $t('Add New Client')" :form="form">

        <div>
            <Label for="name" :text="$t('Name')"/>
            <Input type="text" id="name" v-model="form.name"/>
            <FormSingleError :for="formErrors.name" />
        </div>

        <div>
            <Label for="phone" :text="$t('Phone')"/>
            <Input type="text" id="phone" v-model="form.phone"/>
            <FormSingleError :for="formErrors.phone" />
        </div>

        <div>
            <Label for="address" :text="$t('Address')"/>
            <Input type="text" id="address" v-model="form.address"/>
            <FormSingleError :for="formErrors.address" />
        </div>

        <div>
            <Label for="notes" :text="$t('Notes')"/>
            <Input type="text" id="notes" v-model="form.notes"/>
            <FormSingleError :for="formErrors.notes" />
        </div>

    </FormContainer>

</template>
