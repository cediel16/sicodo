<?php

include_once 'phpmailer/class.phpmailer.php';

class email extends PHPMailer {

    //datos de remitente
    var $host = "correo.alcaldiadeguacara.gob.ve";
    var $email = 'no_responder@alcaldiadeguacara.gob.ve';
    var $nombre = 'No responder';
    var $clave = '123456';

    /**
     * Constructor de clase
     */
    public function __construct() {
        parent::__construct();
        $this->Mailer = "smtp";
        $this->Host = $this->host;
        $this->SMTPAuth = true;
        $this->Username = $this->email;
        $this->Password = $this->clave;
        $this->From = $this->email;
        $this->FromName = $this->nombre;
        $this->Timeout = 30;
    }

    public function enviar($destino, $asunto, $cuerpo) {

        $this->AddAddress($destino);

        $this->Subject = $asunto;
        $this->Body = $cuerpo;

        //$this->AltBody = $cuerpo;

        return $this->Send();
    }

}

//--> fin clase
?>
