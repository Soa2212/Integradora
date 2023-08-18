<script setup>
import { ref, computed } from "vue";
import { useIdStore } from "@/stores/IdUSR";

const IdUsr = useIdStore();
const id = IdUsr.IdLS; // Acceder a la variable IdLS desde el store

const Orden = ref("");
const objCar = ref({
  articulo: "",
  cantidad: "",
  usuario: "",
  orden: "",
});

const finalizarCompra = () => {
  const copiaCarritoP = [...carritoP.value];

  fetch("http://3.136.87.82/ordenUSL/" + id)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Hubo un problema con la solicitud.");
      }
      return response.json();
    })
    .then((data) => {
      Orden.value = data.data;
      // Realizar el ciclo aquí, dentro del segundo then
      for (let i = 0; i < copiaCarritoP.length; i++) {
        const objCar = {
          articulo: copiaCarritoP[i].Articulo,
          cantidad: copiaCarritoP[i].cantidad,
          orden: Orden.value,
          usuario: id,
        };

        fetch("http://3.136.87.82/detallarL", {
          method: "POST",
          body: JSON.stringify(objCar),
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
    setTimeout(() => {
      location.reload();
    }, 500)
};

//Las tres primeras variables son para el popup cuando se agrega un producto al carrito o como yo le digo menu individual
const isHovered = ref([]);
const showPopup = ref(false);
const carritoP = ref([]);
const carritoX = ref({
  Articulo: "",
  cantidad: "",
});
const dialog = ref(false);
const eliminar = ref(false);
const dialogEliminar = ref(false);
const dialogConfirmar = ref(false);

const seleccionados = ref([]);

const eliminarArticulo = () => {
  for (const id of seleccionados.value) {
    const index = carritoP.value.findIndex(
      (producto) => producto.Articulo == id
    );
    if (index !== -1) {
      carritoP.value.splice(index, 1);
      seleccionados.value = [];
    }
  }
  dialogEliminar.value = false;
};

const realizarPedido = () => {
  finalizarCompra();
  dialogConfirmar.value = false;
};

const cancelarSeleccion = () => {
  eliminar.value = false;
  seleccionados.value = [];
};

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
  } else {
    mostrarPestana();
  }
}

const popupF = () => {
  setTimeout(() => {
    showPopup.value = false;
    defArticulo();
  }, 720);
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
</script>

<template>
  <div class="d-flex flex-column pa-5">
    <v-dialog v-model="dialog" width="auto">
      <template v-slot:activator="{ props }">
        <v-btn style="width: min-content" color="primary" v-bind="props">
          Seleccionar productos
        </v-btn>
      </template>
      <v-card class="pa-5">
        <h1 class="d-flex justify-center text-h3 mt-3 mb-1">Productos</h1>
        <div class="d-flex align-center">
          <v-row class="mt-3 d-flex">
            <v-col
              class="d-flex justify-center"
              v-for="(producto, index) in productosConStock"
              :key="producto.id"
              cols="6"
              sm="6"
              md="4"
              lg="3"
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
                <v-card
                  @mouseover="setHovered(index, true)"
                  @mouseleave="setHovered(index, false)"
                  height="280"
                  width="16em"
                  class="d-flex flex-column mb-3"
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
                  >
                    <p style="font-size: 15px; text-align: center">
                      {{ producto.categoria }}
                    </p>
                    <h3
                      style="
                        cursor: pointer;
                        font-size: 15px;
                        text-align: center;
                      "
                    >
                      {{ producto.nombre }}
                    </h3>
                    <h2 style="font-size: 15px; text-align: center">
                      $ {{ producto.precio }}
                    </h2>
                  </div>
                </v-card>
              </button>
            </v-col>
          </v-row>
        </div>
      </v-card>

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
    </v-dialog>

    <div>
      <h1 style="font-size: 1.5em" class="mt-9">Resumen de pedido</h1>
      <div>
        <v-table class="mr-5">
          <thead>
            <tr>
              <th
                v-if="eliminar"
                style="width: min-content"
                class="text-center"
              >
                Eliminar
              </th>
              <th class="text-center">Articulo</th>
              <th class="text-center">Imagen</th>
              <th class="text-center">Talla</th>
              <th class="text-center">Color</th>
              <th class="text-center">Cantidad</th>
              <th class="text-center">Precio</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="art in carritoP" :key="art.id">
              <td v-if="eliminar" style="width: 10px">
                <v-checkbox
                  v-model="seleccionados"
                  class="d-flex justify-center align-center"
                  :value="art.Articulo"
                ></v-checkbox>
              </td>
              <td class="text-center">{{ art.nombre }}</td>
              <td class="text-center">
                <img
                  style="height: 100px; width: auto; margin: 1.5em"
                  :src="art.imagen"
                  alt="Imagen de producto"
                />
              </td>
              <td class="text-center">{{ art.talla }}</td>
              <td class="text-center">{{ art.color }}</td>
              <td class="text-center">{{ art.cantidad }}</td>
              <td class="text-center">{{ art.precio * art.cantidad }}</td>
            </tr>
          </tbody>
        </v-table>
        <div class="mt-5 d-flex justify-space-between">
          <div>
            <v-dialog v-model="dialogEliminar" width="auto">
              <template v-slot:activator="{ props }">
                <v-btn
                  :="props"
                  v-if="eliminar"
                  @click="dialogEliminar = true"
                  class="mr-5"
                  >Eliminar</v-btn
                >
                <v-btn v-if="eliminar" @click="cancelarSeleccion" class="mr-5"
                  >Cancelar</v-btn
                >
              </template>

              <v-card>
                <v-card-text>
                  Esta seguro que desea eliminar los articulos seleccionados?
                </v-card-text>
                <v-card-actions>
                  <v-btn color="primary" block @click="eliminarArticulo"
                    >De acuerdo</v-btn
                  >
                </v-card-actions>
              </v-card>
            </v-dialog>
          </div>
          <div>
            <v-btn @click="eliminar = true" class="mr-5"
              >Modificar articulos</v-btn
            >
            <v-dialog v-model="dialogConfirmar" width="auto">
              <template v-slot:activator="{ props }">
                <v-btn :="props" @click="dialogConfirmar = true" class="mr-5"
                  >Confirmar pedido</v-btn
                >
              </template>

              <v-card>
                <v-card-text>
                  Esta seguro que desea realizar el pedido?
                </v-card-text>
                <v-card-actions>
                  <v-btn color="primary" block @click="realizarPedido"
                    >De acuerdo</v-btn
                  >
                </v-card-actions>
              </v-card>
            </v-dialog>
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

.productos {
  background-color: white;
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
.fade-enter,
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
  display: flex;
  width: 55%;
  height: 60%;
  padding: 20px;
  border-radius: 15px;
  position: relative; /* Añadido para posicionar el botón de cierre */
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

.popup2 {
  display: flex;
  width: 100%;
  height: 100%;
  flex-wrap: wrap;
}

.popupIMG {
  width: 40%;
  display: flex;
  align-items: center;
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

.close-button:hover {
  color: black;
  transition: 0.55s;
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
  margin-top: -500px;
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
</style>
