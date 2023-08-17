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
        $stmn=self::$pdo->prepare("SELECT * FROM categorias WHERE estado='activo'");
        $stmn->execute();
        $res=$stmn->fetchAll(PDO::FETCH_ASSOC);
        $ver=new Success($res);
        $ver->Send();
    }
    public function SelCat($id){
        $q=Table::query("call selcat(".$id.")");
        $r=new Success($q);
        $r->Send();
    }
    public function PSelCat($id){
        $q=Table::query("call selprodcat(".$id.")");
        $r=new Success($q);
        $r->Send();
    }
    public function insertarCategoria(){
        $datos = json_decode(file_get_contents("php://input"), true);
        $nombreCategoria = $datos["categoria"];
        $estadoCategoria = $datos["estado"];
        $stmt = self::$pdo->prepare("INSERT INTO $this->table (categoria, estado) VALUES  ('$nombreCategoria','$estadoCategoria')");
        $stmt->execute();
    }
    public function eliminarCategoria(){
    $datos = json_decode(file_get_contents("php://input"), true);
    $data = array();
    foreach ($datos as $id) {
        $stmt = self::$pdo->prepare("SELECT productos.id FROM productos WHERE categoria=:categoria");
        $stmt->bindParam(':categoria', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }

            foreach ($data as $prod) {
                $stmt = self::$pdo->prepare("DELETE FROM articulos WHERE producto=:producto_id");
                $stmt->bindParam(':producto_id', $prod['id']);
                $stmt->execute();
            }
        }}
        $stmt = self::$pdo->prepare("DELETE FROM productos WHERE categoria=:categoria");
        $stmt->bindParam(':categoria', $id);
        $stmt->execute();
        $stmt = self::$pdo->prepare("DELETE FROM $this->table WHERE id=:categoria");
        $stmt->bindParam(':categoria', $id);
        $stmt->execute();
    }
    public function categoriasInactivas() {
        $stmn=self::$pdo->prepare("SELECT * FROM categorias WHERE estado='inactivo'");
        $stmn->execute();
        $res=$stmn->fetchAll(PDO::FETCH_ASSOC);
        $ver=new Success($res);
        $ver->Send();
    }

public function inhabilitarCategoria(){
        $datos = json_decode(file_get_contents("php://input"), true);
        $data = array();
        foreach ($datos as $id) {
            $stmt = self::$pdo->prepare("UPDATE $this->table SET estado = 'inactivo' WHERE id=:categoria");
            $stmt->bindParam(':categoria', $id);
            $stmt->execute(); 
        } 
    }
    public function habilitarCategoria(){
        $datos = json_decode(file_get_contents("php://input"), true);
        $data = array();
        foreach ($datos as $id) {
            $stmt = self::$pdo->prepare("UPDATE $this->table SET estado = 'activo' WHERE id=:categoria");
            $stmt->bindParam(':categoria', $id);
            $stmt->execute(); 
        } 
    }
}
