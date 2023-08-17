<?php

    namespace proyecto\Models;

    use proyecto\Models\Table;
    use PDO;
    use function json_encode;
    use proyecto\Response\Success;

    
 

    /**
     * Class Persona
     */
    
    class detalles extends Models
    {
       
        protected $filleable = ["producto","TALLA_ROPA","TALLA_NUMERICA", "color","cantidad", "precio_unitario","total","imagen"];
        public $producto = "";
        public $TALLA_ROPA = "";
        public $TALLA_NUMERICA = "";
        public $color = "";
        public $cantidad="";
        public $precio_unitario = "";
        public $total = "";
        public $imagen ='';

        public $ordenid='';



   public function detalle(){
    $datos = json_decode(file_get_contents("php://input"),true);
       $ordenid = $datos['ordenid'];
       $stmt =Table::query("call actividad_segura.dettalle_compra_orden('$ordenid')");
       $x=new Success($stmt);
       $x ->Send();
   } 
           
    }
    