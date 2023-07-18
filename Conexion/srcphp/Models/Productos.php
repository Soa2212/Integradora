<?php
namespace proyecto\Models;
use proyecto\Response\Success;
use PDO;
use function json_encode;


class Productos extends Models{
    protected $table='productos';
    protected $id='';	
    protected $nombre='';
    protected $precio='';	
    protected $imagen1='';	
    protected $imagen2='';	
    protected $imagen3='';	
    protected $imagen4='';	
    protected $imagen5='';	
    protected $descripcion='';
    protected $categoria='';	
    protected $estado='';
    protected $filleable=[
        'id',
        'nombre',
        'precio',
        'imagen1',
        'imagen2',
        'imagen3',
        'imagen4',
        'imagen5',
        'descripcion',
        'categoria',
        'estado'
    ];

    public function AllProductos(){
        $stmn=self::$pdo->prepare('Select * from '.$this->table);
        $stmn->execute();
        $res=$stmn->fetchAll(pdo::FETCH_ASSOC);
        $verificar=new Success($res);
        $verificar->Send();
    }
}