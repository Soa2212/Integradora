<script setup>
import { ref } from "vue";
import { useCarritoStore } from "@/stores/carrito";

// Obtén la instancia del store
const carritoStore = useCarritoStore();

// Obtén la variable carritoLS del store
const carritoLS = carritoStore.carritoLS;
const inputValue = ref(1);
const lastValidValue = ref(1);

const increment = (item) => {
  const stock = item.stock; // Obtener el stock disponible desde el item

  // Validar si la cantidad a agregar es mayor que el stock disponible
  if (item.cantidad + 1 <= stock) {
    item.cantidad = parseInt(item.cantidad) + 1;
  } else {
    // Si la cantidad supera el stock, establecer la cantidad en el máximo disponible
    item.cantidad = stock;
  }

  // Actualizar el input para reflejar la nueva cantidad
  inputValue.value = item.cantidad;

  carritoStore.agregarAlCarrito(item); // Guardar el cambio en el store
};

// Función para decrementar la cantidad del item
const decrement = (item) => {
  item.cantidad = Math.max(1, parseInt(item.cantidad) - 1);
  inputValue.value = item.cantidad; // Actualizar el input para reflejar la nueva cantidad

  carritoStore.agregarAlCarrito(item); // Guardar el cambio en el store
};

// Función para validar y mantener solo números enteros en el input
const onInputChange = (item, event) => {
  const inputValue = event.target.value;
  const intValue = parseInt(inputValue);

  // Verificar si el valor es un número entero válido y no excede el stock disponible
  if (!isNaN(intValue) && intValue >= 1 && intValue <= item.stock) {
    item.cantidad = intValue; // Actualiza directamente el item con la nueva cantidad
  } else {
    // Si el valor no es un número entero válido o excede el stock, establecer la cantidad en el último valor válido
    item.cantidad = lastValidValue.value;
  }

  lastValidValue.value = item.cantidad; // Actualizar lastValidValue con el valor válido actual

  carritoStore.agregarAlCarrito(item); // Guardar el cambio en el store
};
</script>

<template>
  <div class="container">
    <div class="carrito">
      <p style="text-align: center">Carrito de compras</p>
      <div v-for="item in carritoLS" :key="item.Articulo" class="item">
        <div style="display: flex; align-items: center">
          <img
            :src="item.imagen"
            alt=""
            style="max-width: 100px; max-height: 100px; border-radius: 20px"
          />
        </div>
        <div style="width: 20%; display: flex; flex-direction: column">
          <div class="IA">{{ item.nombre }}</div>
          <div class="IA">Tamaño: {{ item.talla }}</div>
          <div class="IA">Color: {{ item.color }}</div>
        </div>
        <div class="PA">${{ item.precio }}</div>
        <div
          style="
            width: 20%;
            display: flex;
            justify-content: end;
            align-items: center;
          "
        >
          <button @click="increment(item)" class="btnA">+</button>
          <input
            type="number"
            v-model="item.cantidad"
            @input="(event) => onInputChange(item, event)"
            class="inpQA"
          />
          <button @click="decrement(item)" class="btnA" style="font-size: 30px">
            -
          </button>
        </div>
        <p>${{ item.cantidad * item.precio }}</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Montserrat&display=swap");
* {
  font-family: "Montserrat", sans-serif;
  font-size: 17px;
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

.carrito {
  display: flex;
  flex-wrap: wrap; /* Agregamos flex-wrap: wrap para que los elementos se distribuyan en múltiples líneas */
  background-color: white;
  width: 90%;
  height: 90%;
}

.item {
  display: flex;
  justify-content: space-around;
  align-items: center;
  width: 100%; /* Ahora aplicamos el 100% de ancho directamente al elemento .item */
  border-top: 1px solid #ccc; /* Línea recta arriba del elemento */
  border-bottom: 1px solid #ccc; /* Línea recta debajo del elemento */
}

.IA {
  color: #191919;
  font-size: 14px;
}

.PA {
  width: 20%;
  font-size: 16px;
}

.inpQA {
  width: 90px;
  height: 50px;
  margin-top: 15px;
  margin-block-end: 5px;
  outline: none;
  text-align: center;
  background-color: #f7f8fa;
}

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type="number"] {
  -moz-appearance: textfield; /* Para Firefox */
}

.btnA {
  font-size: 25px;
  font-weight: 900;
  margin-top: 15px;
  margin-block-end: 5px;
  background-color: #f7f8fa;
  height: 50px;
  color: #777777;
  width: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.btnA:hover {
  color: black;
}

</style>
