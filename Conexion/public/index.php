<?php

namespace proyecto;
use proyecto\Controller\ImagenesController;
require("../vendor/autoload.php");
use proyecto\Models\Table;
use proyecto\Models\Productos;
use proyecto\Models\Categorias;
use proyecto\Controller\InfoProdController;
use proyecto\Response\Failure;
use proyecto\Response\Success;


Router::headers();

Router::get('/prueba',[crearPersonaController::class,"prueba"]);

Router::get('/productos',[Productos::class,'AllProductos']);
Router::get('/categorias',[Categorias::class,'AllCategorias']);
Router::get('/categorias/$id',[Categorias::class,'SelCat']);
Router::get('/categoriasp/$id',[Categorias::class,'PSelCat']);
Router::get('/infoprod',[InfoProdController::class,'InfoProd']);
Router::get('/prodcat',[InfoProdController::class,'CatProd']);
Router::get('/articulos/$id',[InfoProdController::class,'ProcedimientoProd']);
Router::get('/imagenes',[ImagenesController::class,'img']);
Router::any('/404', '../views/404.php');
Router::post('/insertarCat',[Categorias::class,'insertarCategoria']);
Router::post('/eliminarCat',[Categorias::class,'eliminarCategoria']);
Router::post('/eliminarProd',[Productos::class,'eliminarProducto']);
Router::post('/insertarProd',[Productos::class,'agregarProducto']);
Router::post('/agregarAdmin',[User::class,'agregarAdmin']);