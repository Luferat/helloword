<?php

/**
 * Obtém todos os comentários de um artigo no formato JSON
 * para ser processado pelo JavaScript no frone-end.
 */

// Carrega configurações globais
require("_global.php");

// Redefine o cabeçalho Content-Type para JSON e UTF-8
header('Content-Type: application/json; charset=utf-8');

/**
 * Constante de formatação do JSON
 * JSON_UNESCAPED_UNICODE → Formata acentos e caracteres especiais
 * JSON_PRETTY_PRINT → JSON mais legível "para humanos"
 **/
define('FORMAT',  JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// Recupeda o id do artigo da URL de requisição
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Se não forneceu um id válido, conclui com uma mensagem de erro
if ($id == 0) {
    exit(json_encode([
        "status" => "error",
        "message" => "Id inválido"
    ], FORMAT));
}

// Query para obter os comentários
$sql = <<<SQL

SELECT 
	cmt_id, cmt_date, cmt_social_id, cmt_content
FROM `comment` 
WHERE
	cmt_article = '{$id}'
    AND cmt_status = 'on'
ORDER BY cmt_date DESC;

SQL;

// Executa a query
$res = $conn->query($sql);

// Array para armazenar os resultados
$response = array();

// Verifica se há resultados
if ($res->num_rows > 0) {

    // Array para armazenar os resultados da consulta
    $rows = array();

    // Loop através dos resultados da consulta
    while ($row = $res->fetch_assoc()) {
        // Adiciona cada linha ao array
        $rows[] = $row;
    }

    // Adiciona o total de resultados ao array de resposta
    $response['total_results'] = count($rows);

    // Adiciona os resultados da consulta ao array de resposta
    $response['data'] = $rows;
} else {
    // Se não houver resultados, define o total de resultados como 0
    $response['total_results'] = 0;
}

// Define o status da resposta como "success"
$response['status'] = "success";

// Converte o array para JSON formatado e exibe
echo json_encode($response, FORMAT);

// Fecha a conexão com o banco de dados
$conn->close();
