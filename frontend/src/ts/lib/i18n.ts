import { createI18n } from "vue-i18n";
import en from '@/json/translations/en.json'
import ar from '@/json/translations/ar.json'
import { watch } from "vue";

export const i18n = createI18n({
    legacy: false,
    locale: localStorage.getItem('locale') || 'en',
    fallbackLocale: 'en',
    messages: {
        en: en,
        ar: ar
    }
})

const updateRootDir = () => {
    document.documentElement.lang = i18n.global.locale.value
    document.dir = i18n.global.locale.value === 'ar' ? 'rtl' : 'ltr'
}
// this is to update the root dir of the document at the start
updateRootDir()

// this is to update the root dir of the document when the locale changes
watch(i18n.global.locale, (newVal: string) => {
    localStorage.setItem('locale', newVal)
    updateRootDir()
})