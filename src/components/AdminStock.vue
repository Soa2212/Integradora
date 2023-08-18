<script setup>
import { ref,onMounted } from "vue";

const dialog = ref(null);
const dialogStock = ref(null);
const productos = ref({});
const articulosProducto = ref({});
const avisoCantidad = ref('')

const articulos = ref({
    producto: '',
    cantidad: '',
    id: ''
})

const mostrarProductos = () => {
fetch("http://3.136.87.82/productos")
  .then((res) => res.json())
  .then((datos) => (productos.value = datos.data));
}

const mostrarArticulos = (id) => {
    articulos.value.producto = id;
dialog.value = false;
fetch(`http://3.136.87.82/articulosStock/${id}`)
  .then((res) => res.json())
  .then((datos) => (articulosProducto.value = datos.data));
}

const actualizarStock = (id) => {
  if(articulos.value.cantidad != '' && /^[0-9]+$/.test(articulos.value.cantidad)){
    articulos.value.id = id;
    fetch("http://3.136.87.82/actualizarStock", {
    method: "POST",
    body: JSON.stringify(articulos.value)
    })
    setTimeout(() => {
      mostrarArticulos(articulos.value.producto)
    }, 500)
    articulos.value.cantidad = '';
    avisoCantidad.value = '';
  } else if (articulos.value.cantidad == '') {
    avisoCantidad.value = 'Por favor, ingrese una cantidad'
  }
  else if (!/^[0-9]+$/.test(articulos.value.cantidad)){
    avisoCantidad.value = 'Por favor, utilice solo numeros'
  }
}

onMounted(() => {
    mostrarProductos();
})
</script>

<template>
    <v-app class="pa-5">
        <h1 class="mb-3">Actualizar stock</h1>
        <v-dialog
      v-model="dialog"
      width="auto"
    >
      <template v-slot:activator="{ props }">
        <v-btn
          width="min-content"
          color="primary"
          v-bind="props"
        >
          Seleccionar producto
        </v-btn>
      </template>

      <v-card class="pa-5">
        <v-row>
        <v-col v-for="producto in productos" cols="12" sm="12" md="6" lg="4">
        <v-card
          class="d-flex flex-column justify-center align-center pb-5"
          style="height: 18em"
        >
          <v-img style="height: 100px" :src="producto.imagen1"></v-img>
          <v-card-text style="text-align: center">{{
            producto.nombre
          }}</v-card-text>
          <v-card-text>Precio: ${{ producto.precio }}</v-card-text>
          <v-btn
            @click="mostrarArticulos(producto.id)"
            class="d-flex justify-center align-center"
            :value="producto.id"
            label="Eliminar"
          >Seleccionar</v-btn>
        </v-card>
      </v-col>
    </v-row>
      </v-card>
    </v-dialog>
    <v-table class="mt-5">
    <thead>
      <tr>
        <th class="text-center">Producto</th>
        <th class="text-center">Talla Ropa</th>
        <th class="text-center">Talla Numerica</th>
        <th class="text-center">Color</th>
        <th class="text-center">Cantidad</th>
        <th class="text-center"></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="art in articulosProducto" key="art.id_art">
        <td class="text-center">{{ art.producto }}</td>
        <td class="text-center" v-if=" art.TALLA_ROPA != 'NA' ? art.TALLA_ROPA=art.TALLA_ROPA:art.TALLA_ROPA='-' ">{{ art.TALLA_ROPA }}</td>
        <td class="text-center" v-if=" art.TALLA_NUMERICA != 'NA' ? art.TALLA_NUMERICA=art.TALLA_NUMERICA:art.TALLA_NUMERICA='-' ">{{ art.TALLA_NUMERICA }}</td>
        <td class="text-center" v-if=" art.color != 'NA' ? art.color=art.color:art.color='-' ">{{ art.color }}</td>
        <td class="text-center">{{ art.cantidad }}</td>
        <td class="text-center pa-5"> 
          <v-btn @click="actualizarStock(art.id_art)" class="ml-3">Actualizar</v-btn>
        </td>
      </tr>
    </tbody>
  </v-table>
  <v-row class="d-flex justify-end mt-2">
    <v-col cols="6" lg="2" md="4" sm="6">
      <v-text-field label="Ingrese nueva cantidad" v-model="articulos.cantidad"></v-text-field>
      <p style="color: rgb(177, 0, 0);">{{ avisoCantidad }}</p>
    </v-col>
  </v-row>
    </v-app>
</template>