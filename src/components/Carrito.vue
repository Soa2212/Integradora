<script setup>

import { ref, computed, watch } from "vue";
import { useCarritoStore } from "@/stores/carrito";
import { RouterLink } from "vue-router";
import { useTokenStore } from "@/stores/TokenUser";
import { useIdStore } from "@/stores/IdUSR";
import BloqLog from "@/components/BloqLog.vue";
const tokenStore = useTokenStore();
const tieneToken = tokenStore.tieneToken;

// Obtén la instancia del store
const IdUsr = useIdStore();
const id = IdUsr.IdLS; // Acceder a la variable IdLS desde el store

//Variable que contiene la id es la id de arriba

const carritoStore = useCarritoStore();
const mostrarModal = ref(false);
let temporizador = null;
const tiempoVisible = 4000; // Tiempo en milisegundos

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

  carritoStore.agregarAlCarrito1(item); // Guardar el cambio en el store
};

// Función para decrementar la cantidad del item
const decrement = (item) => {
  item.cantidad = Math.max(1, parseInt(item.cantidad) - 1);
  inputValue.value = item.cantidad; // Actualizar el input para reflejar la nueva cantidad

  carritoStore.agregarAlCarrito1(item); // Guardar el cambio en el store
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

  carritoStore.agregarAlCarrito1(item); // Guardar el cambio en el store
};

const elimArt = (idArticulo) => {
  carritoStore.eliminarDelCarrito(idArticulo);
};

const vaCA = () => {
  carritoStore.eliminarTodoDelLocalStorage();
  location.reload();
};

const calcularTotalParcial = (item) => {
  return item.cantidad * parseFloat(item.precio);
};

const total = ref(0);

const actualizarTotal = () => {
  total.value = Math.ceil(
    carritoLS.reduce((total, item) => total + calcularTotalParcial(item), 0)
  );
};

// Calculamos el total al inicio
actualizarTotal();

// Observamos cambios en carritoLS y actualizamos el total reactivamente
watch(carritoLS, () => {
  actualizarTotal();
});

const objCar = ref({
  articulo: "",
  cantidad: "",
  usuario: "",
  orden: "",
}); //Poner la orden activa para asi tener en cuenta el proceso

const Orden = ref("");

//Faltara que haga el proceso que permita agregarlo a una orden por medio de un usuario
const finalizarCompra = () => {
  const carritoParaCompra = carritoLS.map((item) => ({
    Articulo: item.Articulo,
    cantidad: item.cantidad,
  }));
  objCar.value.usuario = id;

  fetch("http://3.136.87.82/ordenUS/" + objCar.value.usuario)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Hubo un problema con la solicitud.");
      }
      return response.json();
    })
    .then((data) => {
      Orden.value = data.data;

      // Realizar el ciclo aquí, dentro del segundo then
      for (let i = 0; i < carritoParaCompra.length; i++) {
        objCar.value.articulo = carritoParaCompra[i].Articulo;
        objCar.value.cantidad = carritoParaCompra[i].cantidad;
        objCar.value.orden = Orden.value;

        fetch("http://3.136.87.82/detallar", {
          method: "POST",
          body: JSON.stringify(objCar.value),
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error("Hubo un problema con la solicitud.");
            }
            return response.json();
          })
          .then((data) => {
            console.log(data);
          })
          .catch((error) => {
            console.error("Error en la solicitud:", error);
          });
      }
    })
    .catch((error) => {
      console.error("Error en la solicitud:", error);
    });
  mostrarPestana();
};

const mostrarPestana = () => {
  mostrarModal.value = true;
  if (temporizador) clearTimeout(temporizador);
};

const iniciarTemporizador = () => {
  temporizador = setTimeout(() => {
    mostrarModal.value = false;
    vaCA();
  }, tiempoVisible);
};
</script>

<template>
  <div v-if="!tieneToken"><BloqLog></BloqLog></div>
  <template v-if="carritoLS.length === 0">
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
            v-if="tieneToken"
            src="@/assets/carrito_vista0.png"
            style="height: 150px; width: 150px"
          />
          <strong style="font-size: 30px"
            >Tu carrito de compras está vacío</strong
          >
          <p style="color: #777777; font-size: 15px">
            No tiene artículos en su carrito de compras.
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
            <strong style="font-size: 15px">SEGUIR COMPRANDO</strong>
          </RouterLink>
        </div>
      </div>
    </div>
  </template>
  <template v-else>
    <div class="container">
      <div class="carrito">
        <div
          style="
            width: 100%;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 40px;
          "
        >
          <p style="text-align: center; font-size: 34px; font-weight: bold">
            Carrito de compras
          </p>
        </div>
        <div v-for="item in carritoLS" :key="item.Articulo" class="item">
          <div
            style="
              display: flex;
              align-items: center;
              width: 20%;
              justify-content: center;
              margin-top: 10px;
              margin-bottom: 10px;
            "
          >
            <img
              :src="item.imagen"
              alt=""
              style="max-width: 100px; max-height: 100px; border-radius: 20px"
            />
          </div>
          <div style="width: 30%; display: flex; flex-direction: column">
            <div class="IA">{{ item.nombre }}</div>
            <div v-if="item.talla != 'NA' && item.talla != 'No seleccionada' " class="IAB">
              Tamaño: {{ item.talla }}
            </div>
            <div
              v-if="item.color != '0' && item.color != 'NA'"
              class="IAB"
            >
              Color: {{ item.color }}
            </div>
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
            <button
              @click="decrement(item)"
              class="btnA"
              style="font-size: 30px"
            >
              -
            </button>
          </div>
          <div style="width: 20%; display: flex">
            <div
              style="
                width: 50%;
                overflow-x: auto;
                display: flex;
                justify-content: start;
                align-items: center;
                margin-left: 20px;
              "
            >
              <p style="white-space: nowrap">
                ${{ calcularTotalParcial(item) }}
              </p>
            </div>
            <div
              style="
                width: 50%;
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
              "
            >
              <button @click="elimArt(item.Articulo)">
                <img
                  src="../assets/btnB.png"
                  alt="Eliminar"
                  style="width: 20px; height: 20px"
                />
              </button>
            </div>
          </div>
        </div>

        <div style="width: 50%; margin-bottom: 50px; margin-top: 30px">
          <div
            style="
              display: flex;
              align-items: center;
              justify-content: start;
              height: 40px;
            "
          >
            <RouterLink
              to="/ProductosView"
              style="
                text-decoration: none;
                color: black;
                font-size: 14px;
                font-weight: bold;
              "
            >
              <img
                src="../assets/btnSC.png"
                alt=""
                style="width: 23px; height: 17px; margin-bottom: -3.5px"
              />
              SEGUIR COMPRANDO
            </RouterLink>
          </div>
        </div>
        <div
          style="
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: end;
          "
        >
          <div
            style="
              display: flex;
              align-items: center;
              justify-content: end;
              height: 40px;
            "
          >
            <button
              to="/ProductosView"
              style="
                text-decoration: none;
                color: black;
                font-size: 14px;
                font-weight: bold;
                margin-right: 20px;
              "
              @click="vaCA"
            >
              <img
                src="../assets/btnB.png"
                alt=""
                style="
                  width: 19px;
                  height: 17px;
                  margin-bottom: -2.5px;
                  margin-right: 3px;
                "
              />
              VACIAR CARRITO
            </button>
          </div>
        </div>
      </div>
      <div class="submenu">
        <div class="subTTL">
          <div style="display: flex">
            <div style="width: 50%; display: flex; justify-content: center">
              <strong style="font-size: 20px">TOTAL :</strong>
            </div>
            <div style="width: 50%; display: flex; justify-content: center">
              <strong style="font-size: 20px">${{ total }}</strong>
            </div>
          </div>
          <button to="Pedido" class="botnsEstF" @click="finalizarCompra">
            <strong class="botnsP">REALIZAR PEDIDO</strong>
          </button>
        </div>
      </div>
    </div>
  </template>
  <transition name="pestanita" @after-enter="iniciarTemporizador">
    <div v-if="mostrarModal" class="modal2">
      <div class="modal-contenido2">
        <p>
          Su pedido ha sido confirmado. Por favor, revise su correo en las
          próximas 24 horas. Si surge algún problema, no dude en contactarnos.
        </p>
      </div>
    </div>
  </transition>
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
  width: 100%;
  height: 50%;
  border-top-right-radius: 30px;
  border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
  padding-left: 20px;
  padding-right: 20px;
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

.submenu {
  display: flex;
  justify-content: end;
  flex-wrap: wrap;
  background-color: beige;
  width: 100%;
  height: 50%;
  border-top-right-radius: 30px;
  border-top-left-radius: 30px;
}
.subTTL {
  display: flex;
  flex-direction: column;
  justify-content: center;
  width: 40%;
  background-color: white;
  border-bottom-left-radius: 20px;
  border-bottom-right-radius: 20px;
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
  text-align: start;
}

.PA {
  width: 10%;
  font-size: 16px;
  display: flex;
  justify-content: center;
}

.inpQA {
  width: 90px;
  height: 50px;
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

.botnsP {
  font-size: 15px;
  margin-top: 10px;
  margin-block-end: 10px;
}

.botnsEstF {
  width: 80%;
  margin-top: 20px;
  margin-bottom: 30px;
  display: flex;
  text-decoration: none;
  justify-content: center;
  align-self: center;
  background-color: black;
  color: white;
}

.modal2 {
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 45%;
}
.modal-contenido2 {
  background-color: green;
  color: white;
  padding: 10px;
  border-radius: 8px;
}

.pestanita-enter-active,
.pestanita-leave-active {
  transition: opacity 0.3s;
}

.pestanita-enter, .pestanita-leave-to /* .pestanita-leave-active in <2.1.8 */ {
  opacity: 0;
}
</style>
