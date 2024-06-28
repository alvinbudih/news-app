import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import { useGlobalStore } from '@/stores/global'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import DashboardView from '@/views/DashboardView.vue'
import LogView from '@/views/LogView.vue'
import IndexView from '@/views/News/IndexView.vue'
import FormView from '@/views/News/FormView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      children: [
        {
          path: '/',
          name: 'dashboard',
          component: DashboardView
        },
        {
          path: '/news',
          name: 'news',
          component: IndexView
        },
        {
          path: '/news/create',
          name: 'newsCreate',
          component: FormView
        },
        {
          path: '/logs',
          name: 'logs',
          component: LogView
        }
      ]
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    }
    // {
    //   path: '/about',
    //   name: 'about',
    //   // route level code-splitting
    //   // this generates a separate chunk (About.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () => import('../views/AboutView.vue')
    // }
  ]
})

router.beforeEach((to, from, next) => {
  let { isLogin } = useGlobalStore()

  if (!isLogin && to.name !== 'login' && to.name !== 'register') {
    next({ name: 'login' })
  } else if (isLogin && (to.name === 'login' || to.name === 'register')) {
    next({ name: 'home' })
  } else {
    next()
  }
})

export default router
