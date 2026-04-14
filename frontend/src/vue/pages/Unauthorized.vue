<script setup lang="ts">
import Button from '@/vue/components/Button.vue'
import { useRouter } from 'vue-router'

const router = useRouter()
</script>

<template>
    <div class="flex min-h-dvh items-center justify-center bg-secondary-background p-4">
        <div
            class="flex w-full max-w-md flex-col gap-5 rounded-xl border border-border bg-background p-8 text-center shadow-[var(--shadow-card)]"
        >
            <h1 class="text-3xl font-bold leading-tight tracking-tight text-danger">{{ $t('Unauthorized') }}</h1>
            <p class="text-base leading-relaxed text-text-muted">
                {{ $t('You do not have permission to access this page.') }}
            </p>
            <Button :label="$t('Back')" class="min-h-10 min-w-[8rem]" @click="router.back()" />
        </div>
    </div>
</template>
