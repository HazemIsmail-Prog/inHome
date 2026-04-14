import './assets/main.css'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from '@/App.vue'
import router from '@/ts/router'
import { i18n } from '@/ts/lib/i18n'
import { useColorMode } from '@vueuse/core'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import { useTheme } from '@/ts/composables/theme'

const app = createApp(App)


const mode = useColorMode({
    initialValue: 'auto',
    storageKey: 'theme',
})

const { applyStoredUiPreferences } = useTheme()
applyStoredUiPreferences()

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)
app.use(pinia)

app.provide('mode', mode)
app.use(router)
app.use(i18n)

app.mount('#app')






