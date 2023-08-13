<script setup></script>
<template>
  <footer class="footer">
    <div class="contenedor-foot">
      <div class="content-foo">
        <h4>Numero</h4>
        <p>3326413741</p>
      </div>
      <div class="content-foo">
        <h4>Email</h4>
        <p>ventasgdl@actividadsegura.com</p>
      </div>
      <div class="content-foo">
        <h4>ubicación</h4>
        <p>
          Av. Cruz del Sur no. 5000 local 5e Col. Las Águilas. Zapopan, Jal.
        </p>
      </div>
    </div>
    <h2 class="titulo-final">&copy; Actividad Segura</h2>
  </footer>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Montserrat&display=swap");
* {
  font-family: "Montserrat", sans-serif;
  font-size: 17px;
}

.footer {
  background: #414141;
  padding: 60px 0 30px 0;
  margin: auto;
  overflow: hidden;
}
.contenedor-foot {
  display: flex;
  width: 90%;
  justify-content: space-evenly;
  margin: auto;
  padding-bottom: 50px;
  border-bottom: 1px solid gray;
}

.content-foo {
  text-align: center;
}
.content-foo h4 {
  color: white;
  border-bottom: 3px solid rgb(0, 0, 0);
  padding-bottom: 5px;
  margin-bottom: 20px;
}
.content-foo p {
  color: #ccc;
}
.titulo-final {
  text-align: center;
  font-size: 24px;
  margin-top: 20px;
  color: #9e9797;
}
.tarjetas {
  width: 75%;
  display: flex;
  flex-direction: column;
}
</style>
