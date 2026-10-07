<?php
require_once __DIR__ . '/../conexao.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["status" => "erro", "message" => "Usuário não autenticado."]);
    exit();
}
$usuario_id = (int) $_SESSION['usuario_id'];

$foto = trim($_POST['foto'] ?? '');

// Só aceita uma das fotos oferecidas no modal
if (!in_array($foto, FOTOS_PERFIL, true)) {
    echo json_encode(["status" => "erro", "message" => "Foto inválida."]);
    exit();
}

$stmt = $conn->prepare("UPDATE usuarios SET foto = ? WHERE id = ?");
$stmt->bind_param("si", $foto, $usuario_id);
$stmt->execute();
$stmt->close();

$_SESSION['foto'] = $foto;
echo json_encode(["status" => "sucesso", "message" => "Foto de perfil atualizada com sucesso!"]);
