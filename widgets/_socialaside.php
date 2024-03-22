<?php

/**
 * Exibe uma lista de ícones de redes sociais na <aside>
 * A lista está cadastrada em $site['social_list'] no arquivo
 * de configuração global (_global.php).
 * As folhas de estilo estão em 'assets/css/global.css'.
 **/

/**
 * Se $show_contact for true, exibe o link da página de contatos no final
 * Defina o valor de $show_contact antes de fazer o require do widget
 * Default: false
 **/
$show_contact = isset($show_contact) ? $show_contact : false;

// Inicializa View
$aside_social = <<<HTML

<h3>+ Contatos</h3>
<p>Você também pode entrar em contato ou saber mais pelas nossas redes sociais:</p>
<div class="social-side">

HTML;

// Itera $site['social_list'] que está definida em _global.php
foreach ($site['social_list'] as $item) {

    $aside_social .= <<<HTML

        <a href="{$item['link']}" target="_blank" title="{$item['name']}">
            <i class="{$item['icon']}" style="color: {$item['color']}"></i>
        </a>

    HTML;
}

if ($show_contact) :

    $aside_social .= <<<HTML

        <a href="contacts.php" title="Faça contato">
            <i class="fa-solid fa-square-envelope fa-fw" style="color: #888"></i>    
        </a>

    HTML;

endif;

$aside_social .= '</div>';

echo $aside_social;
