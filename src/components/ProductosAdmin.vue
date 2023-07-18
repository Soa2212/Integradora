<script setup>
import { ref } from 'vue';
const productos = ref({});

fetch("http://localhost/productos")
.then(res => res.json())
.then((datos) => productos.value = datos.data);

</script>

<template>
    <div class="botones">
        <v-col cols="auto">
            <v-btn block rounded="xl" size="large"><v-icon
          icon="mdi-plus-circle" class="mr-2"></v-icon>Agregar producto</v-btn>
        </v-col>
        <v-col cols="auto">
            <v-btn block rounded="xl" size="large"><v-icon
          icon="mdi-minus-circle" class="mr-2"></v-icon>Eliminar producto</v-btn>
        </v-col>
    </div>
    <div class="catalogo">
        <h1>Productos</h1>
        <v-divider thickness="2" color="black"></v-divider>
        <div class="productos">
            <v-col v-for="producto in productos" cols="4">
            <v-card class="d-flex flex-column justify-center align-center pa-3" style="height: 15em;">
                <v-img style="height: 100px;" src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg"></v-img>
                <v-card-text style="text-align: center;">{{ producto.nombre }}</v-card-text>
                <v-card-text>Precio: {{ producto.precio }}</v-card-text>
            </v-card>
        </v-col>
        </div>
    </div>
</template>

<style scoped>
.botones, .productos {
    display: flex;
    flex-wrap: wrap;
}

.catalogo {
    margin: 1em;
}
</style>