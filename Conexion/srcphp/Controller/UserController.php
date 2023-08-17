<?php

namespace proyecto\Controller;
use proyecto\Models\User;
use proyecto\Models\Table;

class UserController{
    public function login(){
        $dtos = file_get_contents("php://input");
        $obj=json_decode($dtos);
        $email=$obj->email;
        $passLog=$obj->contrasena;
        $c=new User;
        $stm=Table::query("SELECT password FROM usuarios WHERE email='$email'");
        foreach($stm as $pass){
            $passUS=$pass["password"];
        }
        if(password_verify($passLog,$passUS))
        {
            $c::auth($obj->email,$passUS);
        }
        else
        {
            return;
        }
        
    }
}