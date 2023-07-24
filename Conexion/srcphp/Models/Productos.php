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
    protected $imagenID='';
    protected $descripcion='';
    protected $categoria='';	
    protected $estado='';
    protected $filleable=[
        'id',
        'nombre',
        'precio',
        'imagenID',
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
    public function agregarProducto(){
        $datos = json_decode(file_get_contents("php://input"), true);
            $nombre = $datos["nombre"];
            $precio = $datos["precio"];
            $imagen = $datos["imagen1"];
            $descripcion = $datos["descripcion"];
            $categoria = 4;
            $estado = $datos["estado"];

            $stmt = self::$pdo->prepare("INSERT INTO $this->table (nombre,precio,imagen1,descripcion,categoria,estado) VALUES  ('$nombre','$precio','$imagen','$descripcion',$categoria,'$estado')");
            $stmt->execute();
    }
    public function eliminarProducto(){
        $datos = json_decode(file_get_contents("php://input"), true);
        foreach ($datos as $id) {
            $stmt = self::$pdo->prepare("DELETE FROM articulos WHERE producto=:producto");
            $stmt->bindParam(':producto', $id);
            $stmt->execute();
            $stmt = self::$pdo->prepare("DELETE FROM productos WHERE id=:producto");
            $stmt->bindParam(':producto', $id);
            $stmt->execute();
        };
    }
}