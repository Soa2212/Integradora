<?php

namespace proyecto;
use Carbon\Carbon;
use proyecto\Controller\DetalleController;
use proyecto\Controller\ImagenesController;
use proyecto\Models\Orden;
require("../vendor/autoload.php");
use proyecto\Models\Table;
use proyecto\Models\Productos;
use proyecto\Models\Categorias;
use proyecto\Controller\InfoProdController;
use proyecto\Controller\UserController;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\AuthController;
use proyecto\Models\User;
use proyecto\Models\reporteventatpo;
use proyecto\Models\usuarioscompras;
use proyecto\Models\repse;
use proyecto\Models\descontar;
use Dotenv\Dotenv;
Router::headers();

 

Router::get('/prueba',function(){
    $email = "albert@outlook.com";
    $stm=Table::query("SELECT password FROM usuarios WHERE email='$email'");
    
    foreach($stm as $pass){
        $passUS=$pass["password"];
    } echo($passUS);
});

Router::get('/dl/$ordenid',[descontar::class,'detallesorden']);
Router::post('/dlcant',[descontar::class,'detallecant']);

Router::post('/logear',[UserController::class,'login']);
Router::post('/detallar',[DetalleController::class,'setDet']);
Router::post('/detallarL',[DetalleController::class,'setDetL']);

Router::post('/estadoOrden',[Orden::class,'estado']);
Router::get('/ordenUS/$idUS',[Orden::class,'getOrden']);
Router::get('/ordenUSL/$idUS',[Orden::class,'getOrdenL']);

//RUTAS ARANDA
Router::get('/reportesoli',[repse::class,'reportepedido']);
Router::post('/reporteventatpo',[reporteventatpo::class,'reportetipo']);
Router::post('/reporteventatodo',[reporteventatpo::class,'reportefecha']);
Router::get('/reportevengeneral',[reporteventatpo::class,'AllReporte']);
Router::post('/novendidostipo',[reporteventatpo::class,'novendidotipo']);
Router::post('/novendidosfecha',[reporteventatpo::class,'novendidofehca']);
Router::get('/novendidosall',[reporteventatpo::class,'Allnovendido']);
//

Router::post('/comprasusuario',[usuarioscompras::class,'compras']);
Router::post('/detallecompra',[reporteventatpo::class,'detalle']);

Router::post('/inhabilitarCat',[Categorias::class,'inhabilitarCategoria']);
Router::post('/habilitarCat',[Categorias::class,'habilitarCategoria']);
Router::get('/administradores',[User::class,'mostrarAdministradores']);
Router::get('/categoriasInactivas',[Categorias::class,'categoriasInactivas']);
Router::post('/agregarAdmin',[User::class,'agregarAdministrador']);
Router::get('/colores',[Productos::class,'colores']);
Router::get('/tallasNum',[Productos::class,'tallasNumericas']);
Router::get('/tallasRopa',[Productos::class,'tallasRopa']);
Router::post('/obtenerId',[Productos::class,'obtenerId']);
Router::post('/insertarArticulo',[Productos::class,'agregarArticulo']);
Router::post('/actualizarStock',[Productos::class,'actualizarStock']);
Router::post('/agregarUser',[User::class,'agregarUser']);
Router::post('/verificarEmail',[User::class,'verificarEmail']);

Router::post('/insertarProd',[Productos::class,'agregarProducto']);
Router::post('/inhabilitarProd',[Productos::class,'inhabilitarProducto']);
Router::post('/habilitarProd/$id',[Productos::class,'habilitarProducto']);

Router::get('/detalleOrden/$id',[Productos::class,'detalleOrden']);
Router::get('/detalleOrdenTotal/$id',[Productos::class,'detalleOrdenTotal']);
Router::get('/productos',[Productos::class,'AllProductos']);
Router::get('/productosInactivos',[Productos::class,'ProductosInactivos']);
Router::get('/ordenesEnProceso',[Productos::class,'ordenesProceso']);
Router::get('/ordenesAceptadas',[Productos::class,'ordenesAceptadas']);
Router::get('/articuloCantidad/$id',[Productos::class,'articuloCantidad']);

Router::get('/categorias',[Categorias::class,'AllCategorias']);
Router::get('/categorias/$id',[Categorias::class,'SelCat']);
Router::get('/categoriasp/$id',[Categorias::class,'PSelCat']);
Router::get('/infoprod',[InfoProdController::class,'InfoProd']);
Router::get('/prodcat',[InfoProdController::class,'CatProd']);
Router::get('/articulos/$id',[InfoProdController::class,'ProcedimientoProd']);
Router::get('/articulosStock/$id',[InfoProdController::class,'articulosStock']);

Router::post('/insertarCat',[Categorias::class,'insertarCategoria']);
Router::post('/eliminarCat',[Categorias::class,'eliminarCategoria']);
Router::post('/eliminarProd',[Productos::class,'eliminarProducto']);
Router::post('/detallar',[DetalleController::class,'setDet']);
Router::get('/ruta',function(){
    echo 'Ramiro';
});

$dotenv = Dotenv::createImmutable(_DIR_);
$dotenv->load();

Router::any('/404', '../views/404.php');



