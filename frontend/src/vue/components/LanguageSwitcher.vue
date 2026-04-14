<script setup lang="ts">
import Button from './Button.vue'
</script>

<template>
    <div class="flex flex-col gap-3">
        <h2 class="text-xs font-semibold uppercase tracking-wider text-text-muted">{{ $t('Language') }}</h2>
        <div class="flex items-center p-1 bg-secondary-background rounded">
            <Button v-for="locale in $i18n.availableLocales" :key="`locale-${locale}`"
                class="w-full"
                @click="$i18n.locale = locale"
                :label="$t(locale)"
                :variant="$i18n.locale === locale ? 'accent' : 'ghost'"
            />
        </div>
    </div>
</template>