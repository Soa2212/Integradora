<script setup></script>
<template>
  <header class="header">
    <section class="textos-header">
      <h1
        style="
          width: 50%;
          font-size: 25px;
          margin-block-end: 15px;
          color: rgb(255, 255, 255);
        "
      >
        Equipo de Protección Personal para el Trabajo
      </h1>
      <h2 style="width: 50%; font-size: 20px; color: rgb(255, 255, 255)">
        Somos proveedores de Equipo de protección personal para Industria,
        contratistas, talleres y particulares. Encuentra el Equipo que necesitas
        para tus proyectos teniendo como prioridad el cuidado de tu equipo de
        colaboradores sin dejar de lado confort, accesibilidad y dinamismo en tu
        logística para lograr óptimos resultados en todos los procesos de tu
        Actividad.
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
    <div class="tarjetas">
      <div>
        <div class="productos" style="margin-top: 20px">
          <h1 style="display: flex; justify-content: center; font-size: 24px">
            Productos Recientes
          </h1>
          <v-row class="mt-3">
            <v-col v-for="n in 12" :key="n" cols="4">
              <v-card height="300" class="d-flex flex-column" style="cursor: pointer;">
                <v-img
                  height="100"
                  src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg"
                  cover
                >
                </v-img>
                <div class="informacion">
                  <p>Bonita flor</p>
                  <h3>Bonita flor de color morado</h3>
                  <h2>$1399</h2>
                </div>
              </v-card>
            </v-col>
          </v-row>
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
.informacion {
  padding: 10px;
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
  margin-top: -80px;
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
.tarjetas {
  width: 75%;
  display: flex;
  flex-direction: column;
}
</style>
