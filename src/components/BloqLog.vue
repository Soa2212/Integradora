<template>
  
  <div class="overlay">
    <div class="centered-message">
      <div class="warning-icon">⚠️</div>
      <h2>¡Hola!</h2>
      <p>Para aprovechar al máximo todas las ventajas de nuestro carrito, te animamos a iniciar sesión.</p>
      <RouterLink to="LoginView" class="login-button">Iniciar sesión</RouterLink>
    </div>
  </div>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Montserrat&display=swap");
* {
  font-family: "Montserrat", sans-serif;
  font-size: 17px;
}

.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.centered-message {
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
  text-align: center;
}

.warning-icon {
  font-size: 36px;
  margin-bottom: 10px;
}

h2 {
  font-size: 24px;
  margin-bottom: 10px;
}

p {
  margin-bottom: 20px;
}

.login-button {
  background-color: #007bff;
  text-decoration: none;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.login-button:hover {
  background-color: #0056b3;
}
</style>

<script setup>
</script>
