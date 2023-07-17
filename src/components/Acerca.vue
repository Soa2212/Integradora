<script setup>
import { onMounted } from 'vue';

let map;

const initMap = async () => {
  //@ts-ignore
  const { Map } = await google.maps.importLibrary('maps');

  map = new Map(document.getElementById('map'), {
    center: { lat: -34.397, lng: 150.644 },
    zoom: 8,
  });
};

onMounted(initMap);
</script>
<template>
  <div class="container">
   <div class="card">
     <div class="Nos">
      <p style="margin-top: 20px;">Sobre Nosotros.</p>
    </div>
    <p style="margin-top: 20px;">Quienes somos</p>
    <h6 style="margin-top: 30px; width: 70%; text-align: justify;">
      En ACTIVIDAD SEGURA no sólo encontrará lo que necesita, sino también
      calidad y buen precio. Experiencia en la industria nos dan una
      especialización para proporcionar productos y servicio con los que los
      clientes quedan satisfechos. Así esté buscando el equipo para un proyecto,
      una compra especial o desee comprar al mayoreo, puede contar con nosotros
      y nuestros productos, siempre con un servicio de calidad. Descargue y
      revise el catálogo base, llámenos si requiere un producto dentro o fuera
      de catálogo.
    </h6>
    <div class="video">
      <iframe width="660" height="355" src="https://www.youtube.com/embed/UsHccXFV-60" frameborder="0" allowfullscreen></iframe>
    </div>
   </div>

   <div class="card2">
    <div class="Nos">
      <p style="margin-top: 20px;">Contáctenos.</p>
    </div>
    <p style="margin-top: 25px;"> Av. Cruz del Sur no. 5000 local 5e</p>
    <p>Col. Las Águilas. Zapopan, Jal.</p>
    <p>ventasgdl@actividadsegura.com</p>
    <p>#3326413741</p>
    <div style="display: flex; width: 220px; justify-content: space-around; align-items: center;">
      <a href="https://www.youtube.com/channel/UCLE1Kol1YywJmaJRYD0Nobw" target="_blank"><img src="../assets/logo1.jpg" alt=""></a>
      <a href="https://www.facebook.com/actividadsegura?ti=as" target="_blank"><img src="../assets/logo2.jpg" alt=""></a>
      <a href="https://www.google.com/maps/place/20%C2%B037'43.4%22N+103%C2%B024'31.6%22W/@20.6287153,-103.4109686,17z/data=!3m1!4b1!4m4!3m3!8m2!3d20.6287153!4d-103.4087799?entry=ttu" target="_blank"><img src="../assets/logo3.jpg" alt=""></a>
    </div>
    <div id="map">

    </div>
    
   </div>

  </div>
</template>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Montserrat&display=swap");
* {
  font-family: "Montserrat", sans-serif;
}
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 40px;
  height: 1340px;
  width: 100vw;
  background-color: beige;
}
.Nos {
  color: rgb(251, 205, 45);
  font-size: 40px;
  font-weight: 100;
}
.card{
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 75%;
  height: 864.5px;
  background-color: white;
  box-shadow: 0 5px 10px -5px rgba(0, 0, 0, 1.9);
  border-radius: 50px;
}
.card2{
  margin-top: 50px;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 75%;
  height: 344.5px;
  background-color: white;
  box-shadow: 0 5px 10px -5px rgba(0, 0, 0, 1.9);
  border-radius: 50px;
}

.video{
  width: 90%;
  height: 57%;
  margin-top: 40px;
  border-radius: 20px;
  background-image: url(../assets/ANIMG.JPG);
  background-size: cover;
  display: flex;
  justify-content: center;
  align-items: center;
  }
</style>
