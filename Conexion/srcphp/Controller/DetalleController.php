<?php

namespace proyecto\Controller;

use Exception;
use proyecto\Models\Detalle;
use proyecto\Response\Success;
use proyecto\Models\Table;


class DetalleController{
    public function setDet(){
        $dtos = file_get_contents("php://input");
        $obj=json_decode($dtos);
        try{
        $stm=Table::query('call buscarordenusrocrearweb('.$obj->usuario.')');
        $ordenUs="";
        foreach($stm as $ord){
            $ordenUs=$ord['id_de_orden'];
        }
        
        $deta=new Detalle();
        $deta->orden=$ordenUs;
        $deta->articulo=$obj->articulo;
        $deta->cantidad=$obj->cantidad;
        $deta->save();
        $r=new Success($deta);
        
        return $r->Send();
        }catch(Exception $e){
            return 'Error en la compra '.$e;
        }
    }
    public function setDetL(){
        $dtos = file_get_contents("php://input");
        $obj=json_decode($dtos);
        try{
        $stm=Table::query('call buscarordenusrocrearlocal('.$obj->usuario.')');
        $ordenUs="";
        foreach($stm as $ord){
            $ordenUs=$ord['id_de_orden'];
        }
        
        $deta=new Detalle();
        $deta->orden=$ordenUs;
        $deta->articulo=$obj->articulo;
        $deta->cantidad=$obj->cantidad;
        $deta->save();
        $r=new Success($deta);
        
        return $r->Send();
        }catch(Exception $e){
            return 'Error en la compra '.$e;
        }
    }
}