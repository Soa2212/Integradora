<?php

    namespace proyecto\Models;


    use PDO;
    use function json_encode;
    use proyecto\Response\Success;

    
 

    /**
     * Class Persona
     */

    class repse extends Models
    {
       
        protected $filleable = ["producto","TALLA_ROPA","TALLA_NUMERICA", "color","cantidad", "cantidad_soli"];
        public $producto = "";
        public $TALLA_ROPA = "";
        public $TALLA_NUMERICA = "";
        public $color = "";
        public $cantidad="";
        public $cantidad_soli = "";
       

        public function reportepedido(){

            $stmt = self::$pdo->prepare("call actividad_segura.cantidad_solicitada_y_real(); ");
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
            $x=new Success($resultados);
            $x ->Send();
        }
    }
    
