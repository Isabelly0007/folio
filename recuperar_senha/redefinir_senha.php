<?php
require_once __DIR__ . '/../conexao.php';
// redefinir_senha.php

$token = $_GET['token'] ?? '';
if (!$token) {
    echo "Token inválido.";
    exit;
}

// Buscar usuário pelo token (e garantir que não esteja expirado aqui opcionalmente)
$stmt = $conn->prepare("SELECT id, token_expira FROM usuarios WHERE token_recuperacao = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "Token inválido ou já usado.";
    exit;
}

// Verificar expiração
if (strtotime($user['token_expira']) < time()) {
    echo "Token expirado.";
    exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Redefinir senha</title>
  <style>
    body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg,rgb(89, 0, 0),rgb(147, 0, 0));
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
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
  margin-bottom: 1.5rem;
  color: #820000ff;
}

label {
  display: block;
  font-size: 0.95rem;
  margin-bottom: 0.5rem;
  text-align: left;
}

input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 0.7rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  margin-bottom: 1.2rem;
  font-size: 0.95rem;
  transition: border-color 0.3s;
}

input:focus {
  border-color: #f65c5cff;
  outline: none;
}

button {
  width: 100%;
  background-color: #820000ff;
  color: white;
  border: none;
  padding: 0.8rem;
  border-radius: 8px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #d92828ff;
}

p {
  margin-top: 1rem;
  font-size: 0.9rem;
}

a {
  display: inline-block;
  margin-top: 1rem;
  text-decoration: none;
  color: white;
  background-color: #820000ff;
  padding: 0.7rem 1.2rem;
  border-radius: 8px;
  transition: background-color 0.3s;
}

a:hover {
  background-color: #000000ff;
}

.sucesso { color: #000000ff; }
.erro { color: #000000ff; }

  </style>
  <link rel="stylesheet" href="../css/tema.css" />
</head>
<body>
  <div class="container">
    <h2>Redefinir senha</h2>
    <form action="salvar_nova_senha.php" method="POST">
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token, ENT_QUOTES); ?>">
      <label>Nova senha:</label><br>
      <input type="password" name="senha" required minlength="8"><br>
      <small>Mínimo de 8 caracteres, com letra maiúscula, minúscula, número e símbolo.</small><br><br>
      <label>Confirmar senha:</label><br>
      <input type="password" name="confirma" required minlength="8"><br><br>
      <button type="submit">Salvar nova senha</button>
    </form>
    <p><a href="../inicial/inicio.html">Voltar ao site</a></p>
  </div>
</body>
</html>
