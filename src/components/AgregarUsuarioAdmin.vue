<script setup>
import { ref, onMounted } from "vue";
import { useField, useForm } from "vee-validate";

const nuevoAdmin = ref({
  nombre: "",
  email: "",
  passwd: "",
  tipo: "admin",
});

const administradores = ref({});

const mostrarAdministradores = () => {
  fetch("http://localhost/administradores")
    .then((res) => res.json())
    .then((data) => (administradores.value = data.data));
};

onMounted(() => {
  mostrarAdministradores();
});

const { handleSubmit, handleReset } = useForm({
  validationSchema: {
    name(value) {
      if (value?.length >= 2) {
        nuevoAdmin.value.nombre = value;
        return true;
      }

      return "Ingrese al menos 2 caracteres";
    },
    email(value) {
      if (/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) {
        nuevoAdmin.value.email = value;
        return true;
      }

      return "Ingrese un e-mail valido";
    },
    passwd(value) {
      if (value?.length >= 5) return true;

      return "Ingrese al menos 5 caracteres";
    },
    confirmPasswd(value) {
      if (passwd.value.value === value) {
        nuevoAdmin.value.passwd = value;
        return true;
      }

      return "Las contraseñas no coinciden";
    },
    checkbox(value) {
      if (value === "1") return true;

      return "Por favor confirme";
    },
  },
});
const name = useField("name");
const email = useField("email");
const passwd = useField("passwd");
const confirmPasswd = useField("confirmPasswd");
const checkbox = useField("checkbox");

const submit = handleSubmit((values) => {
  fetch("http://localhost/agregarAdmin", {
    method: "POST",
    body: JSON.stringify(nuevoAdmin.value),
  });
  handleReset();
  setTimeout(() => {
    mostrarAdministradores();
  }, 500);
});
</script>
<template>
  <div class="ma-4">
    <h1 class="mb-2">Agregar usuario administrador</h1>
    <v-divider class="mb-5" thickness="2" color="black"></v-divider>
    <div class="d-flex">
      <div class="d-flex w-50">
        <form class="mt-4" @submit.prevent="submit">
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
            type="password"
            v-model="passwd.value.value"
            :error-messages="passwd.errorMessage.value"
            label="Contraseña"
          ></v-text-field>
          <v-text-field
            type="password"
            v-model="confirmPasswd.value.value"
            :error-messages="confirmPasswd.errorMessage.value"
            label="Confirmar contraseña"
          ></v-text-field>
          <v-checkbox
            v-model="checkbox.value.value"
            :error-messages="checkbox.errorMessage.value"
            value="1"
            label="Acepto y me hago responsable por la creacion de este nuevo usuario"
            type="checkbox"
          ></v-checkbox>
          <v-btn class="me-4" type="submit"> Agregar usuario </v-btn>
        </form>
      </div>
      <div class="d-flex flex-column w-50">
        <h2>Administradores actuales</h2>
        <v-table class="mr-5">
          <thead>
            <tr>
              <th class="text-left">Nombre</th>
              <th class="text-left">Email</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="admin in administradores" :key="admin.id">
              <td>{{ admin.nombre }}</td>
              <td>{{ admin.email }}</td>
            </tr>
          </tbody>
        </v-table>
      </div>
    </div>
  </div>
</template>
