<script setup lang="ts">
import { Sparkles } from '@lucide/vue'
</script>

<template>
    <div
        class="flex min-h-[min(320px,45dvh)] flex-col items-center justify-center gap-8 bg-background px-[var(--space-page)] py-12 text-center sm:px-8"
    >
        <div
            class="relative flex h-20 w-20 items-center justify-center rounded-2xl bg-accent/10 shadow-[var(--surface-inset-highlight)] ring-1 ring-accent/25"
            aria-hidden="true"
        >
            <div
                class="pointer-events-none absolute inset-0 rounded-2xl [background-image:var(--gradient-accent-glow)]"
            />
            <Sparkles class="relative size-9 text-accent" :stroke-width="1.5" />
        </div>

        <div class="max-w-sm space-y-3">
            <h2 class="text-lg font-semibold leading-snug tracking-tight text-text">
                {{ $t('emptyStateTitle') }}
            </h2>
            <p class="text-base leading-relaxed text-text-muted">
                {{ $t('emptyStateSubtitle') }}
            </p>
        </div>

        <div
            class="w-full max-w-sm rounded-xl border border-dashed border-border bg-secondary-background px-4 py-4 text-start sm:px-5"
        >
            <p class="text-xs font-medium uppercase tracking-wide text-text-muted">
                {{ $t('Tip') }}
            </p>
            <p class="mt-1 text-sm leading-relaxed text-text-muted">
                {{ $t('emptyStateTip') }}
            </p>
        </div>
    </div>
</template>
