<script setup>
import { ref, onMounted , watch, computed } from "vue";
import { useRouter, RouterView } from "vue-router";
import NavBar from "./components/NavBar.vue";
import Footer from "./components/Footer.vue";
import AdminView from "./views/AdminView.vue";
import { useTipoStore } from "@/stores/TipoUSR";

const TipoUSR = useTipoStore();
const Admin = computed(() => TipoUSR.tieneTipo);

const loginResult = ref({//Este es el arreglo que se vendra con la verificacion
  isAdmin: Admin.value, // Cambiar a 'false' si el usuario es cliente
});

// Verificar el rol del usuario y establecer la variable 'admin'
let admin = loginResult.value.isAdmin;

watch(
  Admin,
  (newValue) => {
    const router = useRouter();
    if (newValue) {
      router.push({ name: "AdminPro" });
    } else {
      router.push({ name: "HomeView" });
    }
  }
);

// Realizar la redirección después de que el componente se haya montado y el valor de 'admin' esté actualizado
onMounted(() => {
  if (admin !== null) {
    // Realizar la redirección inicial según el valor de 'admin' al montar el componente
    const router = useRouter();
    if (admin) {
      router.push({ name: "AdminPro" }); // Cambia "AdminPro" al nombre de la ruta de AdminProductos
    } else {
      router.push({ name: "HomeView" });
    }
  }
});
</script>

<template>
  <v-app>
    <v-system-bar style="height: -24px" v-if="!admin">
      <!-- Mostrar NavBar solo si el usuario es cliente -->
      <NavBar ></NavBar>
    </v-system-bar>

    <div style=" background-color: beige;">
      <!-- Verificar si el usuario es administrador -->
      <template v-if="loginResult.isAdmin">
        <!-- Mostrar la vista de administrador -->
        <AdminView></AdminView>
      </template>
      <template v-else>
        <!-- Mostrar la vista de cliente -->
        <div style="margin-top: 90px">
          <RouterView></RouterView>
          <Footer></Footer>
        </div>
      </template>
    </div>
  </v-app>
</template>
