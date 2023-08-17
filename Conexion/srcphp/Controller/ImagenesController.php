<?php

namespace proyecto\Controller;
use Exception;
use proyecto\Models\Table;

use proyecto\Response\Success;

class ImagenesController{
    public function setImg(){
        $con=new Table;
        $cx=$con::getDataconexion();
        $nomImg=$_FILES['foto']['name'];
        $tipoImg=$_FILES['foto']['type'];
        $tamanooImg=$_FILES['foto']['size'];

        $imgSub=fopen($_FILES['foto']['tmp_name'],'r');
        $binimg=fread($imgSub,$tamanooImg);
        $binimg=mysqli_escape_string($cx,$binimg);
        $consulta="Insert into imagenes (nombre,tipo,imagen) values ('".$nomImg."','".$tipoImg."','".$binimg."')";
        
        try{
            $stmn=Table::query($consulta);
            return $stmn;
        }catch(Exception $e){
            return $e;
        }
    }

    public function aggImg(){
        $variable = file_get_contents("php://input");
        $v2=jason_decode($variable);
        $img=base64_decode($v2->imagen);
    }
}