<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { RouterLink, RouterView } from 'vue-router';
const isNavActive = ref(false);

const handleScroll = () => {
  isNavActive.value = window.scrollY > 0;
};

onMounted(() => {
  window.addEventListener("scroll", handleScroll);
});

onBeforeUnmount(() => {
  window.removeEventListener("scroll", handleScroll);
});
</script>

<template>

<header>
<nav :class="{ active: isNavActive }" class="nav">     
  <ul class="menu">
  <div class="logo"><img src="../assets/Protecc_Seg.png" alt="Logo" style="height: 60px; width: 230px;"></div>
  <li><RouterLink to="Home">Inicio</RouterLink></li>
  <li>
      <li><RouterLink to="ProductosView">Catalogo</RouterLink></li>
      <ul class="menu-drop">
          <li><a href="#">Cat1</a></li>
          <li><a href="#">Cat2</a></li>
          <li><a href="#">Cat3</a></li>
      </ul>
  </li>
  <li><RouterLink to="CotizacionView">Cotiza</RouterLink></li>
  <li><a>Acerca</a></li>


<div style="display: flex; gap: 60px; justify-content: flex-end; align-items: center; width: 400px;">

  <img src="../assets/carrito.png" alt=""  style="height: 30px; width: 40px;">

<li>
    <li><RouterLink to="#"><img src="../assets/user.png" alt="" style="height: 30px; width: 30px; margin: 0%; padding: 0%;" class="user-icon" /></RouterLink></li>
    <ul class="menu-drop" style="font-size: 15px; width: 150px; margin-left: -30px;">
        <li><RouterLink to="LoginView">Login</RouterLink></li>
        <li><a href="#">Log out</a></li>
    </ul>
</li>

<img src="../assets/ajustes.png" alt="" style="height: 30px; width: 35px;">
</div>


</ul>
</nav>
</header>


</template>
<style scoped>

*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
/*Barra nav conf*/ 
template{
  font-family:sans-serif;
}
header{
  width: 100%;
  background-size: cover;
  background-position: center;
}
header ul{
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
}
header ul li{
  list-style: none;
  color: black;
}
header ul li a{
  position: relative;
  margin: 0 2px;
  text-decoration: none;
  color: rgb(255, 255, 255);
  letter-spacing: 2px;
  font-weight: 600;
}
header .active .logo,
header.active ul li a{
  color: black;
  font-size: 10px;
  margin: 0;
  padding: 0;
  font-size: 20px;
}
/*Color de la barra de navegacion*/
.nav{
  position: fixed;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-around;
  padding: 10px;
  margin-left: -10px;
  margin-block-start: -10px;
  height: 130px;
  background-color: #ffffff;
}
.nav.active{
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-around;
  margin-left: -10px;
  padding: 20px;
  height: 100px;
  background-color: #ffffff;
}
.nav.active .logo,
.nav.active a{
    color: black;
}
.nav.active a:hover{
  color: rgb(255, 219, 61);
}
.menu-drop{
  position: absolute;
  display: none;
  list-style: none;
  width: 170px;
  border-radius: 5px;
  background-color: rgba(255, 255, 255, 0.748);
}

.menu{
  display: flex;
  justify-content: center;
  gap: 40px;
  height: 85px;
  width: 100%;
  font-family: sans-serif;
  font-size:medium;
  list-style: none;
}
.menu li{
  list-style: none;
  margin: 20px;  
}
.menu li a{
  display: block;
  color: #000000;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.5s ease;
  
}
/*Letras de hover barra */
.menu li a:hover{
  display: flex;
  color: rgb(255, 219, 61);
}
.menu li:hover .menu-drop{
  display: flex;
  flex-direction: column;
}
.scrol{
    height: 100px;
}
.Menu2{
  display: flex;
  height: 85px;
  width: 100%;
  gap: 40px;
  margin-left: 60px;
  margin-right:60px;
  background-color: #000000;
}
</style>