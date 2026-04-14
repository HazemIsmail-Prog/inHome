import LoginView from '@/vue/pages/Login.vue'
import DashboardView from '@/vue/pages/Dashboard.vue'
import UsersIndex from '@/vue/pages/users/Index.vue'
import PermissionsIndex from '@/vue/pages/permissions/Index.vue'
import RolesIndex from '@/vue/pages/roles/Index.vue'
import PreferencesView from '@/vue/pages/Preferences.vue'
import UnauthorizedView from '@/vue/pages/Unauthorized.vue'
import NotfoundView from '@/vue/pages/Notfound.vue'


export const routes = [

        {
          path: '/login',
          name: 'login',
          component: LoginView,
          meta: {
            guest: true,
          },
        },
        {
          path: '/',
          name: 'dashboard',
          component: DashboardView,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: '/users',
          name: 'users',
          component: UsersIndex,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: '/permissions',
          name: 'permissions',
          component: PermissionsIndex,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: '/roles',
          name: 'roles',
          component: RolesIndex,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: '/preferences',
          name: 'preferences',
          component: PreferencesView,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: '/unauthorized',
          name: 'unauthorized',
          component: UnauthorizedView,
        },
        {
          path: '/:pathMatch(.*)*',
          name: 'notfound',
          component: NotfoundView,
        },
    ]