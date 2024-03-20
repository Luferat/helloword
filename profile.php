<?php

// Carrega configurações globais
require("_global.php");

// Configurações desta página
$page = array(
    "title" => "Perfil do Usuário",
    "css" => "profile.css",
    "js" => "profile.js"
);

$user_comments = '';

$sql = <<<SQL

SELECT *
FROM comment
WHERE cmt_social_id = 'ID_DO_USUARIO'
ORDER BY cmt_date DESC
LIMIT 5;

SQL;

// Inclui o cabeçalho do documento
require('_header.php');
?>

<article>

    <h2>Olá <span id="userName">usuário</span>!</h2>

    <div id="userCard"></div>

    <p>Sua conta é gerenciada pelo Google. Clique no botão abaixo para acessar seu perfil no Google.</p>

    <p class="center">
        <button type="button" id="btnGoogleProfile">
            <i class="fa-brands fa-google fa-fw"></i>
            Acessar perfil no Google
        </button>
    </p>

    <p>Clique no botão abaixo se quise sair do aplicativo.</p>

    <p class="center">
        <button type="button" id="btnLogout">
        <i class="fa-solid fa-right-from-bracket fa-fw"></i>
            Logout / Sair
        </button>
    </p>

</article>

<aside>
    <?php echo $user_comments ?>
</aside>

<?php
// Inclui o rodapé do documento
require('_footer.php');
?>