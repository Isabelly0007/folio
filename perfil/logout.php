<?php
session_start();

// Destroi a sessão
session_unset();
session_destroy();

// Desativa o cache da página
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redireciona para a página inicial (pública)
header("location: ../inicial/inicio.html");
exit();
?>
