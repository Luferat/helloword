<?php

// Carrega configurações globais
require("_global.php");

// Configurações desta página
$page = array(
    "title" => "Login / Entrar", // Título desta página
    "css" => "login.css",            // Folha de estilos desta página
    "js" => "login.js",              // JavaScript desta página
);

// Inclui o cabeçalho do documento
require('_header.php');
?>

<article>
    <h2>Login / Entrar</h2>
    <p>Logue-se para ter acesso aos recursos exclusivos. Use sua conta Google.</p>
    <p class="center"><a href="privacy.php">Políticas de privacidade</a></p>
    <p id="authError"></p>
    <p class="center">
        <button type="button" id="btnLogin">
            <i class="fa-brands fa-google fa-fw"></i>
            &nbsp; Login com Google
        </button>
    </p>
</article>

<?php
// Inclui o rodapé do documento
require('_footer.php');
?>