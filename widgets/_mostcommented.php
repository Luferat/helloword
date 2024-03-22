<?php

/**
 *********** Atividade 1 ***********
 * Total a ser exibido, por default '3'
 * Para alterar este valor, no código principal, defina $num_list antes de 
 * fazer o require() deste código.
 **/
$num_list = isset($num_list) ? intval($num_list) : 3;

$output = '';

// Obtém uma lista de artigos mais comentados no site
// Referências: https://www.w3schools.com/mysql/mysql_groupby.asp
$sql = <<<SQL

SELECT 
    -- ID do artigo
    cmt_article, 
    -- Conta os registros / comentários
    COUNT(*) AS total_comments,
    -- Dados do artigo
    art_title, art_summary    
FROM comment
    -- Relacionamento entre tabelas comment e article
    INNER JOIN article ON cmt_article = art_id
WHERE 
    -- Requisitos pré estabelecidos
    cmt_status = 'on'
    AND art_status = 'on' 
    AND art_date <= NOW()
-- Agrupa os registros que tem o mesmo cmt_article (ID do artigo)
GROUP BY cmt_article
-- Ordena pelo total de registros / comentários
ORDER BY total_comments DESC
-- Limita os registros
LIMIT {$num_list};

SQL;
$res = $conn->query($sql);

// Se existem artigos:
if ($res->num_rows > 0) :

    $output = '
        <div class="aside_block">
            <h3>+ Comentados</h3>
    ';

    while ($art = $res->fetch_assoc()) :

        $tot = $art['total_comments'] == 1 ? '1 comentário.' : $art['total_comments'] . ' comentários';

        // Monta a view do box
        $output .= aside_box([
            'href' => "view.php?id={$art['cmt_article']}'",
            'title' => $art['art_title'],
            'body' => $art['art_summary'],
            'footer' => $tot
        ]);

    endwhile;

    $output .= '</div>';

endif;

echo $output;
