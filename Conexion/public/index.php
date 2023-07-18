<?php

namespace proyecto;
require("../vendor/autoload.php");

use proyecto\Models\Productos;
use proyecto\Models\Categorias;
use proyecto\Controller\InfoProdController;
use proyecto\Models\User;
use proyecto\Response\Failure;
use proyecto\Response\Success;


Router::get('/prueba',[crearPersonaController::class,"prueba"]);

Router::get('/productos',[Productos::class,'AllProductos']);
Router::get('/categorias',[Categorias::class,'AllCategorias']);
Router::get('/infoprod',[InfoProdController::class,'InfoProd']);
Router::any('/404', '../views/404.php');
