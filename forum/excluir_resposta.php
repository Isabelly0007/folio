<?php
require_once __DIR__ . '/../conexao.php';
exigir_login();

$usuario_id = $_SESSION['usuario_id'];
$resposta_id = intval($_GET['id'] ?? 0);

if ($resposta_id <= 0) {
    header("location: forum.php");
    exit();
}

// Verifica se a resposta pertence ao usuário logado
$stmt = $conn->prepare("SELECT usuario_id, topico_id FROM respostas WHERE id = ?");
$stmt->bind_param("i", $resposta_id);
$stmt->execute();
$result = $stmt->get_result();
$resposta = $result->fetch_assoc();
$stmt->close();

if (!$resposta || $resposta['usuario_id'] != $usuario_id) {
    echo "Você não tem permissão para excluir esta resposta.";
    exit();
}

// Exclui a resposta
$stmt = $conn->prepare("DELETE FROM respostas WHERE id = ?");
$stmt->bind_param("i", $resposta_id);
$stmt->execute();
$stmt->close();

header("Location: ver_topico.php?id=".$resposta['topico_id']);
exit();
?>
