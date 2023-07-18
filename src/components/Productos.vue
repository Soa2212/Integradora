<script setup>
import { ref, computed } from "vue";

//Las tres primeras variables son para el popup cuando se agrega un producto al carrito o como yo le digo menu individual
const hovered = ref(false);
const isHovered = ref([]);
const showPopup = ref(false);
let unidad = ref(1); //Siempre sera uno ya que esta pensado para el menu individual
const carrito = ref([]); //Variable que se va ir a la base de datos

function setHovered(index, value) {
  isHovered.value[index] = value;
}

const mostrarBoton = (producto) => { //Funcion que se encarga de mostrar el menu individual solo a productos que mantengan ciertas propiedades
  return producto.talla_numerica === "No tiene" && producto.talla_ropa === "No tiene" && producto.color === "No tiene";
};

const productosConStock = computed(() => {
  return productos.value.filter(
    (producto) => producto.estado === "activo"
  ); // Filtrador para evitar mostrar productos sin stock o si no estan activos
});



function guardarProducto(Articulo, CantidadProducto, precioProducto) {
  const producto = { Articulo, CantidadProducto, precioProducto };
  const index = carrito.value.findIndex(
    (producto) => producto.Articulo === Articulo
  );
  if (index !== -1) {
    carrito.value[index].CantidadProducto += 1; // Actualiza la cantidad del producto existente
  } else {
    carrito.value.push(producto); // Agrega un nuevo objeto al carrito
  }
}

const productoEncontrado = ref([]);
const productoCarrito = ref([]);

const mostrarProducto = (id) => {
  //Una variable me da un objeto del arreglo productos con todas sus propiedades y la otra me da ese mismo objeto pero con las caracteristicas del carrito
  productoEncontrado.value = productos.value.find(
    (producto) => producto.id === id
  );
  productoCarrito.value = carrito.value.find(
    (carrito) => carrito.Articulo === id
  );
};

const cantidadTotalPerP = computed(() => {
  //Variable que me da la cantidad total de articulos en el carrito
  return carrito.value.reduce((acumulador, producto) => {
    return acumulador + producto.CantidadProducto;
  }, 0);
});

const totalCarrito = computed(() => {
  //Variable que me da la el costo total en el carrito
  return carrito.value.reduce((total, producto) => {
    return total + producto.CantidadProducto * producto.precioProducto;
  }, 0);
});

const prod=ref({})

fetch('http://localhost/CatalogoProductos')
.then(res=>res.json())
.then((datos)=>{
  productos.value=datos.data
 console.log(productos.value)
})


const productos = ref([]);

const Mostrar = () => {
  //Esto se debera mandar al la bd para poder pasarselo al carrito
  console.log(carrito.value);
};
</script>

<template>
  <div class="contenedor">
    <div class="vista">
      <div class="categorias">
        <button @click="Mostrar">Mostrar carrito</button>
        <div><router-link to="/Carrito">Ir al Carrito</router-link></div>
      </div>

      <div class="productos">
        <h1 style="display: flex; justify-content: center; font-size: 24px">
          Productos
        </h1>
        <v-row class="mt-3">
          <v-col
            v-for="(producto, index) in productosConStock"
            :key="producto.id"
            cols="4"
          >
            <v-card
              height="360"
              class="d-flex flex-column tarjeta"
              style="box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 2.9)"
            >
              <v-img
                style="cursor: pointer; border-radius: 10px;"
                height="100"
                :src="producto.imagen1"
                cover
              ></v-img>
              <div
                class="informacion"
                :class="{ hovered: isHovered[index] }"
                @mouseover="setHovered(index, true)"
                @mouseleave="setHovered(index, false)"
              >
                <p style="font-size: 15px; text-align: center">
                  {{ producto.categoria }}
                </p>
                <h3
                  style="cursor: pointer; font-size: 15px; text-align: center"
                >
                  {{ producto.nombre }}
                </h3>
                <h2 style="font-size: 15px; text-align: center">
                  $ {{ producto.precio }}
                </h2>

              </div>
            </v-card>
          </v-col>
        </v-row>
      </div>

      <div v-if="showPopup" class="popup-container">
        <div class="popup-content">
          <span class="close-button" @click="showPopup = false">✖</span>
          <div style="width: 100%; display: flex">
            <div
              style="
                width: 50%;
                display: flex;
                flex-direction: column;
                align-items: center;
              "
            >
              <h2>✔ Producto agregado con</h2>
              <h2>éxito!</h2>
              <v-img
                :src="productoEncontrado.imagen1"
                style="width: 200px; height: 200px; margin-top: -20px"
              ></v-img>
              <b
                style="
                  margin-top: -20px;
                  font-size: 13px;
                  text-align: center;
                  color: rgb(86, 86, 86);
                "
                >{{ productoEncontrado.nombre }}</b
              >
              <h4 style="font-size: 13px; text-align: center">
                Cantidad Actual: {{ productoCarrito.CantidadProducto }}
              </h4>
              <div style="display: flex; align-items: center">
                <p
                  style="
                    font-size: 15px;
                    font-weight: 600;
                    margin-right: 5px;
                    margin-top: 5px;
                  "
                >
                  TOTAL P/Producto: ${{
                    productoCarrito.CantidadProducto *
                    productoCarrito.precioProducto
                  }}
                </p>
              </div>
            </div>
            <div class="linea"></div>
            <div
              style="
                width: 50%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
              "
            >
              <h2 class="CTPP">Hay {{ cantidadTotalPerP }} elementos</h2>
              <h2 class="CTPP" style="margin-block-end: 10px">en su carrito</h2>
              <div style="display: flex; align-items: center">
                <p
                  style="
                    font-size: 13px;
                    font-weight: 600;
                    margin-right: 5px;
                    margin-top: 10px;
                  "
                >
                  TOTAL:
                </p>
                <p style="font-size: 27px; font-weight: 700; margin-right: 5px">
                  ${{ totalCarrito }}
                </p>
              </div>
              <button
                @click="showPopup = false"
                style="margin-top: 10px"
                class="botnsEst"
              >
                <b class="botnsP">SEGUIR COMPRANDO</b>
              </button>
              <button style="margin-top: 10px" class="botnsEst">
                <b class="botnsP">VER CARRITO</b>
              </button>
              <button style="margin-top: 10px" class="botnsEstF">
                <strong class="botnsP">FINALIZAR COMPRA</strong>
              </button>
            </div>
          </div>
        </div>
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
.contenedor {
  background-color: beige;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 50px;
  width: 100%;
  height: min-content;
}

.vista {
  display: flex;
  width: 80vw;
  height: 90%;
  background-color: red;
}

.categorias {
  width: 25%;
  height: 100px;
  background-color: aqua;
}

.productos {
  width: 75%;
  height: 100%;
  background-color: white;
  padding: 2em 1em;
}

.tarjeta {
  border-radius: 5px;
  position: relative;
  overflow: hidden;
  transition: transform 0.5s;
}

.informacion {
  transition: transform 0.5s;
  background-color: white;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 150px;
}

.informacion.hovered {
  transform: translateY(-30%);
  border-radius: 30px;
}

.informacion.hovered p {
  margin-top: 40px;
}

button.accion {
  display: none;
  transition: 0.3s;
}

.informacion.hovered button.accion {
  display: block;
  transition: 0.3s;
}

button.accion {
  cursor: pointer;
  color: #fcd100;
  font-weight: 500;
}
button.accion:hover {
  cursor: pointer;
  color: black;
  transition: 0.3s;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
.popup-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.popup-content {
  background-color: white;
  width: 45%;
  height: 47%;
  padding: 20px;
  border-radius: 5px;
  position: relative; /* Añadido para posicionar el botón de cierre */
}

.close-button {
  position: absolute;
  top: -30px;
  right: -30px;
  width: 20px;
  height: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  font-size: 14px;
  z-index: 1;
  font-size: 20px;
  color: white;
}

.close-button:hover {
  color: black;
  transition: 0.55s;
}

.linea {
  width: 1px;
  background-color: rgba(193, 180, 180, 0.76);
}
.CTPP {
  display: flex;
  flex-direction: row;
  justify-items: center;
  color: gray;
  font-size: 13px;
}
.botnsP {
  font-size: 15px;
  margin-top: 5px;
  margin-block-end: 5px;
}

.botnsEst {
  width: 80%;
  margin-left: 20px;
  display: flex;
  justify-content: center;
  align-self: center;
  border: solid 2px black;
  margin-top: 10px;
}

.botnsEstF {
  width: 80%;
  margin-left: 20px;
  display: flex;
  justify-content: center;
  align-self: center;
  background-color: black;
  color: white;
  margin-top: 10px;
}

.botnsEst:hover {
  color: white;
  background-color: black;
  transition: 0.5s;
}
</style>
