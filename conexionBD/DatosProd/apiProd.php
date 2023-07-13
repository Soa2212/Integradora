<?php

require 'productos.php';

class apiProd{
    function obtenerInf(){
        $prod=new Produtos();
        $infProd=array();
        $infProd['items']=array();
        $result=$prod->obtenerProductos();

        if($result->rowCount()){
            while($row=$result->fetch(PDO::FETCH_ASSOC)){
                $item=array(
                    'codigo_barras'=>$row['codigo_barras'],
                    'nombre'=>$row['nombre'],
                    'precio'=>$row['precio'],
                    'imagen1'=>$row['imagen1'],
                    'imagen2'=>$row['imagen2'],
                    'imagen3'=>$row['imagen3'],
                    'imagen4'=>$row['imagen4'],
                    'imagen5'=>$row['imagen5'],
                    'descripcion'=>$row['descripcion'],
                    'categoria'=>$row['categoria']
                );
                array_push($infProd['items'],$item);
            }
            echo json_encode($infProd);
        }else{
            echo json_encode(array('mensaje'=>'No hay elementos'));
        }

    }
}
