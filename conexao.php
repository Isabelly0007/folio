<?php
/*
 * Conexão centralizada com o banco de dados.
 * Todas as páginas usam:  require_once __DIR__ . '/../conexao.php';
 * Os dados de acesso ficam em config.php (veja config.example.php).
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function config(): array
{
    static $config = null;
    if ($config === null) {
        $arquivo = __DIR__ . '/config.php';
        if (!file_exists($arquivo)) {
            http_response_code(500);
            die('Arquivo config.php não encontrado. Copie config.example.php para config.php e preencha seus dados.');
        }
        $config = require $arquivo;
    }
    return $config;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $db = config()['db'];
    $conn = new mysqli($db['host'], $db['usuario'], $db['senha'], $db['banco'], (int) ($db['porta'] ?? 3306));
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log('Erro de conexão com o banco: ' . $e->getMessage());
    http_response_code(500);
    die('Não foi possível conectar ao banco de dados. Verifique se o MySQL está ligado e se o config.php está correto.');
}

/** Exige usuário logado; caso contrário, volta para a tela inicial (login). */
function exigir_login(): int
{
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ../inicial/inicio.html');
        exit();
    }
    return (int) $_SESSION['usuario_id'];
}

/** Fotos de perfil que o usuário pode escolher. */
const FOTOS_PERFIL = [
    '../perfil/img/foto1.jpeg',
    '../perfil/img/foto2.jpeg',
    '../perfil/img/foto3.jpeg',
    '../perfil/img/foto4.jpeg',
];

/** Foto do usuário, ou a imagem padrão se ele ainda não escolheu uma. */
function foto_perfil(?string $foto): string
{
    return in_array($foto, FOTOS_PERFIL, true) ? $foto : '../perfil/img/padrao.svg';
}
