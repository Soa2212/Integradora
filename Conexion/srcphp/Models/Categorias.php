<?php

namespace proyecto\Models;
use proyecto\Response\Success;
use proyecto\Models\Models;
use PDO;

class Categorias extends Models{
    protected $id='';
    protected $categoria='';
    protected $estado='';
    protected $table='categorias';

    protected $filleable=[
        'id',
        'categoria',
        'estado'
    ];
    public function AllCategorias(){
        $stmn=self::$pdo->prepare('Select * from '.$this->table);
        $stmn->execute();
        $res=$stmn->fetchAll(PDO::FETCH_OBJ);
        $ver=new Success($res);
        $ver->Send();
    }
}