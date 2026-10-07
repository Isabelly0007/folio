<?php
require_once __DIR__ . '/../conexao.php';
// salvar_nova_senha.php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método inválido.";
    exit;
}

$token = $_POST['token'] ?? '';
$senha = $_POST['senha'] ?? '';
$confirma = $_POST['confirma'] ?? '';

if (!$token || !$senha || !$confirma) {
    $mensagem = "Preencha todos os campos.";
} elseif ($senha !== $confirma) {
    $mensagem = "As senhas não coincidem.";
} elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $senha)) {
    // mesma regra do cadastro
    $mensagem = "A senha deve ter pelo menos 8 caracteres, com letra maiúscula, minúscula, número e símbolo.";
} else {
    // Verifica token válido
    $stmt = $conn->prepare("SELECT id, token_expira FROM usuarios WHERE token_recuperacao = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        $mensagem = "Token inválido ou já usado.";
    } elseif (strtotime($user['token_expira']) < time()) {
        $mensagem = "O link de redefinição expirou. Solicite novamente.";
    } else {
        // Atualiza senha e limpa token
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $upd = $conn->prepare("UPDATE usuarios SET senha = ?, token_recuperacao = NULL, token_expira = NULL WHERE id = ?");
        $upd->bind_param("si", $senhaHash, $user['id']);

        if ($upd->execute()) {
            $mensagem = "Senha redefinida com sucesso!";
            $sucesso = true;
        } else {
            $mensagem = "Erro ao salvar nova senha. Tente novamente.";
        }
        $upd->close();
    }
}
$conn->close();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Redefinição de Senha</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: linear-gradient(135deg,rgb(89, 0, 0),rgb(147, 0, 0));
      font-family: Arial, sans-serif;
    }
    .form-box {
      background-color: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
      width: 350px;
      text-align: center;
    }
    .form-box h2 {
      color: #820000ff;
      margin-bottom: 25px;
    }
    .form-box p {
      font-size: 16px;
      color: #333;
      margin-bottom: 20px;
    }
    .form-box a {
      color: #600000ff;
      text-decoration: none;
      font-weight: bold;
    }
    .form-box a:hover {
      text-decoration: underline;
    }
    .success {
      color: #003f1bff;
      font-weight: bold;
    }
    .error {
      color: #b22222;
      font-weight: bold;
    }
  </style>
  <link rel="stylesheet" href="../css/tema.css" />
</head>
<body>
  <div class="form-box">
    <h2>Redefinição de Senha</h2>
    <p class="<?php echo isset($sucesso) ? 'success' : 'error'; ?>">
      <?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?>
    </p>
    <?php if (isset($sucesso)) : ?>
      <a href="../inicial/inicio.html">Ir para o login</a>
    <?php else : ?>
      <a href="../inicial/inicio.html">Voltar</a>
    <?php endif; ?>
  </div>
</body>
</html>
