<?php

/**
 * Protótipo de função em PHP que obtém todos os arquivos CSS de uma pasta,
 * faz o backup de cada um e salva uma nova versão com todos os atributos
 * ordenados alfabeticamente.
 *
 * Para saber mais, acesse https://www.catabits.com.br/devops/ordenando-atributos-css
 **/

function order_css_attributes_in_folder($folder_path) {
    // Verifica se o caminho é uma pasta válida
    if (!is_dir($folder_path)) {
        echo "The specified path is not a valid folder.";
        return;
    }

    // Itera sobre os arquivos na pasta
    $files = glob($folder_path . '/*.css');
    foreach ($files as $file) {
        $content = file_get_contents($file);

        // Salva uma cópia do arquivo original com o sufixo ".original.css"
        $original_file = preg_replace('/\.css$/', '.original.css', $file);
        rename($file, $original_file);

        $regex = '/{([^{}]+)}/s';
        $new_content = preg_replace_callback($regex, function ($match) {
            $attributes = explode(';', $match[1]);
            sort($attributes);
            $attributes = array_map('trim', $attributes);
            return '{ ' . implode(";\n  ", $attributes) . ";\n}";
        }, $content);

        // Remover o ";" após a abertura da chave
        $new_content = preg_replace('/{[\s;]*\n/', "{\n", $new_content);

        // Salva uma cópia do arquivo com os atributos ordenados
        $new_file = $file;
        file_put_contents($new_file, $new_content);
        echo "File '{$new_file}' created successfully.\n";
    }
}

// Exemplo de uso:
order_css_attributes_in_folder('./');

?>
