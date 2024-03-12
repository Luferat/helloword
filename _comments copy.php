<hr class="block-divider">

<?php

// Query para obter os comentários
$sql = <<<SQL

SELECT 
	cmt_id, cmt_social_id, cmt_content,
	DATE_FORMAT(cmt_date, "%d/%m/%Y às %H:%i") AS cmt_datebr
FROM `comment` 
WHERE
	cmt_article = '{$id}'
    AND cmt_status = 'on'
ORDER BY cmt_date DESC;

SQL;

// Executa a query
$res = $conn->query($sql);

// Total de registros obtidos
$total_comments = $res->num_rows;

// Formata título da seção
if ($total_comments == 0)
    echo '<h2>Comentários</h2>';
elseif ($total_comments == 1)
    echo '<h2>1 comentário</h2>';
else
    echo "<h2>{$total_comments} comentários</h2>";

?>

<div id="notLogged">
    <p><a href="login.php">Logue-se</a> para comentar.</p>
</div>

<div id="isLogged">
    <form action="" method="post">
        <p>
            <textarea name="comment" id="comment"></textarea>
            <button type="submit">Enviar</button>
        </p>
    </form>
</div>

<hr class="divider">

<?php

if ($total_comments == 0) :
    echo "<p>Ainda não temos comentários. Seja o(a) primeiro(a) a comentar!</p>";
else :

    $jsData = '<script>jsData = [';
    while ($cmt = $res->fetch_assoc()) :

        echo <<<HTML



<div class="comment-item">
    <img src="" alt="" title="">
    <div class="comment-body">
        <div class="comment-header">
            Por {} em {}.
        </div>
        <div class="comment-text">{}</div>
    </div>
</div>

HTML;

    endwhile;

endif;
?>