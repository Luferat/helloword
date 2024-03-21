<?php

/**
 * Total a ser exibido, por default '3'
 * Para alterar este valor, no código principal, defina $num_list antes de 
 * fazer o require() deste código.
 **/ 
$num_list = (isset($num_list)) ? intval($num_list) : 3;

// Obtém uma lista de artigos mais visualizados no site
$sql = <<<SQL

SELECT 
    art_id, art_title, art_summary
FROM article
WHERE 
    art_status = 'on'
    AND art_date <= NOW()
ORDER BY art_views
LIMIT {$num_list};

SQL;

// Executa a query e armazena os resultados em '$res'
$res = $conn->query($sql);

// Variável acumuladora. Armazena cada um dos artigos.
$aside_viewed = '<h3>Artigos + vistos</h3><div class="viewed">';

// Loop para obter cada registro
while ($mv = $res->fetch_assoc()) :

    // Cria uma variável '$art_summary' para o resumo
    $art_summary = $mv['art_summary'];

    /**
     * Opcional
     * Se o resumo tem mais de X caracteres, onde X é definido em _config.php,
     * na variável $site['summary_length'].
     * Para usar, logo abaixo, no bloco HTML, troque:
     *      <small title="{$mv['art_summary']}">{$mv['art_summary']}</small>
     * por
     *      <small title="{$mv['art_summary']}">{$art_summary}</small>
     *                                           ^^^^^^^^^^^^   
     * Referências: https://www.w3schools.com/php/func_string_strlen.asp
     **/
    if (strlen($mv['art_summary']) > $site['summary_length'])

        /**
         * Corta o resumo para a quantidade de caracteres correta
         * Referências: https://www.php.net/mb_substr
         **/
        $art_summary = mb_substr(
            $mv['art_summary'],         // String completa, a ser cortada
            0,                          // Posição do primeiro caracter do corte
            $site['summary_length']     // Tamanho do corte
        ) . "...";                      // Concatena reticências no final

    // Monta a view HTML
    $aside_viewed .= <<<HTML

<div onclick="location.href = 'view.php?id={$mv['art_id']}'">
    <h5>{$mv['art_title']}</h5>
    <p><small title="{$mv['art_summary']}">{$mv['art_summary']}</small></p>
</div>

HTML;
endwhile;

$aside_viewed .= '</div>';

// Envia para a view
echo $aside_viewed;
