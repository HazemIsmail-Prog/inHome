<script setup lang="ts">
import FormSingleError from '@/vue/components/FormSingleError.vue'
import Input from '@/vue/components/Input.vue'
import Label from '@/vue/components/Label.vue'
import { ref, inject, watch, computed } from 'vue'
import type { UserForm, Permission, Role } from '@/ts/types'
import Switch from '@/vue/components/Switch.vue'
import FormContainer from '@/vue/components/FormContainer.vue'
import { useTranslateBackend } from '@/ts/composables/translateBackend'
import MultiSelector from '@/vue/components/MultiSelector.vue'
const { translated } = useTranslateBackend()

// Constants
const sharedCrud = inject('sharedCrud')
const { 
    formErrors,
    selectedRecord, 
    relatedLists,
} = sharedCrud as any

const emptyForm = (): UserForm => ({
    id: undefined,
    name_en: '',
    name_ar: '',
    email: '',
    password: '',
    is_active: true,
    permissions: [],
    roles: [],
})

const form = ref<UserForm>(emptyForm())

    const sortedPermissions = computed(() => {
    // sort by name_en and place selected permissions at the beginning
    return relatedLists.value.permissions
        .sort((a: Permission, b: Permission) => 
            a.name_en.localeCompare(b.name_en))
        .filter((permission: Permission) => 
            form.value.permissions?.includes(permission.id) ?? false)
        .concat(relatedLists.value.permissions
        .filter((permission: Permission) => 
            !(form.value.permissions?.includes(permission.id) ?? false)))
})

const sortedRoles = computed(() => {
    // sort by name_en and place selected permissions at the beginning
    return relatedLists.value.roles
        .sort((a: Role, b: Role) => 
            a.name_en.localeCompare(b.name_en))
        .filter((role: Role) => 
            form.value.roles?.includes(role.id) ?? false)
        .concat(relatedLists.value.roles
        .filter((role: Role) => 
            !(form.value.roles?.includes(role.id) ?? false)))
})
    
// Watchers
watch(selectedRecord, (value) => {
    form.value = value ? { 
        ...value,
        permissions: value.permissions?.map((permission: Permission) => permission.id) ?? [],
        roles: value.roles?.map((role: Role) => role.id) ?? [],
    } : emptyForm()
}, { immediate: true, deep: true })

const updatePermissions = (permissionId: number) => {
    if (form.value.permissions.includes(permissionId)) {
        form.value.permissions.splice(form.value.permissions.indexOf(permissionId), 1)
    } else {
        form.value.permissions.push(permissionId)
    }
}
const updateRoles = (roleId: number) => {
    if (form.value.roles.includes(roleId)) {
        form.value.roles.splice(form.value.roles.indexOf(roleId), 1)
    } else {
        form.value.roles.push(roleId)
    }
}

</script>

<template>

    <FormContainer :title="form.id ? $t('Edit User') : $t('Add New User')" :form="form">

        <div>
            <Label for="name" :text="$t('Name')"/>
            <Input :trailing-text="$t('en')" dir="ltr" class="text-left" type="text" id="name_en" v-model="form.name_en"/>
            <Input :trailing-text="$t('ar')" dir="rtl" class="text-right" type="text" id="name_ar" v-model="form.name_ar"/>
            <FormSingleError :for="formErrors.name_en" />
            <FormSingleError :for="formErrors.name_ar" />
        </div>
        <div>
            <Label for="email" :text="$t('Email')"/>
            <Input type="email" id="email" v-model="form.email"/>
            <FormSingleError :for="formErrors.email" />
        </div>
        <div>
            <Label for="password" :text="$t('Password')"/>
            <Input type="password" id="password" v-model="form.password"/>
            <FormSingleError :for="formErrors.password" />
        </div>
        <div>
            <Switch :label="$t('Active')" v-model="form.is_active"/>
            <FormSingleError :for="formErrors.is_active" />
        </div>

        <div>
            <Label for="roles" :text="$t('Roles')" class="mb-2"/>
            <MultiSelector
                :items="relatedLists.roles"
                :selected-items="form.roles"
                :placeholder="$t('Search...')"
                @update:selected-items="form.roles = $event"
            />
            <FormSingleError :for="formErrors.roles" />
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
