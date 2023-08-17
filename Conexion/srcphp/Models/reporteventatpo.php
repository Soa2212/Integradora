<?php

    namespace proyecto\Models;

    use proyecto\Models\Table;
    use PDO;
    use function json_encode;
    use proyecto\Response\Success;

    
 

    /**
     * Class Persona
     */
    
    class reporteventatpo extends Models
    {
       
        protected $filleable = ["orden","producto","TALLA_ROPA","TALLA_NUMERICA", "color","cantidad", "precio_unitario","total"];
        public $orden = "";
        public $producto = "";
        public $TALLA_ROPA = "";
        public $TALLA_NUMERICA = "";
        public $color = "";
        public $cantidad="";
        public $precio_unitario = "";
        public $total = "";


        public $tipo='';
        public $fecha_ini='';
        public $fecha_fin='';

        public function reportetipo(){
            $datos = json_decode(file_get_contents("php://input"),true);
            $tipo = $datos['tipo'];
            $fecha_ini = $datos['fecha_ini'];
            $fecha_fin = $datos['fecha_fin'];
            $stmt =Table::query("call actividad_segura.reporte_ventas_x_tipo_orden_periodo('$tipo','$fecha_ini','$fecha_fin')");
            $x=new Success($stmt);
            $x ->Send();
        }
        public function reportefecha(){
            $datos = json_decode(file_get_contents("php://input"),true);
            $fecha_ini = $datos['fecha_ini'];
            $fecha_fin = $datos['fecha_fin'];
            $stmt =Table::query("call actividad_segura.reporte_ventas_x_periodo('$fecha_ini','$fecha_fin')");
            $x=new Success($stmt);
            $x ->Send();
        }
            public function AllReporte(){
            $stmn=self::$pdo->prepare("call actividad_segura.reporte_ventas()");
            $stmn->execute();
            $res=$stmn->fetchAll(pdo::FETCH_ASSOC);
            $verificar=new Success($res);
            $verificar->Send();

    }
    public function novendidotipo(){
        $datos = json_decode(file_get_contents("php://input"),true);
           $tipo = $datos['tipo'];
           $fecha_ini = $datos['fecha_ini'];
           $fecha_fin = $datos['fecha_fin'];
           $stmt =Table::query("call actividad_segura.PRODUCTOS_no_vendidos_x_periodo_tipo_orden('$tipo','$fecha_ini','$fecha_fin')");
           $x=new Success($stmt);
           $x ->Send();
       }
       public function novendidofehca(){
           $datos = json_decode(file_get_contents("php://input"),true);
              $fecha_ini = $datos['fecha_ini'];
              $fecha_fin = $datos['fecha_fin'];
              $stmt =Table::query("call actividad_segura.PRODUCTOS_no_vendidos_x_periodo('$fecha_ini','$fecha_fin')");
              $x=new Success($stmt);
              $x ->Send();
          }
        
          public function Allnovendido(){
           $stmn=self::$pdo->prepare("call actividad_segura.PRODUCTOS_no_vendidos();");
           $stmn->execute();
           $res=$stmn->fetchAll(pdo::FETCH_ASSOC);
           $verificar=new Success($res);
           $verificar->Send();

   }
   public function detalle(){
    $datos = json_decode(file_get_contents("php://input"),true);
    $ordenid = $datos['ordenid'];
    $fecha_fin = $datos['fecha_fin'];
    $stmt =Table::query("call actividad_segura.dettalle_compra_orden('$ordenid')");
    $x=new Success($stmt);
    $x ->Send();
}
           
    }
    