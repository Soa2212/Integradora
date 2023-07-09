<template>
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">

  <div class="container">
    <div class="barra-nav">
    </div>
    <div class="formulario">
      <div class="form">
        <!-- Hoja del formulario -->
        <v-sheet width="500" class="mx-auto pa-6 rounded-lg">
        <v-form @submit.prevent="submit">
          <h1 class="title">Formulario de cotización</h1>
          <p class="message">Ingresa tus datos y nos pondremos en contacto contigo</p>
          <v-text-field
            v-model="name.value.value"
            label="Nombre o Empresa*"
            :error-messages="name.errorMessage.value"
          ></v-text-field>
          <v-text-field
            v-model="email.value.value"
            label="Correo electrónico*"
            :error-messages="email.errorMessage.value"
          ></v-text-field>
          <v-text-field
            v-model="phone.value.value"
            label="Teléfono*"
            :error-messages="phone.errorMessage.value"
          ></v-text-field>
          <v-combobox
            v-model="select.value.value"
            label="Productos de interés"
            :error-messages="select.errorMessage.value"
            :items="items"
          ></v-combobox>
          <v-text-field
            v-model="message.value.value"
            label="Mensaje*"
            :error-messages="message.errorMessage.value"
          ></v-text-field>
          <v-btn color="black" rounded="xs" block class="mt-2" type="submit">Enviar</v-btn>
          <!-- Este es el mensaje que aparece al cargar los datos del formulario-->
          <v-dialog
            v-model="dialog"
            :scrim="false"
            persistent
            width="auto"
          >
            <v-card
              color="black"
            >
              <v-card-text>
                Espere un momento
                <v-progress-linear
                  indeterminate
                  color="white"
                  class="mb-0"
                ></v-progress-linear>
              </v-card-text>
            </v-card>
          </v-dialog>
          <!-- Este es el mensaje que aparece despues de haber cargado los datos -->
          <v-dialog
            v-model="dialog2"
            width="auto"
          >
            <v-card>
              <v-card-text>
                Formulario enviado
              </v-card-text>
              <v-card-actions>
                <v-btn
                  color="primary"
                  variant="text"
                  @click="dialog2 = false"
                >
                  Cerrar
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-form>
      </v-sheet>
      </div>
    </div>
    
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
//Esto es un plugin que ayuda a validar formularios
import { useField, useForm } from 'vee-validate';

const dialog = ref(false);
const dialog2 = ref(false);

//Cuando el valor de dialog cambia, tomara un segundo para que vuelva a cambiar a falso y no se muestre
//Cuando pase ese segundo, el valor de dialog2 cambia a true para mostrarse
//Dialog2 se deja de mostrar cuando se presiona Cerrar
watch(dialog, (val) => {
  if (!val) return;

  setTimeout(() => {
    dialog.value = false
    dialog2.value = true;
  }, 1000)
  
});

//Guarda los valores y valida el formulario
const { handleSubmit } = useForm({
    validationSchema: {
      name (value) {
        if (value?.length >= 2) return true
        return 'Necesita al menos dos caracteres'
      },
      phone (value) {
        if (value?.length > 9 && /[0-9-]+/.test(value)) return true
        return 'El numero necesita al menos 9 digitos'
      },
      email (value) {
        if (/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) return true
        return 'Ingrese un email-valido'
      },
      select (value) {
        if (value) return true
        return 'Seleccione un producto'
      },      
      message (value) {
        if (value) return true
        return 'Este campo es obligatorio'
      },
    },
  })

  const name = useField('name')
  const phone = useField('phone')
  const email = useField('email')
  const select = useField('select')
  const message = useField('message')

  const items = ref([
    'Item 1',
    'Item 2',
    'Item 3',
    'Item 4',
  ])

  const submit = handleSubmit(values => {
    dialog.value = true;
    console.log(values);
  })
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