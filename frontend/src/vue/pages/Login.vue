<script setup lang="ts">
import { useTabTitle } from '@/ts/composables/tabTitle'
import { useAuthStore } from '@/ts/stores/auth'
import Button from '@/vue/components/Button.vue'
import Label from '@/vue/components/Label.vue'
import Input from '@/vue/components/Input.vue'
import { ref } from 'vue'
import type { LoginForm } from '@/ts/types'

useTabTitle('Login')
const auth = useAuthStore()
const form = ref<LoginForm>({
    email: 'test@example.com',
    password: 'password',
})

</script>

<template>
    <div class="flex min-h-dvh bg-secondary-background items-center justify-center">
        <form
            @submit.prevent="auth.login(form)"
            class="flex w-full max-w-md flex-col gap-5 rounded-xl border border-border bg-background p-8 shadow-[var(--shadow-card)]"
        >
            <h2 class="text-center text-2xl font-bold leading-tight tracking-tight text-text">
                {{ $t('Login') }}
            </h2>
            <div
                v-if="auth.authError"
                class="relative rounded-md border border-danger/30 bg-danger/10 px-4 py-3 text-sm leading-relaxed text-danger ring-1 ring-danger/15"
                role="alert"
            >
                <span class="block sm:inline">{{ auth.authError?.message }}</span>
            </div>
            <div>
                <Label :text="$t('Email')" for="email" />
                <Input
                    id="email"
                    type="email"
                    class="text-center"
                    v-model="form.email"
                    autocomplete="email"
                    required
                />
            </div>
            <div>
                <Label :text="$t('Password')" for="password" />
                <Input
                    type="password"
                    class="text-center"
                    id="password"
                    v-model="form.password"
                    autocomplete="current-password"
                    required
                />
            </div>
            <div class="flex justify-center pt-1">
                <Button
                    type="submit"
                    class="w-full min-h-10"
                    :processing="auth.loading"
                    :label="$t('Login')"
                />
            </div>
        </form>
    </div>
</template>