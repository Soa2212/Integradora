<?php

namespace proyecto\Models;

use PDO;
use proyecto\Conexion;


class Table
{
    public static $pdo = null;
    public function __construct()
    {

    }
    static  function getDataconexion(){
        $cc = new  Conexion("actividad_segura", "localhost", "integradora", "1234");
            self::$pdo = $cc->getPDO();
            return self::$pdo;
    }
    static function query($query)
    {

        $cc = new  Conexion("actividad_segura", "localhost", "integradora", "1234");
        self::$pdo = $cc->getPDO();
        $stmt = self::$pdo->query($query);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }
}
