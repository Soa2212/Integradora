<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { RouterLink, RouterView } from 'vue-router';
import { useTokenStore } from "@/stores/TokenUser";
import { useIdStore } from "@/stores/IdUSR";
import { useTipoStore } from "@/stores/TipoUSR";
import { useEmailStore } from "@/stores/EmailUSR";

const Email = useEmailStore();
const IdUsr = useIdStore();
const TipoUSR = useTipoStore();
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

const categorias = ref([]);
fetch("http://3.136.87.82/categorias") //Me consigue todas las categorias para mostrar en la pagina
  .then((res) => res.json())
  .then((datos) => {
    categorias.value = datos.data;
  });  

const logout=()=>{
  tokenStore.eliminarTokenDelLocalStorage();
  TipoUSR.eliminarTipoDelLocalStorage();
  IdUsr.eliminarIdDelLocalStorage();
  Email.eliminarEmailDelLocalStorage();
  location.reload();
}

const tokenStore = useTokenStore();
const tieneToken = tokenStore.tieneToken;

</script>

<template>

<header>
<nav :class="{ active: isNavActive }" class="nav" >     
  <ul class="menu" :class="{ menuDD: isNavActive  }">
    <RouterLink to="HomeView" :class="{ IMGD: isNavActive }" >
      <img src="../assets/Protecc_Seg.png" alt="Logo" style="height: 65px; width: 215px; margin-left: 40px; margin-top: 10px;">
    </RouterLink>
      <div class="nvbr">
        <li><RouterLink to="HomeView" >Inicio</RouterLink></li>
        <li><RouterLink to="ProductosView">Catalogo</RouterLink></li> 
        <li><a href="https://www.actividadsegura.com/_files/ugd/ebd4b4_b015367e2e184b23808b0addf4860c35.pdf" target="_blank" >Catalogo PDF</a></li>
        <li><RouterLink to="AcercaView">Acerca de</RouterLink></li>
    </div>
    <div class="usrCarrito">
      <RouterLink to="/Carrito">
        <img src="../assets/carrito.png" alt=""  class="carrIMG"> 
      </RouterLink>
      <li>
        <li><img src="../assets/user.png" alt="" class="usrIMG"/></li>
          <ul class="menu-drop" style=" width: 250px;">
            <li v-if="tieneToken">
              <RouterLink to="Pedidos">Pedidos 
                <v-icon class="mdi-border-color">a</v-icon>
              </RouterLink>
            </li>
              <li><RouterLink to="LoginView" v-if="!tieneToken">Iniciar Sesion</RouterLink>
                <RouterLink @click="logout()" to="HomeView" v-else>Cerrar Sesion</RouterLink>
                </li>
              
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
  display: none;
  list-style: none;
  margin-top: -5px;
  margin-left: -140px;
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
  list-style: none;
  margin-top: -7px;
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
  cursor: pointer;
  
}
/*Letras de hover barra */
.menu li a:hover{
  display: flex;
  color: rgb(28, 172, 216);
  cursor: pointer;
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

.carrIMG{
  height: 30px; 
  width: 40px;
  transition: 0.6s;
}

.carrIMG:hover{
  height: 33px; 
  width: 43px;
  transition: 0.4s;
}

.usrIMG{
  height: 30px; 
  width: 30px;
  transition: 0.6s;
}
.usrIMG:hover{
  height: 33px; 
  width: 33px;
  transition: 0.4s;
}
.usrCarrito{
  width: 20%; 
  display: flex; 
  align-items: center; 
  justify-content: space-evenly; 
  margin-left: 20px;
}


.nvbr{
  width: 80%; 
  display: flex; 
  align-items: center; 
  justify-content: flex-start; 
  gap: 20px;
}
@media (max-width: 1188px) {
  *{
    font-size: 15px;
    text-align: center;

  }
}
@media (max-width: 1123px) {
  *{
    font-size: 15px;
  }
}
@media (max-width: 1080px) {
  *{
    font-size: 14px;
  }
}
@media (max-width: 1062px) {
  *{
    font-size: 12px;
  }
}
@media (max-width: 1050px) {
  *{
    font-size: 14px;
  }
}
@media (max-width: 930px) {
  .usrCarrito{
    margin-left: 0;
  }
}
@media (max-width: 910px) {
  .usrCarrito{
    margin-left: -15px;
  }
}



</style>