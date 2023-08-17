<?php

namespace proyecto\Models;

use proyecto\Response\Failure;
use proyecto\Response\Response;
use proyecto\Response\Success;


use PDO;
use proyecto\Auth;
use function json_encode;

class User extends Models
{
    public $contrasena = "";
    public $nombre = "";
    public $email = "";

    public $id = "";

    /**
     * @var array
     */
    protected $filleable = [
        "nombre",
        "email",
        "password"
    ];
    protected  $table = "usuarios";




    public static function auth($user, $contrasena):Response
    {
        $class = get_called_class();
        $c = new $class();
        $stmt = self::$pdo->prepare("select *  from $c->table  where  email=:email and password=:password");
        $stmt->bindParam(":email", $user);
        $stmt->bindParam(":password", $contrasena);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_CLASS,User::class);

        if ($resultados) {

            $r=new Success(["usuario"=>$resultados[0],"_token"=>Auth::generateToken([$resultados[0]->id])]);
        return  $r->Send();
        }
        $r=new Failure(401,"Usuario o contraseña incorrectos");
        return $r->Send();

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
    public function agregarAdministrador()
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        $admin = $datos["nombre"];
        $correo = $datos["email"];
        $passwd = $datos["passwd"];
        $tipo = $datos["tipo"];
        $pass_encrypted=password_hash($passwd,PASSWORD_DEFAULT);
        $stmt = self::$pdo->prepare("INSERT INTO usuarios (nombre, email, password, tipo) VALUES (?, ?, ?, ?)");
        $stmt->execute([$admin, $correo, $pass_encrypted, $tipo]);
    }
    public function agregarUser()
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        $usuario = $datos["nombre"];
        $email = $datos["email"];
        $password = $datos["password"];
        $tipo = $datos["tipo"];
        $pass_encrypted=password_hash($password,PASSWORD_DEFAULT);
        $stmt = self::$pdo->prepare("INSERT INTO usuarios (nombre, email, password, tipo) VALUES (?, ?, ?, ?)");
        $stmt->execute([$usuario, $email, $pass_encrypted, $tipo]);
    }
    public function verificarEmail()
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        $email = $datos["email"];
        $stmt = self::$pdo->prepare("CALL buscarcorreo(:email)");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $ver=new Success($res);
        $ver->Send();
    }
    public function mostrarAdministradores()
    {
        $stmn=self::$pdo->prepare("SELECT * FROM usuarios WHERE tipo='admin'");
        $stmn->execute();
        $res=$stmn->fetchAll(PDO::FETCH_ASSOC);
        $ver=new Success($res);
        $ver->Send();
    }
}
