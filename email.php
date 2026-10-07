<?php
/*
 * Envio de e-mails (PHPMailer) com os dados do config.php.
 * Usado pelo "Fale Conosco" e pela recuperação de senha.
 */

use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/phpmailer-master/src/exception.php';
require_once __DIR__ . '/phpmailer-master/src/phpmailer.php';
require_once __DIR__ . '/phpmailer-master/src/smtp.php';

function config_email(): array
{
    return (require __DIR__ . '/config.php')['email'];
}

function criar_email(): PHPMailer
{
    $cfg = config_email();

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $cfg['host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $cfg['usuario'];
    $mail->Password   = $cfg['senha'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = (int) $cfg['porta'];
    $mail->CharSet    = 'UTF-8';
    // O Gmail só aceita enviar em nome da própria conta
    $mail->setFrom($cfg['usuario'], $cfg['nome']);

    return $mail;
}
