import { createRouter, createWebHistory } from 'vue-router'
import AppLayout from '@/layouts/AppLayout.vue'
import DashboardView from '@/views/DashboardView.vue'
import NotFoundView from '@/views/NotFoundView.vue'
import TeamsView from '@/views/teams/TeamsView.vue'

const routes = [
  {
    path: '',
    component: AppLayout,
    redirect: { name: 'dashboard' },
    children: [
      {
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardView,
        meta: {
          title: 'Dashboard',
          icon: 'tabler:layout-dashboard',
          showOnSidebar: true
        }
      }
    ],
  },
  {
    path: '/teams',
    component: AppLayout,
    redirect: { name: 'teams' },
    children: [
      {
        path: '/teams',
        name: 'teams',
        component: TeamsView,
        meta: {
          title: 'Teams',
          icon: 'mdi:security',
          showOnSidebar: true
        }
      }
    ],
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: NotFoundView
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach(async (to, from, next) => {
  next();
});

export default router
