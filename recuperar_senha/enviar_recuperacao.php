<?php
// Envia o e-mail com o link para redefinir a senha
require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/../email.php';

use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

// Resposta igual para e-mail cadastrado ou não (não revela quem tem conta)
$mensagem = "Se o e-mail estiver cadastrado, enviamos um link de recuperação.";
$status = "sucesso";

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
if (!$email) {
    $mensagem = "E-mail inválido. Tente novamente.";
    $status = "erro";
} else {
    $stmt = $conn->prepare("SELECT id, nome, username FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user) {
        // Token seguro, válido por 1 hora
        $token = bin2hex(random_bytes(32));
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $upd = $conn->prepare("UPDATE usuarios SET token_recuperacao = ?, token_expira = ? WHERE id = ?");
        $upd->bind_param("ssi", $token, $expira, $user['id']);
        $upd->execute();
        $upd->close();

        // Endereço do site: config.php ou detectado automaticamente
        $base = rtrim(config()['url_site'] ?? '', '/');
        if ($base === '') {
            $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $base = $protocolo . '://' . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['SCRIPT_NAME']));
            $base = rtrim(strtr($base, DIRECTORY_SEPARATOR, '/'), '/');
        }
        $link = $base . "/recuperar_senha/redefinir_senha.php?token=" . urlencode($token);
        $nome = htmlspecialchars($user['nome'] ?: $user['username'], ENT_QUOTES, 'UTF-8');

        try {
            $mail = criar_email();
            $mail->addAddress($email, $user['nome'] ?: $user['username']);
            $mail->isHTML(true);
            $mail->Subject = 'Recuperação de senha - Fólio';
            $mail->Body = "
                <p>Olá <strong>{$nome}</strong>,</p>
                <p>Recebemos uma solicitação para redefinir sua senha no Fólio.</p>
                <p><a href='{$link}'>Clique aqui para redefinir sua senha</a></p>
                <p>Este link expira em 1 hora.</p>
                <p>Se você não solicitou, ignore este e-mail.</p>
            ";
            $mail->AltBody = "Para redefinir sua senha, acesse: {$link} (o link expira em 1 hora).";
            $mail->send();
        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail de recuperação: " . $e->getMessage());
            $mensagem = "Erro ao enviar o e-mail. Tente novamente mais tarde.";
            $status = "erro";
        }
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Recuperar Senha</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg,rgb(89, 0, 0),rgb(147, 0, 0));
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      color: #333;
    }
    .container {
      background: #fff;
      padding: 2.5rem;
      border-radius: 15px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
      width: 400px;
      text-align: center;
      animation: fadeIn 0.6s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    h2 {
      margin-bottom: 1rem;
      color: #820000ff;
    }
    p {
      margin-top: 1rem;
      font-size: 0.95rem;
    }
    .sucesso {
      color: #000000ff;
    }
    .erro {
      color: #000000ff;
    }
    a {
      display: inline-block;
      margin-top: 1.5rem;
      text-decoration: none;
      color: white;
      background: #820000ff;
      padding: 0.8rem 1.5rem;
      border-radius: 8px;
      transition: background 0.3s;
    }
    a:hover {
      background: #d92828ff;
    }
  </style>
  <link rel="stylesheet" href="../css/tema.css" />
</head>
<body>
  <div class="container">
    <h2>Recuperação de Senha</h2>
    <p class="<?php echo $status; ?>">
      <?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?>
    </p>
    <a href="../inicial/inicio.html">Voltar ao início</a>
  </div>
</body>
</html>
