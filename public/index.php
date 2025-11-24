<?php
// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/PetController.php';
require_once __DIR__ . '/../controllers/UsuarioController.php';
require_once __DIR__ . '/../controllers/VacinacaoController.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove o BASE_URL do request para normalizar as rotas
// Isso permite que as mesmas rotas funcionem em qualquer ambiente
if (BASE_URL !== '' && strpos($requestUri, BASE_URL) === 0) {
    $request = substr($requestUri, strlen(BASE_URL));
} else {
    $request = $requestUri;
}

// Garante que o request comece com /
if (empty($request) || $request === '') {
    $request = '/';
}
if ($request[0] !== '/') {
    $request = '/' . $request;
}

// ---------------- ROTAS DINAMICAS ------------------

// Editar Pet (formulario GET e atualizacao POST)
if (preg_match('#^/update-pet/(\d+)$#', $request, $matches)) {
    $controller = new PetController();
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller->showUpdateForm($matches[1]);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->updatePet($matches[1]);
    }
    exit;
}

// Excluir Pet
if (preg_match('#^/delete-pet/(\d+)$#', $request, $matches)) {
    (new PetController())->deletePetById($matches[1]);
    exit;
}

// Editar Vacina
if (preg_match('#^/editar-vacina/(\d+)$#', $request, $matches)) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $idUsuario = $_SESSION['user_id'] ?? null;
    $controller = new VacinacaoController($idUsuario);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->editar(
            $matches[1],
            $_POST['data'],
            $_POST['doses'],
            $_POST['id_vacina'],
            $_POST['id_pet'],
            $_POST['proxima_dose'] ?? null
        );
    } else {
        $vacina = $controller->buscarPorId($matches[1]);
        include __DIR__ . '/../views/update_vacinacao.php';
    }
    exit;
}

// Excluir Vacina
if (preg_match('#^/excluir-vacina/(\d+)$#', $request, $matches)) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $idUsuario = $_SESSION['user_id'] ?? null;
    (new VacinacaoController($idUsuario))->excluir($matches[1]);
    exit;
}

// Perfil do Usuario Logado
if ($request === '/perfil-usuario') {
    (new UsuarioController())->perfilUsuario();
    exit;
}

// Atualizar Usuario - Exibir formulario
if (preg_match('#^/update-usuario/(\d+)$#', $request, $matches) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    (new UsuarioController())->editarForm($matches[1]);
    exit;
}

// Atualizar Usuario - Processar POST
if (preg_match('#^/update-usuario/(\d+)$#', $request, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = $_POST;
    $dados['id'] = $matches[1];
    (new UsuarioController())->atualizar($dados, $_FILES);
    exit;
}

// Excluir Pet Vinculado as Vacinacoes
if ($request === '/delete-pet') {
    $controller = new PetController();
    if (isset($_GET['id'])) {
        $controller->deletePetById($_GET['id']);
    } else {
        echo "ID nao fornecido para exclusao.";
    }
    exit;
}

// Carteirinha individual de vacinacao do pet
if (preg_match('#^/vacinacao-pet/(\d+)$#', $request, $matches)) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $idUsuario = $_SESSION['user_id'] ?? null;
    $idPet = $matches[1];

    $controller = new VacinacaoController($idUsuario);
    $controller->vacinacaoPet($idPet);
    exit;
}




// ---------------- ROTAS FIXAS ------------------
switch ($request) {

    // Rota raiz - redireciona para homepage
    case '/':
        include __DIR__ . '/../views/homepage.php';
        break;

    // Guilherme A
    case '/recuperarForm':
        include __DIR__ . '/../views/recuperar.php';
        break;

    case '/cadastrar':
        (new UsuarioController())->cadastrar();
        break;

    case '/cadastrarForm':
        (new UsuarioController())->cadastrarForm();
        break;

    case '/loginForm':
        (new UsuarioController())->loginForm();
        break;

    case '/login':
        (new UsuarioController())->login();
        break;

    case '/logout':
        session_start();
        session_destroy();
        redirect('/');
        break;

    case '/enviarCodigo':
        (new UsuarioController())->enviarCodigo();
        break;

    case '/verificarCodigo':
        (new UsuarioController())->verificarCodigo();
        break;

    case '/redefinirSenha':
        (new UsuarioController())->redefinirSenha();
        break;

    // Camilla chefona
    case '/formulario':
        (new PetController())->showForm();
        break;

    case '/save-pet':
        (new PetController())->savePet();
        break;

    case '/list-pet':
        (new PetController())->listPet();
        break;

    case '/update-pet':
        (new PetController())->updatePet();
        break;

    case '/cadastrar-vacina':
        if (session_status() === PHP_SESSION_NONE) session_start();
        $usuarioId = $_SESSION['user_id'] ?? null;
        (new VacinacaoController($usuarioId))->listVacina();
        break;

    case '/nova-vacina':
        if (session_status() === PHP_SESSION_NONE) session_start();
        $usuarioId = $_SESSION['user_id'] ?? null;
        (new VacinacaoController($usuarioId))->exibirFormulario();
        break;

    case '/salvar-vacina':
        (new VacinacaoController())->cadastrarVacina();
        break;

    case '/list-vacinas':
        if (session_status() === PHP_SESSION_NONE) session_start();
        $usuarioId = $_SESSION['user_id'] ?? null;
        (new VacinacaoController($usuarioId))->listVacina();
        break;

    case '/curiosidades':
        include __DIR__ . '/../views/curiosidades.php';
        break;

    case '/recomendacoes':
        include __DIR__ . '/../views/adocao_pets.php';
        break;

    // Isadora
    case '/perfil-usuario':
        if (!isset($_GET['id'])) {
            echo "ID nao especificado.";
            exit;
        }
        $controller = new UsuarioController();
        $usuario = $controller->perfil($_GET['id']);
        include __DIR__ . '/../views/perfil_usuario.php';
        break;

    case '/excluir-usuario':
        if (!isset($_GET['id'])) {
            echo "ID nao especificado.";
            exit;
        }
        $controller = new UsuarioController();
        $sucesso = $controller->excluir($_GET['id']);
        echo $sucesso ? "Usuario excluido com sucesso." : "Erro ao excluir usuario.";
        break;

    case '/perfil':
        break;

    case '/homepage':
        include __DIR__ . '/../views/homepage.php';
        break;

    case '/sobre-nos':
        include __DIR__ . '/../views/sobre_nos.php';
        break;

    case '/pets-exibir':
        include __DIR__ . '/../views/exibicao_pets.php';
        break;

    case '/pets-perfil':
        include __DIR__ . '/../views/perfil_pet.php';
        break;

    default:
        http_response_code(404);
        echo "Pagina nao encontrada: $request";
        break;
}
