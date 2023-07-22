<script setup>
import { ref,computed } from "vue";

const productos = ref({});
const categorias = ref({});
const eliminar = ref(false);
const dialog = ref(false);
const dialogDel = ref(false);
const alerta = ref(false);
const fileInput = ref(null);
const selectedImage = ref(null);

// Esta propiedad es para mostrar las categorias al momento de agregar un producto
const categoriasItems = computed(() => categorias.value.map(categoria => categoria.categoria));

const seleccionados = ref([]);

const nuevoProducto = ref({
  nombre: '',
  precio: '',
  imagen1: null,
  descripcion: '',
  categoria: '',
  estado: 'activo'
})

const handleFileChange = () => {
  selectedImage.value = fileInput.value.files[0];
};

fetch("http://localhost/productos")
  .then((res) => res.json())
  .then((datos) => (productos.value = datos.data));

fetch("http://localhost/categorias")
  .then((res) => res.json())
  .then((datos) => categorias.value = datos.data);

const eliminarProducto = () => {
  if(seleccionados.value[0] != undefined){
    fetch("http://localhost/eliminarProd", {
    method: "POST",
    body: JSON.stringify(seleccionados.value)});
  } else {
    event.preventDefault();
    alerta.value = true;
    dialogDel.value = false;
  }
}

const agregarProducto = () => {
    if (selectedImage.value) {
      const reader = new FileReader();
      reader.readAsDataURL(selectedImage.value);
      reader.onload = () => {
        const base64String = reader.result.split(',')[1];
        nuevoProducto.value.imagen1 ='data:image/jpeg;base64,'+base64String;
        fetch("http://localhost/insertarProd", {
        method: "POST",
        body: JSON.stringify(nuevoProducto.value)});
      };
    }
  };

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
              <form @submit="agregarProducto">
                <v-row>
                <v-col cols="12" sm="12" md="12">
                  <v-text-field v-model="nuevoProducto.nombre" label="Nombre*"></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                  <v-text-field v-model="nuevoProducto.precio"
                    label="Precio"
                    hint="Utilice solo 2 decimales"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <div>
      <input type="file" ref="fileInput" @change="handleFileChange"/>
    </div>
                </v-col>
                <v-col cols="12">
                  <v-text-field v-model="nuevoProducto.descripcion"
                    label="Descripcion del producto"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                    <v-combobox v-model="nuevoProducto.categoria"
                        :items="categoriasItems"
                        label="Categoria"
                    ></v-combobox>
                </v-col>
                <v-col class="d-flex justify-end">
                  <v-btn type="submit">Agregar</v-btn>
                  <v-btn @click="dialog=false" class="ml-3">Cancelar</v-btn>
                </v-col>
              </v-row>
              </form>
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
      <v-row class="d-flex ml-1">
            <v-col cols="auto">
              <v-alert v-if="alerta"
                density="compact"
                type="warning"
                title="Por favor, seleccione un producto"
              ></v-alert>
          </v-col>
        </v-row>
      <v-btn @click="eliminar=false" class="ma-3" v-if="eliminar">Cancelar</v-btn>
      <v-dialog
      v-model="dialogDel"
      persistent
      width="min-content"
    >
      <template v-slot:activator="{ props }">
        <v-btn :=props class="ma-3" v-if="eliminar">Eliminar</v-btn>
      </template>
      <v-card>
        <form @submit="eliminarProducto">
          <v-card-title>
          <div class="text-h5 d-flex mb-2">¿Está seguro que desea eliminarlos?</div>
          <div>Esto ocasionará que todos los articulos relacionados a este producto se eliminen también</div>
        </v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue-darken-1" variant="text" type="submit">Estoy de acuerdo</v-btn>
          <v-btn color="blue-darken-1" variant="text" @click="dialogDel = false">Cancelar</v-btn>
        </v-card-actions>
        </form>
      </v-card>
    </v-dialog>
    </div>
    <div class="productos">
      <v-col v-for="producto in productos" cols="4">
        <v-card
          class="d-flex flex-column justify-center align-center pa-3"
          style="height: 15em"
        >
          <v-img
            style="height: 100px"
            :src="producto.imagen1"
          ></v-img>
          <v-card-text style="text-align: center">{{
            producto.nombre
          }}</v-card-text>
          <v-card-text>Precio: ${{ producto.precio }}</v-card-text>
        </v-card>
        <v-card class="d-flex justify-center align-center">
          <v-checkbox @click="alerta=false" v-model="seleccionados" class="d-flex justify-center align-center" v-if="eliminar" :value="producto.id" label="Eliminar"></v-checkbox>
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
