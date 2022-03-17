export default [
  {
    name: 'view-board',
    path: '/board/:id',
    component: () => import('@/pages/board/ViewBoard.vue'),
    meta: {
      title: 'Kanban Board',
      layout: 'main-full',
    },
  },
]
