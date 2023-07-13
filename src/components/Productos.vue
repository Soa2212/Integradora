<script setup>

</script>

<template>
<div class="contenedor">
  <div class="vista">
    <div class="categorias">
    </div>
    <div class="productos">
      <h1 style="display: flex; justify-content: center;">Productos</h1>
      <v-row class="mt-3">
          <v-col
            v-for="n in 12"
            :key="n"
            cols="4"
          >
            <v-card height="400" class="d-flex flex-column">
              <v-img height="100" src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg" cover>
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
</template>
<style scoped>
.contenedor{
  background-color: beige;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 50px;
  width: 100%;
  height: min-content;
}

.vista{
  display: flex;
  width: 80vw;
  height: 90%;
  background-color: red;
}

.categorias{
  width: 25%;
  height: 100px;
  background-color: aqua;
}

.productos{
  width: 75%;
  height: 100%;
  background-color: white;
  padding: 2em 1em;
}

.informacion {
  padding: 10px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 150px;
}
</style>