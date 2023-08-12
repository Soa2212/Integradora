<script setup>
import {useIdStore} from "@/stores/IdUSR";
const Idusr = useIdStore();
const Id = Idusr.getIdLS;
</script>
<template>
<div class="contenedor">
    <div class="tarjeta">{{ Id }}</div>
</div>
</template>
<style scoped>
.contenedor{
    background-color: beige;
    width: 100%;
    height: 70vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
.tarjeta{
    background-color: white;
    width: 90%;
    height: 90%;
    border-radius: 20px;

}
</style>