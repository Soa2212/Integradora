<script setup>
import { RouterLink,RouterView } from 'vue-router';
</script>

<template>
  <div class="menu">
    <menu class="opciones">
      <RouterLink to="/" class="links"><div class="op"><h3>Home</h3></div></RouterLink>
      <RouterLink to="/categorias" class="links"><div class="op"><h3>Categorias</h3></div></RouterLink>
      <RouterLink to="/productos" class="links"><div class="op"><h3>Productos</h3></div></RouterLink>
      <RouterLink to="/acercade" class="links"><div class="op"><h3>Acerca de</h3></div></RouterLink>
    </menu>
  </div>
  <RouterView/>
</template>

<style scoped>
*
{
  margin: 0%;
  padding: 0%;
  box-sizing: border-box;
}
.menu
{
  width: 100%;
}
.opciones{
  display: flex;
  justify-content: center;
  width: 100%;
  height: 50px;
  border: 1px solid black;
  background-color: rgb(237, 237, 56);
}
.op
{
  display: flex;
  justify-content: center;
  height: 100%;
  width: 100%;
}
.op:hover
{
  background-color: black;
  color: white;
  transition: .3s ease-out;
}
.links
{
  text-decoration: none;
  color: black;
  width: 15%;
}
</style>