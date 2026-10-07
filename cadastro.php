<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/conexao.php';

function responder(string $status, string $mensagem): void
{
    echo json_encode(['status' => $status, 'mensagem' => $mensagem]);
    exit;
}

$nome     = trim($_POST['username'] ?? ''); // o nome digitado também vira o nome de usuário
$email    = trim($_POST['email'] ?? '');
$senha    = $_POST['senha'] ?? '';
$confirma = $_POST['confirma'] ?? '';

if ($nome === '' || $email === '' || $senha === '') {
    responder('erro', 'Preencha todos os campos.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    responder('erro', 'Digite um e-mail válido.');
}

if ($senha !== $confirma) {
    responder('erro', 'As senhas não coincidem.');
}

// Força da senha: mínimo 8 caracteres, com maiúscula, minúscula, número e símbolo
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $senha)) {
    responder('erro', 'A senha deve conter pelo menos 8 caracteres, incluindo uma letra maiúscula, uma minúscula, um número e um símbolo.');
}

// Verifica se o e-mail já existe
$stmt = $conn->prepare('SELECT id FROM usuarios WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    responder('erro', 'E-mail já cadastrado.');
}
$stmt->close();

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);
$username = $nome;

$stmt = $conn->prepare('INSERT INTO usuarios (nome, username, email, senha) VALUES (?, ?, ?, ?)');
$stmt->bind_param('ssss', $nome, $username, $email, $senhaHash);
$stmt->execute();

responder('sucesso', 'Cadastro realizado com sucesso!');
