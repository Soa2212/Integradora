<?php

class conexion{
    private $host;
    private $db;
    private $usr;
    private $password;

    public function __construct(){
        $this->host='localhost';
        $this->db='actividad_segura';
        $this->usr='Ricardo';
        $this->password='1234';
    }

    function connect(){
        try{
            $con=new PDO('mysql:host='.$this->host.';dbname='.$this->db.';user='.$this->usr.';password='.$this->password.';');
            return $con;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    
}

