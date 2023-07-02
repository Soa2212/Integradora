import { createRouter, createWebHistory } from 'vue-router'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {path:'/Inicio',
      name:'Inicio',
      component:()=>import('../views/Inicio.vue')},
    {path:'/Acerca',
      name:'Acerca',
      component:()=>import('../views/Acerca.vue')},
      {path:'/Cotizacion',
      name:'Cotizacion',
      component:()=>import('../views/Cotizacion.vue')}
    
   
  ]
})

export default router
