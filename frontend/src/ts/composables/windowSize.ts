import { useWindowSize } from '@vueuse/core'
import { computed } from 'vue'

export const { width: windowWidth, height: windowHeight } = useWindowSize()

export const isMobile = computed(() => windowWidth.value < 768)