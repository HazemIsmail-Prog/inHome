<script setup lang="ts">
import { useTabTitle } from '@/ts/composables/tabTitle'
import { useTheme } from '@/ts/composables/theme'
import DefaultLayout from '@/vue/layouts/DefaultLayout.vue'
import ThemeSwitcher from '@/vue/components/ThemeSwitcher.vue'
import LanguageSwitcher from '@/vue/components/LanguageSwitcher.vue'
import Button from '@/vue/components/Button.vue'

useTabTitle('Preferences')

const theme = useTheme()
theme.applyStoredUiPreferences()

const fontOptions: { id: string; labelKey: string }[] = [
    { id: 'compact', labelKey: 'Text size compact' },
    { id: 'default', labelKey: 'Text size default' },
    { id: 'large', labelKey: 'Text size large' },
]

const spaceOptions: { id: string; labelKey: string }[] = [
    { id: 'compact', labelKey: 'Spacing compact' },
    { id: 'default', labelKey: 'Spacing default' },
    { id: 'relaxed', labelKey: 'Spacing relaxed' },
]

const radiusOptions: { id: string; labelKey: string }[] = [
    { id: 'sharp', labelKey: 'Radius sharp' },
    { id: 'default', labelKey: 'Radius default' },
    { id: 'soft', labelKey: 'Radius soft' },
]
</script>

<template>
    <DefaultLayout>
        <template #header>
            <h1>{{ $t('Preferences') }}</h1>
        </template>

        <div class="mx-auto flex max-w-lg flex-col gap-[var(--space-stack)]">
            <section
                class="rounded-xl border border-border bg-background p-[var(--space-page)] shadow-sm"
            >
                <h2 class="text-xs font-semibold uppercase tracking-wider text-text-muted">
                    {{ $t('Theme and language') }}
                </h2>
                <div class="mt-4 flex flex-col gap-5">
                    <ThemeSwitcher />
                    <LanguageSwitcher />
                </div>
            </section>

            <section
                class="rounded-xl border border-border bg-background p-[var(--space-page)] shadow-sm"
            >
                <h2 class="text-xs font-semibold uppercase tracking-wider text-text-muted">
                    {{ $t('Text size') }}
                </h2>
                <p class="mt-2 text-sm leading-relaxed text-text-muted">
                    {{ $t('Text size hint') }}
                </p>
                <div class="mt-4 flex flex-col gap-2 rounded-lg bg-secondary-background p-1 sm:flex-row">
                    <Button
                        v-for="opt in fontOptions"
                        :key="opt.id"
                        class="w-full sm:flex-1"
                        :variant="theme.fontPreset.value === opt.id ? 'accent' : 'ghost'"
                        :label="$t(opt.labelKey)"
                        @click="theme.fontPreset.value = opt.id"
                    />
                </div>
            </section>

            <section
                class="rounded-xl border border-border bg-background p-[var(--space-page)] shadow-sm"
            >
                <h2 class="text-xs font-semibold uppercase tracking-wider text-text-muted">
                    {{ $t('Layout density') }}
                </h2>
                <p class="mt-2 text-sm leading-relaxed text-text-muted">
                    {{ $t('Spacing hint') }}
                </p>
                <div class="mt-4 flex flex-col gap-2 rounded-lg bg-secondary-background p-1 sm:flex-row">
                    <Button
                        v-for="opt in spaceOptions"
                        :key="opt.id"
                        class="w-full sm:flex-1"
                        :variant="theme.spacePreset.value === opt.id ? 'accent' : 'ghost'"
                        :label="$t(opt.labelKey)"
                        @click="theme.spacePreset.value = opt.id"
                    />
                </div>
            </section>

            <section
                class="rounded-xl border border-border bg-background p-[var(--space-page)] shadow-sm"
            >
                <h2 class="text-xs font-semibold uppercase tracking-wider text-text-muted">
                    {{ $t('Corner roundness') }}
                </h2>
                <p class="mt-2 text-sm leading-relaxed text-text-muted">
                    {{ $t('Radius hint') }}
                </p>
                <div class="mt-4 flex flex-col gap-2 rounded-lg bg-secondary-background p-1 sm:flex-row">
                    <Button
                        v-for="opt in radiusOptions"
                        :key="opt.id"
                        class="w-full sm:flex-1"
                        :variant="theme.radiusPreset.value === opt.id ? 'accent' : 'ghost'"
                        :label="$t(opt.labelKey)"
                        @click="theme.radiusPreset.value = opt.id"
                    />
                </div>
            </section>

            <section
                class="rounded-xl border border-border bg-background p-[var(--space-page)] shadow-sm"
            >
                <h2
                    class="text-center text-xs font-semibold uppercase tracking-wider text-text-muted sm:text-start"
                >
                    {{ $t('Accent color') }}
                </h2>
                <div class="mt-4 flex flex-col items-center gap-2.5">
                    <div class="mx-auto flex w-full items-center gap-2.5">
                        <input
                            id="page-accent-color"
                            type="color"
                            :value="theme.accentHex.value"
                            :aria-label="$t('Accent color')"
                            class="h-9 w-14 shrink-0 cursor-pointer rounded border border-border bg-background p-0.5"
                            @input="theme.accentHex.value = ($event.target as HTMLInputElement).value"
                        />
                        <code
                            class="min-w-0 flex-1 truncate rounded border border-border bg-secondary-background px-2 py-1.5 text-start text-xs text-text-muted sm:max-w-none"
                        >{{ theme.accentHex.value }}</code>
                    </div>
                </div>
            </section>

            <section
                v-if="theme.isNonDefault"
                class="rounded-xl border border-border border-dashed bg-secondary-background p-[var(--space-page)] text-center"
            >
                <p class="mx-auto max-w-prose text-sm leading-relaxed text-text-muted">
                    {{ $t('Layout prefs active hint') }}
                </p>
                <Button
                    class="mx-auto mt-3 w-full max-w-sm"
                    variant="ghost"
                    :label="$t('Reset layout preferences')"
                    @click="theme.resetUiPreferences()"
                />
            </section>
        </div>
    </DefaultLayout>
</template>
