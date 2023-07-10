<template>
    <v-app id="inspire" class="container">
  
      <v-main>
        <v-container>
          <v-row>
            <v-col
              v-for="n in 24"
              :key="n"
              cols="4"
            >
            <v-col>
                <v-card
                class="mx-auto"
                max-width="344"
                style="border-radius: 15px;">
                <div style="display: flex;
                justify-content: center;">
                    <img src=""/>
                </div>
                    <img src="">
                    <v-card-subtitle style="color: rgb(84, 84, 84);">Categoria</v-card-subtitle>
                    <v-card-title>Nombre Product</v-card-title>
                    <v-card-actions>
                        <v-btn color="orange-lighten-2" variant="text">
                            Comprar
                        </v-btn>
                        <v-btn size="small" color="indigo-darken-4" style="background-color: #8C9EFF; border: 1px solid #2137b1; border-radius: 15px;">Agregar al Carrito</v-btn>
                    <v-spacer></v-spacer>
                    </v-card-actions>
                    <v-divider></v-divider>
                    <v-card-text>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam, dolorum minus nam eaque veniam voluptas dolor consequuntur quibusdam debitis nihil earum voluptatem soluta esse, architecto officiis temporibus natus rem dolore.
                    </v-card-text>
                </v-card>
            </v-col>
            </v-col>
          </v-row>
        </v-container>
      </v-main>
    </v-app>
  </template>
  <style>
.container{
  background-color: beige;
}
</style>