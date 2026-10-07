<?php
/*
 * Configurações do Fólio
 *
 * 1. Faça uma cópia deste arquivo com o nome "config.php"
 * 2. Preencha com os seus dados
 *
 * O config.php está no .gitignore: suas senhas nunca vão para o GitHub.
 */

return [
    // Banco de dados (os valores abaixo são o padrão do XAMPP)
    'db' => [
        'host'    => 'localhost',
        'porta'   => 3306,
        'usuario' => 'root',
        'senha'   => '',
        'banco'   => 'literatura',
    ],

    // E-mail usado no "Fale Conosco" e na recuperação de senha.
    // Para Gmail, crie uma "senha de app": https://myaccount.google.com/apppasswords
    'email' => [
        'host'    => 'smtp.gmail.com',
        'porta'   => 587,
        'usuario' => 'seu-email@gmail.com',
        'senha'   => 'sua-senha-de-app',
        'nome'    => 'Fólio',
        'contato' => 'seu-email@gmail.com', // quem recebe as mensagens do "Fale Conosco"
    ],

    // Endereço público do site, usado no link de recuperação de senha.
    // Deixe vazio para detectar automaticamente.
    // Ex.: 'http://localhost/folio'  ou  'https://meusite.infinityfreeapp.com'
    'url_site' => '',
];
