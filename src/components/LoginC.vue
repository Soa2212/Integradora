<script setup>
import { ref } from "vue";
import { useTokenStore } from "@/stores/TokenUser";
import Loading from "@/components/Loading.vue";

const TokenUser = useTokenStore();
let valid = ref(true);
const mail = ref("");
const contrasena = ref("");
let overlay = ref(false);
const token = ref();

const data = ref({
  email: "",
  contrasena: "",
});

function login() {
  overlay.value = true;

  data.value.contrasena = contrasena.value;
  data.value.email = mail.value;

  fetch("http://localhost/logear", {
    method: "POST",
    body: JSON.stringify(data.value),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Hubo un problema con la solicitud.");
      }
      return response.json();
    })
    .then((responseData) => {
      // Cambio el nombre de la variable para evitar conflicto con data
      console.log(responseData);
      token.value = responseData.data._token;
      console.log(token.value); // Acceder al valor del token, no al token en sí
      TokenUser.guardarTokenEnLocalStorage(token.value); // Guardar el valor del token en almacenamiento local
      overlay.value = false; // Mover estas líneas dentro del segundo then
      location.reload();
    })
    .catch((error) => {
      console.error("Error en la solicitud:", error);
      overlay.value = false;
    });
}
</script>
<template>
  <div class="container">
    <div class="form">
      <h2
        class="form__title"
        style="display: flex; justify-content: center; font-size: 24px"
      >
        Inicio Sesion
      </h2>
      <p class="form__paragraph">
        Aun no tienes una cuenta?<RouterLink to="Registro">
          Entra aqui</RouterLink
        >
      </p>

      <div class="form__container">
        <v-text-field
          v-model="mail"
          :counter="'...'"
          label="E-mail"
        ></v-text-field>

        <v-text-field
          v-model="contrasena"
          label="Contraseña"
          type="password"
        ></v-text-field>
        <v-btn @click="login()" class="custom-btn">submit</v-btn>
      </div>
      <Loading :mostrar="overlay"></Loading>
    </div>
  </div>
</template>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Montserrat&display=swap");

* {
  box-sizing: border-box;
  font-family: "Montserrat", sans-serif;
  font-size: 17px;
}

.container {
  display: flex;
  min-height: 100vh;
  background-color: #f5f5dc;
  background-image: radial-gradient(#f2ff00 0.45px, #f5f5dc 0.45px);
  background-size: 9px 9px;
}

.form {
  background-color: #fff;
  margin: auto;
  width: 90%;
  max-width: 500px;
  max-height: 700px;
  padding: 4.5em 3em;
  border-radius: 10px;
  box-shadow: 0 5px 10px -5px rgba(0, 0, 0, 1.9);
  text-align: center;
}
.form__title {
  font-size: 2rem;
  margin-bottom: 0.5em;
}
.form__container {
  margin-top: 3em;
  display: grid;
  gap: 2.5em;
}
.custom-btn {
  background-color: #3866f2;
  transition: 0.3s;
  border-radius: 20px;
  color: #fff;
}
.custom-btn:hover {
  background-color: rgb(30, 139, 30);
}
</style>
@/stores/TokenUser
