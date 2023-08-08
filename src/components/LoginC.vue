<script setup>
import { ref } from "vue";
import { useUsuarioStore } from "@/stores/UsuarioStore";
import Loading from "@/components/Loading.vue";

const usuarioStore = useUsuarioStore();
let valid = ref(true);
const mail = ref("");
const contraseña = ref("");

const data = {
  nombre: "",
  contraseña: "",
};

let overlay = ref(false);

function login() {
  if (!valid.value) {
    return;
  }

  const usuarioStore = useUsuarioStore();

  data.email = mail.value;
  data.contraseña = contraseña.value;

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
          v-model="contraseña"
          label="Contraseña"
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
