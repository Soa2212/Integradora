import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: ()=>import('../views/home.vue')
    },
    {
      path: '/categorias',
      name: 'categorias',
      component: ()=>import('../views/categorias.vue')
    },
    {
      path: '/productos',
      name: 'productos',
      component: ()=>import('../views/productos.vue')
    },
    {
      path: '/acercade',
      name: 'acercade',
      component: ()=>import('../views/acercade.vue')
    }
  ]
})

export default router
