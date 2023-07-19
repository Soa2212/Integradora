<script setup>
import { ref } from 'vue';

const categorias = ref({});

fetch("http://localhost/categorias")
.then(res => res.json())
.then(data => categorias.value = data.data);
</script>

<template>
    <div class="botones">
        <v-col cols="auto">
            <v-btn block rounded="xl" size="large"><v-icon
          icon="mdi-plus-circle" class="mr-2"></v-icon>Agregar categoria</v-btn>
        </v-col>
        <v-col cols="auto">
            <v-btn block rounded="xl" size="large"><v-icon
          icon="mdi-minus-circle" class="mr-2"></v-icon>Eliminar categoria</v-btn>
        </v-col>
    </div>
    <p v-for="cat in categorias">{{ cat.categoria }}</p>
</template>

<style scoped>
.botones{
    display: flex;
}
</style>