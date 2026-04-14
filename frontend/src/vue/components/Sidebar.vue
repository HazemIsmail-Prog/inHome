<script setup lang="ts">
import NavItem from '@/vue/components/NavItem.vue'
import { Home, Users, LogOut, ShieldCheck, SlidersHorizontal } from '@lucide/vue'
import Button from '@/vue/components/Button.vue'
import { useAuthStore } from '@/ts/stores/auth'
const auth = useAuthStore()
import { useTranslateBackend } from '@/ts/composables/translateBackend'

const { translated } = useTranslateBackend()

</script>

<template>
            <div
                class="flex flex-col h-full overflow-hidden bg-background p-[var(--space-page)] rounded-xl border border-border"
            >
                <div class="shrink-0">
                    <h1 class="px-0.5 text-lg font-bold tracking-tight text-text whitespace-nowrap">
                        My App
                    </h1>
                    <hr class="my-4 border-border" />
                </div>

                <nav
                    class="flex min-h-0 flex-1 flex-col gap-2 overflow-y-auto overflow-x-hidden overscroll-contain"
                    aria-label="Main"
                >
                    <NavItem
                        v-if="auth.user?.can.includes('dashboard_view')"
                        :icon="Home"
                        :label="$t('Dashboard')"
                        :isActive="$route.name === 'dashboard'"
                        :to="{ name: 'dashboard' }"
                    />
                    <NavItem
                        v-if="auth.user?.can.includes('permissions_view')"
                        :icon="ShieldCheck"
                        :label="$t('Permissions')"
                        :isActive="$route.name === 'permissions'"
                        :to="{ name: 'permissions' }"
                    />
                    <NavItem
                        v-if="auth.user?.can.includes('roles_view')"
                        :icon="ShieldCheck"
                        :label="$t('Roles')"
                        :isActive="$route.name === 'roles'"
                        :to="{ name: 'roles' }"
                    />
                    <NavItem
                        v-if="auth.user?.can.includes('users_view')"
                        :icon="Users"
                        :label="$t('Users')"
                        :isActive="$route.name === 'users'"
                        :to="{ name: 'users' }"
                    />

                    <NavItem
                        v-if="auth.user?.can.includes('clients_view')"
                        :icon="Users"
                        :label="$t('Clients')"
                        :isActive="$route.name === 'clients'"
                        :to="{ name: 'clients' }"
                    />

                    <NavItem
                        v-if="auth.user?.can.includes('stores_view')"
                        :icon="Users"
                        :label="$t('Stores')"
                        :isActive="$route.name === 'stores'"
                        :to="{ name: 'stores' }"
                    />
                    
                    <NavItem
                        class="mt-auto mb-3"
                        :icon="SlidersHorizontal"
                        :label="$t('Preferences')"
                        :isActive="$route.name === 'preferences'"
                        :to="{ name: 'preferences' }"
                    />
                </nav>


                <div class="shrink-0 border-t border-border pt-4">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium leading-snug text-text whitespace-nowrap">
                            {{ translated(auth.user?.name) }}
                        </p>
                        <p class="mt-0.5 truncate text-xs leading-normal text-accent whitespace-nowrap">
                            {{ auth.user?.email }}
                        </p>
                    </div>

                    <div class="mt-3 flex flex-col gap-3">


                        <Button
                            class="justify-start"
                            v-if="auth.user"
                            :leading-icon="LogOut"
                            :processing="auth.loading"
                            :label="$t('Logout')"
                            @click="auth.logout()"
                        />
                    </div>
                </div>

            </div>


</template>