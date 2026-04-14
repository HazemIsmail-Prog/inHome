import { createRouter, createWebHistory } from 'vue-router'
import { routes } from './routes'
import { useAuthStore } from '@/ts/stores/auth'
import { useModalsStore } from '@/ts/stores/modals'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

router.beforeEach(async (to, from) => {
  if (from.path !== to.path) {
    useModalsStore().dismissRightModal()
  }

  const auth = useAuthStore()
  // await auth.getUser()
  if (to.meta.guest && auth.isAuthenticated) {
    return { name: 'dashboard' }
  } else if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return { name: 'login' }
  } else {
    return true
  }
})  
export default router
