<script setup>
import { ref,onMounted} from "vue";
import { useField, useForm } from 'vee-validate'

const productos = ref({});
const categorias = ref({});
const eliminar = ref(false);
const dialog = ref(false);
const dialogDel = ref(false);
const alerta = ref(false);
const fileInput = ref(null);
const selectedImage = ref(null);
const detallar = ref(false);
const crearNuevoArticulo = ref(false);
const seleccionarCat = ref(false);

const agregarTallaNum = ref(true);
const agregarTallaRopa = ref(false);
const agregarColor = ref(false);
const aviso = ref('');

const producto = ref({
  nombre: ''
});

const seleccionarColor = ref(false);
const seleccionarTallaNum = ref(false);
const seleccionarTallaRopa = ref(false);

const tallaNum = ref({});
const tallaRopa = ref({});
const colores = ref({});

let letras = /[a-zA-Z]/;

const seleccionados = ref([]);

const nuevoProducto = ref({
  nombre: "",
  precio: "",
  imagen1: null,
  descripcion: "",
  categoria: "",
  estado: "activo",
});

const nuevoArticulo = ref({
  producto: "",
  cantidad: "",
  talla_numerica: "33",
  talla_ropa: "7",
  color: "17"
})

const handleFileChange = () => {
  selectedImage.value = fileInput.value.files[0];
};

const mostrarProductos = () => {
  fetch("http://localhost/productos")
  .then((res) => res.json())
  .then((datos) => (productos.value = datos.data));
}

const mostrarCategorias = () =>{
  fetch("http://localhost/categorias")
  .then((res) => res.json())
  .then((datos) => (categorias.value = datos.data));
}

const mostrarColores = () => {
  fetch("http://localhost/colores")
  .then((res) => res.json())
  .then((datos) => (colores.value = datos.data));
}

const mostrarTallasNumericas = () => {
  fetch("http://localhost/tallasNum")
  .then((res) => res.json())
  .then((datos) => (tallaNum.value = datos.data));
}

const mostrarTallasRopa = () => {
  fetch("http://localhost/tallasRopa")
  .then((res) => res.json())
  .then((datos) => (tallaRopa.value = datos.data));
}

const cancelarSeleccion = () => {
  eliminar.value = false;
  seleccionados.value = [];
}

const borrarDatosArticulo = () => {
  crearNuevoArticulo.value = false;
  nuevoArticulo.value.producto = '';
}

const agregarNuevoArticulo = () => {
  crearNuevoArticulo.value = false;
  detallar.value = true;
  nuevoArticulo.value.cantidad = '';
  nuevoArticulo.value.talla_numerica = '33';
  nuevoArticulo.value.talla_ropa = '7';
  nuevoArticulo.value.color = '17';
}

onMounted(() => {
  mostrarProductos();
  mostrarCategorias();
});

const eliminarProducto = () => {
  if (seleccionados.value[0] != undefined) {
    fetch("http://localhost/inhabilitarProd", {
      method: "POST",
      body: JSON.stringify(seleccionados.value),
    });
    dialogDel.value = false;
    seleccionados.value = [];
  } else {
    alerta.value = true;
    dialogDel.value = false;
  }
};

const agregarProducto = () => {
  if (selectedImage.value) {
    producto.value.nombre = nuevoProducto.value.nombre;
    const reader = new FileReader();
    reader.readAsDataURL(selectedImage.value);
    reader.onload = () => {
      const base64String = reader.result.split(",")[1];
      nuevoProducto.value.imagen1 = "data:image/jpeg;base64," + base64String;
      fetch("http://localhost/insertarProd", {
        method: "POST",
        body: JSON.stringify(nuevoProducto.value)});
    }}
    detallar.value = true;
    mostrarColores();
    mostrarTallasNumericas();
    mostrarTallasRopa();
      dialog.value = false;
      setTimeout(() => {
        mostrarProductos();
        fetch("http://localhost/obtenerId", {
          method: "POST",
          body: JSON.stringify(producto.value),
        })
          .then((res) => res.json())
          .then((datos) => {
            nuevoArticulo.value.producto = datos.data[0].id;
          });
      }, 1000);
};

const verificarArticuloTallaNum = (id) => {
  if (id == 33) {
    agregarColor.value = false;
    agregarTallaRopa.value = true;
  }
  else if (id !== 33) {
    agregarTallaRopa.value = false;
    agregarColor.value = true;
    aviso.value = '';
  }
}

const verificarArticuloTallaRopa = (id) => {
  if (id == 7 && nuevoArticulo.value.talla_numerica !== 33) {
    agregarColor.value = false;
  }
  else if (id !== 7) {
    agregarTallaNum.value = false;
    agregarColor.value = true;
  }
  else if (id == 7 && nuevoArticulo.value.talla_numerica == 33){
    aviso.value = 'Su articulo no tiene talla, por ende no puede tener color. Modifique las tallas si necesita un color';
  }
}


// VALIDACION DE FORMULARIO
const agregarArticulo = () => {
  fetch("http://localhost/insertarArticulo", {
    method: "POST",
    body: JSON.stringify(nuevoArticulo.value)
  })
  detallar.value = false;
  crearNuevoArticulo.value = true;
}

  const { handleSubmit, handleReset } = useForm({
    validationSchema: {
      name (value) {
        if (value?.length >= 2) {
            nuevoProducto.value.nombre = value;
            return true}

        return 'Ingrese al menos 2 caracteres'
      },
      precio (value) {
        if (letras.test(value) || value?.length <= 2) 
          return 'Use solamente numeros'
        else {
            nuevoProducto.value.precio = value;
            return true}
      },
      descripcion (value) {
        if (value?.length >= 5) {
          nuevoProducto.value.descripcion = value;
          return true
        }

        return 'Ingrese al menos 5 caracteres'
      }
    },
  })
  const name = useField('name')
  const precio = useField('precio')
  const descripcion = useField('descripcion')

  const submit = handleSubmit(values => {
    agregarProducto()
    handleReset();
  });

</script>

<template>
  {{ nuevoProducto }} <br>
  {{ nuevoArticulo }}
  <div class="botones">
    <v-col cols="auto">
      <v-dialog v-model="dialog" width="auto">
        <template v-slot:activator="{ props }">
          <v-btn v-bind="props" block rounded="xl" size="large"
            ><v-icon icon="mdi-plus-circle" class="mr-2"></v-icon>Agregar
            producto</v-btn
          >
        </template>
        <v-card>
          <form @submit.prevent="submit">
          <v-card-title>Agregar producto</v-card-title>
          <v-card-text>
            <v-container>
                <v-row>
                <v-col cols="12" sm="12" md="12">
                  <v-text-field v-model="name.value.value" 
                  :error-messages="name.errorMessage.value" label="Nombre*"></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                  <v-text-field v-model="precio.value.value"
                  :error-messages="precio.errorMessage.value"
                    label="Precio"
                    hint="Utilice solo 2 decimales"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <div>
                    <input type="file" ref="fileInput" @change="handleFileChange"/>
                  </div>
                </v-col>
                <v-col cols="12">
                  <v-text-field v-model="descripcion.value.value"
                  :error-messages="descripcion.errorMessage.value"
                    label="Descripcion del producto"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <div class="text-left">
                    <v-btn
                      color="primary"
                      @click="seleccionarCat = true"
                    >
                      Seleccionar categoria
                    </v-btn>

                    <v-dialog
                      v-model="seleccionarCat"
                      width="auto"
                    >
                      <v-card class="pa-7">
                        <v-row v-for="cat in categorias">
                          <v-card-text><v-checkbox @click="seleccionarCat=false" v-model="nuevoProducto.categoria" :value="cat.id" :label="cat.categoria"></v-checkbox></v-card-text>
                        </v-row>
                      </v-card>
                    </v-dialog>
                  </div>
                  </v-col>
                  <v-col class="d-flex justify-end">
                    <v-btn type="submit" >Continuar</v-btn>
                    <v-btn @click="dialog = false" class="ml-3">Cancelar</v-btn>
                  </v-col>
                </v-row>
            </v-container>
            <small>* Indica que es un campo requerido</small>
          </v-card-text>
        </form>
        </v-card>
      </v-dialog>
    </v-col>
    <v-dialog
        v-model="detallar"
        width="auto"
      >
        <v-card>
          <v-card-title>
            Detalle su producto
          </v-card-title>
          <div class="d-flex pa-5 flex-column">
            <div class="text-left mb-3">
                    <v-btn
                      v-if="agregarTallaNum"
                      color="primary"
                      @click="seleccionarTallaNum = true"
                    >
                      Seleccionar talla numerica
                    </v-btn>

                    <v-dialog
                      v-model="seleccionarTallaNum"
                      width="auto"
                    >
                      <v-card class="pa-7">
                        <v-row v-for="talla in tallaNum">
                          <v-card-text><v-checkbox @click="verificarArticuloTallaNum(talla.id)" v-model="nuevoArticulo.talla_numerica" :value="talla.id" :label="talla.talla"></v-checkbox></v-card-text>
                        </v-row>
                      </v-card>
                    </v-dialog>
                  </div>
                  <div class="text-left mb-3">
                    <v-btn
                      v-if="agregarTallaRopa"
                      color="primary"
                      @click="seleccionarTallaRopa = true"
                    >
                      Seleccionar talla ropa
                    </v-btn>

                    <v-dialog
                      v-model="seleccionarTallaRopa"
                      width="auto"
                    >
                      <v-card class="pa-7">
                        <v-row v-for="talla in tallaRopa">
                          <v-card-text><v-checkbox @click="verificarArticuloTallaRopa(talla.id)" v-model="nuevoArticulo.talla_ropa" :value="talla.id" :label="talla.talla"></v-checkbox></v-card-text>
                        </v-row>
                      </v-card>
                    </v-dialog>
                  </div>
            <div class="text-left mb-3">
                    <v-btn
                      v-if="agregarColor"
                      color="primary"
                      @click="seleccionarColor = true"
                    >
                      Seleccionar color
                    </v-btn>
                    <v-dialog
                      v-model="seleccionarColor"
                      width="auto"
                    >
                      <v-card class="pa-7">
                        <v-row v-for="col in colores">
                          <v-card-text><v-checkbox v-model="nuevoArticulo.color" :value="col.id" :label="col.color"></v-checkbox></v-card-text>
                        </v-row>
                      </v-card>
                    </v-dialog>
                  </div>
                  <v-card-text>
                    {{ aviso }}
                  </v-card-text>
                  <v-text-field
                      v-model="nuevoArticulo.cantidad"
                      label="Existencias"
                      required
                    ></v-text-field>
          <v-card-actions>
            <v-btn
              color="primary"
              variant="text"
              @click="detallar = false"
            >
              Cerrar
            </v-btn>
            <v-btn
              color="primary"
              variant="text"
              @click="agregarArticulo"
            >
              Agregar
            </v-btn>
          </v-card-actions>
          </div>
        </v-card>
      </v-dialog>
      <v-dialog
                      v-model="crearNuevoArticulo"
                      width="auto"
                    >
                      <v-card class="pa-7">
                          <v-card-text class="mb-6">
                            ¿Desea crear un nuevo articulo?
                          </v-card-text>
                          <v-row class="d-flex justify-end">
                            <v-btn @click="agregarNuevoArticulo" class="mr-3">Aceptar</v-btn>
                          <v-btn @click="borrarDatosArticulo">Cancelar</v-btn>
                          </v-row>
                      </v-card>
                    </v-dialog>
    <v-col cols="auto">
      <v-btn @click="eliminar = true" block rounded="xl" size="large"
        ><v-icon icon="mdi-minus-circle" class="mr-2"></v-icon>Eliminar
        producto</v-btn
      >
    </v-col>
  </div>
  <div class="catalogo">
    <h1>Productos</h1>
    <v-divider class="mb-5" thickness="2" color="black"></v-divider>
    <div class="opciones">
      <v-row class="d-flex ml-1">
        <v-col cols="auto">
          <v-alert
            v-if="alerta"
            density="compact"
            type="warning"
            title="Por favor, seleccione un producto"
          ></v-alert>
        </v-col>
      </v-row>
      <v-btn @click="cancelarSeleccion" class="ma-3" v-if="eliminar"
        >Cancelar</v-btn
      >
      <v-dialog v-model="dialogDel" persistent width="min-content">
        <template v-slot:activator="{ props }">
          <v-btn :="props" class="ma-3" v-if="eliminar">Eliminar</v-btn>
        </template>
        <v-card>
          <form @submit.prevent="eliminarProducto">
            <v-card-title>
              <div class="text-h5 d-flex mb-2">
                ¿Está seguro que desea eliminarlos?
              </div>
              <div>
                Esto ocasionará que todos los articulos relacionados a este
                producto se eliminen también
              </div>
            </v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue-darken-1" variant="text" type="submit"
                >Estoy de acuerdo</v-btn
              >
              <v-btn
                color="blue-darken-1"
                variant="text"
                @click="dialogDel = false"
                >Cancelar</v-btn
              >
            </v-card-actions>
          </form>
        </v-card>
      </v-dialog>
    </div>
    <div class="productos">
      <v-col v-for="producto in productos" cols="4">
        <v-card
          class="d-flex flex-column justify-center align-center pa-3"
          style="height: 15em"
        >
          <v-img style="height: 100px" :src="producto.imagen1"></v-img>
          <v-card-text style="text-align: center">{{
            producto.nombre
          }}</v-card-text>
          <v-card-text>Precio: ${{ producto.precio }}</v-card-text>
        </v-card>
        <v-card class="d-flex justify-center align-center">
          <v-checkbox
            @click="alerta = false"
            v-model="seleccionados"
            class="d-flex justify-center align-center"
            v-if="eliminar"
            :value="producto.id"
            label="Eliminar"
          ></v-checkbox>
        </v-card>
      </v-col>
    </div>
  </div>
</template>

<style scoped>
.botones,
.productos {
  display: flex;
  flex-wrap: wrap;
}
.catalogo {
  margin: 1em;
}
.opciones {
  display: flex;
  justify-content: flex-end;
}
</style>


