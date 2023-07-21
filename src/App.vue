<script setup>
import { RouterLink, RouterView } from 'vue-router';
import NavBar from './components/NavBar.vue';
import Footer from './components/Footer.vue';
import AdminView from './views/AdminView.vue';

// Cambiar el valor de esta variable a 'false' cuando quieran visualizar la otra pagina(como eres mañoso tovar)
let admin = false;
</script>

<template>
<v-app v-if="admin" id="administrador">
  <AdminView></AdminView>
</v-app>
<v-app v-if="!admin" id="inspire">
  <v-system-bar style="height: -24px;">
    <NavBar></NavBar>
  </v-system-bar>
  
 <div style="margin-top: 70px; background-color:beige ;">
  <div style="margin-top: 30px;"><RouterView></RouterView></div>
  <div>
    <Footer></Footer>
  </div>
</div>

</v-app>

</template>
<style>
</style>