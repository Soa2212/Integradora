<script setup>
import { onMounted, ref } from "vue";

const categorias = ref({});
const categoriasInactivas = ref({});
const eliminar = ref(false);
const dialog = ref(false);
const dialogInh = ref(false);
const alerta = ref(false);
const timestamp = Date.now();
const url = `http://3.136.87.82/inhabilitarCat?timestamp=${timestamp}`;

const seleccionados = ref([]);
const seleccionadosActivar = ref([]);

const categoriaNueva = ref({
  categoria: "",
  estado: "activo",
});

const mostrarCategorias = () => {
  fetch("http://3.136.87.82/categorias")
    .then((res) => res.json())
    .then((data) => (categorias.value = data.data));
};

const mostrarCategoriasInactivas = () => {
  fetch("http://3.136.87.82/categoriasInactivas")
    .then((res) => res.json())
    .then((data) => (categoriasInactivas.value = data.data));
};

onMounted(() => {
  mostrarCategorias();
  mostrarCategoriasInactivas();
});

const cancelar = () => {
  eliminar.value = false;
  seleccionados.value = [];
  alerta.value = false;
};

const agregarCategoria = (event) => {
  event.preventDefault();
  dialog.value = false;
  fetch("http://3.136.87.82/insertarCat", {
    method: "POST",
    body: JSON.stringify(categoriaNueva.value),
  });
  categoriaNueva.value.categoria = "";
  setTimeout(() => {
    mostrarCategorias();
  }, 500);
};

const habilitarCategoria = (event) => {
  if (seleccionadosActivar.value[0] != undefined) {
    event.preventDefault();
    dialogInh.value = false;
    alerta.value = false;
    fetch("http://3.136.87.82/habilitarCat", {
      method: "POST",
      body: JSON.stringify(seleccionadosActivar.value),
    });
    seleccionadosActivar.value = [];
    setTimeout(() => {
      mostrarCategorias();
      mostrarCategoriasInactivas();
    }, 500);
  } else {
    event.preventDefault();
    alerta.value = true;
    dialogInh.value = false;
  }
};

const inhabilitarCategoria = (event) => {
  if (seleccionados.value[0] != undefined) {
    event.preventDefault();
    dialogInh.value = false;
    alerta.value = false;
    fetch(url, {
      method: "POST",
      body: JSON.stringify(seleccionados.value),
    });
    seleccionados.value = [];
    setTimeout(() => {
      mostrarCategorias();
      mostrarCategoriasInactivas();
    }, 500);
  } else {
    event.preventDefault();
    alerta.value = true;
    dialogInh.value = false;
  }
};
</script>

<template>
  <v-row class="pa-5">
    <v-col cols="12" sm="6" md="4" lg="4">
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
                    <v-text-field
                      v-model="categoriaNueva.categoria"
                      label="Nombre*"
                      required
                    ></v-text-field>
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
    <v-col cols="12" sm="6" md="4" lg="4">
      <v-btn @click="eliminar = true" block rounded="xl" size="large"
        ><v-icon icon="mdi-cog" class="mr-2"></v-icon>Modificar
        categorias</v-btn
      >
    </v-col>
  </v-row>
  <div class="pl-5">
    <h1>Categorias activas</h1>
    <v-divider class="mb-5 mr-5" thickness="2" color="black"></v-divider>

    <div class="d-flex justify-space-between">
      <div class="pb-2">
        <v-row class="d-flex ml-3 mt-1">
          <v-col cols="auto">
            <v-alert
              v-if="alerta"
              density="compact"
              type="warning"
              title="Por favor, seleccione una categoria"
            ></v-alert>
          </v-col>
        </v-row>
      </div>
      <div>
        <v-btn @click="cancelar" class="ma-3" v-if="eliminar">Cancelar</v-btn>
        <v-dialog v-model="dialogInh" persistent width="min-content">
          <template v-slot:activator="{ props }">
            <v-btn :="props" class="ma-3" v-if="eliminar">Eliminar</v-btn>
          </template>
          <v-card>
            <form @submit="inhabilitarCategoria">
              <v-card-title>
                <span class="text-h5 d-flex mb-2"
                  >¿Está seguro que desea eliminar las categorias
                  seleccionadas?</span
                >
              </v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue-darken-1" variant="text" type="submit"
                  >Acepto</v-btn
                >
                <v-btn
                  color="blue-darken-1"
                  variant="text"
                  @click="dialogInh = false"
                  >Cancelar</v-btn
                >
              </v-card-actions>
            </form>
          </v-card>
        </v-dialog>
      </div>
    </div>
    <div class="tabla">
      <v-table class="mr-5">
        <thead>
          <tr>
            <th v-if="eliminar" class="text-left">Eliminar</th>
            <th class="text-left">Categoria</th>
            <th class="text-left">Estado</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="cat in categorias" :key="cat.id">
            <td v-if="eliminar" style="width: 10px">
              <v-checkbox
                @click="alerta = false"
                v-model="seleccionados"
                class="d-flex justify-center align-center"
                :value="cat.id"
              ></v-checkbox>
            </td>
            <td>{{ cat.categoria }}</td>
            <td>{{ cat.estado }}</td>
          </tr>
        </tbody>
      </v-table>
    </div>
    <h1 class="mt-5">Categorias inactivas</h1>
    <v-divider class="mb-5 mr-5" thickness="2" color="black"></v-divider>
    <div class="d-flex justify-end">
      <v-btn @click="habilitarCategoria" class="ma-3" v-if="eliminar"
        >Habilitar</v-btn
      >
    </div>
    <v-table class="mr-5 mb-5">
      <thead>
        <tr>
          <th v-if="eliminar" class="text-left">Habilitar</th>
          <th class="text-left">Categoria</th>
          <th class="text-left">Estado</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cat in categoriasInactivas" :key="cat.id">
          <td v-if="eliminar" style="width: 10px">
            <v-checkbox
              @click="alerta = false"
              v-model="seleccionadosActivar"
              class="d-flex justify-center align-center"
              :value="cat.id"
            ></v-checkbox>
          </td>
          <td>{{ cat.categoria }}</td>
          <td>{{ cat.estado }}</td>
        </tr>
      </tbody>
    </v-table>
  </div>
</template>

<style scoped></style>
