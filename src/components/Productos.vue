<script setup>
import { ref, computed } from "vue";
import { useCarritoStore } from "@/stores/carrito.js";
const carritoStore = useCarritoStore();

//Las tres primeras variables son para el popup cuando se agrega un producto al carrito o como yo le digo menu individual
const hovered = ref(false);
const isHovered = ref([]);
const showPopup = ref(false);
const carritoP = ref([]); //Variable que se va ir a la base de datos

const productoPP = (id) => {
  showPopup.value = true;
  Articulos(id);
};

const productos = ref([]);
fetch("http://3.136.87.82/prodcat") //Me consigue todos los productos para mostrar en el catalogo
  .then((res) => res.json())
  .then((datos) => {
    productos.value = datos.data;
  });

const ArticulosProd = ref([]);

const Articulos = (id) => {
  fetch("http://3.136.87.82/articulos/" + id)
    .then((res) => res.json())
    .then((datos) => {
      ArticulosProd.value = datos.data;

      // Verificar que ArticulosProd.value tenga al menos un objeto
      if (ArticulosProd.value.length > 0) {
        // Asignar las propiedades 'cantidad' y 'articulo' del primer objeto en ArticulosProd.value
        amountArticulo.value = ArticulosProd.value[0].cantidad;
        idArticulo.value = ArticulosProd.value[0].articulo;
        if (ArticulosProd.value[0].tall_ropa != "NA") {
          tallaArticulo.value = ArticulosProd.value[0].tall_ropa;
        }
        if (ArticulosProd.value[0].TALLA_NUMERICA != "NA") {
          tallaArticulo.value = ArticulosProd.value[0].TALLA_NUMERICA;
        }
        colorArticulo.value = ArticulosProd.value[0].color;
      }
    });
};

const categorias = ref([]);
fetch("http://3.136.87.82/categorias") //Me consigue todas las categorias para mostrar en la pagina
  .then((res) => res.json())
  .then((datos) => {
    categorias.value = datos.data;
  });

function setHovered(index, value) {
  isHovered.value[index] = value;
}

const productosConStock = computed(() => {
  return productos.value.filter((producto) => producto.estado === "activo"); // Filtrador para evitar mostrar productos sin stock o si no estan activos
});

function guardarProducto(
  id,
  stockProducto,
  cantidadD,
  nombre,
  imagen,
  precio,
  talla,
  color
) {
  if (stockProducto >= cantidadD) {
    // Buscar si la id ya existe en el array de objetos
    const index = carritoP.value.findIndex(
      (producto) => producto.Articulo === id
    );

    if (index !== -1) {
      // Si la id ya existe, sumar cantidadD a la propiedad cantidad del objeto
      const cantidadTotal = carritoP.value[index].cantidad + cantidadD;
      if (cantidadTotal <= stockProducto) {
        carritoP.value[index].cantidad = cantidadTotal; //se le suma la cantidad a carritoP
        mostrarPestanaV();
      } else {
        mostrarPestana();
      }
    } else {
      // Si la id no existe, crear un nuevo objeto y añadirlo al array
      const nuevoProducto = {
        Articulo: id,
        stock: stockProducto,
        cantidad: cantidadD,
        nombre: nombre,
        imagen: imagen,
        precio: precio,
        talla: talla,
        color: color,
      };
      carritoP.value.push(nuevoProducto);
      mostrarPestanaV();
    }
    carritoLS();
  } else {
    mostrarPestana();
  }
}

const carritoLS = () => {
  //Funcion para guardar los datos en local storage
  carritoP.value.forEach((producto) => {
    carritoStore.agregarAlCarrito(producto);
  });
  carritoP.value = [];
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
    (ArticulosProd.value[0].talla_numerica !== "NA" ||
      ArticulosProd.value[0].talla_ropa !== "NA")
  ) {
    return true;
  }
  return false;
});

const shouldDisplayColor = computed(() => {
  return colorArticulo.value !== "NA" && colorArticulo.value !== "0";
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

//Estas tres funciones de abajo sirven para la alerta si el cliente agrega mas productos de los posibles
const mostrarModal = ref(false);
const tiempoVisible = 300; // Tiempo en milisegundos
let temporizador = null;
const mostrarModal2 = ref(false);

const mostrarPestana = () => {
  mostrarModal.value = true;
  if (temporizador) clearTimeout(temporizador);
};

const mostrarPestanaV = () => {
  mostrarModal2.value = true;
  if (temporizador) clearTimeout(temporizador);
};

const iniciarTemporizador = () => {
  temporizador = setTimeout(() => {
    mostrarModal.value = false;
  }, tiempoVisible);
};

const iniciarTemporizadorV = () => {
  clearTimeout(temporizador); // Cancelar el temporizador existente, si lo hay
  temporizador = setTimeout(() => {
    mostrarModal2.value = false;
  }, tiempoVisible);
};

const prodCategoria = (id) => {
  fetch("http://3.136.87.82/categoriasp/" + id) //Me consigue todos los productos de una categoria en especifico para mostrar en el catalogo
    .then((res) => res.json())
    .then((datos) => {
      productos.value = datos.data;
    });
};

const prodCategoriaDEF = (id) => {
  fetch("http://3.136.87.82/prodcat") //Me consigue todos los productos para mostrar en el catalogo
    .then((res) => res.json())
    .then((datos) => {
      productos.value = datos.data;
    });
};
const popupF = () => {
  setTimeout(() => {
    showPopup.value = false;
    defArticulo();
  }, 720);
};
</script>

<template>
  <div class="contenedor">
    <div class="vista">
      <div class="categorias">
        <div class="CB">
          <button @click="prodCategoriaDEF" class="CTB">CATÁLOGO</button>
          <div class="lh"></div>
          <p v-for="cat in categorias" :key="cat.id" class="CBB">
            <button
              @click="prodCategoria(cat.id)"
              v-if="cat.estado != 'inactivo'"
            >
              {{ cat.categoria }}
            </button>
          </p>
        </div>
      </div>

      <div class="productos">
        <p style="display: flex; justify-content: center; font-size: 26px">
          Productos
        </p>
        <div class="lh"></div>
        <v-row class="mt-3 d-flex">
          <v-col
            class="d-flex justify-center"
            v-for="(producto, index) in productosConStock"
            :key="producto.id"
            cols="12"
            lg="4"
            md="6"
            sm="12"
          >
            <button
              style="width: 100%"
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
              <v-card
                class="d-flex flex-column tarjeta pa-2"
                @mouseover="setHovered(index, true)"
                @mouseleave="setHovered(index, false)"
                height="360"
                style="box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 2.9)"
              >
                <v-img
                  style="border-radius: 10px"
                  height="100"
                  :src="producto.imagen1"
                  cover
                ></v-img>
                <div class="informacion" :class="{ hovered: isHovered[index] }">
                  <p class="infoprod">
                    {{ producto.categoria }}
                  </p>
                  <h3 class="infoprod1">
                    {{ producto.nombre }}
                  </h3>
                  <h2 class="infoprod">$ {{ producto.precio }}</h2>
                </div>
              </v-card>
            </button>
          </v-col>
        </v-row>
      </div>

      <div
        :class="['popup-container', { hide: !showPopup }]"
        @click="
          showPopup = false;
          defArticulo();
        "
      >
        <div class="popup-content" @click.stop>
          <div class="popup">
            <div class="popup2">
              <div style="width: 100%; display: flex">
                <div class="popupIMG">
                  <img
                    :src="productBanner.imagen1"
                    alt=""
                    style="
                      max-width: 225px;
                      max-height: 225px;
                      border-radius: 20px;
                    "
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
                  <p class="BannerNP">{{ productBanner.nombre }}</p>
                  <div class="BannerIO">
                    <p style="margin-top: 10px">
                      Costo ${{ productBanner.precio }}
                    </p>
                    <div v-if="shouldDisplayTalla">
                      <p
                        v-if="
                          tallaArticulo != 'No seleccionada' &&
                          tallaArticulo != 'NA'
                        "
                        style="margin-top: 10px"
                      >
                        Talla: {{ tallaArticulo }}
                      </p>
                      <p v-if="shouldDisplayColor">
                        Color: {{ colorArticulo }}
                      </p>
                    </div>
                  </div>

                  <div class="scroll">
                    <div
                      v-for="articulo in ArticulosProd"
                      :key="articulo.articulo"
                    >
                      <div
                        v-if="
                          articulo.TALLA_NUMERICA == 'NA' &&
                          articulo.tall_ropa == 'NA'
                        "
                      >
                        <button
                          @click="
                            tallaArt(
                              articulo.TALLA_NUMERICA,
                              articulo.color,
                              articulo.articulo,
                              articulo.cantidad
                            )
                          "
                          class="btnTallas2"
                          style="font-size: 12px; min-width: 40px"
                          v-if="articulo.color !== 'NA'"
                        >
                          {{ articulo.color }}
                        </button>
                      </div>
                      <div v-else>
                        <button
                          @click="
                            tallaArt(
                              articulo.TALLA_NUMERICA,
                              articulo.color,
                              articulo.articulo,
                              articulo.cantidad
                            )
                          "
                          class="btnTallas"
                          style="font-size: 16px; min-width: 40px"
                          v-if="articulo.TALLA_NUMERICA !== 'NA'"
                        >
                          {{ articulo.TALLA_NUMERICA }}
                        </button>

                        <button
                          @click="
                            tallaArt(
                              articulo.tall_ropa,
                              articulo.color,
                              articulo.articulo,
                              articulo.cantidad
                            )
                          "
                          class="btnTallas"
                          style="font-size: 16px; min-width: 40px"
                          v-if="articulo.tall_ropa !== 'NA'"
                        >
                          {{ articulo.tall_ropa }}
                        </button>
                      </div>
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
                        margin-right: -20px;
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
                      />
                      <button
                        @click="DinputValue"
                        class="btnA"
                        style="font-size: 30px"
                      >
                        -
                      </button>
                    </div>
                    <div style="width: 70%; background-color: ">
                      <button
                        style="margin-top: 10px"
                        class="botnsEstF"
                        @click="
                          guardarProducto(
                            idArticulo,
                            amountArticulo,
                            inputValue,
                            productBanner.nombre,
                            productBanner.imagen1,
                            productBanner.precio,
                            tallaArticulo,
                            colorArticulo
                          ),
                            popupF()
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
                            <p>
                              No puedes agregar mas
                              {{ productBanner.nombre }} al carrito.
                            </p>
                          </div>
                        </div>
                      </transition>
                      <transition
                        name="pestanita"
                        @after-enter="iniciarTemporizadorV"
                      >
                        <div v-if="mostrarModal2" class="modal2">
                          <div class="modal-contenido2">
                            <p>Producto agregado con exito al carrito.</p>
                          </div>
                        </div>
                      </transition>
                    </div>
                  </div>
                </div>
              </div>
              <div style="width: 100%; margin-top: 10px">
                <div class="linea-horizontal"></div>
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
  background-color: beige;
}

.categorias {
  width: 30%;
  height: max-content;
  padding-bottom: 170px;
  margin-right: 10px;
  background-color: white;
  padding-left: 15px;
  padding-top: 10px;
  border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
}

.CB {
  background-color: white;
  widows: 100%;
}

.lh {
  border-bottom: 1px solid #ccc;
  margin-bottom: 10px;
  border-radius: 50px;
  width: 90%;
  height: 5px;
}
.CTB {
  width: 100%;
  font-size: 26px;
  display: flex;
  justify-content: center;
  margin-top: 25px;
}
.infoprod {
  font-size: 15px;
  text-align: center;
}

.CTB:hover {
  /* Sombras al hacer hover */
  color: rgb(28, 172, 216);
  transition: 0.5s;
}

.CBB {
  color: #837f7f;
  margin-top: 7px;
  transition: 0.3s;
  margin-bottom: 7px;
}

.CBB:hover {
  /* Sombras al hacer hover */
  color: rgb(0, 0, 0);
  font-size: 24px;
  transition: 0.6s;
}
.productos {
  width: 75%;
  height: 100%;
  background-color: white;
  border-top-right-radius: 20px; /* Radio de esquina superior derecha */
  border-bottom-right-radius: 20px; /* Radio de esquina inferior derecha */
  border-bottom-left-radius: 20px;
  padding: 2em 1em;
}
.infoprod1 {
  cursor: pointer;
  font-size: 15px;
  text-align: center;
}

.tarjeta {
  border-radius: 15px;
  width: 100%;
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
  opacity: 1; /* Configuración de opacidad inicial */
  transition: opacity 0.3s ease; /* Transición de opacidad */
  pointer-events: auto; /* Habilitar interacción con el popup visible */
}

.hide {
  opacity: 0; /* Opacidad a 0 para ocultar el popup */
  pointer-events: none; /* Deshabilitar interacción con el popup oculto */
}

.popup-content {
  background-color: white;
  display: flex;
  width: 55%;
  height: 65%;
  padding: 20px;
  border-radius: 15px;
  position: relative; /* Añadido para posicionar el botón de cierre */
}
.popup {
  width: 100%;
  padding: 20px;
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

.popup2 {
  display: flex;
  width: 100%;
  height: 100%;
  flex-wrap: wrap;
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
  margin-top: 10px;
  margin-block-end: 10px;
}

.botnsEstF {
  width: 100%;
  margin-left: 20px;
  display: flex;
  justify-content: center;
  align-self: center;
  background-color: black;
  color: white;
}

.botnsEst:hover {
  color: white;
  background-color: black;
  transition: 0.5s;
}
.popupIMG {
  width: 40%;
  display: flex;
  align-items: center;
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

.descArt {
  text-align: center;
  margin-top: 20px;
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

.btnTallas2:hover {
  background-color: black;
  color: white;
  transition: 0.5s;
}

.btnTallas2 {
  height: 40px;
  margin-left: 5px;
  background-color: #f7f8fa;
}

.btnTallas2:hover {
  background-color: black;
  color: white;
  transition: 0.5s;
}

.scroll {
  /* Estilo para el div que contendrá los botones de las tallas */
  display: flex;
  max-width: 400px;
  justify-content: flex-start;
  margin-top: 10px;
  align-items: center;
  margin-left: 10px;
  overflow-x: auto;
  max-height: 200px;
  flex-wrap: nowrap;
  padding-right: 5px;
}

.scroll button {
  /* Estilo para los botones de las tallas */
  max-width: max-content; /* Establece el ancho deseado para los botones */
  flex-shrink: 0; /* Evita que los botones se reduzcan si hay muchos en una fila */
}

.modal {
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.modal2 {
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
.modal-contenido2 {
  background-color: green;
  color: white;
  top: 50%;
  left: 50%;
  margin-top: -680px;
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.modal-contenido {
  background-color: rgb(128, 0, 0);
  color: white;
  top: 50%;
  left: 50%;
  padding: 10px;
  margin-top: -680px;
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

.BannerNP {
  margin-top: 10px;
  font-size: 20px;
  font-weight: bold;
}

.BannerIO {
  display: flex;
  flex-direction: column;
  font-size: 10px;
  font-weight: bold;
  font-style: oblique;
}

.linea-horizontal {
  width: 100%;
  margin-top: -30px;
  border-bottom: 1px solid #ccc;
  border-radius: 50px;
  height: 5px;
}

@media (max-width: 785px) {
  .CTB {
    font-size: 16px;
    font-weight: bolder;
  }
  .CBB button {
    font-size: 10px;
    text-align: start;
  }
}

@media (max-width: 544px) {
  .CTB {
    font-size: 11px;
    font-weight: bolder;
  }
}

@media (max-width: 422px) {
  .CTB {
    font-size: 8px;
    margin-right: 20px;
  }
  .CBB button {
    font-size: 7px;
  }

  .BannerNP {
    font-size: 10px;
  }

  .infoprod  {
    font-size: 9px;
  }
  .infoprod1 {
    font-size: 9px;
  }

}
</style>
