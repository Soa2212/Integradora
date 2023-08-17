<?php
namespace proyecto\Models;
use proyecto\Response\Success;
use PDO;
use function json_encode;


class Productos extends Models{
    protected $table='productos';
    protected $id='';	
    protected $nombre='';
    protected $precio='';	
    protected $imagenID='';
    protected $descripcion='';
    protected $categoria='';	
    protected $estado='';
    protected $filleable=[
        'id',
        'nombre',
        'precio',
        'imagenID',
        'descripcion',
        'categoria',
        'estado'
    ];

    public function AllProductos(){
        $stmn=self::$pdo->prepare("SELECT * FROM productos WHERE estado='activo'");
        $stmn->execute();
        $res=$stmn->fetchAll(pdo::FETCH_ASSOC);
        $verificar=new Success($res);
        $verificar->Send();
    }
    public function productosInactivos(){
        $stmn=self::$pdo->prepare("SELECT * FROM productos WHERE estado='inactivo'");
        $stmn->execute();
        $res=$stmn->fetchAll(pdo::FETCH_ASSOC);
        $verificar=new Success($res);
        $verificar->Send();
    }
    public function agregarProducto(){
        $datos = json_decode(file_get_contents("php://input"), true);
            $nombre = $datos["nombre"];
            $precio = $datos["precio"];
            $imagen = $datos["imagen1"];
            $descripcion = $datos["descripcion"];
            $categoria = $datos["categoria"];
            $estado = $datos["estado"];

            $stmt = self::$pdo->prepare("INSERT INTO $this->table (nombre,precio,imagen1,descripcion,categoria,estado) VALUES  ('$nombre','$precio','$imagen','$descripcion',$categoria,'$estado')");
            $stmt->execute();
    }
    public function eliminarProducto(){
        $datos = json_decode(file_get_contents("php://input"), true);
        foreach ($datos as $id) {
            $stmt = self::$pdo->prepare("DELETE FROM articulos WHERE producto=:producto");
            $stmt->bindParam(':producto', $id);
            $stmt->execute();
            $stmt = self::$pdo->prepare("DELETE FROM productos WHERE id=:producto");
            $stmt->bindParam(':producto', $id);
            $stmt->execute();
        };
    }
    public function inhabilitarProducto(){
        $datos = json_decode(file_get_contents("php://input"), true);
        $data = array();
        foreach ($datos as $id) {
            $stmt = self::$pdo->prepare("UPDATE productos SET estado = 'inactivo' WHERE id=:producto");
            $stmt->bindParam(':producto', $id);
            $stmt->execute(); 
        }}
        public function habilitarProducto($id){
            $datos = json_decode(file_get_contents("php://input"), true);
            $stmt = self::$pdo->prepare("UPDATE productos SET estado = 'activo' WHERE id=:producto");
            $stmt->bindParam(':producto', $id);
            $stmt->execute(); 
        }
        public function colores(){
            $stmn=self::$pdo->prepare("SELECT * FROM colores");
            $stmn->execute();
            $res=$stmn->fetchAll(pdo::FETCH_ASSOC);
            $verificar=new Success($res);
            $verificar->Send();
        }
        public function tallasNumericas(){
            $stmn=self::$pdo->prepare("SELECT * FROM talla_numerica");
            $stmn->execute();
            $res=$stmn->fetchAll(pdo::FETCH_ASSOC);
            $verificar=new Success($res);
            $verificar->Send();
        }
        public function tallasRopa(){
            $stmn=self::$pdo->prepare("SELECT * FROM talla_ropa");
            $stmn->execute();
            $res=$stmn->fetchAll(pdo::FETCH_ASSOC);
            $verificar=new Success($res);
            $verificar->Send();
        }
        public function obtenerId(){
            $datos = json_decode(file_get_contents("php://input"), true);
            $producto = $datos["nombre"];
            $stmn=self::$pdo->prepare("SELECT productos.id FROM productos where nombre=:prod");
            $stmn->bindParam(':prod', $producto);
            $stmn->execute();
            $res=$stmn->fetchAll(pdo::FETCH_ASSOC);
            $verificar=new Success($res);
            $verificar->Send();
        }
        public function obtenerProducto(){
            $datos = json_decode(file_get_contents("php://input"), true);
            $producto = $datos["nombre"];
            $stmn=self::$pdo->prepare("SELECT * FROM productos where nombre=:prod");
            $stmn->bindParam(':prod', $producto);
            $stmn->execute();
            $res=$stmn->fetchAll(pdo::FETCH_ASSOC);
            $verificar=new Success($res);
            $verificar->Send();
        }
        public function agregarArticulo(){
            $datos = json_decode(file_get_contents("php://input"), true);
                $producto = $datos["producto"];
                $cantidad = $datos["cantidad"];
                $talla_numerica = $datos["talla_numerica"];
                $talla_ropa = $datos["talla_ropa"];
                $color = $datos["color"];
    
                $stmt = self::$pdo->prepare("INSERT INTO articulos (producto,cantidad,talla_numerica,talla_ropa,color) VALUES  ('$producto','$cantidad','$talla_numerica','$talla_ropa',$color)");
                $stmt->execute();
        }
        public function ordenesProceso(){
            $stmt=self::$pdo->prepare("SELECT usuarios.nombre, orden_venta.id, orden_venta.FechaOrden, orden_venta.Estado_Venta, orden_venta.tipo_orden FROM orden_venta inner join usuarios on orden_venta.Cliente = usuarios.id WHERE Estado_Venta='En Proceso'");
            $stmt->execute();
            $res=$stmt->fetchAll(pdo::FETCH_ASSOC);
            $verificar=new Success($res);
            $verificar->Send();
        }
        public function ordenesAceptadas(){
            $stmt=self::$pdo->prepare("SELECT usuarios.nombre, orden_venta.id, orden_venta.FechaOrden, orden_venta.Estado_Venta, orden_venta.tipo_orden FROM orden_venta inner join usuarios on orden_venta.Cliente = usuarios.id WHERE Estado_Venta='Aceptada'");
            $stmt->execute();
            $res=$stmt->fetchAll(pdo::FETCH_ASSOC);
            $verificar=new Success($res);
            $verificar->Send();
        }
        public function detalleOrden($id){
            $stmt=self::$pdo->prepare("SELECT articulos.id,productos.nombre, talla_numerica.talla as 'Talla_numerica', talla_ropa.talla as 'Talla_ropa', colores.color, detalle_orden.cantidad, articulos.cantidad as 'stock', sum(productos.precio * detalle_orden.cantidad)as Total from productos inner join articulos on productos.id = articulos.producto
            inner join talla_numerica on articulos.talla_numerica = talla_numerica.id
            inner join talla_ropa on articulos.talla_ropa = talla_ropa.id
            inner join colores on articulos.color = colores.id
            inner join detalle_orden on detalle_orden.Articulo = articulos.id where detalle_orden.Orden = $id
            group by productos.nombre");
            /*$stmt=self::$pdo->prepare("SELECT articulos.id,productos.nombre, talla_numerica.talla as 'Talla_numerica', talla_ropa.talla as 'Talla_ropa', colores.color, detalle_orden.cantidad, articulos.cantidad as 'stock' from productos inner join articulos on productos.id = articulos.producto
            inner join talla_numerica on articulos.talla_numerica = talla_numerica.id
            inner join talla_ropa on articulos.talla_ropa = talla_ropa.id
            inner join colores on articulos.color = colores.id
            inner join detalle_orden on detalle_orden.Articulo = articulos.id where detalle_orden.Orden = $id");*/
            $stmt->execute();
            $res=$stmt->fetchAll(pdo::FETCH_ASSOC);
            $verificar=new Success($res);
            $verificar->Send();
        }
        public function detalleOrdenTotal($id){
            $stmt=self::$pdo->prepare("SELECT sum(Detalle.Total) as 'Total' FROM (SELECT articulos.id,productos.nombre, talla_numerica.talla as 'Talla_numerica', talla_ropa.talla as 'Talla_ropa', colores.color, detalle_orden.cantidad, articulos.cantidad as 'stock', sum(productos.precio * detalle_orden.cantidad)as Total from productos inner join articulos on productos.id = articulos.producto
            inner join talla_numerica on articulos.talla_numerica = talla_numerica.id
            inner join talla_ropa on articulos.talla_ropa = talla_ropa.id
            inner join colores on articulos.color = colores.id
            inner join detalle_orden on detalle_orden.Articulo = articulos.id where detalle_orden.Orden = $id
            group by productos.nombre) as Detalle");
            $stmt->execute();
            $res=$stmt->fetchAll(pdo::FETCH_ASSOC);
            $verificar=new Success($res);
            $verificar->Send();
        }
        public function actualizarStock(){
            $datos = json_decode(file_get_contents("php://input"), true);
                $producto = $datos["producto"];
                $cantidad = $datos["cantidad"];
                $articulo = $datos["id"];
                $stmt = self::$pdo->prepare("UPDATE articulos SET cantidad=:cant WHERE articulos.producto=:prod AND articulos.id=:art");
                $stmt->bindParam(':cant', $cantidad);
                $stmt->bindParam(':prod', $producto);
                $stmt->bindParam(':art', $articulo);
                $stmt->execute();
        }
        public function articuloCantidad($id){
            $stmt=self::$pdo->prepare("SELECT articulos.id, detalle_orden.cantidad from");
            $stmt->execute();
            $res=$stmt->fetchAll(pdo::FETCH_ASSOC);
            $verificar=new Success($res);
            $verificar->Send();
        }
    }