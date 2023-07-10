<template>
    
<form class="form">
    <h2 class="form__title">Inicia Seion</h2>
    <p class="form__paragraph">Aun no tienes sesion? <a href="#" class="form__link">Entra aqui</a></p>
    
    <div class="for__container">
        <div class="form__group">
            <input type="text" id="name" class="form__input" placeholder="  ">
            <label for="name" class="form__label">Nombre:</label>
            <span class="form__line"></span>
        </div>
        <div class="form__group">
            <input type="text" id="user" class="form__input" placeholder="  ">
            <label for="user" class="form__label">Usuario:</label>
            <span class="form__line"></span>
        </div>
        <div class="form__group">
            <input type="text" id="password" class="form__input" placeholder="  ">
            <label for="password" class="form__label">Nombre:</label>
            <span class="form__line"></span>
        </div>
        <input type="submit" class="form__submit" value="Entrar">
    </div>
</form>

</template>
<script setup>

</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200&family=Roboto:wght@300;400;700&display=swap');
.custom-title {
  font-family: 'Roboto', sans-serif;
}

.custom-paragraph {
  font-family: 'Nunito Sans', sans-serif;
}
</style>