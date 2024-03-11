<?php

/**
 * Exibe uma lista de ícones de redes sociais
 * A lista está cadastrada em $site['social_list'] no arquivo
 * de configuração global (_global.php).
 * As folhas de estilo estão em 'assets/css/global.css'.
 **/

?>
<div class="social-side">
    <?php foreach ($site['social_list'] as $item) : ?>
        <a class="col" href="<?php echo $item['link'] ?>" target="_blank" title="<?php echo $item['name'] ?>">
            <i class="<?php echo $item['icon'] ?>" style="color: <?php echo $item['color'] ?>"></i>
        </a>
    <?php endforeach ?>
</div>