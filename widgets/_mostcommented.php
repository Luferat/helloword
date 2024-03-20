<?php

// Total a ser exibido, por default '3'
$num_list = (isset($num_list)) ? $num_list : 3;

// Inicializa view
$html_view = '';

// Obtém uma lista de artigos mais visualizados no site
$sql = <<<SQL

SELECT 
    cmt_article, 
    COUNT(*) AS total_comments,
    art_title, art_summary    
FROM comment
    INNER JOIN article ON cmt_article = art_id
WHERE cmt_status = 'on'
GROUP BY cmt_article
ORDER BY total_comments DESC
LIMIT {$num_list};

SQL;

$res = $conn->query($sql);

if ($res->num_rows > 0) :

    $html_view = '<h3>+ Comentados</h3>';

    while ($art = $res->fetch_assoc()) :

        if ($art['total_comments'] == 1)
            $tot = '1 comentário.';
        else
            $tot = $art['total_comments'] . ' comentários';

        $html_view .= <<<HTML

<div onclick="location.href = 'view.php?id={$art['cmt_article']}'">
    <h5>{$art['art_title']}</h5>
    <p><small>{$art['art_summary']}</small></p>
    <p class="commented"><small>{$tot}</small></p>
</div>

HTML;

    endwhile;

endif;

?>

<div class="viewed">
    <?php echo $html_view ?>
</div>