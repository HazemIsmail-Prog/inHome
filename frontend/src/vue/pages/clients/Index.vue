<script setup lang="ts">
import { provide, ref } from 'vue'
import TableCell from '@/vue/components/TableCell.vue'
import TableHead from '@/vue/components/TableHead.vue'
import { Plus, Trash, Filter } from '@lucide/vue'
import { useCrud } from '@/ts/composables/crud'
import Button from '@/vue/components/Button.vue'
import IconButton from '@/vue/components/IconButton.vue'
import ClientsForm from './Form.vue'
import type { Client } from '@/ts/types'
import Spinner from '@/vue/components/Spinner.vue'
import { useTabTitle } from '@/ts/composables/tabTitle'
import DefaultLayout from '@/vue/layouts/DefaultLayout.vue'
import AddNewButton from '@/vue/components/AddNewButton.vue'
import LoadMoreRef from '@/vue/components/LoadMoreRef.vue'
import Filters from './Filters.vue'
    
// Constants
const confirmDelete = ref<number | null>(null)

const crud = useCrud<Client>('/api/clients')
const { 
    records, 
    selectedRecord, 
    fetchingRecords,
    deleteRecord, 
    openModal,
    openFilters,
} = crud

provide('sharedCrud', crud)

// Use composables
useTabTitle('Clients')

</script>

<template>

    <DefaultLayout>

        <template #header>
            <h1>{{ $t('Clients') }}</h1>
            <div class="flex items-center gap-2">
                <IconButton
                    :title="$t('Filters')"
                    variant="accent"
                    class="!text-accent-text w-fit"
                    :icon="Filter"
                    @click="openFilters(Filters)"
                />
                <AddNewButton
                    :icon="Plus"
                    :label="$t('Add New Client')"
                    @click="openModal(null, ClientsForm)"
                />
            </div>
        </template>



        <div class="flex flex-col gap-[var(--space-stack)]">

            <div v-if="records.length === 0 && !fetchingRecords" class="py-14 text-center text-base leading-relaxed text-text-muted">
                {{ $t('No records found.') }}
            </div>

            <div v-if="fetchingRecords" class="flex justify-center py-14">
                <Spinner />
            </div>

            <div
                v-if="records.length > 0 && !fetchingRecords"
                class="overflow-x-auto rounded-xl border border-border bg-background"
            >
            
                <table class="min-w-full">
                    <thead class="bg-secondary-background">
                        <tr>
                            <TableHead :label="$t('Name')" />
                            <TableHead :label="$t('Phone')" />
                            <TableHead :label="$t('Address')" />
                            <TableHead :label="$t('Notes')" />
                            <TableHead />
                        </tr>
                    </thead>
                    <tbody>
                        <tr 
                            @click="openModal(record, ClientsForm)" 
                            v-for="record in records" 
                            :key="record.id"
                            class="cursor-pointer border-s-[3px] leading-normal transition-colors duration-200 even:bg-secondary-background/70"
                            :class="
                                record.id === selectedRecord?.id
                                    ? 'border-accent bg-selected-row-gradient font-medium text-text'
                                    : 'border-transparent text-text-muted hover:bg-hover'
                            "
                        >
                            <TableCell>{{ record.name }}</TableCell>
                            <TableCell>{{ record.phone }}</TableCell>
                            <TableCell>{{ record.address }}</TableCell>
                            <TableCell>{{ record.notes }}</TableCell>
                            <TableCell>
                                <div class="flex justify-end">
                                    <IconButton
                                        v-if="confirmDelete !== record.id"
                                        :icon="Trash" 
                                        @click.stop="confirmDelete = record.id"
                                        variant="ghost"
                                        class="!text-danger"
                                    />
                                    <div
                                        v-if="confirmDelete === record.id"
                                        class="inline-flex items-center gap-2 rounded-lg border border-border bg-secondary-background p-1 shadow-sm"
                                        @click.stop
                                    >
                                        <Button
                                            variant="danger"
                                            :label="$t('Delete')"
                                            class="!min-h-8 !px-3 !py-1.5 text-xs"
                                            @click.stop="deleteRecord(record.id)"
                                        />
                                        <Button
                                            variant="ghost"
                                            :label="$t('Cancel')"
                                            class="!min-h-8 !px-3 !py-1.5 text-xs"
                                            @click.stop="confirmDelete = null"
                                        />
                                    </div>
                                </div>
                            </TableCell>
                        </tr>
                    </tbody>
                </table>

                <LoadMoreRef />

            </div>
            
        </div>

    </DefaultLayout>

</template>