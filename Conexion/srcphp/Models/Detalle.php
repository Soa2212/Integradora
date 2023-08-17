<?php

namespace proyecto\Models;

use PDO;
use proyecto\Auth;
use proyecto\Response\Failure;
use proyecto\Response\Response;
use proyecto\Response\Success;
use function json_encode;

class Detalle extends Models{
    public $orden="";
    public $articulo="";
    public $cantidad="";

    public $id="";

    protected $table="detalle_orden";

    public $filleable=[
        "orden",
        "articulo",
        "cantidad"
    ];
}