<?php

// Carrega configurações globais
require("_global.php");

// Configurações desta página
$page = array(
    "title" => "perfil de usuário",
    "css" => "profile.css",
    "js" => "profile.js",
);

// Inclui o cabeçalho do documento
require('_header.php');
?>

<article>
    <h2>Olá <strong id="userName">usuário</strong>!</h2>
    <p>Sua conta é gerenciada pelo Google, que nos fornece apenas alguns dados públicos sobre você.</p>
    <p>Para gerenciar sua conta, trocar sua senha ou sua imagem, clique no botão abaixo:</p>
    <p class="center">
        <button type="button" id="btnProfile">
            <i class="fa-brands fa-google fa-fw"></i>
            &nbsp; Gerenciar conta Google
        </button>
    </p>
    <p>Caso queira fazer logout do aplicativo neste dispositivo, clique no botão abaixo:</p>
    <p id="authError"></p>
    <p class="center">
        <button type="button" id="btnLogout">
            <i class="fa-brands fa-google fa-fw"></i>
            &nbsp; Sair do aplicativo
        </button>
    </p>
</article>

<aside>
    <h3>Para você</h3>
</aside>

<?php
// Inclui o rodapé do documento
require('_footer.php');
?>