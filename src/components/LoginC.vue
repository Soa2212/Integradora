<script setup>

</script>
<template>
<div class="container">

  <form  class="form">
  <h2 class="form__title">Inicio Sesion</h2>
  <p class="form__paragraph">Aun no tienes una cuenta?<RouterLink to="Registro"> Entra aqui</RouterLink></p>

  <div class="form__container">
    
    <div class="form__group">
      <input type="text" id="name" class="form__input" placeholder=" ">
      <label for="name" class="form__label">Nombre:</label>
      <span class="form__line"></span>
    </div>

    <div class="form__group">
      <input type="text" id="user" class="form__input" placeholder=" ">
      <label for="user" class="form__label">Usuario:</label>
      <span class="form__line"></span>
    </div>

    <div class="form__group">
      <input type="text" id="password" class="form__input" placeholder=" ">
      <label for="password" class="form__label">Contraseña:</label>
      <span class="form__line"></span>
    </div>

      <input  type="submit" class="form__submit" value="Entrar">
  </div>

</form>

</div>
</template>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200&family=Roboto:wght@300;400;700&display=swap');
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

.form__paragraph{
  font-weight: 300;
}
.form__link{
  font-weight: 400;
  color: black;
}

.form__container{
  margin-top: 3em;
  display: grid;
  gap: 2.5em;
}
.form__group{
  position: relative;
  --color:#5757577e;

}
.form__input{
  width: 100%;
  background-color: none;
  color:#706c6c ;
  font-size: 1rem;
  padding: .6em .3em;
  border: none;
  outline: none;
  border-bottom: 1px solid var(--color);
  font-family: 'Roboto', sans-serif;
}

.form__input:not(:placeholder-shown){
  color: #4d4646;
}

.form__input:focus + .form__label,
.form__input:not(:placeholder-shown)+.form__label{
  transform: translateY(-12px) scale(.7);
  transform-origin: left top;
  color: #000000;
}

.form__label{
  color: var(--color);
  cursor: pointer;
  position: absolute;
  top: 0;
  left: 5px;
  transform: translateY(10px);
  transition: transform .5s,color .3s;
}

.form__submit{
  background-color: #3866f2;
  color: white;
  font-family: 'Roboto', sans-serif;
  font-weight: 300;
  font-size: 1rem;
  padding: .8em 0;
  border: none;
  border-radius: .5em;
}

.form__submit:hover{
  background-color:rgb(30, 139, 30);
  transition: 0.7s;
}

.form__line{
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 1px;
  background-color: #000000;
  transform: scale(0);
  transform: left bottom;
  transition: transform .4s;
}

.form__input:focus ~ .form__line,
.form__input:not(:placeholder-shown)+.form__line{
transform: scale(1);
}
</style>