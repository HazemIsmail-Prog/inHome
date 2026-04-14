import { computed, ref, watch } from 'vue'

export const TRANSITION_DURATION: string = '0.3s'

export const useTheme = () => {

    // Constants
    const ROOT = document.documentElement

    const UI_PREF_ACCENT_COLOR_KEY: string = 'ui-pref-accent-color'
    const UI_PREF_FONT_KEY: string = 'ui-pref-font'
    const UI_PREF_SPACE_KEY: string = 'ui-pref-space'
    const UI_PREF_RADIUS_KEY: string = 'ui-pref-radius'
    
    const ACCENT_DEFAULT_HEX: string = '#34875a'
    const accentHex = ref<string>(ACCENT_DEFAULT_HEX)
    const fontPreset = ref('default')
    const spacePreset = ref('default')
    const radiusPreset = ref('default')

    const applyStoredUiPreferences = () => {
        accentHex.value = localStorage.getItem(UI_PREF_ACCENT_COLOR_KEY) || ACCENT_DEFAULT_HEX
        fontPreset.value = localStorage.getItem(UI_PREF_FONT_KEY) || 'default'
        spacePreset.value = localStorage.getItem(UI_PREF_SPACE_KEY) || 'default'
        radiusPreset.value = localStorage.getItem(UI_PREF_RADIUS_KEY) || 'default'
    }

    const isNonDefault = computed(
        () =>
            fontPreset.value !== 'default' ||
            spacePreset.value !== 'default' ||
            radiusPreset.value !== 'default' ||
            accentHex.value !== ACCENT_DEFAULT_HEX,
    )


    const resetUiPreferences = () => {
        ;[
            UI_PREF_ACCENT_COLOR_KEY,
            UI_PREF_FONT_KEY,
            UI_PREF_SPACE_KEY,
            UI_PREF_RADIUS_KEY,
        ].forEach((k) =>
            localStorage.removeItem(k),
        )
        ROOT.style.removeProperty('--accent')
        ROOT.style.removeProperty('--ui-root-font-size')
        ROOT.style.removeProperty('--ui-space-scale')
        ROOT.style.removeProperty('--ui-radius-scale')
        accentHex.value = ACCENT_DEFAULT_HEX
        fontPreset.value = 'default'
        spacePreset.value = 'default'
        radiusPreset.value = 'default'
    }

    watch(accentHex, (newVal) => {
        if (newVal !== ACCENT_DEFAULT_HEX) {
            ROOT.style.setProperty('--accent', newVal)
        }
        localStorage.setItem(UI_PREF_ACCENT_COLOR_KEY, newVal)
    })

    watch(fontPreset, (newVal) => {
        switch (newVal) {
            case 'compact':
                ROOT.style.setProperty('--ui-root-font-size', '93.75%')
                break
            case 'large':
                ROOT.style.setProperty('--ui-root-font-size', '112.5%')
                break
            default:
                ROOT.style.removeProperty('--ui-root-font-size')
                break
        }
        localStorage.setItem(UI_PREF_FONT_KEY, newVal)
    })

    watch(spacePreset, (newVal) => {
        switch (newVal) {
            case 'compact':
                ROOT.style.setProperty('--ui-space-scale', '0.92')
                break
            case 'relaxed':
                ROOT.style.setProperty('--ui-space-scale', '1.1')
                break
            default:
                ROOT.style.removeProperty('--ui-space-scale')
                break
        }
        localStorage.setItem(UI_PREF_SPACE_KEY, newVal)
    })

    watch(radiusPreset, (newVal) => {
        switch (newVal) {
            case 'sharp':
                ROOT.style.setProperty('--ui-radius-scale', '0')
                break
            case 'soft':
                ROOT.style.setProperty('--ui-radius-scale', '1.32')
                break
            default:
                ROOT.style.removeProperty('--ui-radius-scale')
                break
        }
        localStorage.setItem(UI_PREF_RADIUS_KEY, newVal)
    })

    return {
        accentHex,
        fontPreset,
        spacePreset,
        radiusPreset,
        applyStoredUiPreferences,
        resetUiPreferences,
        isNonDefault,
    }
}
