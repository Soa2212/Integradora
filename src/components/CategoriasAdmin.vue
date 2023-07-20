<script setup>
import { ref } from 'vue';

const categorias = ref({});
const eliminar = ref(false);
const dialog = ref(false);
const dialogDel = ref(false);
const alerta = ref(false);

const seleccionados = ref([]);

const categoriaNueva = ref({
  categoria: '',
  estado: 'activo'
});

fetch("http://localhost/categorias")
.then(res => res.json())
.then(data => categorias.value = data.data);

const agregarCategoria = () => {
  fetch('http://localhost/insertarCat', {
  method: "POST",
  body: JSON.stringify(categoriaNueva.value)
})};

const eliminarCategoria = () => {
  if(seleccionados.value[0] != undefined){
    fetch('http://localhost/eliminarCat', {
  method: "POST",
  body: JSON.stringify(seleccionados.value)})
  } else {
    alert('No seleccionaste ninguna categoria')
  }  
}


</script>

<template>
  <v-row class="pa-5">
    <v-col cols="auto">
      <v-dialog v-model="dialog" width="900">
        <template v-slot:activator="{ props }">
          <v-btn v-bind="props" block rounded="xl" size="large"
            ><v-icon icon="mdi-plus-circle" class="mr-2"></v-icon>Agregar
            categoria</v-btn
          >
        </template>
        <v-card>
          <v-card-title>Agregar categoria</v-card-title>
          <v-card-text>
            <v-container>
              <form @submit="agregarCategoria">
                <v-row>
                <v-col cols="12" sm="12" md="12">
                  <v-text-field v-model="categoriaNueva.categoria" label="Nombre*" required></v-text-field>
                </v-col>
              </v-row>
              <v-row class="d-flex justify-end pr-3">
                <v-btn type="submit">Agregar</v-btn>
              </v-row>
              </form>
            </v-container>
            <small>* Indica que es un campo requerido</small>
          </v-card-text>
        </v-card>
      </v-dialog>
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
        <v-dialog
      v-model="dialogDel"
      persistent
      width="1024"
    >
      <template v-slot:activator="{ props }">
        <v-btn v-bind="props" class="ma-3" v-if="eliminar">Eliminar</v-btn>
      </template>
      <v-card>
        <form @submit="eliminarCategoria">
          <v-card-title>
          <span class="text-h5">¿Está seguro que desea eliminar las siguientes categorias?</span>
        </v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue-darken-1" variant="text" type="submit">Acepto</v-btn>
          <v-btn color="blue-darken-1" variant="text" @click="dialogDel = false">Cancelar</v-btn>
        </v-card-actions>
        </form>
      </v-card>
    </v-dialog>
        
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
                <v-checkbox v-model="seleccionados" class="d-flex justify-center align-center" :value="cat.categoria"></v-checkbox>
              </td>
              <td>{{ cat.categoria }}</td>
              <td>{{ cat.estado }}</td>
            </tr>
          </tbody>
        </v-table>
        <v-alert v-if="alerta"
    density="compact"
    type="warning"
    title="No ha seleccionado una categoria"
    text="Por favor, seleccione las categorias que necesita eliminar"
  ></v-alert>
      </div>
    </div>
</template>

<style scoped>
</style>