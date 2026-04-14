<script setup lang="ts">
import { useIntersectionObserver } from '@vueuse/core'
import { useTemplateRef, ref } from 'vue'
import Button from '@/vue/components/Button.vue'
import { inject } from 'vue'

const sharedCrud = inject('sharedCrud')
const { loadMoreRecords, nextPageUrl, loadingMore } = sharedCrud as any


const targetIsVisible = ref(false)
const loadMoreTarget = useTemplateRef('loadMoreTarget')


useIntersectionObserver(
    loadMoreTarget,
    ([entry]) => {
        targetIsVisible.value = entry?.isIntersecting || false
        if (targetIsVisible.value) {
            loadMoreRecords()
        }
    },
)

</script>

<template>
    <div ref="loadMoreTarget" v-if="nextPageUrl" class="flex justify-center py-5">
        <Button 
            variant="ghost"
            :label="$t('Load More')" 
            @click="loadMoreRecords()" 
            :processing="loadingMore"
        />
    </div>
</template>