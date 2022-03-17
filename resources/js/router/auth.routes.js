export default [
  {
    name: 'sign-in',
    path: '/sign-in',
    component: () => import('@/pages/auth/SignIn.vue'),
    meta: { layout: 'full', guarded: false },
  },
  {
    name: 'sign-up',
    path: '/sign-up',
    component: () => import('@/pages/auth/SignUp.vue'),
    meta: { layout: 'full', guarded: false },
  },
  {
    name: 'home',
    path: '/home',
    component: () => import('@/pages/auth/Home.vue'),
    meta: {
      title: 'Home',
      layout: 'main',
      breadcrumbs: [{ title: 'Home', to: { name: 'home' }, active: true }],
    },
  },
]
