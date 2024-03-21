<?php

// Carrega configurações globais
require("_global.php");

// Configurações desta página
$page = array(
    "title" => "Procurando...",
    "css" => "index.css",
    "js" => "search.js",
);

// Recebe e sanitiza a query string da URL
$query = isset($_GET['q']) ? trim(htmlentities(strip_tags($_GET['q']))) : '';

// Inicializa a view
$search_results = '';

// Inicializa contador
$total = 0;

// Template do formulário
$search_form = <<<HTML

<div class="page-search">
    <form action="search.php" method="get" onsubmit="return formSearchValidate('searchField')">
        <input type="search" name="q" id="searchField" placeholder="Procurar..." value="{$query}">
        <button type="submit"><i class="fa-solid fa-magnifying-glass fa-fw fa-flip-horizontal"></i></button>
    </form>
</div>

HTML;

// 
if ($query == '') :

    $search_results = <<<HTML

<h2>Procurar no site</h2>
{$search_form}
<p>Digite algo para pesquisar!</p>

HTML;

else :

    // Consulta preparada
    $sql = <<<SQL

SELECT 
	art_id, art_thumbnail, art_title, art_summary
FROM article 
WHERE
	art_date <= NOW()
    AND art_status = 'on'
    AND (
        art_title LIKE ?
        OR art_summary LIKE ?
        OR art_content LIKE ?
    )
ORDER BY art_date DESC;

SQL;

    $stmt = $conn->prepare($sql);

    // Verifica se a preparação da consulta teve sucesso
    if ($stmt === false) {
        header('Location: 404.php');
    }

    // Define o parâmetro para a consulta LIKE
    $search_term = "%{$query}%";

    // Bind dos parâmetros
    $stmt->bind_param(
        'sss',
        $search_term,
        $search_term,
        $search_term
    );

    // Executa a consulta
    $stmt->execute();

    // Obtém o resultado da consulta
    $res = $stmt->get_result();

    // Total de resultados
    $total = $res->num_rows;

    // Verifica se há resultados
    if ($total > 0) {

        if ($total == 1) $total_string = "<small class=\"search-small\">1 resultado</small>";
        else $total_string = "<small class=\"search-small\">{$total} resultados</small>";

        $search_results = <<<HTML

<h2>Procurando por "{$query}"</h2>
{$search_form}
{$total_string}

HTML;

        // Exibe os dados encontrados
        while ($art = $res->fetch_assoc()) {

            $search_results .= <<<HTML

<div class="article" onclick="location.href = 'view.php?id={$art['art_id']}'">
    <img src="{$art['art_thumbnail']}" alt="{$art['art_title']}">
    <div>
        <h4>{$art['art_title']}</h4>
        <p>{$art['art_summary']}</p>
    </div>
</div>

HTML;
        }
    } else {
        $search_results .= <<<HTML

<h2>Procurar no site</h2>
{$search_form}
<p class="center">Nenhum resultado encontrado.</p>

HTML;
    }

endif;

// Inclui o cabeçalho do documento
require('_header.php');
?>

<article>
    <?php echo $search_results ?>
</article>

<aside>
    <?php
    require('widgets/_mostviewed.php');

    if ($total > 4) require('widgets/_mostcommented.php');
    ?>
</aside>

<?php
// Inclui o rodapé do documento
require('_footer.php');
?>