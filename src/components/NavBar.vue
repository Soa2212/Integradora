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
const selectedIndex  = ref(0);

const selectNavItemF = (index) => {
  selectedIndex .value = index;
};
const categorias = ref([]);
fetch("http://localhost/categorias") //Me consigue todas las categorias para mostrar en la pagina
  .then((res) => res.json())
  .then((datos) => {
    categorias.value = datos.data;
  });  

</script>

<template>

<header>
<nav :class="{ active: isNavActive }" class="nav" >     
  <ul class="menu" :class="{ menuDD: isNavActive }">
    <RouterLink to="HomeView" :class="{ IMGD: isNavActive }" ><img src="../assets/Protecc_Seg.png" alt="Logo" style="height: 65px; width: 215px; margin-left: 40px; margin-top: 10px;"></RouterLink>
      <div style="width: 80%; display: flex; align-items: center; justify-content: flex-start; gap: 20px;">
        <li><RouterLink to="HomeView" :class="{ 'selected': selectedIndex === 0 }" @click.native="selectNavItemF(0)">Inicio</RouterLink></li>
        <li>
            <li><RouterLink to="ProductosView"  :class="{ 'selected': selectedIndex === 1 }" @click.native="selectNavItemF(1)">Catalogo</RouterLink></li>
              <ul class="menu-drop" style="margin-left: -10px;width: 170px;">
              <li v-for="cat in categorias" :key="cat.id">
                <a href="#">{{ cat.categoria }}</a>
              </li>
              </ul>
        </li>
        <li><a href="https://www.actividadsegura.com/_files/ugd/ebd4b4_b015367e2e184b23808b0addf4860c35.pdf" target="_blank" :class="{ 'selected': selectedIndex === 2 }" @click.native="selectNavItemF(2)">Catalogo PDF</a></li>
        <li><RouterLink to="AcercaView" :class="{ 'selected': selectedIndex === 4 }" @click.native="selectNavItemF(4)">Acerca de</RouterLink></li>
    </div>
    <div style="width: 20%; display: flex; align-items: center; justify-content: space-evenly; margin-left: 20px;">
      <img src="../assets/carrito.png" alt=""  style="height: 30px; width: 40px;"> 
      <li>
        <li ><img src="../assets/user.png" alt="" style="height: 30px; width: 30px;" /></li>
          <ul class="menu-drop" style="font-size: 20px; width: 250px;">
              <li><RouterLink to="LoginView">Iniciar Sesion</RouterLink></li>
              <li><RouterLink to="#">Cerrar Sesion</RouterLink></li>
          </ul>
      </li>
    </div>
  </ul>
</nav>
</header>


</template>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Montserrat', sans-serif;
  font-size: 17px;
}

/*Barra nav conf*/ 
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
header ul li {
  position: relative;
  margin: 0 2px;
  text-decoration: none;
  color: rgb(255, 255, 255);
  letter-spacing: 2px;
  font-weight: 600;
}
header .active .logo,
header .active ul li{
  color: black;
  font-size: small;
  font-size: small;
    
}
.IMGD{
  opacity: 0;
  transition: opacity 0.3s ease;
  cursor: auto;
  width: 300px;
  transition: .5s;
  
}
.selected {
  position: relative;
}

.selected::after {
  content: '';
  display: block;
  position: absolute;
  bottom: 0;
  left: 0;
  margin-left: -2px;
  width: 105%;
  height: 3px;
  border-radius: 10px;
  background-color: rgba(76, 170, 237, 0.3);
}
/*Color de la barra de navegacion*/
.nav{
  position: fixed;
  width: 100vw;
  display: flex;
  align-items: center;
  justify-content: space-around;
  margin-left: -10px;
  margin-block-start: -10px;
  margin-block-end: -10px;
  height: 39px;
  background-color: white;
}
.nav.active{
  width: 100vw;
  display: flex;
  height: 70px;
  align-items: center;
  justify-content: space-around;
  background-color: #ffffff;
}
.nav.active .logo,
.nav.active a{
    color: black;
}
.nav.active a:hover{
 color: rgb(54, 166, 183);
}
.menu-drop{
  position: absolute;
  text-align: center;
  font-size: 13px;
  display: none;
  list-style: none;
  margin-top: -5px;
  margin-left: -100px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  border-bottom-left-radius: 20px;
  border-bottom-right-radius: 20px;
  background-color: rgba(255, 255, 255, 0.748);
  box-shadow: inset 0 -5px 15px -5px rgba(0, 0, 0, 0.2); 

}

.menu:not(.menuDD){
  display: flex;
  justify-content: center;
  gap: 40px;
  height: 85px;
  width: 100%;
  font-family: sans-serif;
  font-size:small;
  list-style: none;
  margin-top: -10px;
  box-shadow: inset 0 -5px 15px -5px rgba(0, 0, 0, 0.2); 
  margin-bottom: -57px;
  transition: 0.20s;
  background-color: #ffffff;
}
.menuDD{
  display: flex;
  justify-content: center;
  gap: 40px;
  height: 70px;
  width: 100%;
  font-family: sans-serif;
  font-size:small;
  list-style: none;
  margin-top: -50px;
  box-shadow: inset 0 -5px 15px -5px rgba(0, 0, 0, 0.4); 
  margin-bottom: -52px;
  transition: .2s;

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
  color: rgb(28, 172, 216);
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
  background-color: #000000;
}

</style>