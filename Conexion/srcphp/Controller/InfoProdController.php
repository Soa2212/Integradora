<?php
namespace proyecto\Controller;
use proyecto\Models\Table;
use proyecto\Response\Success;

class InfoProdController{
    public function InfoProd(){
        $stmn=Table::query('SELECT productos.id as '.'id'.',
        articulos.cantidad as '.'cantidad'.',
        talla_numerica.talla as '.'talla_numerica'.',
        talla_ropa.talla as '.'talla_ropa'.',
        colores.color as '.'color'.',
        productos.nombre as '.'nombre'.',
        productos.precio as '.'precio'.',
        productos.imagen1 as '.'imagen1'.',
        productos.descripcion as '.'descripcion'.',
        productos.estado as '.'estado'.',
        categorias.categoria as '.'categoria'.',
        articulos.id as '.'Articulo_ID'.'
        from categorias inner join productos on productos.categoria=categorias.id
        inner join articulos on articulos.producto=productos.id
        inner join talla_numerica on articulos.talla_numerica=talla_numerica.id
        inner join talla_ropa on articulos.talla_ropa=talla_ropa.id
        inner join colores on articulos.color=colores.id');
        $r=new Success($stmn);
        $r->Send();
    }

    public function ProcedimientoProd($id){
        $stmn=Table::query('call ArtProducto('.$id.')');
        $r=new Success($stmn);
        $r->Send();
    }
    public function articulosStock($id){
        $stmn=Table::query('call cantidad_stock_x_prod('.$id.')');
        $r=new Success($stmn);
        $r->Send();
    }
    public function CatProd(){
        $stmn=Table::query('SELECT * FROM productos_categoria');
        $r=new Success($stmn);
        $r->Send();
    }
}

