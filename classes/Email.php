<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email {
    public $email;
    public $name;
    public $token;
    public function __construct($email, $name, $token){
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendConfirmation (){
        //Mail
        $mail = new PHPMailer();
        //Server settings
               
        $mail->isSMTP();                                          
        $mail->Host       = $_ENV['EMAIL_HOST'];             
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = $_ENV['EMAIL_USER'];                     
        $mail->Password   = $_ENV['EMAIL_PASS'];                                        
        $mail->Port       = $_ENV['EMAIL_PORT'];
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
        $mail->Subject = "Confirma tu cuenta";

        $contenido = "<html>";
        $contenido.= "<p><strong> Hola " . $this->name .   " </strong> Necesitas confirmar tu cuenta de correo electrónico, para finalizar el registro da click al siguiente enlace</p>";
        $contenido.= "<p> Presiona aquí: <a href='".$_ENV['APP_URL']."/confirm?token=". $this->token ."'> Confirmar Cuenta </a> </p>";
        $contenido.= "<p> Si no solicitaste esta cuenta, puedes ignorar el mensaje   </p>";
        $contenido.= "</html>";

        $mail->Body = $contenido;

        $mail->send();

    }

    public function sendInstructions (){
        //Mail
        $mail = new PHPMailer();
        //Server settings
               
        $mail->isSMTP();                                          
        $mail->Host       = $_ENV['EMAIL_HOST'];             
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = $_ENV['EMAIL_USER'];                     
        $mail->Password   = $_ENV['EMAIL_PASS'];                                        
        $mail->Port       = $_ENV['EMAIL_PORT'];
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
        $mail->Subject = "Restablecer contraseña";

        $contenido = "<html>";
        $contenido.= "<p><strong> Hola " . $this->name .   " </strong> Has solicitado el restablecimiento de tu contraseña </p>";
        $contenido.= "<p> Presiona aquí: <a href='". $_ENV['APP_URL'] ."/reset?token=". $this->token ."'> Restablecer contraseña </a> </p>";
        $contenido.= "<p> Si no lo solicitaste, puedes ignorar el mensaje   </p>";
        $contenido.= "</html>";

        $mail->Body = $contenido;

        $mail->send();
    }


}
