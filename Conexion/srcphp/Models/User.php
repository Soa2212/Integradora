<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class User extends Models
{
    public $user = "";
    public $contrasena = "";
    public $nombre = "";
    public $edad = "";
    public $correo = "";
    public $apellido = "";

    public $id = "";

    /**
     * @var array
     */
    protected $filleable = [
        "nombre",
        "edad",
        "correo",
        "apellido",
        "contrasena",
        "user"
    ];
    protected  $table = "usuarios";




    public function login($user, $contraseña)
    {
        $respuesta = [];
        $stmt = self::$pdo->prepare("select *  from $this->table  where  user =:user  and contraseña=:contraseña");
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":contraseña", $contraseña);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);

        if ($resultados) {
            $respuesta["acceso"] = true;
            $respuesta["usuario"] = $resultados[0];
            $auth = new Auth();
            $auth->setUser($resultados[0]);
            return json_encode($respuesta);
        }
        $respuesta["acceso"] = false;
        $respuesta["usuario"] = [];
        return json_encode($respuesta);


    }

    public function find_name($name)
    {

        $stmt = self::$pdo->prepare("select *  from $this->table  where  nombre=:name");
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($resultados == null) {
            return json_encode([]);
        }
        return json_encode($resultados[0]);
    }
    public function agregarAdmin()
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        $admin = $datos["nombre"];
        $correo = $datos["email"];
        $passwd = $datos["contraseña"];
        $tipo = $datos["tipo"];
        $stmt = self::$pdo->prepare("INSERT INTO usuarios (nombre, email, contraseña, tipo) VALUES (?, ?, ?, ?)");
        $stmt->execute([$admin, $correo, $passwd, $tipo]);
    }
}
