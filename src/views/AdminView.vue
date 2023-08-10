<script setup>
import { ref } from "vue";
import { useTokenStore } from "@/stores/TokenUser";
import { useTipoStore } from "@/stores/TipoUSR";
import { useEmailStore } from "@/stores/EmailUSR";
const tokenStore = useTokenStore();
const TipoUSR = useTipoStore();

const Email = useEmailStore();
const contenidoEmailLS = Email.getEmailLS;

const drawer = ref(null);

const links = [
  ["mdi-store", "Productos", "AdminPro"],
  ["mdi-tag", "Categorias", "AdminCat"],
  ["mdi-home-analytics", "Analiticas", "AdminRep"],
  ["mdi-currency-usd", "Realizar pedido", "AdminPed"],
  ["mdi-account", "Agregar usuario", "AdminAdd"],
];

const logout = () => {
  tokenStore.eliminarTokenDelLocalStorage();
  TipoUSR.eliminarTipoDelLocalStorage();
  location.reload();
};
</script>

<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer">
      <v-sheet color="grey-lighten-4" class="pa-4">
        <v-avatar class="mb-4" color="grey-darken-1" size="64"></v-avatar>

        <div>{{contenidoEmailLS}}</div>
      </v-sheet>

      <v-divider></v-divider>

      <v-list>
        <v-list-item v-for="[icon, text, link] in links" :key="icon" link>
          <template v-slot:prepend>
            <v-icon>{{ icon }}</v-icon>
          </template>

          <router-link
            :to="{ name: link }"
            style="text-decoration: none; color: black"
            ><v-list-item-title>{{ text }}</v-list-item-title></router-link
          >
        </v-list-item>
        <v-list-item>
          <v-btn @click="logout()"
            ><v-icon class="mdi-exit-to-app"></v-icon>Cerrar sesion</v-btn
          >
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>Dashboard</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<style scoped></style>
