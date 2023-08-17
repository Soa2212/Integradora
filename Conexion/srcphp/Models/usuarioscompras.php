<?php

    namespace proyecto\Models;

    use proyecto\Models\Table;
    use PDO;
    use function json_encode;
    use proyecto\Response\Success;

    
 

    /**
     * Class Persona
     */
    
    class usuarioscompras extends Models
    {

        protected $filleable = ["orden","fecha","cantidad_articulos","total","estado"];
        public $orden = "";
        public $fecha = "";
        public $cantidad_articulos = "";
        public $total = "";
        public $estado ='';
        public $id='';
        public function compras(){
         $datos = json_decode(file_get_contents("php://input"),true);
            $id = $datos['id'];
            $stmt =Table::query("call actividad_segura.compra_usuario('$id')");
            $x=new Success($stmt);
            $x ->Send();
        }   
    }
    