<?php

namespace proyecto;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use proyecto\Models\User;

class Auth
{
    private $user;


    /*
    $t=new Carbon;
    $t->setTimezone('America/Monterrey');
    $t->addHour();
    $hora_actual=$t->toTimeString();

    Coloca la hora y fecha en el tiempo correcto pero agrega una hora mas
    que se puede utilizar para el token
    */
    
    public static function generateToken($data): string
    {
        $t=new Carbon;
        $t->setTimezone('America/Monterrey');
        $t->addHour();
        $hora_exp=Carbon::createFromFormat('H:i:s',$t->toTimeString());
        $hora_exp=$hora_exp->toTimeString();
        $key = 'orimar174';
        $payload = ['exp' => $hora_exp, 'data' => $data];
        return JWT::encode($payload, $key, 'HS256');
    }

    /**
     * @return mixed
     */
    public static function getUser()
    {
        $secretKey = 'orimar174';
        $jwt = Router::getBearerToken();
        $token = JWT::decode($jwt, new key($secretKey, 'HS256'));
        return User::find($token->data[0]);
    }

    /**
     * @param mixed $user
     */
    public static function setUser($user): void
    {
        $session = new Session();
        $session->set('user', $user);

    }

    public function clearUser($user): void
    {
        $se = new Session();
        $se->remove("user");
    }


}
