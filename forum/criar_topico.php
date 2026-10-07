<?php
require_once __DIR__ . '/../conexao.php';

exigir_login();

$usuario_id = $_SESSION['usuario_id'];

// Recebe dados do formulário
$titulo = $_POST['titulo'] ?? '';
$obra = $_POST['obra_relacionada'] ?? '';
$conteudo = $_POST['conteudo'] ?? '';

if (empty($titulo) || empty($conteudo)) {
    die("Erro: título ou conteúdo vazios.");
}

// INSERT SEGURO
$sql = "INSERT INTO topicos (usuario_id, titulo, conteudo, obra_relacionada, data_criacao)
        VALUES (?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $usuario_id, $titulo, $conteudo, $obra);

if ($stmt->execute()) {
    header("Location: forum.php?sucesso=1");
    exit();
} else {
    die("Erro ao criar tópico: " . $stmt->error);
}
?>
