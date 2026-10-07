<?php
// esqueci_senha.php
// Apenas exibe o formulário; ação para enviar_recuperacao.php
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Recuperar senha</title>
  <style>
    /* Reset básico */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: Arial, sans-serif;
  background: linear-gradient(135deg,rgb(89, 0, 0),rgb(147, 0, 0));
}

.container {
  background: #fff;
  padding: 40px;
  border-radius: 12px;
  width: 350px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  text-align: center;
}

h2 {
  color: #820000ff;
  margin-bottom: 25px;
}

label {
  font-weight: bold;
  color: #333;
}

input[type="email"] {
  width: 100%;
  padding: 10px;
  margin: 10px 0 20px 0;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 15px;
  transition: border-color 0.3s;
}

input[type="email"]:focus {
  border-color: #820000ff;
  outline: none;
}

button {
  width: 100%;
  padding: 10px;
  background: #820000ff;
  color: #fff;
  border: none;
  border-radius: 6px;
  font-weight: bold;
  font-size: 16px;
  cursor: pointer;
  transition: background 0.3s;
}

button:hover {
  background: #3d0000ff;
}

p {
  margin-top: 20px;
}

a {
  color: #820000ff;
  text-decoration: none;
  font-weight: bold;
}

a:hover {
  text-decoration: underline;
}

  </style>
  <link rel="stylesheet" href="../css/tema.css" />
</head>
<body>
  <div class="container">
    <h2>Recuperar senha</h2>
    <form action="enviar_recuperacao.php" method="POST">
      <label for="email">Digite seu e-mail cadastrado</label><br>
      <input type="email" name="email" id="email" required placeholder="seu@exemplo.com"><br><br>
      <button type="submit">Enviar link de recuperação</button>
    </form>
    <p><a href="../inicial/inicio.html">Voltar</a></p>
  </div>
</body>
</html>
