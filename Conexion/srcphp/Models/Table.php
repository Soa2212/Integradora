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




}
    static function query($query)
    {

        $cc = new  Conexion("actividad_segura", "localhost", "Ricardo", "1234");
        self::$pdo = $cc->getPDO();
        $stmt = self::$pdo->query($query);
        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $resultados;
    }
}
