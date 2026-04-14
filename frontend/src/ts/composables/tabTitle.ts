import { useTitle } from '@vueuse/core'
import { watch } from 'vue'
import { useI18n } from 'vue-i18n'

export const useTabTitle = (title: string) => {
    const i18n = useI18n()
    useTitle(i18n.t(title))
    watch(i18n.locale, () => {
        useTitle(i18n.t(title))
    })
}

