<script setup>
import { ref, computed } from "vue";
import { useCarritoStore } from "@/stores/carrito.js";
const carritoStore = useCarritoStore();

//Las tres primeras variables son para el popup cuando se agrega un producto al carrito o como yo le digo menu individual
const hovered = ref(false);
const isHovered = ref([]);
const showPopup = ref(false);
let unidad = ref(1); //Siempre sera uno ya que esta pensado para el menu individual
const carritoP = ref([]); //Variable que se va ir a la base de datos

const productoPP = (id) => {
  showPopup.value = true;
  Articulos(id);
};

const productos = ref([]);
fetch("http://localhost/prodcat") //Me consigue todos los productos para mostrar en el catalogo
  .then((res) => res.json())
  .then((datos) => {
    productos.value = datos.data;
  });

const ArticulosProd = ref([]);

const Articulos = (id) => {
  fetch("http://localhost/articulos/" + id)
    .then((res) => res.json())
    .then((datos) => {
      ArticulosProd.value = datos.data;

      // Verificar que ArticulosProd.value tenga al menos un objeto
      if (ArticulosProd.value.length > 0) {
        // Asignar las propiedades 'cantidad' y 'articulo' del primer objeto en ArticulosProd.value
        amountArticulo.value = ArticulosProd.value[0].cantidad;
        idArticulo.value = ArticulosProd.value[0].articulo;
        if (ArticulosProd.value[0].tall_ropa != "No tiene") {
          tallaArticulo.value = ArticulosProd.value[0].tall_ropa;
        }
        if (ArticulosProd.value[0].talla_numerica != "No tiene") {
          tallaArticulo.value = ArticulosProd.value[0].talla_numerica;
        }
      }
    });
};

function setHovered(index, value) {
  isHovered.value[index] = value;
}

const productosConStock = computed(() => {
  return productos.value.filter((producto) => producto.estado === "activo"); // Filtrador para evitar mostrar productos sin stock o si no estan activos
});

function guardarProducto(id, stockProducto, cantidadD) {
  if (stockProducto >= cantidadD) {
    // Buscar si la id ya existe en el array de objetos
    const index = carritoP.value.findIndex((producto) => producto.Articulo === id);

    if (index !== -1) {
      // Si la id ya existe, sumar cantidadD a la propiedad cantidad del objeto
      const cantidadTotal = carritoP.value[index].cantidad + cantidadD;
      if (cantidadTotal <= stockProducto) {
        carritoP.value[index].cantidad = cantidadTotal;//se le suma la cantidad a carritoP
        carritoLS()
      } else {
        mostrarPestana();
      }
    } else {
      // Si la id no existe, crear un nuevo objeto y añadirlo al array
      const nuevoProducto = {
        Articulo: id,
        cantidad: cantidadD,
      };
      carritoP.value.push(nuevoProducto);
      carritoLS()
    }
  } else {
    mostrarPestana();
  }
}

const carritoLS = () => {//Funcion para guardar los datos en local storage
  carritoP.value.forEach((producto) => {
    carritoStore.agregarAlCarrito(producto);
  });
};



const Mostrar = () => {
  //Esto se debera mandar al la bd para poder pasarselo al carrito
  console.log(carritoP.value);
};

//El objeto de abajo y la funcion que le sigue es para mostra ciertas caracteristicas cuando se seleccione un producto
const productBanner = ref({
  nombre: "",
  descripcion: "",
  precio: "",
  imagen1: null,
});

const productShow = (nombre, descripcion, precio, imagen1) => {
  productBanner.value.nombre = nombre;
  productBanner.value.descripcion = descripcion;
  productBanner.value.precio = precio;
  productBanner.value.imagen1 = imagen1;
};

const tallaArticulo = ref("No seleccionada");
const colorArticulo = ref("0");
const idArticulo = ref(null);
const amountArticulo = ref(null);
const tallaArt = (talla, color, id, cantidad) => {
  //Funcion que mostrara la talla seleccionada por el usuario y permitira en base a la talla la seleccion del articulo en si
  tallaArticulo.value = talla;
  colorArticulo.value = color;
  idArticulo.value = id;
  amountArticulo.value = cantidad;
};

const defArticulo = () => {
  //Funcion que se utiliza para que siempre muestre No seleccionada cuando entre a un producto
  tallaArticulo.value = "No seleccionada";
  colorArticulo.value = "0";
  idArticulo.value = "";
  amountArticulo.value = "";
  inputValue.value = 1;
  lastValidValue.value = 1;
  mostrarModal.value = false;
};

const shouldDisplayTalla = computed(() => {
  //Funcion que nos permite verificar las tallas de los articulos y mostrar la opcion de talla si es que la hay
  if (
    ArticulosProd.value &&
    ArticulosProd.value.length > 0 &&
    (ArticulosProd.value[0].talla_numerica !== "No tiene" ||
      ArticulosProd.value[0].talla_ropa !== "No tiene")
  ) {
    return true;
  }
  return false;
});

const shouldDisplayColor = computed(() => {
  return colorArticulo.value !== "No tiene" && colorArticulo.value !== "0";
});

//Variables que me sirven para elegir la cantidad deseada evitando que elija datos erroneos
const inputValue = ref(1);
const lastValidValue = ref(1);
const onInputChange = () => {
  // Verificar el valor ingresado para asegurar que sea un número entero positivo y no 0
  const value = parseInt(inputValue.value);

  // Si el valor no es un número entero positivo o es 0, restablecer inputValue a lastValidValue
  if (isNaN(value) || value <= 0) {
    inputValue.value = lastValidValue.value;
  } else {
    // Si es un número entero positivo válido, actualizar lastValidValue y la variable reactiva
    lastValidValue.value = value;
    inputValue.value = value;
  }
};

const IinputValue = () => {
  inputValue.value = inputValue.value + 1;
  lastValidValue.value = lastValidValue.value + 1;
};
const DinputValue = () => {
  if (inputValue.value > 1) {
    inputValue.value = inputValue.value - 1;
    lastValidValue.value = lastValidValue.value - 1;
  } else {
    inputValue.value = inputValue.value;
    lastValidValue.value = lastValidValue.value;
  }
};

const mostrarModal = ref(false);
const tiempoVisible = 800; // Tiempo en milisegundos (1/8 de segundo)
let temporizador = null;

const mostrarPestana = () => {
  mostrarModal.value = true;
  if (temporizador) clearTimeout(temporizador);
};

const iniciarTemporizador = () => {
  temporizador = setTimeout(() => {
    mostrarModal.value = false;
  }, tiempoVisible);
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
                style="border-radius: 10px"
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
                <button
                  @click="
                    productoPP(producto.id);
                    productShow(
                      producto.nombre,
                      producto.descripcion,
                      producto.precio,
                      producto.imagen1
                    );
                  "
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
                </button>
              </div>
            </v-card>
          </v-col>
        </v-row>
      </div>

      <div v-if="showPopup" class="popup-container">
        <div class="popup-content">
          <span
            class="close-button"
            @click="
              showPopup = false;
              defArticulo();
            "
            >✖</span
          >
          <div>
            <div
              style="display: flex; width: 100%; height: 100%; flex-wrap: wrap"
            >
              <div style="width: 100%; display: flex">
                <div style="width: 40%">
                  <img
                    :src="productBanner.imagen1"
                    alt=""
                    style="width: 300px; height: 300px; border-radius: 20px"
                  />
                </div>
                <div
                  style="
                    width: 60%;
                    text-align: center;
                    display: flex;
                    flex-direction: column;
                  "
                >
                  <p>{{ productBanner.nombre }}</p>
                  <p>{{ productBanner.precio }}</p>
                  <p>ID ARTICULO: {{ idArticulo }}</p>
                  <p>Cantidad: {{ amountArticulo }}</p>
                  <div v-if="shouldDisplayTalla">
                    <p v-if="tallaArticulo != 'No seleccionada'">
                      Talla: {{ tallaArticulo }}
                    </p>
                    <p v-if="shouldDisplayColor">Color: {{ colorArticulo }}</p>
                  </div>

                  <div
                    style="display: flex; gap: 10px; justify-content: center"
                  >
                    <div
                      class="scroll"
                      v-for="articulo in ArticulosProd"
                      :key="articulo.articulo"
                    >
                      <button
                        @click="
                          tallaArt(
                            articulo.talla_numerica,
                            articulo.color,
                            articulo.articulo,
                            articulo.cantidad
                          )
                        "
                        class="btnTallas"
                        v-if="articulo.talla_numerica !== 'No tiene'"
                      >
                        {{ articulo.talla_numerica }}
                      </button>
                      <button
                        @click="
                          tallaArt(
                            articulo.talla_ropa,
                            articulo.color,
                            articulo.articulo,
                            articulo.cantidad
                          )
                        "
                        v-if="articulo.talla_ropa !== 'No tiene'"
                      >
                        {{ articulo.talla_ropa }}
                      </button>
                    </div>
                  </div>
                  <div
                    style="
                      width: 100%;
                      display: flex;
                      gap: 10px;
                      justify-content: center;
                      align-items: center;
                    "
                  >
                    <div
                      style="
                        width: 30%;
                        height: 100px;
                        display: flex;
                        justify-content: end;
                        align-items: center;
                      "
                    >
                      <button @click="IinputValue" class="btnA">+</button>
                      <input
                        type="number"
                        v-model="inputValue"
                        @input="onInputChange"
                        class="inpQA"
                        id="miInput"
                      />
                      <button
                        @click="DinputValue"
                        class="btnA"
                        style="font-size: 30px"
                      >
                        -
                      </button>
                    </div>
                    <div style="width: 70%">
                      <button
                        style="margin-top: 10px"
                        class="botnsEstF"
                        @click="
                          guardarProducto(
                            idArticulo,
                            amountArticulo,
                            inputValue
                          )
                        "
                      >
                        <strong class="botnsP">AGREGAR AL CARRITO</strong>
                      </button>
                      <transition
                        name="pestanita"
                        @after-enter="iniciarTemporizador"
                      >
                        <div v-if="mostrarModal" class="modal">
                          <div class="modal-contenido">
                            <p>No puedes agregar mas {{ productBanner.nombre }} al carrito.</p>
                          </div>
                        </div>
                      </transition>
                    </div>
                  </div>
                </div>
              </div>
              <div style="width: 100%">
                <p class="descArt">{{ productBanner.descripcion }}</p>
              </div>
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
  border-radius: 15px;
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
  box-shadow: 0 -10px 10px rgba(128, 128, 128, 0.5);
  transition: 0.5s;
  transform: translateY(-25%);
  border-radius: 30px;
}

.informacion.hovered p {
  margin-top: 40px;
}
s .fade-enter-active,
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
  width: 55%;
  height: 67%;
  padding: 20px;
  border-radius: 15px;
  position: relative; /* Añadido para posicionar el botón de cierre */
}

.close-button {
  position: absolute;
  top: -30px;
  right: -30px;
  width: 30px;
  height: 30px;
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
  margin-top: 8px;
  margin-block-end: 8px;
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

.descArt {
  text-align: center;
  font-size: 14px;
  line-height: 22px;
  color: #777777;
}

.btnTallas {
  width: 40px;
  height: 40px;
  margin-left: 5px;
  background-color: #f7f8fa;
}

.btnTallas:hover {
  background-color: black;
  color: white;
  transition: 0.5s;
}

.scroll {
  /* Estilo para el div que contendrá los botones de las tallas */
  display: flex;
  justify-content: end;
  align-items: center;
  margin-left: 10px;
  overflow-y: auto; /* Agregamos el scroll vertical si hay muchas tallas */
  max-height: 200px; /* Establece una altura máxima para el div */
  flex-wrap: wrap; /* Permite que los botones se acomoden en varias líneas */
}

.scroll button {
  /* Estilo para los botones de las tallas */
  width: 40px; /* Establece el ancho deseado para los botones */
}

.modal {
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height:7%;
}

.modal-contenido {
  background-color: #f44336;
  color: white;
  top: 50%;
  left: 50%;
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

/* Transición para la pestaña emergente */
.pestanita-enter-active,
.pestanita-leave-active {
  transition: opacity 0.3s;
}

.pestanita-enter, .pestanita-leave-to /* .pestanita-leave-active in <2.1.8 */ {
  opacity: 0;
}
</style>
