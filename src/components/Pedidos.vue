<script setup>
import { ref } from 'vue';
import {useIdStore} from "@/stores/IdUSR";
const Idusr = useIdStore();
const Id = Idusr.getIdLS;
let compra=ref([]);
let detalle=ref([]);
let objeto =ref({
id :'',
ordenid :''
});
objeto.value.id=Id;
fetch('http://localhost/comprasusuario',{
    method: 'POST',
    body: JSON.stringify(objeto.value)
})
.then((response)=>response.json())
.then(data=>compra.value=data.data)
const detalles =(or)=>{
objeto.value.ordenid=or;
  fetch('http://localhost/detallecompra',{
    method: 'POST',
    body: JSON.stringify(objeto.value)
})
.then((response)=>response.json())
.then(data=>detalle.value=data.data)
}
</script>
<template>
<div class="contenedor">
    <div class="tarjeta">{{ Id }}
    {{ compra }}
    <button type="button" @click="detalles(1)">ajjssa</button>
    {{ detalle }}
    
    
    </div>
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