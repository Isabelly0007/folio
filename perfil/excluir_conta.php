<?php
require_once __DIR__ . '/../conexao.php';
$id = exigir_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: perfil.php");
    exit();
}

// Remove tudo o que pertence ao usuário, na ordem certa por causa das chaves estrangeiras
// (funciona mesmo em bancos antigos sem ON DELETE CASCADE)
$conn->begin_transaction();
try {
    $comandos = [
        "DELETE FROM votos_topicos WHERE usuario_id = ?",
        "DELETE FROM votos_topicos WHERE topico_id IN (SELECT id FROM topicos WHERE usuario_id = ?)",
        "DELETE FROM respostas WHERE topico_id IN (SELECT id FROM topicos WHERE usuario_id = ?)",
        "DELETE FROM respostas WHERE usuario_id = ?",
        "DELETE FROM topicos WHERE usuario_id = ?",
        "DELETE FROM usuarios WHERE id = ?",
    ];
    foreach ($comandos as $sql) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    $conn->commit();
} catch (mysqli_sql_exception $e) {
    $conn->rollback();
    error_log("Erro ao excluir conta: " . $e->getMessage());
    header("Location: perfil.php?status=erro");
    exit();
}

// Finaliza a sessão
session_unset();
session_destroy();

header("Location: ../inicial/inicio.html");
exit();
