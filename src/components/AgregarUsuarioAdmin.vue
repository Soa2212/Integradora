<script setup>
  import { ref } from 'vue'
  import { useField, useForm } from 'vee-validate'

  const nuevoAdmin = ref({
    nombre: '', 
    email: '',
    contraseña: '',
    tipo: 'admin'
  })

  const { handleSubmit } = useForm({
    validationSchema: {
      name (value) {
        if (value?.length >= 2) {
            nuevoAdmin.value.nombre = value;
            return true}

        return 'Ingrese al menos 2 caracteres'
      },
      email (value) {
        if (/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) {
            nuevoAdmin.value.email = value;
            return true}

        return 'Ingrese un e-mail valido'
      },
      passwd (value) {
        if (value?.length >= 5) return true

        return 'Ingrese al menos 5 caracteres'
      },
      confirmPasswd (value) {
        if (passwd.value.value === value) {
            nuevoAdmin.value.contraseña = value;
            return true}

        return 'Las contraseñas no coinciden'
      },
      checkbox (value) {
        if (value === '1') return true

        return 'Por favor confirme'
      },
    },
  })
  const name = useField('name')
  const email = useField('email')
  const passwd = useField('passwd')
  const confirmPasswd = useField('confirmPasswd')
  const checkbox = useField('checkbox')

  const submit = handleSubmit(values => {
    enviarAdmin();
  })

  const enviarAdmin = () => {
  fetch('http://localhost/agregarAdmin', {
  method: "POST",
  body: JSON.stringify(nuevoAdmin.value)})
  window.location.reload();
  }
</script>
<template>
    <div class="ma-4">
        <h1>Agregar usuario administrador</h1>
        <form @submit="submit">
    <v-text-field
      v-model="name.value.value"
      :counter="10"
      :error-messages="name.errorMessage.value"
      label="Name"
    ></v-text-field>
    <v-text-field
      v-model="email.value.value"
      :error-messages="email.errorMessage.value"
      label="E-mail"
    ></v-text-field>
    <v-text-field
      v-model="passwd.value.value"
      :error-messages="passwd.errorMessage.value"
      label="Contraseña"
    ></v-text-field>
    <v-text-field
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
    <v-btn class="me-4" type="submit">
      Agregar usuario
    </v-btn>
  </form>
    </div>
</template>