<script setup>
import { ref } from "vue";
import { useField, useForm } from "vee-validate";

const usuario = ref({
  nombre: "",
  email: "",
  contrasena: "",
  tipo: "normal",
});

const avisoEmail = ref('');

const { handleSubmit, handleReset } = useForm({
  validationSchema: {
    name(value) {
      if (value?.length >= 2) {
        usuario.value.nombre = value;
        return true;
      }

      return "Tu nombre debe tener al menos 2 letras.";
    },
    email(value) {
      // Expresión regular mejorada para validar correos electrónicos
      const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

      if (emailRegex.test(value)) {
        usuario.value.email = value;
        return true;
      }

      return "Por favor, ingresa una dirección de correo electrónico válida.";
    },

    checkbox(value) {
      if (value === "1") return true;

      return "Tienes que validar.";
    },
    contraseña(value) {
      if (value === confcontraseña.value.value) {
        usuario.value.password = value;
        return true;
      }

      return "Las contraseñas son diferentes";
    },
  },
});
const name = useField("name");
const email = useField("email");
const contraseña = useField("contraseña");
const confcontraseña = useField("confcontraseña");
const checkbox = useField("checkbox");

const correoExiste = ref({
  bcorreo: ''
});

const submit = handleSubmit((values) => {
  fetch("http://localhost/verificarEmail", {
    method: "POST",
    body: JSON.stringify(usuario.value),
  })
  .then(res => res.json())
  .then(data => {
    correoExiste.value.bcorreo = data.data[0].bcorreo
    if (correoExiste.value.bcorreo == 1) {
      avisoEmail.value = 'El correo utilizado ya está registrado. Por favor use otro*';
    } else if (correoExiste.value.bcorreo == 0){
      fetch("http://localhost/agregarUser", {
      method: "POST",
      body: JSON.stringify(usuario.value),
      })
      avisoEmail.value = '';
      handleReset();
      location.reload();
    }
  });
});
</script>
<template>
  <div class="cont">
    <form @submit.prevent="submit">
      <h2
        class="form__title"
        style="
          display: flex;
          justify-content: center;
          font-size: 27px;
          margin-block-end: 20px;
        "
      >
        Registro
      </h2>
      <p style="display: flex; justify-content: center; margin-bottom: 10px">
        ¿Ya te encuentras registrado?

        <RouterLink to="LoginView"> Entra aqui</RouterLink>
      </p>
      <v-text-field
        v-model="name.value.value"
        :counter="10"
        :error-messages="name.errorMessage.value"
        label="Nombre"
      ></v-text-field>

      <v-text-field
        v-model="email.value.value"
        :error-messages="email.errorMessage.value"
        label="E-mail"
      ></v-text-field>

      <v-text-field
        v-model="contraseña.value.value"
        type="password"
        :error-messages="contraseña.errorMessage.value"
        label="Contraseña"
      ></v-text-field>

      <v-text-field
        v-model="confcontraseña.value.value"
        type="password"
        :error-messages="contraseña.errorMessage.value"
        label="Confirma Contraseña"
      ></v-text-field>

      <v-checkbox
        v-model="checkbox.value.value"
        :error-messages="checkbox.errorMessage.value"
        value="1"
        label="Validar"
        type="checkbox"
      ></v-checkbox>

      <p style="color: rgb(177, 0, 0);" class="mb-5 d-flex justify-center">
        {{ avisoEmail }}
      </p>

      <div class="btnsc">
        <div style="width: 65%; display: flex; justify-content: end">
          <v-btn class="form__submit1" type="submit">Registrarse</v-btn>
        </div>

        <div style="width: 30%; display: flex; justify-content: center">
          <v-btn class="form__submit2" @click="handleReset">Vaciar</v-btn>
        </div>
      </div>
    </form>
  </div>
</template>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Montserrat&display=swap");
* {
  padding: 0;
  margin: 0;
  font-family: "Montserrat", sans-serif;
  font-size: 17px;
}
.v-text-field {
  background-color: rgb(255, 255, 255);
}
.form__title {
  font-size: 2rem;
  margin-bottom: 0.5em;
  display: flex;
  justify-content: center;
}
.btnsc {
  display: flex;
  align-items: center;
}
.form__submit1 {
  display: flex;
  align-items: center;
  background-color: #3866f2;
  color: white;
  font-family: "Roboto", sans-serif;
  font-weight: 300;
  width: 150px;
  font-size: 1rem;
  padding: 0.8em 0;
  border: none;
  border-radius: 0.5em;
}

.form__submit1:hover {
  background-color: rgb(30, 139, 30);
  transition: 0.7s;
}
.form__submit2 {
  display: flex;
  align-items: center;
  background-color: #3866f2;
  color: white;
  font-family: "Roboto", sans-serif;
  font-weight: 300;
  width: 80px;
  height: 30px;
  font-size: 13px;
  padding: 0.8em 0;
  border: none;
  border-radius: 0.5em;
}
.form__submit2:hover {
  background-color: rgb(167, 17, 17);
  transition: 0.7s;
}
form {
  width: 90%;
  max-width: 500px;
  max-height: 700px;
  padding: 1%;
  border-radius: 20px;
  background-color: white;
  box-shadow: 0 5px 10px -5px rgba(0, 0, 0, 1.9);
}

.cont {
  display: flex;
  height: 100vh;
  width: 100vw;
  justify-content: center;
  align-items: center;
  background-color: beige;
}
</style>