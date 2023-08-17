<?php

namespace proyecto\Models;

use PDO;
use proyecto\Auth;
use proyecto\Response\Failure;
use proyecto\Response\Response;
use proyecto\Response\Success;
use function json_encode;

class descontar extends Models{
    public function detallesorden($ordenid){
        $stmn =self::$pdo->prepare("SELECT articulos.id ,detalle_orden.cantidad from productos inner join articulos on productos.id = articulos.producto
        inner join detalle_orden on detalle_orden.Articulo = articulos.id where detalle_orden.Orden = $ordenid");
        $stmn->execute();
        $res=$stmn->fetchAll(pdo::FETCH_ASSOC);
        $verificar = new Success($res);
        $verificar-> Send();
    } 
    
    public function detallecant(){
     $datos = json_decode(file_get_contents("php://input"),true);
     $idart = $datos['idart'];
     $cantidadart = $datos['cantidadart'];
        $stmt =Table::query("call actividad_segura.actualizar_stock('$idart','$cantidadart')");
        $x=new Success($stmt);
        $x ->Send();
    } 
}














