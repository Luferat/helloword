<?php

// Carrega configurações globais
require("_global.php");

// Configurações desta página
$page = array(
    "title" => "Artigo Completo",
    "css" => "view.css",
    "js" => "view.js"
);

// Obter o ID do artigo e armazenar na variável 'id'
// Operador ternário
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Se o ID for inválido redireciona para a página 404.
// Referências: https://www.w3schools.com/php/func_network_header.asp
if ($id < 1) header('Location: 404.php');

// Obtém o artigo do banco de dados
$sql = <<<SQL

SELECT

 	-- Obtém os campos de article necessários
 	art_id, art_title, art_content,
    
    -- Obtém a data formatada para o pseudo-campo art_datebr
    -- Referência: https://www.w3schools.com/sql/func_mysql_date_format.asp
    DATE_FORMAT(art_date, "%d/%m/%Y às %H:%i") AS art_datebr,
    
    -- Obtém os campos de employee necessários
    emp_id, emp_photo, emp_name, emp_type,
    
    -- Obtém a data formatada de cadastro do emplyee para o pseudo-campo emp_datebr
    DATE_FORMAT(emp_date, "%d/%m/%Y") AS emp_datebr,
    
    -- Obtém a idade do employee em anos
    -- Referências: https://www.w3schools.com/sql/func_mysql_timediff.asp
    TIMESTAMPDIFF(YEAR, emp_birth, CURDATE()) AS emp_age 

-- Tabela original
FROM `article`

-- Faz a junção das tabelas 'article' e 'employee'
INNER JOIN `employee` ON art_author = emp_id

-- Regras para obter os dados
WHERE art_id = '{$id}'

	-- A data deve ser menor ou igual a agora
    -- Não obtém artigos agendados para o futuro
	AND art_date <= NOW()
    
    -- O artigo deve estar online
    AND art_status = 'on';

SQL;

// Executa o SQL
$res = $conn->query($sql);

// Se artigo não existe redireciona para a página 404.
if ($res->num_rows == 0) header('Location: 404.php');

// Obtém o artigo e armazena em $art[]
$art = $res->fetch_assoc();

// Gera a view para o usuário
// Atividade 3) → <small class="authordate">
$article = <<<ART

<div class="article">
    <h2>{$art['art_title']}</h2>
    <small class="authordate">Por {$art['emp_name']} em {$art['art_datebr']}.</small>
    <div>{$art['art_content']}</div>
</div>

ART;

// Atualiza as visualizações do artigo
$sql = <<<SQL

UPDATE article 
    SET art_views = art_views + 1 
WHERE art_id = '{$id}';

SQL;
$conn->query($sql);

// Seleciona o tipo de colaborador
switch ($art['emp_type']) {
    case 'admin':
        $emp_type = 'administrador(a)';
        break;
    case 'author':
        $emp_type = 'autor(a)';
        break;
    case 'moderator':
        $emp_type = 'moderador(a)';
        break;
    default:
        $emp_type = 'indefinido(a)';
};

// Monta a view do autor para a <aside>
$aside_author = <<<HTML

<div class="aside-author">
    <img src="{$art['emp_photo']}" alt="{$art['emp_name']}">
    <h4>{$art['emp_name']}</h4>
    <ul>
        <li>{$art['emp_age']} anos</li>    
        <li>Colaborador desde {$art['emp_datebr']} como {$emp_type}.</li>
    </ul>
</div>

HTML;

// Obtém outros artigos do autor
$sql = <<<SQL

-- Seleciona
SELECT
	-- os campos necessários
	art_id, art_title, art_summary, art_views
-- da tabela 'article'    
FROM `article`
-- quando
WHERE 
	-- o id do author é este
	art_author = '{$art['emp_id']}'
    -- não pegar o artigo atual
    AND art_id != '{$art['art_id']}'
    -- data atual ou no passado
    AND art_date <= NOW()
    -- status online
    AND art_status = 'on'
-- ordenados de forma aleatória
-- Referências: https://w3schools.com/sql/func_mysql_rand.asp
ORDER BY RAND()
-- limitado ao máximo de 3 registros
LIMIT 3;

SQL;
$res = $conn->query($sql);

// Atividade 2) Extrai primeiro nome do autor
$afn = explode(' ', $art['emp_name'])[0];

// Atividade 2) Inicializa a view
$aside_articles = <<<HTML
    <div class="aside_block">
        <h4>+ Artigos de {$afn}</h4>    
HTML;

// Loop da view
while ($aart = $res->fetch_assoc()) :

    // Se o resumo tem mais de X caracteres
    // Referências: https://www.w3schools.com/php/func_string_strlen.asp
    if (strlen($aart['art_summary']) > $site['summary_length'])

        // Corta o resumo para a quantidade de caracteres correta
        // Referências: https://www.php.net/mb_substr
        $art_summary = mb_substr(
            $aart['art_summary'],       // String completa, a ser cortada
            0,                          // Posição do primeiro caracter do corte
            $site['summary_length']     // Tamanho do corte
        ) . "...";                      // Concatena reticências no final

    // Contador de visualizações
    if ($aart['art_views'] == 0) $art_views = "Nenhuma visualização";
    elseif ($aart['art_views'] == 1) $art_views = "1 visualização";
    else $art_views = "{$aart['art_views']} visualizações";

    $aside_articles .= <<<HTML

<div onclick="location.href = 'view.php?id={$aart['art_id']}'">
    <h5>{$aart['art_title']}</h5>
    <small title="{$aart['art_summary']}">{$aart['art_summary']}</small>
    <small class="footer">{$art_views}</small>
</div>

HTML;

endwhile;

// Fecha view
$aside_articles .= '</div>';

// O título da página contém o título do artigo
$page['title'] = $art['art_title'];

// Inclui o cabeçalho do documento
require('_header.php');
?>

<article>
    <?php
    echo $article;

    // Inclui o processamento dos comentários
    require('widgets/_comments.php');
    ?>
</article>

<aside>
    <?php
    echo $aside_author; // Dados do autor
    echo $aside_articles; // Artigos do autor
    ?>
</aside>

<?php
// Inclui o rodapé do documento
require('_footer.php');
?>