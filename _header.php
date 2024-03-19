<?php

/**
 * Testa se solicitou a inclusão dos arquivos ".css" e ".js" desta página
 * Isso torna desnecessário criar arquivos .css e/ou .js vazios para as páginas que não precisam dele(s)
 **/

// Inicializa sem tags para CSS e JS.
$_css = $_js = '';

// Se existe referência a um arquivo .css em $page[]:
if (isset($page['css']))
    // Cria a tag que carrega a folha de estilos referenciada
    $_css = '<link rel="stylesheet" href="assets/css/' . $page["css"] . '">' . "\n";

// Se existe referência a um arquivo .js em $page[]:
if (isset($page['js']))
    // Cria a tag que carrega o JavaScript referenciado
    $_js = '<script src="assets/js/' . $page["js"] . '"></script>' . "\n";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php // Define a localização da raiz do site em relação ao servidor Web e ao domínio
    ?>
    <base href="./">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php // Carrega folhas de stilo do tema 
    ?>
    <link rel="stylesheet" href="assets/css/global.css">
    <?php
    // Tag de carga da folha de estilos da página atual, gerado dinâmicamente 
    echo $_css;
    ?>
    <?php // Ícone de favoritos usado na guia e atalhos 
    ?>
    <link rel="shortcut icon" href="assets/img/logo02.png">
    <?php // Título da página, inicializado em $page[] ou gerado dinâmicamente 
    ?>
    <title><?php echo $site['sitename'] . ' .:. ' . $page["title"] ?></title>
</head>

<body>

    <?php // "#wrap" é necessário para limitar e centralizar conteúdo da página e para o "sticky footer" 
    ?>
    <div id="wrap">

        <header>

            <div class="header-logo-title">

                <?php // Logotipo do site com link para a página inicial 
                ?>
                <a href="index.php" title="Página inicial">
                    <?php // O logotipo é carregado de forma dinâmica 
                    ?>
                    <img src="assets/img/<?php echo $site["logo"] ?>" alt="Logotipo de <?php echo $site["sitename"] ?>">
                </a>

                <?php // Título e slogan da página que são "montados" dinâmicamente 
                ?>
                <div class="header-title">
                    <h1><?php echo $site["title"] ?></h1>
                    <small><?php echo $site["slogan"] ?></small>
                </div>

            </div>

            <?php // Formulário de Buscas 
            ?>
            <div class="header-search">
                <form action="search.php" method="get">
                    <input type="search" name="q" id="search" placeholder="Procurar...">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass fa-fw fa-flip-horizontal"></i></button>
                </form>
            </div>

        </header>

        <?php // Menu Principal 
        ?>
        <nav>

            <a href="index.php" title="Página inicial">
                <i class="fa-solid fa-house fa-fw"></i>
                <span>Início</span>
            </a>

            <a href="contacts.php" title="Faça Contato">
                <i class="fa-solid fa-comment fa-fw"></i>
                <span>Contatos</span>
            </a>

            <a href="about.php" title="Sobre agente">
                <i class="fa-solid fa-circle-info fa-fw"></i>
                <span>Sobre</span>
            </a>

            <?php // Botão de interação do perfil do usuário, modificado pelo JavaScript 
            ?>
            <a id="userAccess" href="login.php" title="Logue-se">
                <img id="userImg" src="assets/img/logo02.png" alt="Login de usuário" referrerpolicy="no-referrer">
                <i id="userIcon" class="fa-solid fa-right-to-bracket fa-fw"></i>
                <span id="userLabel"></span>
            </a>

        </nav>

        <main>