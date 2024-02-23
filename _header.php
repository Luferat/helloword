<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php // Insere o link das folhas de stilo do tema ?>
    <link rel="stylesheet" href="assets/css/global.css">
    <?php // Link da folha de estilos da página atual gerado dinâmicamente ?>
    <link rel="stylesheet" href="assets/css/<?php echo $page["css"] ?>">
    <?php // Ícone de favoritos usado na guia e atalhos ?>
    <link rel="shortcut icon" href="assets/img/logo02.png">
    <?php // Título da página, gerado dinâmicamente ?>
    <title>Hello Word - <?php echo $page["title"] ?></title>
</head>

<body>

    <div id="wrap">

        <header>

            <div class="header-logo-title">

                <?php // Logotipo do site com link para a página inicial ?>
                <a href="index.php" title="Página inicial">
                    <?php // O logotipo é carregado de forma dinâmica ?>
                    <img src="assets/img/<?php echo $site["logo"] ?>" alt="Logotipo de <?php echo $site["sitename"] ?>">
                </a>

                <?php // Título e slogan da página que são "montados" dinâmicamente ?>
                <div class="header-title">
                    <h1><?php echo $site["title"] ?></h1>
                    <small><?php echo $site["slogan"] ?></small>
                </div>

            </div>

            <?php // Formulário de Buscas (ainda não funcional) ?>
            <div class="header-search">
                <form action="" method="get">
                    <input type="search" name="q" id="search" placeholder="Procurar...">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass fa-fw"></i></button>
                </form>
            </div>

        </header>

        <?php // Menu Principal ?>
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

        </nav>

        <main>