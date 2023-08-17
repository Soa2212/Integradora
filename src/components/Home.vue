<script setup>
import { ref, computed } from "vue";

//Las tres primeras variables son para el popup cuando se agrega un producto al carrito o como yo le digo menu individual
const isHovered = ref([]);

const productos = ref([]);
fetch("http://3.136.87.82/categoriasp/4") //Me consigue todos los productos para mostrar en el catalogo
  .then((res) => res.json())
  .then((datos) => {
    productos.value = datos.data;
  });

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
</script>
<template>
  <div style="width: 100%; height: 100%">
    <header class="header">
      <section class="textos-header">
        <h1 class="titulo1">Equipo de Protección Personal para el Trabajo</h1>
        <h2 class="titulo2">
          Somos proveedores de Equipo de protección personal para Industria,
          contratistas, talleres y particulares. Encuentra el Equipo que
          necesitas para tus proyectos teniendo como prioridad el cuidado de tu
          equipo de colaboradores sin dejar de lado confort, accesibilidad y
          dinamismo en tu logística para lograr óptimos resultados en todos los
          procesos de tu Actividad.
        </h2>
      </section>
      <div
        class="wave"
        style="height: 150px; margin-block-end: -3px; overflow: hidden"
      >
        <svg
          viewBox="0 0 500 150"
          preserveAspectRatio="none"
          style="height: 100%; width: 100%"
        >
          <path
            d="M-0.78,30.01 C290.97,148.12 349.20,-49.85 621.66,99.90 L500.00,149.60 L0.00,149.60 Z"
            style="stroke: none; fill: rgb(245, 245, 220)"
          ></path>
        </svg>
      </div>
    </header>

    <div class="container">
      <div class="productos">
        <p
          style="
            display: flex;
            justify-content: center;
            font-size: 26px;
            font-weight: 700;
            font-style: italic;
          "
        >
          Productos de una de nuestras categorias...
        </p>
        <div style="display: flex; justify-content: center">
          <div class="lh"></div>
        </div>
        <v-row class="mt-3 d-flex">
          <v-col
            class="d-flex justify-center"
            v-for="(producto, index) in productosConStock.slice(0, 12)"
            :key="producto.id"
            cols="12"
            lg="3"
            md="4"
            sm="12"
          >
            <router-link
              to="/ProductosView"
              style="text-decoration: none; color: black; width: 100%"
            >
              <v-card
                @mouseover="setHovered(index, true)"
                @mouseleave="setHovered(index, false)"
                height="360"
                class="d-flex flex-column tarjeta pa-2"
                style="box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 2.9)"
              >
                <v-img
                  style="border-radius: 10px"
                  height="100"
                  :src="producto.imagen1"
                  cover
                ></v-img>
                <div class="informacion" :class="{ hovered: isHovered[index] }">
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
            </router-link>
          </v-col>
        </v-row>
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
}

.lh {
  border-bottom: 2px solid #ccc;
  margin-bottom: 10px;
  border-radius: 50px;
  width: 70%;
  height: 5px;
}
.CTB {
  font-size: 26px;
  text-align: center;
  margin-top: 25px;
  margin-left: 70px;
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
}

.CBB:hover {
  /* Sombras al hacer hover */
  color: rgb(0, 0, 0);
  font-size: 24px;
  transition: 0.6s;
}
.productos {
  width: 80%;
  height: 90%;
  background-color: rgb(255, 255, 255);
  padding: 2em 1em;
  border-radius: 50px;
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
}

.popup-content {
  background-color: white;
  display: flex;
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
  margin-top: 10px;
  margin-block-end: 10px;
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
}

.botnsEst:hover {
  color: white;
  background-color: black;
  transition: 0.5s;
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
  width: 40px; /* Establece el ancho deseado para los botones */
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
  height: 7%;
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
  margin-top: -30px;
  border-bottom: 1px solid #ccc;
  border-radius: 50px;
  height: 5px;
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
.container {
  display: flex;
  padding: 60px 0;
  width: 100%;
  height: 100%;
  justify-content: center;
  margin: auto;
  overflow: hidden;
  margin-block-end: 50px;
  margin-top: -60px;
}
.titulo {
  color: black;
  font-size: 30px;
  text-align: center;
  margin-bottom: 60px;
}

.header {
  width: 100%;
  height: 450px;
  margin-top: -20px;
  background: #004ff9; /* fallback for old browsers */
  background: -webkit-linear-gradient(
      to right,
      hsla(58, 100%, 60%, 0.599),
      hsla(221, 100%, 60%, 0.599)
    ),
    url(../assets/p1.jpg); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(
      to right,
      hsla(58, 100%, 60%, 0.599),
      hsla(221, 100%, 60%, 0.599)
    ),
    url(../assets/p1.jpg); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  background-size: cover;
  background-attachment: fixed;
  background-repeat: no-repeat;
  position: relative;
}
.titulo1 {
  width: 50%;
  font-size: 25px;
  margin-block-end: 15px;
  color: rgb(255, 255, 255);
}

.titulo2 {
  width: 50%;
  font-size: 20px;
  color: rgb(255, 255, 255);
}
.vista {
  display: flex;
  width: 90%;
  height: 90%;
  background-color: #004ff9;
}

.textos-header {
  display: flex;
  height: 350px;
  width: 100%;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}

.textos-header h1 {
  text-align: center;
}

.textos-header h2 {
  text-align: justify;
  font-weight: 100;
  font-style: italic;
}
.wave {
  position: absolute;
  bottom: 0;
  width: 100%;
}

.footer {
  background: #414141;
  padding: 60px 0 30px 0;
  margin: auto;
  overflow: hidden;
}
.contenedor-foot {
  display: flex;
  width: 90%;
  justify-content: space-evenly;
  margin: auto;
  padding-bottom: 50px;
  border-bottom: 1px solid gray;
}

.content-foo {
  text-align: center;
}
.content-foo h4 {
  color: white;
  border-bottom: 3px solid rgb(0, 0, 0);
  padding-bottom: 5px;
  margin-bottom: 20px;
}
.content-foo p {
  color: #ccc;
}
.titulo-final {
  text-align: center;
  font-size: 24px;
  margin-top: 20px;
  color: #9e9797;
}

@media (max-width: 1155px) {
  .titulo2 {
    font-size: 15px;
  }
  .titulo1 {
    font-size: 17px;
  }
}

@media (max-width: 593px) {
  .titulo2 {
    font-size: 11px;
  }
  .titulo1 {
    font-size: 14px;
  }
}

@media (max-width: 338px) {
  .titulo1 {
    margin-top: 40px;
  }
}
</style>
