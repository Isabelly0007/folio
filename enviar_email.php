<?php
// "Fale Conosco" (formulário do rodapé). Responde "success" ou "error".

use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/email.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$emailUsuario    = filter_var(trim($_POST['emailContato'] ?? ''), FILTER_VALIDATE_EMAIL);
$mensagemUsuario = trim($_POST['mensagemContato'] ?? '');

if (!$emailUsuario || $mensagemUsuario === '') {
    echo 'error';
    exit;
}

try {
    $mail = criar_email();
    $cfg = config_email();
    $mail->addAddress($cfg['contato'] ?: $cfg['usuario']);
    $mail->addReplyTo($emailUsuario); // "Responder" vai direto para o visitante

    $mail->isHTML(false);
    $mail->Subject = 'Nova mensagem do site Fólio';
    $mail->Body    = "Email: $emailUsuario\n\nMensagem:\n$mensagemUsuario";

    $mail->send();
    echo 'success';
} catch (Exception $e) {
    error_log('Erro no Fale Conosco: ' . $e->getMessage());
    echo 'error';
}
