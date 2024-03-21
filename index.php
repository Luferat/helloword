<?php

// Carrega configurações globais
require("_global.php");

// Configurações desta página
$page = array(
    "title" => $site['slogan'], // Título desta página
    "css" => "index.css", // Folha de estilos desta página
);

/**
 * Listar os artigos do banco de dados
 * Regras / parâmetros:
 *  • Ordenados pela data de publicação com os mais recentes primeiro
 *  • Obter somente artigos no passado e presente
 *      • Não obter artigos agendados para o futuro
 *  • Obter somente artigos com status = 'on'
 *  • Obter os campos id, thumbnail, title, summary
 **/
$sql = <<<SQL

SELECT
-- Obter os campos id, thumbnail, title, summary
	art_id, art_date, art_thumbnail, art_title, art_summary
FROM article

-- Obter somente artigos no passado e presente
-- Não obter artigos agendados para o futuro
	WHERE art_date <= NOW()	  	
        
-- Obter somente artigos com status = 'on'
		AND art_status = 'on'        	

-- Ordenados pela data de publicação com os mais recentes primeiro
	ORDER BY art_date DESC;

SQL;

//  Executa o SQL e armazena os resultados em $res
$res = $conn->query($sql);

// Conta os registros e armazena em $total
$total = $res->num_rows;

// Variável que contém a lista de artigos em HTML e título
$articles = '';

// Se não tem artigos, exibe um aviso
if ($total == 0) :
    $articles = "<h2>Artigos recentes</h2><p>Não achei nada!</p>";
else :

    // Título
    if ($total == 1) $articles = '<h2>Artigo mais recente</h2>';
    else $articles = "<h2>{$total} artigos mais recentes</h2>";

    // Loop para obter cada artigo
    while ($art = $res->fetch_assoc()) :

        $articles .= <<<HTML

<div class="article" onclick="location.href = 'view.php?id={$art['art_id']}'">
    <img src="{$art['art_thumbnail']}" alt="{$art['art_title']}">
    <div>
        <h4>{$art['art_title']}</h4>
        <p>{$art['art_summary']}</p>
    </div>
</div>

HTML;

    endwhile;

endif;

// Inclui o cabeçalho do documento
require('_header.php');
?>

<article>
    <?php echo $articles ?>
</article>

<aside>
    <?php 
    // Mostra os artigos mais visualizados
    require('widgets/_mostviewed.php');
    
    // Atividade 1) Mostra os artigos mais comentados
    require('widgets/_mostcommented.php');
    ?>
</aside> 

<?php require('_footer.php') ?>