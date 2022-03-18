export default [
  {
    name: 'board-list',
    path: '/board/list',
    component: () => import('@/pages/board/BoardList.vue'),
    meta: {
      title: 'Manage Boards',
      layout: 'main',
      breadcrumbs: [
        { title: 'Home', to: { name: 'home' } },
        { title: 'Board', to: { name: 'board-list' }, active: true },
      ],
    },
  },
  {
    name: 'create-board',
    path: '/board/create',
    component: () => import('@/pages/board/CreateBoard.vue'),
    meta: {
      title: 'Create Products',
      layout: 'main',
      breadcrumbs: [
        { title: 'Home', to: { name: 'home' } },
        { title: 'Board', to: { name: 'board-list' } },
        { title: 'Create Board', to: { name: 'create-board' }, active: true },
      ],
    },
  },
  {
    name: 'view-board',
    path: '/board/:id',
    component: () => import('@/pages/board/ViewBoard.vue'),
    meta: {
      // title: 'Kanban Board',
      get title() {
        const _vm = document.getElementById('app')?.__vue__
        const boardName = _vm.$store.state.kanban.board.name
        const pageTitle = 'Kanban Board'
        if (boardName) return `${boardName} | ${pageTitle}`
        return pageTitle
      },
      layout: 'main-full',
    },
  },
]
