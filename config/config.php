<?php
/**
 * Configuracoes globais do projeto VetZ
 *
 * Este arquivo detecta automaticamente a base URL para funcionar
 * tanto com XAMPP (/projeto/vetz/) quanto com php -S localhost
 */

// Detecta automaticamente a base URL
// Extrai o caminho base do diretorio do script
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$requestUri = $_SERVER['REQUEST_URI'] ?? '';

// Detecta o diretorio base automaticamente
// Ex: /VetZ-projeto/public/index.php -> /VetZ-projeto
if (preg_match('#^(/[^/]+)/#', $scriptName, $matches)) {
    $baseDir = $matches[1];
    // Verifica se nao esta na raiz do htdocs
    if ($baseDir !== '/index.php' && $baseDir !== '/public') {
        define('BASE_URL', $baseDir);
    } else {
        define('BASE_URL', '');
    }
} else {
    // Rodando com php -S localhost:8000 ou similar (sem subdiretorio)
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
