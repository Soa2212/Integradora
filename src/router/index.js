// Composables
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    component: () => import('@/layouts/default/Default.vue'),
    children: [
      {
        path: '/Home',
        name: 'Home',
        component: () => import('@/views/Home.vue'),
      },
      { 
        path:'/ProductosView',
        name:'ProductosView',
        component:()=>import('@/views/ProductosView.vue')
      },
      {
        path:'/CotizacionView',
        name:'CotizacionView',
        component:()=>import('@/views/CotizacionView.vue')
      }
      ,
      {
        path:'/LoginView',
        name:'LoginView',
        component:()=>import('@/views/LoginView.vue')
      }
    ],
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

export default router
