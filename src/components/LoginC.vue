<script setup>
import { useField, useForm } from 'vee-validate'
    const { handleSubmit, handleReset } = useForm({
      validationSchema: {
        name (value) {
          if (value?.length >= 2) return true
  
          return 'Tu nombre debe tener al menos 2 letras.'
        },
        contraseña (value) {
          if (value === 'Hola') return true
  
          return 'Las contraseñas son diferentes'
        },
      },
    })
    const name = useField('name')
    const contraseña = useField('contraseña')
</script>
<template>
<div class="container">

  <form  class="form">
  <h2 class="form__title">Inicio Sesion</h2>
  <p class="form__paragraph">Aun no tienes una cuenta?<RouterLink to="Registro"> Entra aqui</RouterLink></p>

  <div class="form__container">

    <v-text-field
      v-model="name.value.value"
      :counter="10"
      :error-messages="name.errorMessage.value"
      label="Nombre"
    ></v-text-field>
    <v-text-field
      v-model="contraseña.value.value"
      :error-messages="contraseña.errorMessage.value"
      label="Contraseña"
    ></v-text-field>
    <v-btn class="custom-btn" type="Comfirmar">submit</v-btn>
  </div>

</form>

</div>
</template>
<style scoped>
.title {
  font-family: 'Nunito Sans', sans-serif;
}

.text {
  font-family: 'Roboto', sans-serif;
}

*{
  box-sizing: border-box;
}

.container{
  display: flex;
  min-height: 100vh;
  background-color: #F5F5DC;
  background-image: radial-gradient(#f2ff00 0.45px, #F5F5DC 0.45px);
  background-size: 9px 9px;
}

.form{
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
.form__title{
  font-size: 2rem;
  margin-bottom: .5em;
}
.form__container{
  margin-top: 3em;
  display: grid;
  gap: 2.5em;
}
.custom-btn {
  background-color: #3866f2;
  transition: 0.3s;
}
.custom-btn:hover {
  background-color: rgb(30, 139, 30);
}
</style>