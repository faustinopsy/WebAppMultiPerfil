<?php
namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class EnviaEMail{
    public function __construct() {
        $configFilePath = __DIR__ . '/../Database/configEmail.php';
        $config = require_once $configFilePath;
    }

public function recupera($dados) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = MAIL_HOST; 
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME; 
        $mail->Password = MAIL_PASSWORD; 
        $mail->SMTPSecure = 'tls'; 
        $mail->Port = MAIL_PORT; 

        $mail->setFrom(MAIL_FROM, 'Nome do Remetente');
        $mail->addAddress($dados['email']); 
        $mail->isHTML(true);
        if(isset($dados['senha'])){
            $mail->Subject = 'Recupera Senha';
            $mail->Body    = 'Sua senha temporária é: ' . $dados['senha'];
        }else{
            $mail->Subject = 'Código de acesso';
            $mail->Body    = 'o Código de acesso é: ' . $dados['codigo'];
        }
        

        $mail->send();

        return true;
    } catch (Exception $e) {
        return false;
    }
}
}
