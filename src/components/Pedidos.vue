<script setup>
import { ref } from "vue";
import { useIdStore } from "@/stores/IdUSR";
const Idusr = useIdStore();
const Id = Idusr.getIdLS;
let compra = ref([]);
let detalle = ref([]);
let objeto = ref({
  id: "",
  ordenid: "",
});
objeto.value.id = Id;
fetch("http://localhost/comprasusuario", {
  method: "POST",
  body: JSON.stringify(objeto.value),
})
  .then((response) => response.json())
  .then((data) => (compra.value = data.data));
</script>
<script>
export default {
  data: () => ({
    show: false,
  }),
};
</script>
<template>
  <div class="contenedor">
    <div class="tarjeta">
      <div>
        <v-table theme="width">
          <thead>
            <tr>
              <th class="text-left">#Orden</th>
              <th class="text-left">fecha</th>

              <th class="text-left">cantidad de articulos</th>
              <th class="text-left">estado</th>
              <th class="text-left">total</th>
            </tr>
          </thead>
          <tbody v-for="item in compra" :key="item.orden">
            <tr>
              <td>{{ item.orden }}</td>
              <td>{{ item.fecha }}</td>
              <td>{{ item.cantidad_articulos }}</td>
              <td>{{ item.estado }}</td>
              <td>{{ item.total }}</td>
            </tr>
          </tbody>
        </v-table>
      </div>
    </div>
  </div>
</template>
<style scoped>
.contenedor {
  background-color: beige;
  width: 100%;
  height: 70vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
.tarjeta {
  background-color: white;
  width: 90%;
  height: 90%;
  border-radius: 20px;
}
</style>
