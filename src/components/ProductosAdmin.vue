<script setup>
import { ref } from "vue";

const productos = ref({});
const categorias = ref({});
const eliminar = ref(false);
const dialog = ref(false);

fetch("http://localhost/productos")
  .then((res) => res.json())
  .then((datos) => (productos.value = datos.data));

  fetch("http://localhost/categorias")
  .then((res) => res.json())
  .then((datos) => {
    categorias.value = datos.data;
    console.log(categorias.value);
  });
</script>

<template>
  <div class="botones">
    <v-col cols="auto">
      <v-dialog v-model="dialog" width="auto">
        <template v-slot:activator="{ props }">
          <v-btn v-bind="props" block rounded="xl" size="large"
            ><v-icon icon="mdi-plus-circle" class="mr-2"></v-icon>Agregar
            producto</v-btn
          >
        </template>
        <v-card>
          <v-card-title>Agregar producto</v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field label="Nombre*" required></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    label="Precio"
                    hint="Utilice solo 2 decimales"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-file-input label="Imagen"></v-file-input>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    label="Descripcion del producto"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                    <v-combobox
                        :items="['Hola']"
                        label="Categoria"
                    ></v-combobox>
                </v-col>
              </v-row>
            </v-container>
            <small>* Indica que es un campo requerido</small>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-col>
    <v-col cols="auto">
      <v-btn @click="eliminar=true" block rounded="xl" size="large"
        ><v-icon icon="mdi-minus-circle" class="mr-2"></v-icon>Eliminar
        producto</v-btn>
    </v-col>
  </div>
  <div class="catalogo">
    <h1>Productos</h1>
    <v-divider class="mb-5" thickness="2" color="black"></v-divider>
    <div class="opciones">
      <v-btn @click="eliminar=false" class="ma-3" v-if="eliminar">Cancelar</v-btn>
      <v-btn class="ma-3" v-if="eliminar">Eliminar</v-btn>
    </div>
    <div class="productos">
      <v-col v-for="producto in productos" cols="4">
        <v-card
          class="d-flex flex-column justify-center align-center pa-3"
          style="height: 15em"
        >
          <v-img
            style="height: 100px"
            src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg"
          ></v-img>
          <v-card-text style="text-align: center">{{
            producto.nombre
          }}</v-card-text>
          <v-card-text>Precio: ${{ producto.precio }}</v-card-text>
        </v-card>
        <v-card class="d-flex justify-center align-center">
          <v-checkbox class="d-flex justify-center align-center" v-if="eliminar" label="Eliminar"></v-checkbox>
        </v-card>
      </v-col>
    </div>
  </div>
</template>

<style scoped>
.botones,
.productos {
  display: flex;
  flex-wrap: wrap;
}
.catalogo {
  margin: 1em;
}
.opciones {
  display: flex;
  justify-content: flex-end;
}
</style>
