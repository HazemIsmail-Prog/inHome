<script setup lang="ts">
import Button from '@/vue/components/Button.vue'
import { inject } from 'vue'

// Constants
const sharedCrud = inject('sharedCrud')
const { 
    isSubmitting,
    createRecord, 
    updateRecord, 
    closeModal,
} = sharedCrud as any

const props = defineProps<{
    title: string
    form: any
}>()

</script>

<template>

    <div class="flex h-full flex-col rounded-xl border border-border bg-background gap-[var(--space-stack)] p-[var(--space-page)] overflow-y-hidden">
        
        <h2 class="text-lg font-bold leading-snug tracking-tight text-text whitespace-nowrap">
            {{ title }}
        </h2>

        <hr class="border-border">

        <form 
            class="flex flex-1 flex-col gap-[var(--space-stack)] overflow-y-auto" 
            @submit.prevent="form.id ? updateRecord(form) : createRecord(form)"
            :disabled="isSubmitting"
        >

            <div class="flex flex-1 flex-col gap-[var(--space-stack)] overflow-y-auto">

                <slot />

            </div>

            <hr class="border-border">

            <div class="flex justify-end gap-3">

                <Button 
                    class="w-full"
                    variant="ghost"
                    :label="$t('Cancel')"
                    @click="closeModal()"
                />

                <Button 
                    class="w-full"
                    variant="accent"
                    type="submit"
                    :label="isSubmitting ? $t('Saving...') : $t('Save')"
                    :processing="isSubmitting"
                />

            </div>

        </form>

    </div>


</template>
