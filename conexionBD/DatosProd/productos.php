<?php

require 'conectar.php';
class Produtos {

    function obtenerProductos(){
        $con=new conexion;
        $resul=$con->connect()->query('SELECT * FROM productos');

        return $resul;
    }
}