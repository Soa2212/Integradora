<script setup>
import { RouterLink, RouterView } from 'vue-router';
import NavBar from './components/NavBar.vue';
</script>

<template>
<v-app id="inspire">
  <v-system-bar style="height: -24px;">
    <NavBar></NavBar>
  </v-system-bar>
  
 <div style="margin-top: 100px;">
  <div ><RouterView></RouterView></div>
 </div>
</v-app>

</template>
<style>
</style>