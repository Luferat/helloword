<?php

// Recebe o novo comentário
$new_comment = isset($_POST['comment']) ? trim(htmlentities($_POST['comment'])) : '';

// Chegou um novo comentário
if ($new_comment != '') :

    // Recupera e sanitiza dados do comentarista
    $new_socialid = trim(htmlentities($_POST['social_id']));
    $new_social_name = trim(htmlentities($_POST['social_name']));
    $new_social_photo = trim(filter_input(INPUT_POST, "social_photo", FILTER_SANITIZE_URL));
    $new_social_email = trim(filter_input(INPUT_POST, "social_email", FILTER_SANITIZE_EMAIL));

    // Se os campos necessários foram preenchidos:
    if (
        $new_comment != ''
        && $new_social_name != ''
        && $new_social_photo != ''
    ) :

        // Query de insersão
        $sql = <<<SQL

INSERT INTO comment (
    cmt_article,
    cmt_social_id,
    cmt_social_name,
    cmt_social_photo,
    cmt_social_email,
    cmt_content
) VALUES (?, ?, ?, ?, ?, ?);

SQL;

        // Prepara o comando SQL para o banco de dados
        $stmt = $conn->prepare($sql);

        // Envia os dados para o banco
        $stmt->bind_param(
            "ssssss",
            $id,
            $new_socialid,
            $new_social_name,
            $new_social_photo,
            $new_social_email,
            $new_comment
        );

        // Executa o prepared
        $stmt->execute();

    endif;

endif;

// Query que recebe todos os comentários do artigo atual
$sql = <<<SQL

SELECT 
cmt_id, cmt_social_name, cmt_social_photo, cmt_content,
DATE_FORMAT(cmt_date, "%d/%m/%Y às %H:%i") AS cmt_datebr
FROM comment
WHERE
	cmt_article = '{$id}'
    AND cmt_status = 'on'
ORDER BY cmt_date DESC;

SQL;

// Executar
$res = $conn->query($sql);

// Conta o número de comentários
$cmt_total = $res->num_rows;

// Subtítulo conforme o número de comentários.
if ($cmt_total == 0) $view_total = '<h5>Nenhum comentário</h5>';
elseif ($cmt_total == 1) $view_total = '<h5>1 comentário</h5>';
else $view_total = "<h5>{$cmt_total} comentários</h5>";

// Se existem comentários:
if ($cmt_total > 0) :

    // Loop para iterar os comentários
    $comments_view = '';
    while ($cmt = $res->fetch_assoc()) :

        // Sanitiza comentário antes de exibir
        $cmt_content = htmlspecialchars(trim($cmt['cmt_content']));

        $comments_view .= <<<HTML

<div class="cmt_box">
    <div class="cmt_header">
        <img src="{$cmt['cmt_social_photo']}" alt="{$cmt['cmt_social_name']}" referrerpolicy="no-referrer">
        <small>Por {$cmt['cmt_social_name']} em {$cmt['cmt_datebr']}.</small>
    </div>
    <div class="cmt_body">{$cmt_content}</div>
</div>

HTML;

    endwhile;

// Se não existem comentários
else :

    $comments_view = '<p class="center">Seja o(a) primeiro(a) a comentar.</p>';

endif;

?>

<div class="comment_section">
    <h2 id="comment">Comentários</h2>
    <div id="commentBox"></div>
    <?php echo $view_total ?>
    <?php echo html_entity_decode($comments_view) ?>
</div>