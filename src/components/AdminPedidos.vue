<script setup>
import { ref, computed} from 'vue';

const dialog = ref(false);
const productos = ref({});
const seleccionar = ref(false);

const productosSeleccionados = ref([]);


fetch("http://localhost/productos")
  .then((res) => res.json())
  .then((datos) => (productos.value = datos.data));

</script>

<template>

    
    <v-app class="pa-5">
        <h1 class="mb-5">Realiza tu pedido</h1>
        <v-dialog
      v-model="dialog"
      width="auto"
    >
      <template v-slot:activator="{ props }">
        <v-btn
          class="mb-9"
          color="primary"
          v-bind="props"
          style="width: min-content;"
        >
          Selecciona productos
        </v-btn>
      </template>

      <v-card>
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
          <v-checkbox @click="seleccionar=true" v-model="productosSeleccionados" class="d-flex justify-center align-center" :value="producto.id" label="Seleccionar"></v-checkbox>
        </v-card>
      </v-col>
        </div>
        
        <v-card-actions>
          <v-btn color="primary" block @click="dialog = false">Cerrar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <h2>Resumen</h2>
    <v-table class="mr-5 mb-5">
          <thead>
            <tr>
              <th class="text-left">
                Producto
              </th>
              <th class="text-left">
                Imagen
              </th>
              <th class="text-left">
                Talla
              </th>
              <th class="text-left">
                Talla
              </th>
              <th class="text-left">
                Color
              </th>
              <th class="text-left">
                Cantidad
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="prod in productosSeleccionados"
              :key="prod"
            >
              <td>{{ prod }}</td>
              <td>{{ prod.imagen1 }}</td>
              <td><v-combobox
                :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                ></v-combobox>
              </td>
              <td><v-combobox
                :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                ></v-combobox>
              </td>
              <td><v-combobox
                :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                ></v-combobox>
              </td>
            </tr>
          </tbody>
        </v-table>
        <v-row class="mt-2 mr-4 d-flex justify-end">
            <v-btn
          color="primary"
          style="width: min-content;"
        >
          Confirmar pedido
        </v-btn>
        </v-row>
        
    </v-app>
</template>

<style scoped>
.productos {
  display: flex;
  flex-wrap: wrap;
}
</style>