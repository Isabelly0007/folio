<?php
require_once __DIR__ . '/../conexao.php';
$id = exigir_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: perfil.php");
    exit();
}

function voltar(string $status): void
{
    header("Location: perfil.php?status=$status");
    exit();
}

// Dados recebidos (a foto é salva separadamente, em salvar_foto.php)
$nome           = trim($_POST['nome'] ?? '');
$username       = trim($_POST['username'] ?? '');
$email          = trim($_POST['email'] ?? '');
$bio            = trim($_POST['bio'] ?? '');
$senha          = $_POST['senha'] ?? '';
$confirma_senha = $_POST['confirma_senha'] ?? '';

if ($nome === '' || $username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    voltar('erro_campos');
}

// O e-mail não pode pertencer a outra conta
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ? AND id <> ?");
$stmt->bind_param("si", $email, $id);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    voltar('erro_email');
}
$stmt->close();

// Troca de senha (opcional)
$senha_hashed = null;
if ($senha !== '' || $confirma_senha !== '') {
    if ($senha !== $confirma_senha) {
        voltar('erro_senha');
    }
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $senha)) {
        voltar('erro_senha_fraca');
    }
    $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);
}

if ($senha_hashed) {
    $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, username = ?, email = ?, bio = ?, senha = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $nome, $username, $email, $bio, $senha_hashed, $id);
} else {
    $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, username = ?, email = ?, bio = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $nome, $username, $email, $bio, $id);
}
$stmt->execute();
$stmt->close();

$_SESSION['usuario_nome'] = $nome;
voltar('sucesso');
