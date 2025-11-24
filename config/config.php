<?php
/**
 * Configuracoes globais do projeto VetZ
 *
 * Este arquivo detecta automaticamente a base URL para funcionar
 * tanto com XAMPP (/projeto/vetz/) quanto com php -S localhost
 */

// Detecta automaticamente a base URL
// Se SCRIPT_NAME contem /projeto/vetz/, usa esse prefixo
// Caso contrario, assume que esta rodando na raiz
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$requestUri = $_SERVER['REQUEST_URI'] ?? '';

// Verifica se esta rodando no XAMPP com o path /projeto/vetz/
if (strpos($scriptName, '/projeto/vetz/') !== false || strpos($requestUri, '/projeto/vetz/') !== false) {
    define('BASE_URL', '/projeto/vetz');
} else {
    // Rodando com php -S localhost:8000 ou similar
    define('BASE_URL', '');
}

// Funcao helper para gerar URLs absolutas
function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

// Funcao helper para redirects
function redirect($path = '') {
    header('Location: ' . url($path));
    exit;
}
