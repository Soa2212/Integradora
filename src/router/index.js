import { createRouter, createWebHashHistory  } from "vue-router";

const routes = [
  {
    path: "",
    redirect: "/HomeView", // Redireccionar la ruta raíz a la página de inicio
  },
  {
    path: "/HomeView",
    name: "HomeView",
    component: () => import("@/views/HomeView.vue"),
  },
  {
    path: "/ProductosView",
    name: "ProductosView",
    component: () => import("@/views/ProductosView.vue"),
  },
  {
    path: "/LoginView",
    name: "LoginView",
    component: () => import("@/views/LoginView.vue"),
  },
  {
    path: "/AcercaView",
    name: "AcercaView",
    component: () => import("@/views/AcercaView.vue"),
  },
  {
    path: "/Registro",
    name: "Registro",
    component: () => import("@/views/RegistroView.vue"),
  },
  {
    path: "/Carrito",
    name: "Carrito",
    component: () => import("@/views/CarritoView.vue"),
  },
  {
    path: "/AdminHome",
    name: "AdminHome",
    component: () => import("@/components/AdminHome.vue"),
  },
  {
    path: "/AdminProductos",
    name: "AdminPro",
    component: () => import("@/components/ProductosAdmin.vue"),
  },
  {
    path: "/AdminCategorias",
    name: "AdminCat",
    component: () => import("@/components/CategoriasAdmin.vue"),
  },
  {
    path: "/AgregarAdmin",
    name: "AdminAdd",
    component: () => import("@/components/AgregarUsuarioAdmin.vue"),
  },
  {
    path: "/AdminReportes",
    name: "AdminRep",
    component: () => import("@/components/AdminReportes.vue"),
  },
  {
    path: "/AdminPedido",
    name: "AdminPed",
    component: () => import("@/components/AdminPedidos.vue"),
  },
  {
    path: "/Pedidos",
    name: "Pedidos",
    component: () => import("@/components/Pedidos.vue"),
  },
  {
    path: "/ActualizarStock",
    name: "Stock",
    component: () => import("@/components/AdminStock.vue"),
  }
];

const router = createRouter({
  history: createWebHashHistory(process.env.BASE_URL),
  routes,
});

export default router;
