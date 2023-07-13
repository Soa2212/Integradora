<script setup>
import { RouterLink, RouterView } from 'vue-router';
import NavBar from './components/NavBar.vue';
</script>

<template>
<v-app id="inspire">
  <v-system-bar style="height: -24px;">
    <NavBar></NavBar>
  </v-system-bar>
  
 <div style="margin-top: 70px; background-color:beige ;">
  <div style="margin-top: 30px;"><RouterView></RouterView></div>
 </div>
</v-app>

</template>
<style>
</style>