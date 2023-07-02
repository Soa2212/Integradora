<script setup>
import { RouterLink, RouterView } from 'vue-router'
window.addEventListener("scroll",function(){
  var nav = this.document.querySelector(".nav")
  nav.classList.toggle("active",window.scrollY>0)
})
</script>

<template>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200&display=swap" rel="stylesheet">
<header>
    <nav class="nav">
        <div class="logo">
            <img src="../src/assets/Protecc_Seg.png" alt="Logo" style="height: 65px; width: 270px;">

        </div>
        <ul class="menu">
        <li><RouterLink to="/Inicio">Inicio</RouterLink></li>
        <li>
            <a href="#">Productos</a>
            <ul class="menu-drop">
                <li><a href="#">Cat1</a></li>
                <li><a href="#">Cat2</a></li>
                <li><a href="#">Cat3</a></li>
            </ul>
        </li>
        <li><RouterLink to="/Cotizacion">Cotizacion</RouterLink></li>
        <li><RouterLink to="Acerca">Acerca</RouterLink></li>
        </ul>
        <div class="Menu2">
      <img src="../src/assets/carrito.png" alt=""  style="height: 30px; width: 40px;">
      <img src="../src/assets/user.png" alt="" style="height: 30px; width: 30px;">
      <img src="../src/assets/ajustes.png" alt="" style="height: 30px; width: 35px;">
    </div> 
    </nav>
</header>
<RouterView to="Inicio"></RouterView>
<RouterView to="Cotizacion"></RouterView>
<RouterView to="Acerca"></RouterView>
</template>
<style>
*{
margin: 0;
padding: 0;
box-sizing: border-box;
}
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
  margin: 0 10px;
  text-decoration: none;
  color: rgb(255, 255, 255);
  letter-spacing: 2px;
  font-weight: 600;
  transition: 1.5s;
}
header .active .logo,
header.active ul li a{
  color: black;
  font-size: 10px;
  margin: 0;
  padding: 0;
  font-size: 20px;
}

.nav{
    position: fixed;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 25px;
    transition: all 0.5s ease
}
.nav.active{
    background: #fff;
    padding: 15px;
}
.nav.active .logo,
.nav.active a{
    color: black;
}
.nav.active a:hover{
    color: rgb(8, 61, 255);
}
.menu-drop{
position: absolute;
display: none;
list-style: none;
width: 170px;
border-radius: 5px;
background-color: rgba(255, 255, 255, 0.5);
}

.logo{
font-size: 25px;
color: #FFF;
font-weight: 100;
display: flex;
margin-right: 20px;
margin-left: 40px;
justify-items: flex-end;
}
.menu{
    display: flex;
    display: flex;
  height: 85px;
  width: 800px;
  align-items: center;
  justify-content: space-around;
  font-family: sans-serif;
  font-size:medium;
  list-style: none;
  margin-left: 20px;
}
.menu li{
    list-style: none;
    margin: 10px;
}
.menu li a{
    display: block;
    color: #000000;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.5s ease;
}
.menu li a:hover{
    padding: 5px 10px;
    color: rgb(8, 61, 255);
    border-radius: 15px;
}
.menu li:hover .menu-drop{
  display: block;
}
.scrol{
    height: 100px;
}
.Menu2{
  display: flex;
  height: 85px;
  width: 500px;
  align-items: center;
  justify-content: flex-end;
  gap: 20px;
  margin-left: 60px;
  margin-right:60px;
}

</style>