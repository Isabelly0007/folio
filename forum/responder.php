<?php
require_once __DIR__ . '/../conexao.php';

exigir_login();

// Pega dados do formulário
$conteudo = trim($_POST['conteudo']);
$topico_id = intval($_POST['topico_id']);
$usuario_id = $_SESSION['usuario_id'];

// Verifica se o conteúdo não está vazio
if (empty($conteudo)) {
    header("Location: ver_topico.php?id=$topico_id&erro=empty");
    exit();
}

// Verifica se o tópico existe
$stmt = $conn->prepare("SELECT id FROM topicos WHERE id = ?");
$stmt->bind_param("i", $topico_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    $stmt->close();
    die("Tópico não encontrado.");
}
$stmt->close();

// Insere a resposta no banco
$stmt = $conn->prepare(
    "INSERT INTO respostas (topico_id, usuario_id, conteudo, data_criacao) 
     VALUES (?, ?, ?, NOW())"
);
$stmt->bind_param("iis", $topico_id, $usuario_id, $conteudo);
$stmt->execute();
$stmt->close();

// Redireciona de volta para o tópico
header("Location: ver_topico.php?id=$topico_id");
exit();
?>
