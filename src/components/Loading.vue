<script setup>

defineProps({
  mostrar: {
    type: Boolean,
    default: false,
  },
});
</script>
<template>
  <v-overlay :model-value="mostrar" class="align-center justify-center">
    <v-progress-circular
      color="primary"
      indeterminate
      size="64"
    ></v-progress-circular>
  </v-overlay>
</template>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Montserrat&display=swap");
* {
  font-family: "Montserrat", sans-serif;
  font-size: 17px;
}
</style>
