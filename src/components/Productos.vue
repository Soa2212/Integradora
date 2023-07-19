<script setup>
import { ref, computed } from "vue";

//Las tres primeras variables son para el popup cuando se agrega un producto al carrito o como yo le digo menu individual
const hovered = ref(false);
const isHovered = ref([]);
const showPopup = ref(false);
let unidad = ref(1); //Siempre sera uno ya que esta pensado para el menu individual
const carrito = ref([]); //Variable que se va ir a la base de datos

const productoPP = (id) => {
  showPopup.value = true;
  Articulos(id);
};

const productos = ref([]);
fetch("http://localhost/CatalogoProductos") //Me consigue todos los productos para mostrar en el catalogo
  .then((res) => res.json())
  .then((datos) => {
    productos.value = datos.data;
  });

const ArticulosProd = ref([]);
const Articulos = (id) => {
  fetch("http://localhost/articulos/" + id) //En base al producto seleccionado por el parametro id me mostrara todos los articulos relacionados a ese producto
    .then((res) => res.json())
    .then((datos) => {
      ArticulosProd.value = datos.data;
      console.log(ArticulosProd.value);
    });
};

function setHovered(index, value) {
  isHovered.value[index] = value;
}

const productosConStock = computed(() => {
  return productos.value.filter((producto) => producto.estado === "activo"); // Filtrador para evitar mostrar productos sin stock o si no estan activos
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

const Mostrar = () => {
  //Esto se debera mandar al la bd para poder pasarselo al carrito
  console.log(carrito.value);
};

//El objeto de abajo y la funcion que le sigue es para mostra ciertas caracteristicas cuando se seleccione un producto
const productBanner = ref({
  nombre: "",
  descripcion: "",
  precio: "",
  imagen1: "",
  imagen2: "",
  imagen3: "",
  imagen4: "",
});

const productShow = (
  nombre,
  descripcion,
  precio,
  imagen1,
  imagen2,
  imagen3,
  imagen4
) => {
  productBanner.value.nombre = nombre;
  productBanner.value.descripcion = descripcion;
  productBanner.value.precio = precio;
  productBanner.value.imagen1 = imagen1;
  productBanner.value.imagen2 = imagen2;
  productBanner.value.imagen3 = imagen3;
  productBanner.value.imagen4 = imagen4;
};

const tallaArticulo = ref("No seleccionada");
const colorArticulo = ref("0");
const tallaArt = (talla, color) => {
  //Funcion que mostrara la talla seleccionada por el usuario
  tallaArticulo.value = talla;
  colorArticulo.value = color;
};

const defTalla = () => {
  //Funcion que se utiliza para que siempre muestre No seleccionada cuando entre a un producto
  tallaArticulo.value = "No seleccionada";
  colorArticulo.value = "0";
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
                style="cursor: pointer; border-radius: 10px"
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
                <button
                  @click="
                    productoPP(producto.id);
                    productShow(
                      producto.nombre,
                      producto.descripcion,
                      producto.precio,
                      producto.imagen1,
                      producto.imagen2,
                      producto.imagen3,
                      producto.imagen4
                    );
                  "
                >
                  <h3
                    style="cursor: pointer; font-size: 15px; text-align: center"
                  >
                    {{ producto.nombre }}
                  </h3>
                </button>
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
          <span
            class="close-button"
            @click="
              showPopup = false;
              defTalla();
            "
            >✖</span
          >
          <div>
            <div style="display: flex; width: 100%">
              <div style="width: 50%">{{ productBanner.imagen1 }}</div>
              <div style="width: 50%; text-align: center">
                <p>{{ productBanner.nombre }}</p>
                <p>{{ productBanner.precio }}</p>
                <div v-if="shouldDisplayTalla">
                  <p>Talla: {{ tallaArticulo }}</p>
                  <p v-if="shouldDisplayColor">Color: {{ colorArticulo }}</p>
                </div>

                <div style="display: flex; gap: 10px">
                  <div v-for="articulo in ArticulosProd" :key="articulo.id">
                    <button
                      @click="tallaArt(articulo.talla_numerica, articulo.color)"
                      v-if="articulo.talla_numerica !== 'No tiene'"
                    >
                      {{ articulo.talla_numerica }}
                    </button>
                    <button
                      @click="tallaArt(articulo.talla_ropa, articulo.color)"
                      v-if="articulo.talla_ropa !== 'No tiene'"
                    >
                      {{ articulo.talla_ropa }}
                    </button>
                  </div>
                </div>
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
  border-radius: 5px;
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
