// Composables
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    component: () => import('@/layouts/default/Default.vue'),
    children: [
      {
        path: '/HomeView',
        name: 'HomeView',
        component: () => import('@/views/HomeView.vue'),
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
      },
      {
        path:'/LoginView',
        name:'LoginView',
        component:()=>import('@/views/LoginView.vue')
      },
      {
        path:'/AcercaView',
        name:'AcercaView',
        component:()=>import('@/views/AcercaView.vue')
      },
      {
        path:'/Registro',
        name:'Registro',
        component:()=>import('@/views/RegistroView.vue')
      }

    ],
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

export default router
