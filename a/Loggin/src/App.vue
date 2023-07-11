<template>
  <form @submit.prevent="submit">
    <v-text-field
      v-model="name.value.value"
      :counter="10"
      :error-messages="name.errorMessage.value"
      label="Nombre"
    ></v-text-field>

    <v-text-field
      v-model="phone.value.value"
      :counter="7"
      :error-messages="phone.errorMessage.value"
      label="Telefono o celular"
    ></v-text-field>

    <v-text-field
      v-model="email.value.value"
      :error-messages="email.errorMessage.value"
      label="E-mail"
    ></v-text-field>

    <v-select
      v-model="tcliente.value.value"
      :items="items"
      :error-messages="tcliente.errorMessage.value"
      label="Selecciona tipo de cliente"
    ></v-select>

    <v-text-field
      v-model="contraseña.value.value"
      :error-messages="contraseña.errorMessage.value"
      label="Contraseña"
    ></v-text-field>

    <v-text-field
      v-model="confcontraseña.value.value"
      :error-messages="contraseña.errorMessage.value"
      label="Comfirma Contraseña"
    ></v-text-field>

    <v-checkbox
      v-model="checkbox.value.value"
      :error-messages="checkbox.errorMessage.value"
      value="1"
      label="Validar"
      type="checkbox"
    ></v-checkbox>

    <v-btn
      class="me-4"
      type="Comfirmar"
    >
      submit
    </v-btn>

    

    <v-btn @click="handleReset">
      clear
    </v-btn>
  </form>
</template>
<script setup>
  import { ref } from 'vue'
  import { useField, useForm } from 'vee-validate'

  const { handleSubmit, handleReset } = useForm({
    validationSchema: {
      name (value) {
        if (value?.length >= 2) return true

        return 'Tu nombre debe tener al menos 2 letras.'
      },
      phone (value) {
        if (value?.length > 9 && /[0-9-]+/.test(value)) return true

        return 'Tu numero necesita tener minimo 9 digitos.'
      },
      email (value) {
        if (/^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(value)) return true

        return 'Tu email debe tener un dominio valido.'
      },
      tcliente (value) {
        if (value) return true

        return 'Selecciona que tipo de cliente eres.'
      },
      checkbox (value) {
        if (value === '1') return true

        return 'Tienes que validar.'
      },
      contraseña (value) {
        if (value === confcontraseña.value.value) return true

        return 'Las contraseñas son diferentes'
      },
    },
  })
  const name = useField('name')
  const phone = useField('phone')
  const email = useField('email')
  const tcliente = useField('tcliente')
  const checkbox = useField('checkbox')
  const contraseña = useField('contraseña')
  const confcontraseña = useField('confcontraseña')

  console.log(confcontraseña.value);
  const items = ref([
    'Empresa',
    'Fisico',
  ])

  const submit = handleSubmit(values => {
    alert(JSON.stringify(values, null, 2))
  })
</script>

<style>
*{
  padding: 0;
  margin: 0;
}

form{
  width: 30vw;
  height: 80vh;
}
</style>