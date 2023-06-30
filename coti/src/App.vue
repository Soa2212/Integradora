<template>
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">

  <div class="container">
    <div class="barra-nav">
    </div>
    <div class="formulario">
      <div class="form">
        <v-sheet width="500" class="mx-auto pa-6 rounded-lg">
        <v-form @submit.prevent="asignarDatos">
          <h1 class="title">Formulario de cotización</h1>
          <p class="message">Ingresa tus datos y nos pondremos en contacto contigo</p>
          <v-text-field
            v-model="nombre"
            label="Nombre o Empresa*"
            :rules = "rules"
          ></v-text-field>
          <v-text-field
            v-model="correo"
            label="Correo electrónico*"
            :rules = "rules"
          ></v-text-field>
          <v-text-field
            v-model="telefono"
            label="Teléfono*"
            :rules = "rules"
          ></v-text-field>
          <v-combobox
            v-model="productos"
            label="Productos de interés"
            :items="['Botas de seguridad', 'Casco protector', 'Guantes', 'Chalecos', 'Lentes de seguridad', 'Arneses']"
            :rules = "rules"
          ></v-combobox>
          <v-text-field
            v-model="mensaje"
            label="Mensaje*"
            :rules = "rules"
          ></v-text-field>
          <v-btn color="black" rounded="xs" type="submit" block class="mt-2">Enviar</v-btn>
        </v-form>
      </v-sheet>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

let nombre = ref();
let correo = ref();
let telefono = ref();
let mensaje = ref();
let productos = ref()

let rules = [
        value => {
          if (value) {
            enviar.value = false;
          }
          return 'Este campo es obligatorio'
        },
      ];

const asignarDatos = () => {
  alert(nombre.value);
  alert(correo.value);
  alert(telefono.value);
  alert(productos.value);
  alert(mensaje.value);
}
</script>

<style scoped>
.container {
  height: 100vh;
  width: 100vw;
  background-color: beige;
}

.barra-nav {
  background-color: aqua;
  height: 10%;
  margin-bottom: 3em;
}

.formulario {
  display: flex;
  justify-content: center;
}

.form {
  border: 2px solid yellow;
  padding: 4em;
  background-color: rgb(228, 223, 223);
  margin-bottom: 3em;
}

.message {
  margin-bottom: 2em;
}
</style>