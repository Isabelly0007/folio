<?php
require_once __DIR__ . '/../conexao.php';

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT titulo, descricao, capa, arquivo FROM obras WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
if ($obra = $result->fetch_assoc()) {
    echo json_encode($obra);
} else {
    http_response_code(404);
    echo json_encode(["erro" => "Obra não encontrada"]);
}
?>
