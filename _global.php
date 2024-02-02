<?php
/*
Define a tabela de caracteres para UTF-8
Evita problemas de acentuação
*/
header("Content-type: text/html; charset=utf-8");

// Configurações globais do site
$site = [
    "sitename" => "Olá Mundo",              // Usado na tag <title>
    "title" => "Olá Mundo",                 // Usado na tag <header>
    "slogan" => "De volta às fronteiras",   // Usado na tag <header>
    "logo" => "logo01.png"                  // Usado na tag <header>
];