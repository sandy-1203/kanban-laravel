import Vue from 'vue'
import VueRouter from 'vue-router'

import store from '@/store'

import authRoutes from '@/router/auth.routes'
import kanbanRoutes from './kanban.routes'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: '/',
  // base: process.env.BASE_URL,
  scrollBehavior() {
    return { x: 0, y: 0, behavior: 'smooth' }
  },
  routes: [
    { path: '/', redirect: { name: 'sign-in' } },
    ...authRoutes,
    ...kanbanRoutes,
    {
      path: '*',
      redirect: 'error-404',
    },
  ],
})

const sendBackToLogin = next => next({ name: 'sign-in' })
const sendBackToDashboard = next => next({ name: 'home' })

const checkAuth = async (to, from, next) => {
  const loggedIn = await store.dispatch('auth/verifyAuth')
  // Ensure we checked auth before each page load.
  if (!to.meta.allowAll) {
    if ('guarded' in to.meta) {
      if (to.meta.guarded) {
        if (!loggedIn) {
          return sendBackToLogin(next)
        }
      } else if (loggedIn) {
        return sendBackToDashboard(next)
      }
    } else if (!loggedIn) {
      return sendBackToLogin(next)
    }
  }
  return next()
}

router.beforeEach(checkAuth)

router.afterEach(() => {
  // Remove initial loading
  const body = document.body
  body.classList.remove('hold-transition')
})

export default router
