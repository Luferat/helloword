<?php

// Carrega configurações globais
require("_global.php");

// Configurações desta página
$page = array(
    "title" => "Erro 404",
    "css" => "404.css"
);

// Inclui o cabeçalho do documento
require('_header.php');
?>

<article>
    <h2>Oooops!</h2>
    <img src="assets/img/404.png" alt="Erro 404">
    <p>O conteúdo que você está tentando acessar não existe ou está indisponível.</p>
    <p>Use o menu de navegação para acessar alguma coisa.</p>
</article>

<aside>
    <?php
    $num_list = 2;
    require('widgets/_mostviewed.php');
    ?>
</aside>

<?php
// Inclui o rodapé do documento
require('_footer.php');
?>