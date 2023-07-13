<script setup>
import { ref } from 'vue';
const juas=ref({})
let mostrarCarrito=ref(true)
const prod=ref({
  nombre:'',
  precio:0,
  codigo:0,
  cantidad:0
})
let codigos=ref([])
let carrito=ref([])

  fetch('http://localhost/DatosProd/')
  .then(resultado=>resultado.json())
  .then((data)=>{
    juas.value=data.items;
    console.log(juas.value)

    juas.value.forEach(items=>{
      prod.value.precio=items.precio
      prod.value.codigo=items.codigo_barras
      prod.value.nombre=items.nombre
      codigos.value.push(items.codigo_barras)
    })


  })
  .catch(error => {
    console.error('Error:', error);
  });

  function captar(pk){
    console.log(pk)
    for(let i=0;i<=codigos.value.length;i++){
      if(codigos.value[i]==pk){
        prod.value.cantidad++
        carrito.value.push(prod.value)
      }
    }
  }

  function prueba(cd){
    for(const a in prod.value)
    {
      if(a==='codigo'){
        console.log(prod.value.codigo)
      }
    }
  }


</script>

<template>
<div id="tajetas">
  <v-row>
    <v-card v-for="(inf,codigo_barras) in juas" :key="codigo_barras"
    class="mx-auto"
    max-width="400">
    <v-img
      class="align-end text-white"
      height="200"
      src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
      cover
    >
      <v-card-title>{{inf.nombre}}</v-card-title>
    </v-img>


    <v-card-text>
      <div>
        <p>
          {{ inf.descripcion }}
        </p>
      </div>
      <div>
        <p>
          Precio: ${{ inf.precio }}
        </p>
      </div>

    </v-card-text>

    <v-card-actions>
      <v-btn color="orange" @click="captar(inf.codigo_barras)">
        Share
      </v-btn>

      <v-btn color="orange" @click="prueba(inf.codigo_barras)">
        Explore
      </v-btn>
    </v-card-actions>
  </v-card>
</v-row>

  <v-card
    v-if="mostrarCarrito"
    max-width="425"
    id="carrito"
  >
    <v-list lines="two" v-for="(producto) in carrito">

      <v-list-item>
        <template v-slot:subtitle>
          <span class="font-weight-bold">{{producto.nombre}}</span>
          <br>
        </template>
      </v-list-item>

      <v-divider inset></v-divider>
    </v-list>
  </v-card>
</div>
</template>

<style>
  #tarjetas{
    position: absolute; 
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }
  #carrito{
    position: relative;
  width: 300px;
  height: 200px;
  background-color: #fff;
  border: 1px solid #ccc;
  z-index: 999;
  }
</style>
