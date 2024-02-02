<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Insere o link das folhas de stilo do tema -->
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/<?php echo $page["css"] ?>">
    <title>Hello Word - <?php echo $page["title"] ?></title>
</head>

<body>

    <div id="wrap">

        <header>

            <div class="header-logo-title">

                <a href="index.php" title="Página inicial">
                    <img src="assets/img/<?php echo $site["logo"] ?>" alt="Logotipo de <?php echo $site["sitename"] ?>">
                </a>

                <!-- Título Exemplo 1 -->
                <div class="header-title">
                    <h1><?php echo $site["title"] ?></h1>
                    <small><?php echo $site["slogan"] ?></small>
                </div>

            </div>

            <!-- Título Exemplo 2 -->
            <!--
            <h1>
                Hello World
                <small>Lendo e Aprendendo.</small>
            </h1>
            -->

            <!-- Formulário de Buscas -->
            <div class="header-search">
                <form action="" method="get">
                    <input type="search" name="q" id="search" placeholder="Procurar...">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass fa-fw"></i></button>
                </form>
            </div>

        </header>

        <!-- Menu Principal -->
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