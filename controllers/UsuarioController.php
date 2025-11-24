<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {

    public function loginForm() {
        include __DIR__ . '/../views/login.php';
    }

    public function cadastrarForm() {
        include __DIR__ . '/../views/cadastro.php';
    }

    public function cadastrar() {
        $dados = $_POST;
        $model = new Usuario();
        $ok = $model->cadastrar($dados['nome'], $dados['email'], $dados['senha']);

        if ($ok) {
            redirect('/loginForm');
        } else {
            echo "Erro ao cadastrar.";
        }
    }

   public function login() {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $senha = isset($_POST['senha']) ? $_POST['senha'] : null;

    if (!$email || !$senha) {
        echo "Por favor, preencha email e senha.";
        return;
    }

    $model = new Usuario();
    $usuario = $model->autenticar($email, $senha);

    if ($usuario) {
        session_start();
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nome'];
        $_SESSION['user_email'] = $usuario['email']; // ADICIONE ESTA LINHA
        
        // Redireciona para homepage apos login
        redirect('/homepage');
    } else {
        $_SESSION['erro'] = "Credenciais invalidas.";
        include __DIR__ . '/../views/login.php';
    }
}

    public function enviarCodigo() {
        $email = $_POST['email'];
        $codigo = rand(100000, 999999);

        $usuario = new Usuario();
        $usuario->salvarCodigo($email, $codigo);

        echo $codigo; 
        exit;
    }

    public function verificarCodigo() {
        $email = $_POST['email'];
        $codigo = $_POST['codigo'];
        $novaSenha = $_POST['nova_senha'];

        $model = new Usuario();
        $valido = $model->verificarCodigo($email, $codigo);

        if ($valido) {
            $model->redefinirSenha($email, $novaSenha);
            echo "Senha alterada com sucesso!";
        } else {
            echo "Código inválido ou expirado.";
        }
    }

    public function redefinirSenha() {
        $email = $_POST['email'];
        $novaSenha = $_POST['nova_senha'];

        $model = new Usuario();
        $ok = $model->redefinirSenha($email, $novaSenha);

        echo $ok ? "Senha alterada com sucesso!" : "Erro ao alterar senha.";
    }

    public function perfil($id) {
        $usuarioModel = new Usuario();
        return $usuarioModel->buscarPorId($id);
    }

    public function atualizar($dados, $file) {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            redirect('/loginForm');
            exit;
        }

        $usuarioModel = new Usuario();
        $imagem = null;

        // Verificar se o usuario quer remover a imagem
        if (isset($dados['remover_imagem']) && $dados['remover_imagem'] === '1') {
            // Buscar imagem atual para deletar
            $usuarioAtual = $usuarioModel->buscarPorId($dados['id']);
            if ($usuarioAtual && !empty($usuarioAtual['imagem'])) {
                $caminhoImagem = __DIR__ . '/../uploads/' . $usuarioAtual['imagem'];
                if (file_exists($caminhoImagem)) {
                    unlink($caminhoImagem);
                }
            }
            $imagem = ''; // Define como vazio para remover do banco
        } elseif (isset($file['imagem']) && $file['imagem']['error'] === UPLOAD_ERR_OK) {
            // Upload de nova imagem
            $nomeOriginal = $file['imagem']['name'];
            $extensao = pathinfo($nomeOriginal, PATHINFO_EXTENSION);
            $imagem = uniqid() . '.' . $extensao;

            // Deletar imagem antiga se existir
            $usuarioAtual = $usuarioModel->buscarPorId($dados['id']);
            if ($usuarioAtual && !empty($usuarioAtual['imagem'])) {
                $caminhoImagem = __DIR__ . '/../uploads/' . $usuarioAtual['imagem'];
                if (file_exists($caminhoImagem)) {
                    unlink($caminhoImagem);
                }
            }

            move_uploaded_file($file['imagem']['tmp_name'], __DIR__ . '/../uploads/' . $imagem);
        }

        $senha = !empty($dados['senha']) ? $dados['senha'] : null;
        $telefone = !empty($dados['telefone']) ? $dados['telefone'] : null;
        $endereco = !empty($dados['endereco']) ? $dados['endereco'] : null;
        $nascimento = !empty($dados['nascimento']) ? $dados['nascimento'] : null;

        $resultado = $usuarioModel->atualizar(
            $dados['id'],
            $dados['nome'],
            $dados['email'],
            $senha,
            $imagem,
            $telefone,
            $endereco,
            $nascimento
        );

        if ($resultado) {
            $_SESSION['user_name'] = $dados['nome'];
            $_SESSION['user_email'] = $dados['email'];
            redirect('/perfil-usuario');
        } else {
            echo "Erro ao atualizar perfil.";
        }
    }

    public function excluir($id) {
        $usuarioModel = new Usuario();
        return $usuarioModel->excluir($id);
    }

    public function perfilUsuario() {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        redirect('/loginForm');
    }

    $id = $_SESSION['user_id'];

    $usuarioModel = new Usuario();
    $usuario = $usuarioModel->buscarPorId($id);

    if (!$usuario) {
        echo "Usuário não encontrado.";
        return;
    }

    include __DIR__ . '/../views/perfil_usuario.php';
}

    public function editarForm($id) {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            redirect('/loginForm');
            exit;
        }

        if ($_SESSION['user_id'] != $id) {
            echo "Você não tem permissão para editar este perfil.";
            exit;
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->buscarPorId($id);

        if (!$usuario) {
            echo "Usuário não encontrado.";
            exit;
        }

        include __DIR__ . '/../views/update_usuario.php';
    }

}
