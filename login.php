<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/conexao.php';

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($email === '' || $senha === '') {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Preencha todos os campos.']);
    exit;
}

$stmt = $conn->prepare('SELECT id, nome, senha, foto FROM usuarios WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Mesma mensagem para e-mail inexistente ou senha errada (não revela quais e-mails têm conta)
if (!$user || !password_verify($senha, $user['senha'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'E-mail ou senha incorretos.']);
    exit;
}

session_regenerate_id(true);
$_SESSION['usuario_id']   = (int) $user['id'];
$_SESSION['usuario_nome'] = $user['nome'];
$_SESSION['foto']         = $user['foto'];

echo json_encode(['status' => 'sucesso']);
