<?php
/**
 * Router para o servidor PHP embutido (php -S)
 *
 * Uso: php -S localhost:8000 router.php
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Se o arquivo existe fisicamente, serve ele diretamente (CSS, JS, imagens)
$filePath = __DIR__ . $uri;
if ($uri !== '/' && file_exists($filePath) && is_file($filePath)) {
    // Retorna false para que o servidor PHP sirva o arquivo estatico
    return false;
}

// Caso contrario, redireciona para o router principal
require_once __DIR__ . '/public/index.php';
