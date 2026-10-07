<?php
// Página de entrada: quem já está logado vai para a Home, os demais para o login/cadastro
session_start();
header('Location: ' . (isset($_SESSION['usuario_id']) ? 'carta/carta.html' : 'inicial/inicio.html'));
exit;
