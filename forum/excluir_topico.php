<?php
require_once __DIR__ . '/../conexao.php';
exigir_login();
$usuario_id = $_SESSION['usuario_id'];
$topico_id = intval($_GET['id'] ?? 0);

if ($topico_id <= 0) {
    header("location: forum.php");
    exit();
}

// Verifica se o tópico pertence ao usuário logado
$stmt = $conn->prepare("SELECT usuario_id FROM topicos WHERE id = ?");
$stmt->bind_param("i", $topico_id);
$stmt->execute();
$result = $stmt->get_result();
$topico = $result->fetch_assoc();
$stmt->close();

if (!$topico || $topico['usuario_id'] != $usuario_id) {
    echo "Você não tem permissão para excluir este tópico.";
    exit();
}

// Exclui respostas do tópico primeiro
$stmt = $conn->prepare("DELETE FROM respostas WHERE topico_id = ?");
$stmt->bind_param("i", $topico_id);
$stmt->execute();
$stmt->close();

// Exclui o tópico
$stmt = $conn->prepare("DELETE FROM topicos WHERE id = ?");
$stmt->bind_param("i", $topico_id);
$stmt->execute();
$stmt->close();

header("location: forum.php");
exit();
?>
