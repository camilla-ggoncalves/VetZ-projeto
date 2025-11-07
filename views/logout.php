<?php
// logout.php
session_start();

// Destroi todas as variáveis de sessão
$_SESSION = array();

// Se você quiser destruir a sessão completamente, descomente as linhas abaixo:
// if (ini_get("session.use_cookies")) {
//     $params = session_get_cookie_params();
//     setcookie(session_name(), '', time() - 42000,
//         $params["path"], $params["domain"],
//         $params["secure"], $params["httponly"]
//     );
// }

// Destroi a sessão
session_destroy();

// Redireciona para a página inicial
header('Location: /projeto/vetz/');
exit;
?>