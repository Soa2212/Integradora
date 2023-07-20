<script setup>
import { ref } from 'vue';

const categorias = ref({});
const eliminar = ref(false);

fetch("http://localhost/categorias")
.then(res => res.json())
.then(data => categorias.value = data.data);
</script>

<template>
  <v-row class="pa-5">
    <v-col cols="auto">
            <v-btn block rounded="xl" size="large"><v-icon
          icon="mdi-plus-circle" class="mr-2"></v-icon>Agregar categoria</v-btn>
        </v-col>
        <v-col cols="auto">
            <v-btn @click="eliminar=true" block rounded="xl" size="large"><v-icon
          icon="mdi-minus-circle" class="mr-2"></v-icon>Eliminar categoria</v-btn>
        </v-col>
  </v-row>
    <div class="pa-5">
      <h1>Categorias</h1>
      <v-divider class="mb-5" thickness="2" color="black"></v-divider>
      <div class="d-flex justify-end">
        <v-btn @click="eliminar=false" class="ma-3" v-if="eliminar">Cancelar</v-btn>
        <v-btn class="ma-3" v-if="eliminar">Eliminar</v-btn>
      </div>
      <div class="tabla">
        <v-table>
          <thead>
            <tr>
              <th v-if="eliminar" class="text-left">
                Eliminar
              </th>
              <th class="text-left">
                Categoria
              </th>
              <th class="text-left">
                Estado
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="cat in categorias"
              :key="cat.id"
            >
              <td v-if="eliminar" style="width: 10px;">
                <v-checkbox class="d-flex justify-center align-center"></v-checkbox>
              </td>
              <td>{{ cat.categoria }}</td>
              <td>{{ cat.estado }}</td>
            </tr>
          </tbody>
        </v-table>
      </div>
    </div>
</template>

<style scoped>
</style>