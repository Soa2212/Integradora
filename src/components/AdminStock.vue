<script setup>
import { ref,onMounted } from "vue";

const dialog = ref(null);
const dialogStock = ref(null);
const productos = ref({});
const articulosProducto = ref({});
const idArticulo = ref(null);

const articulos = ref({
    producto: '',
    cantidad: '',
    id: ''
})

const mostrarProductos = () => {
fetch("http://localhost/productos")
  .then((res) => res.json())
  .then((datos) => (productos.value = datos.data));
}

const mostrarArticulos = (id) => {
    articulos.value.producto = id;
dialog.value = false;
fetch(`http://localhost/articulosStock/${id}`)
  .then((res) => res.json())
  .then((datos) => (articulosProducto.value = datos.data));
}

const actualizarStock = (id) => {
    dialogStock.value = false;
    articulos.value.id = id;
    fetch("http://localhost/actualizarStock", {
    method: "POST",
    body: JSON.stringify(articulos.value)
    })
}

const cancelar = () => {
    dialogStock.value = false;
    articulos.value.cantidad = '';
}

onMounted(() => {
    mostrarProductos();
})
</script>

<template>
    {{ articulosProducto }}
    {{ articulos }}
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
          class="d-flex flex-column justify-center align-center"
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
    <v-table>
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
      <tr v-for="art in articulosProducto">
        <td class="text-center">{{ art.producto }}</td>
        <td class="text-center">{{ art.TALLA_ROPA }}</td>
        <td class="text-center">{{ art.TALLA_NUMERICA }}</td>
        <td class="text-center">{{ art.color }}</td>
        <td class="text-center">{{ art.cantidad }}</td>
        <td class="text-center">
            <v-dialog
                v-model="dialogStock"
                width="auto"
                >
                <template v-slot:activator="{ props }">
                    <v-btn
                    color="primary"
                    v-bind="props"
                    >
                    Actualizar
                    </v-btn>
                </template>

                <v-card class="pa-5">
                    <v-card-text>
                    Ingrese la nueva cantidad de stock:
                    </v-card-text>
                    <v-text-field v-model="articulos.cantidad"></v-text-field>
                    <div class="d-flex justify-end">
                        <v-btn color="primary" @click="cancelar">Cancelar</v-btn>
                        <v-btn class="ml-3"
                        :value="art.id_art"
                        color="primary"  @click="actualizarStock(art.id_art)"
                            >Actualizar</v-btn>
                    </div>
                </v-card>
                </v-dialog>
        </td>
      </tr>
    </tbody>
  </v-table>
    </v-app>
</template>