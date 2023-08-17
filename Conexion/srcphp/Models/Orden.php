<?php

namespace proyecto\Models;
use proyecto\Response\Success;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use proyecto\Exception;
class Orden extends Models{
    public $FechaOrden="";
    public $Cliente="";
    public $Estado_Venta="";
    public $tipo_orden="";
    public $table="orden_venta";
    public $filleable=[
        "FechaOrden",
        "Cliente",
        "Estado_venta",
        "tipo_orden"
    ];

    public function estado(){
        $JSON=file_get_contents("php://input");
        $obj=json_decode($JSON);
        $orden=self::$pdo->prepare("UPDATE ".$this->table." SET Estado_Venta=:estado WHERE id=:ordenid");
        $orden->bindValue(":estado",$obj->estado);
        $orden->bindValue(":ordenid",$obj->orden);
        $orden->execute();
        $stmt=self::$pdo->prepare("CALL actualizar_fecha(:ordenid)");
        $stmt->bindValue(":ordenid",$obj->orden);
        $stmt->execute();
            $r=new Success($orden);
            
        
        $stm2=Table::query('SELECT usuarios.email from usuarios 
                            inner join orden_venta on usuarios.id=orden_venta.cliente
                            where orden_venta.id='.$obj->orden.'');
        $correoUS='';
        foreach($stm2 as $email){
            $correoUS=$email['email'];
            echo $correoUS;
        }
        try {
            $debug=true;
            // Crear una instancia de la clase PHPMailer
            $mail = new PHPMailer($debug);
            if ($debug) {
                    // Emitir un registro detallado de
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER; }
            
            // Autentificación vía SMTP
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            // Login
            $mail->Host = "smtp.gmail.com";
            $mail->Port = "587";
            $mail->Username = "actividad.seguraUTT@gmail.com";
            $mail->Password = "kdltpstownxcyeaj";
            $mail->SMTPSecure = "TLS";
            $mail->setFrom('actividad.seguraUTT@gmail.com','Act Segura');
            $mail->addAddress($correoUS);
            $mail->isHTML(true);
            $mail->Subject='Pedido Completado';
            $body='<p>Gracias por su compra</p>
                    <br>
                    <p>Contacto: <b>3326413741</b></p>
                    <br>
                    <p>Para mas informacion: ventasgdl@actividadsegura.com</p>
                    <br>
                    <p>Su Orden de pedido es: <b>'.$obj->orden.'</b></p>
                    <br>
                    <p>Su pedido fue: <b>'.$obj->estado.'</b></p>';
            $mail->Body = $body;
            $mail->send();
        }catch (\PHPMailer\PHPMailer\Exception $e) {
        echo "Message could not be sent. Mailer Error: ".$mail->ErrorInfo;
            }
        return $r->Send();
    }

    public function getOrden($idUS){
        $stm=Table::query('call buscarordenusrocrearweb('.$idUS.')');
        $ordenUs="";
        foreach($stm as $ord){
            $ordenUs=$ord['id_de_orden'];
        }
        $r=new Success($ordenUs);
        return $r->Send();
    }
    public function getOrdenL($idUS){
        $stm=Table::query('call buscarordenusrocrearlocal('.$idUS.')');
        $ordenUs="";
        foreach($stm as $ord){
            $ordenUs=$ord['id_de_orden'];
        }
        $r=new Success($ordenUs);
        return $r->Send();
    }
}