<script setup>
import { ref } from "vue";
import { useIdStore } from "@/stores/IdUSR";
const Idusr = useIdStore();
const Id = Idusr.getIdLS;

let compra = ref([]);
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
<template>
  <template v-if="compra.length === 0">
    <div class="container">
      <div class="carritoV">
        <div
          style="
            display: flex;
            align-items: center;
            width: 100%;
            justify-content: center;
            flex-direction: column;
            margin-top: 10px;
            margin-bottom: 10px;
          "
        >
          <v-img
            src="@\assets\PdidoLost.png"
            style="height: 150px; width: 150px"
          />
          <strong style="font-size: 30px">¿Listo para hacer un pedido?</strong>
          <p style="color: #777777; font-size: 15px">
            Realiza tu pedido ahora y obsérvalo aquí mismo.
          </p>
          <RouterLink
            to="/ProductosView"
            style="
              text-decoration: none;
              margin-top: 20px;
              padding-top: 5px;
              padding-bottom: 5px;
              padding-left: 25px;
              padding-right: 25px;
              display: flex;
              justify-content: center;
              align-self: center;
              background-color: black;
              color: white;
            "
          >
            <strong style="font-size: 15px">Buscar Productos.</strong>
          </RouterLink>
        </div>
      </div>
    </div>
  </template>
  <template v-else>
    <div class="contenedor">
      <div class="tarjeta">
        <div
          style="
            display: flex;
            justify-content: center;
            margin-bottom: 50px;
            margin-top: 30px;
          "
        >
          <p>
            <strong style="font-size: 30px"
              >Explora tu Historial de Compras.</strong
            >
          </p>
        </div>
        <div>
          <v-table theme="width">
            <thead>
              <tr>
                <th class="text-center">#Orden</th>
                <th class="text-center">Fecha</th>

                <th class="text-center">Cantidad de articulos</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Total</th>
              </tr>
            </thead>
            <tbody v-for="item in compra" :key="item.orden">
              <tr>
                <td style="text-align: center">{{ item.orden }}</td>
                <td style="text-align: center">{{ item.fecha }}</td>
                <td style="text-align: center">
                  {{ item.cantidad_articulos }}
                </td>
                <td style="text-align: center">{{ item.estado }}</td>
                <td style="text-align: center">{{ item.total }}</td>
              </tr>
            </tbody>
          </v-table>
        </div>
      </div>
    </div>
  </template>
</template>
<style scoped>
* {
  font-family: "Montserrat", sans-serif;
  font-size: 17px;
}
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
.carritoV {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  background-color: white;
  width: 100%;
  height: 50vh;
  border-radius: 30px;
  padding-left: 20px;
  padding-right: 20px;
  padding-bottom: 40px;
}
.container {
  background-color: beige;
  align-items: center;
  justify-content: center;
  padding: 50px;
  height: 100%;
  width: 100%;
  height: min-content;
}
</style>
