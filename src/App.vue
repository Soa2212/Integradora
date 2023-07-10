<script setup>
import { RouterLink, RouterView } from 'vue-router';
import NavBar from './components/NavBar.vue';
</script>

<template>
<v-app id="inspire">
  <v-system-bar>
    <NavBar></NavBar>
  </v-system-bar>
  
 <div style="margin-top: 160px;">
  <div style="margin-block-start: -20px;"><RouterView></RouterView></div>
 </div>
</v-app>

</template>
<style>
</style>