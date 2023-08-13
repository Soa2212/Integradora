<script setup>
import { ref, onMounted } from "vue";

// CODIGO ARANDA
let reporteventatpo=ref([]);

const tipo=ref(['web','local','general','todo']);

let objeto =ref({
tipo :'',
fecha_ini :'',
fecha_fin :''
});

let objeto2 =ref({
fecha_ini :'',
fecha_fin :''
});

let tip=ref();
let fecha_fin=ref();
let fecha_ini=ref();

const enviar=()=>{
reporteventatpo.value=[];
  if (tip.value == 'web' || tip.value == 'local' ) {

    objeto.value.fecha_fin=fecha_fin.value;
objeto.value.fecha_ini=fecha_ini.value;
objeto.value.tipo=tip.value;

    fetch('http://localhost/reporteventatpo',{
    method: 'POST',
    body: JSON.stringify(objeto.value)
})
.then((response)=>response.json())
.then(data=>reporteventatpo.value=data.data)
  }
  else if (tip.value == 'general' ) {

objeto2.value.fecha_fin=fecha_fin.value;
objeto2.value.fecha_ini=fecha_ini.value;


fetch('http://localhost/reporteventatodo',{
method: 'POST',
body: JSON.stringify(objeto2.value)
})
.then((response)=>response.json())
.then(data=>reporteventatpo.value=data.data)
.then(data=>console.log(data))
}
else if(tip.value == 'todo'){

  fetch('http://localhost/reportevengeneral')
.then((response)=>response.json())
.then(data=>reporteventatpo.value=data.data)
}

objeto.value.fecha_fin='';
objeto.value.fecha_ini='';
objeto.value.tipo='';

}

const enviarNo=()=>{
reporteventatpo.value=[];
  if (tip.value == 'web' || tip.value == 'local' ) {

    objeto.value.fecha_fin=fecha_fin.value;
objeto.value.fecha_ini=fecha_ini.value;
objeto.value.tipo=tip.value;

    fetch('http://localhost/novendidostipo',{
    method: 'POST',
    body: JSON.stringify(objeto.value)
})
.then((response)=>response.json())
.then(data=>reporteventatpo.value=data.data)
  }
  else if (tip.value == 'general' ) {

objeto2.value.fecha_fin=fecha_fin.value;
objeto2.value.fecha_ini=fecha_ini.value;


fetch('http://localhost/novendidosfecha',{
method: 'POST',
body: JSON.stringify(objeto2.value)
})
.then((response)=>response.json())
.then(data=>reporteventatpo.value=data.data)
.then(data=>console.log(data))
}
else if(tip.value == 'todo'){

  fetch('http://localhost/novendidosall')
.then((response)=>response.json())
.then(data=>reporteventatpo.value=data.data)
}

objeto.value.fecha_fin='';
objeto.value.fecha_ini='';
objeto.value.tipo='';
}
//

const tab = ref(null);
const dialog = ref(null);
const idOrden = ref(null);

const ordenesEnProceso = ref({});
const detalleOrden = ref({});

const mostrarOrdenesProceso = () => {
  fetch("http://localhost/ordenesEnProceso")
.then((res) => res.json())
.then((datos) => (ordenesEnProceso.value = datos.data));
}

onMounted(() => {
  mostrarOrdenesProceso()
})

const mostrarDetalleOrden = (id) => {
  idOrden.value = id;
  fetch(`http://localhost/detalleOrden/${id}`)
  .then((res) => res.json())
  .then((datos) => (detalleOrden.value = datos.data));
}

const aceptarOrden = () => {
  dialog.value = false
  console.log(idOrden.value);
  mostrarOrdenesProceso();
}
</script>

<template>
  <h1 class="ml-5 mt-5">Reportes de ventas</h1>
  <v-app class="ma-5">
    <v-card>
    <v-tabs
      v-model="tab"
      bg-color="primary"
    >
      <v-tab value="one">Ventas por cancelar/aprobar</v-tab>
      <v-tab value="two">Ventas</v-tab>
      <v-tab value="three">Articulos no vendidos</v-tab>
    </v-tabs>

    <v-card-text>
      <v-window v-model="tab">
        <v-window-item value="one">
          <v-table class="mr-5">
        <thead>
          <tr>
            <th class="text-center">Orden</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">Estado de venta</th>
            <th class="text-center">Tipo de orden</th>
            <th class="text-center"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="orden in ordenesEnProceso" :key="orden.id">
            <td class="text-center">{{ orden.id }}</td>
            <td class="text-center">{{ orden.FechaOrden }}</td>
            <td class="text-center">{{ orden.Estado_Venta }}</td>
            <td class="text-center">{{ orden.tipo_orden }}</td>
            <td class="text-center">
              <v-dialog
                v-model="dialog"
                width="auto"
              >
                <template v-slot:activator="{ props }">
                  <v-btn
                    class="mr-5"
                    @click="mostrarDetalleOrden(orden.id)"
                    color="primary"
                    v-bind="props"
                  >
                    Ver detalle
                  </v-btn>
                </template>
                <v-card>
                  <v-table>
                    <thead>
                      <tr>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Talla</th>
                        <th class="text-center">Color</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Stock</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="orden in detalleOrden" :key="orden.id">
                        <td class="text-center">{{ orden.nombre }}</td>
                        <td class="text-center">{{ orden.talla }}</td>
                        <td class="text-center">{{ orden.color }}</td>
                        <td class="text-center">{{ orden.cantidad }}</td>
                        <td class="text-center">{{ orden.stock }}</td>
                      </tr>
                    </tbody>
                  </v-table>
                  <v-card-actions class="d-flex justify-end">
                    <v-btn @click="aceptarOrden()" class="mt-5 mb-5">Aceptar orden</v-btn>
                    <v-btn class="ma-5">Cancelar orden</v-btn>
                  </v-card-actions>     
                </v-card>
              </v-dialog>
            </td>
          </tr>
        </tbody>
      </v-table>
        </v-window-item>

        <v-window-item value="two">
            <div id="padre">
                <div id="hijo"><p></p><p>Ventas </p><div id="hijo2"><v-combobox :items="tipo" v-model="tip" ></v-combobox></div></div>
                <div id="hijo"><p>fecha inicio</p><div><v-text-field type="date" v-model="fecha_ini"  :disabled="tip == 'todo'"></v-text-field></div></div>
                <div id="hijo"><p>fecha final</p><div><v-text-field type="date" v-model="fecha_fin" :disabled="tip == 'todo'"></v-text-field></div></div>

        <div><v-btn icon="" @click="enviar">
          <v-icon class="mdi-arrow-right-bold-outline">a</v-icon>
        </v-btn></div>
            </div>

        <div> <v-table theme="width">
              <thead>
                <tr>
                  <th class="text-left">
                      #Orden
                    </th>
                    <th class="text-left">
                      Producto
                    </th>
                    <th class="text-left">
                      Talla_N
                    </th>
                    <th class="text-left">
                      Talla_R
                    </th>
                    <th class="text-left">
                      color
                    </th>
                    <th class="text-left">
                      precio
                    </th>
                    <th class="text-left">
                      cantidad
                    </th>
                    <th class="text-left">
                      total
                    </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="item in reporteventatpo"
                  :key="item.producto"
                >
                <td>{{ item.orden }}</td>
                    <td>{{ item.producto }}</td>
                    <td>{{ item.TALLA_NUMERICA }}</td>
                    <td>{{ item.TALLA_ROPA }}</td>
                    <td>{{ item.color }}</td>
                    <td>{{ item.precio_unitario }}</td>
                    <td>{{ item.cantidad}}</td>
                    <td>{{ item.total }}</td>
                </tr>
              </tbody>
            </v-table></div>
        </v-window-item>

        <v-window-item value="three">
          <div id="padre">
            <div id="hijo"><p></p><p>Ventas </p><div id="hijo2"><v-combobox :items="tipo" v-model="tip" ></v-combobox></div></div>
            <div id="hijo"><p>fecha inicio</p><div><v-text-field type="date" v-model="fecha_ini"  :disabled="tip == 'todo'"></v-text-field></div></div>
            <div id="hijo"><p>fecha final</p><div><v-text-field type="date" v-model="fecha_fin" :disabled="tip == 'todo'"></v-text-field></div></div>

            <div><v-btn icon="" @click="enviarNo">
              <v-icon class="mdi-arrow-right-bold-outline">a</v-icon>
            </v-btn></div>
            </div>

            <div> <v-table theme="width">
                  <thead>
                    <tr>
                        <th class="text-left">
                          Producto
                        </th>
                        <th class="text-left">
                          Talla_N
                        </th>
                        <th class="text-left">
                          Talla_R
                        </th>
                        <th class="text-left">
                          color
                        </th>
                        <th class="text-left">
                          precio
                        </th>
                        <th class="text-left">
                          cantidad
                        </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="item in reporteventatpo"
                      :key="item.producto"
                    >                
                        <td>{{ item.producto }}</td>
                        <td>{{ item.TALLA_NUMERICA }}</td>
                        <td>{{ item.TALLA_ROPA }}</td>
                        <td>{{ item.color }}</td>
                        <td>{{ item.precio_unitario }}</td>
                        <td>{{ item.cantidad}}</td>                       
                    </tr>
                  </tbody>
                </v-table></div>
        </v-window-item>
      </v-window>
    </v-card-text>
  </v-card>
  </v-app>
</template>

<style scoped>
#padre{
    height: 12vh;
    display: flex;
    justify-content: space-around;
    align-items: center;
    margin-top: 2vh;
}

#hijo{
    display: flex;
    align-items: center;
    justify-content: space-around;
    width: 33%;
}

#hijo2{
width: 40%;
}
</style>


