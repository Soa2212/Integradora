<script setup>
import { ref } from "vue";
const length = ref(["Ventas en linea", "Ventas en local"]);
const onboarding = ref(0);
</script>

<template>
  <h1 class="ml-5 mt-5">Reportes de ventas</h1>
  <v-app class="ma-5">
    <v-window v-model="onboarding" show-arrows="hover">
      <v-window-item v-for="n in length" :key="`card-${n}`">
        <v-card
          elevation="2"
          height="100"
          class="d-flex align-center justify-center ma-2"
        >
          <h1 class="text-h4">
            {{ n }}
          </h1>
        </v-card>
      </v-window-item>
    </v-window>
  </v-app>
</template>
