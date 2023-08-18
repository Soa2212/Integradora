<script setup>
import { ref, onMounted } from "vue";

const dialogFechas = ref(null);
const fecha = ref(false);

// CODIGO ARANDA
let reporteventatpo=ref([]);
let detacant = ref({idart:'',cantidadart:''});
const tipo=ref(['web','local','general','todo']);

let reportesoli=ref();

const solisitado=()=>{
  fetch('http://3.136.87.82/reportesoli')
.then((response)=>response.json())
.then(data=>reportesoli.value=data.data)
.then(data=>console.log(data))
}


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

    fetch('http://3.136.87.82/reporteventatpo',{
    method: 'POST',
    body: JSON.stringify(objeto.value)
})
.then((response)=>response.json())
.then(data=>reporteventatpo.value=data.data)
  }
  else if (tip.value == 'general' ) {

objeto2.value.fecha_fin=fecha_fin.value;
objeto2.value.fecha_ini=fecha_ini.value;


fetch('http://3.136.87.82/reporteventatodo',{
method: 'POST',
body: JSON.stringify(objeto2.value)
})
.then((response)=>response.json())
.then(data=>reporteventatpo.value=data.data)
.then(data=>console.log(data))
}
else if(tip.value == 'todo'){

  fetch('http://3.136.87.82/reportevengeneral')
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

    fetch('http://3.136.87.82/novendidostipo',{
    method: 'POST',
    body: JSON.stringify(objeto.value)
})
.then((response)=>response.json())
.then(data=>reporteventatpo.value=data.data)
  }
  else if (tip.value == 'general' ) {

objeto2.value.fecha_fin=fecha_fin.value;
objeto2.value.fecha_ini=fecha_ini.value;


fetch('http://3.136.87.82/novendidosfecha',{
method: 'POST',
body: JSON.stringify(objeto2.value)
})
.then((response)=>response.json())
.then(data=>reporteventatpo.value=data.data)
.then(data=>console.log(data))
}
else if(tip.value == 'todo'){

  fetch('http://3.136.87.82/novendidosall')
.then((response)=>response.json())
.then(data=>reporteventatpo.value=data.data)
}

objeto.value.fecha_fin='';
objeto.value.fecha_ini='';
objeto.value.tipo='';
}
//

const dialogAceptada = ref(null);
const tab = ref(null);
const dialog = ref(null);
const orden = ref({
  estado: '',
  orden: '',
  fecha_de: '',
  fecha_hasta: ''
});

const ordenesEnProceso = ref({});
const ordenesAceptadas = ref({});
const detalleOrden = ref({});
const cantidadArticulo = ref({
  id: '',
  cantidad: ''
})

const mostrarOrdenesProceso = () => {
  fetch("http://3.136.87.82/ordenesEnProceso")
.then((res) => res.json())
.then((datos) => (ordenesEnProceso.value = datos.data));
}

const mostrarOrdenesAceptadas = () => {
  fetch("http://3.136.87.82/ordenesAceptadas")
.then((res) => res.json())
.then((datos) => (ordenesAceptadas.value = datos.data));
}

onMounted(() => {
  mostrarOrdenesProceso()
  mostrarOrdenesAceptadas()
})

const totalPedido = ref(0);

const calcularTotal = (id) => {
  fetch(`http://3.136.87.82/detalleOrdenTotal/${id}`)
  .then((res) => res.json())
  .then((datos) => (totalPedido.value = datos.data[0].Total));
}

const mostrarDetalleOrden = (id) => {
  fecha.value = false;
  fecha_de.value = '';
  fecha_hasta.value = '';
  orden.value.orden = id;
  calcularTotal(id)
  fetch(`http://3.136.87.82/detalleOrden/${id}`)
  .then((res) => res.json())
  .then((datos) => (detalleOrden.value = datos.data));
}

const aceptarOrden = () => {
  orden.value.fecha_de = fecha_de.value;
  orden.value.fecha_hasta = fecha_hasta.value;
  dialog.value = false
  dialogAceptada.value = false;
  orden.value.estado = 'Aceptada'
  fetch("http://3.136.87.82/estadoOrden", {
      method: "POST",
      body: JSON.stringify(orden.value)
    });
  setTimeout(mostrarOrdenesProceso, 500);
}

const cancelarOrden = () => {
  dialog.value = false
  dialogAceptada.value = false;
  orden.value.estado = 'cancelada'
  fetch("http://3.136.87.82/estadoOrden", {
      method: "POST",
      body: JSON.stringify(orden.value)
    });
  setTimeout(mostrarOrdenesProceso, 500);
}

const completarOrden = (id) => {
  mostrarDetalleOrden(id)
  descontarcant()
  dialog.value = false
  dialogAceptada.value = false;
  orden.value.orden = id
  orden.value.estado = 'Completada'
  fetch("http://3.136.87.82/estadoOrden", {
      method: "POST",
      body: JSON.stringify(orden.value)
    });
  setTimeout(mostrarOrdenesAceptadas, 500);
}

const descontarcant=()=>{
  for (let i = 0; i < detalleOrden.value.length; i++) {
detacant.value.idart=detalleOrden.value[i].id;
detacant.value.cantidadart=detalleOrden.value[i].cantidad;
fetch('http://3.136.87.82/dlcant',{
method: 'POST',
body: JSON.stringify(detacant.value)
})
}
}

const cancelarOrdenAceptada = (id) => {
  dialog.value = false
  dialogAceptada.value = false;
  orden.value.orden = id
  orden.value.estado = 'cancelada'
  fetch("http://3.136.87.82/estadoOrden", {
      method: "POST",
      body: JSON.stringify(orden.value)
    });
  setTimeout(mostrarOrdenesAceptadas, 500);
}

const avisoFecha = ref('');

const activarAceptarOrden = () => {
  if (fecha_de.value != '' && fecha_hasta.value != ''){
    dialogFechas.value = false;
    fecha.value = true;
    avisoFecha.value = ''
  } else {
    avisoFecha.value = 'Ingrese las fechas'
  }
  
}

const fecha_de = ref('');
const fecha_hasta = ref('');
</script>

<template>
  <h1 class="ml-5 mt-5">Reportes de ventas</h1>
  <v-app class="ma-5">
    <v-card>
    <v-tabs
      v-model="tab"
      bg-color="primary"
    >
      <v-tab @click="solisitado" value="five">Cantidad solicitada</v-tab>
      <v-tab value="one">Ventas por cancelar/aprobar</v-tab>
      <v-tab @click="mostrarOrdenesAceptadas" value="four">Ordenes por completar</v-tab>
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
            <th class="text-center">Cliente</th>
            <th class="text-center">Estado de venta</th>
            <th class="text-center">Tipo de orden</th>
            <th class="text-center"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="orden in ordenesEnProceso" :key="orden.id">
            <td class="text-center">{{ orden.id }}</td>
            <td class="text-center">{{ orden.FechaOrden }}</td>
            <td class="text-center">{{ orden.nombre }}</td>
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
                        <th class="text-center">ID articulo</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Talla Num</th>
                        <th class="text-center">Talla Ropa</th>
                        <th class="text-center">Color</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Costo</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="orden in detalleOrden" :key="orden.id">
                        <td class="text-center">{{ orden.id }}</td>
                        <td class="text-center">{{ orden.nombre }}</td>
                        <td class="text-center" v-if=" orden.Talla_numerica != 'NA' ? orden.Talla_numerica=orden.Talla_numerica:orden.Talla_numerica='-' ">{{ orden.Talla_numerica }}</td>
                        <td class="text-center" v-if=" orden.Talla_ropa != 'NA' ? orden.Talla_ropa=orden.Talla_ropa:orden.Talla_ropa='-' ">{{ orden.Talla_ropa }}</td>
                        <td class="text-center" v-if=" orden.color != 'NA' ? orden.color=orden.color:orden.color='-' ">{{ orden.color }}</td>
                        <td class="text-center">{{ orden.cantidad }}</td>
                        <td class="text-center">{{ orden.stock }}</td>
                        <td class="text-center">{{ orden.Total }}</td>
                      </tr>
                    </tbody>
                  </v-table>
                  <v-card-text class="font-weight-black">Total de la compra: ${{ totalPedido }}</v-card-text>
                  <v-card-actions class="d-flex justify-end">
                    <div class="text-center">
    <v-dialog
      v-model="dialogFechas"
      width="auto"
    >
      <template v-slot:activator="{ props }">
        <v-btn
          color="primary"
          v-bind="props"
          class="mr-5"
        >
          Ingrese fecha de entrega
        </v-btn>
      </template>

      <v-card class="pa-5">
        <h3 class="mb-2">Periodo de entrega</h3>
        <p class="mb-2">De:</p>
        <input v-model="fecha_de" type="date">
        <p class="mb-2 mt-2">Hasta:</p>
        <input v-model="fecha_hasta" type="date">
        <p class="mt-2" style="color: rgb(177, 0, 0);">{{ avisoFecha }}</p>
        <v-card-actions>
          <v-btn color="primary" block @click="activarAceptarOrden">Cerrar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
                    <v-btn v-if="fecha" @click="aceptarOrden()" class="mt-5 mb-5">Aceptar orden</v-btn>
                    <v-btn @click="cancelarOrden()" class="ma-5">Cancelar orden</v-btn>
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
        <v-window-item value="four">
          <v-table>
            <thead>
              <tr>
                <th class="text-center">ID orden</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Fecha de orden</th>
                <th class="text-center">Estado de venta</th>
                <th class="text-center"></th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="orden in ordenesAceptadas"
                :key="orden.id"
              >
                <td class="text-center">{{ orden.id }}</td>
                <td class="text-center">{{ orden.nombre }}</td>
                <td class="text-center">{{ orden.FechaOrden }}</td>
                <td class="text-center">{{ orden.Estado_Venta }}</td>
                <td class="text-center d-flex justify-center align-center">
                  <v-dialog
                v-model="dialogAceptada"
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
                        <th class="text-center">ID articulo</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Talla Num</th>
                        <th class="text-center">Talla Ropa</th>
                        <th class="text-center">Color</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Costo</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="orden in detalleOrden" :key="orden.id">
                        <td class="text-center">{{ orden.id }}</td>
                        <td class="text-center">{{ orden.nombre }}</td>
                        <td class="text-center" v-if=" orden.Talla_numerica != 'NA' ? orden.Talla_numerica=orden.Talla_numerica:orden.Talla_numerica='-' ">{{ orden.Talla_numerica }}</td>
                        <td class="text-center" v-if=" orden.Talla_ropa != 'NA' ? orden.Talla_ropa=orden.Talla_ropa:orden.Talla_ropa='-' ">{{ orden.Talla_ropa }}</td>
                        <td class="text-center" v-if=" orden.color != 'NA' ? orden.color=orden.color:orden.color='-' ">{{ orden.color }}</td>
                        <td class="text-center">{{ orden.cantidad }}</td>
                        <td class="text-center">{{ orden.stock }}</td>
                        <td class="text-center">{{ orden.Total }}</td>
                      </tr>
                    </tbody>
                  </v-table>
                  <v-card-text class="mt-4 font-weight-black">Total de la compra: ${{ totalPedido }}</v-card-text>
                  <v-card-actions class="d-flex justify-end">
                    <v-btn @click="completarOrden(orden.id)" class="mb-5">Completar orden</v-btn>
                    <v-btn @click="cancelarOrdenAceptada(orden.id)" class="mb-5 mr-5">Cancelar orden</v-btn>
                  </v-card-actions>     
                </v-card>
              </v-dialog>
                </td>
              </tr>
            </tbody>
          </v-table>
        </v-window-item>
        <v-window-item value="five">
          <div> <v-table theme="width">
      <thead>
        <tr>
          <th class="text-center">
            Producto
          </th>
          <th class="text-center">
            Talla
          </th>
          <th class="text-center">
            Talla
          </th>
          <th class="text-center">
            Color
          </th>
          <th class="text-center">
            Stock
          </th>
          <th class="text-center">
            Cantidad solicitada
          </th>
          <th class="text-center">
            Diferencia
          </th>

        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in reportesoli"
          :key="item.producto"
        >
        <td>{{ item.producto }}</td>
          <td class="text-center" v-if=" item.TALLA_NUMERICA != 'NA' ? item.TALLA_NUMERICA=item.TALLA_NUMERICA:item.TALLA_NUMERICA='-' ">{{ item.TALLA_NUMERICA }}</td>
          <td class="text-center" v-if=" item.TALLA_ROPA != 'NA' ? item.TALLA_ROPA=item.TALLA_ROPA:item.TALLA_ROPA='-'">{{ item.TALLA_ROPA }}</td>
          <td class="text-center" v-if=" item.color != 'NA' ? item.color=item.color:item.color='-' ">{{ item.color }}</td>
          <td class="text-center">{{ item.cantidad }}</td>
          <td class="text-center">{{ item.cantidad_soli }}</td>
          <td class="text-center"><p style="width: 50%;" :style="item.cantidad-item.cantidad_soli <= 0 ? 'background-color: red;font-size: x-large;':'background-color:null;'">{{ item.cantidad-item.cantidad_soli }}</p></td>
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


