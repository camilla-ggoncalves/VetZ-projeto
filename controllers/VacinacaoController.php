<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Vacinacao.php';
require_once __DIR__ . '/../models/Pet.php';
require_once __DIR__ . '/../models/Usuario.php';

class VacinacaoController {

    private $usuarioId;

    public function __construct($usuarioId = null) {
        $this->usuarioId = $usuarioId; // id do usuário logado
    }

    // Listar todas as vacinacoes do usuario logado
    public function listVacina() {
        if (!$this->usuarioId) {
            $_SESSION['error_message'] = 'Usuario nao autenticado.';
            redirect('/loginForm');
            return;
        }

        $vacinas = $this->listarVacinasUsuario();
        include __DIR__ . '/../views/vacinacao_list.php';
    }

    // Listar vacinações de um usuário específico
    public function listarVacinasUsuario() {
        if (!$this->usuarioId) return [];

        $petModel = new Pet();
        $vacinacaoModel = new Vacinacao();
        $usuarioModel = new Usuario();

        // Busca nome do tutor
        $tutor = $usuarioModel->buscarPorId($this->usuarioId);
        $nomeTutor = $tutor['nome'] ?? '';

        // Pega todos os pets do usuário
        $pets = $petModel->getPetsByUsuario($this->usuarioId);

        $vacinasUsuario = [];
        foreach ($pets as $pet) {
            $vacinas = $vacinacaoModel->listarPorPet($pet['id']);
            foreach ($vacinas as $v) {
                $v['nome_pet'] = $pet['nome'];
                $v['nome_tutor'] = $nomeTutor;
                $vacinasUsuario[] = $v;
            }
        }

        return $vacinasUsuario;
    }

    // Exibir formulario de cadastro
    public function exibirFormulario() {
        $vacinacaoModel = new Vacinacao();
        $vacinas = $vacinacaoModel->listarVacinas();

        $pets = (new Pet())->getPetsByUsuario($this->usuarioId);
        include __DIR__ . '/../views/vacinacao_form.php';
    }

    // Cadastrar vacinação
    public function cadastrarVacina() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Usuario nao logado.';
            redirect('/loginForm');
        }

        $data_vacinacao = $_POST['data'] ?? '';
        $doses = $_POST['doses'] ?? '';
        $id_vacina = $_POST['id_vacina'] ?? '';
        $id_pet = $_POST['id_pet'] ?? '';

        // Valida campos obrigatorios
        if (empty($data_vacinacao) || empty($doses) || empty($id_vacina) || empty($id_pet)) {
            $_SESSION['error_message'] = 'Preencha todos os campos obrigatorios.';
            redirect('/cadastrar-vacina');
        }

        // Valida que pet pertence ao usuario
        $petModel = new Pet();
        if (!$petModel->pertenceAoUsuario($id_pet, $_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Pet invalido ou nao pertence a este usuario.';
            redirect('/cadastrar-vacina');
        }

        // Valida que vacina existe
        $vacinacaoModel = new Vacinacao();
        if (!$vacinacaoModel->vacinaExiste($id_vacina)) {
            $_SESSION['error_message'] = 'Vacina invalida.';
            redirect('/cadastrar-vacina');
        }

        // Valida data (nao futura)
        if (strtotime($data_vacinacao) > time()) {
            $_SESSION['error_message'] = 'A data da vacinacao nao pode ser futura.';
            redirect('/cadastrar-vacina');
        }

        $proxima_dose = !empty($_POST['proxima_dose']) ? $_POST['proxima_dose'] : null;

        // Insere a vacinacao
        if ($vacinacaoModel->cadastrar($data_vacinacao, $doses, $id_vacina, $id_pet, $proxima_dose)) {
            $_SESSION['success_message'] = 'Vacinacao cadastrada com sucesso!';
            redirect('/vacinacao-pet/' . $id_pet);
        } else {
            $_SESSION['error_message'] = 'Erro ao cadastrar a vacinacao.';
            redirect('/cadastrar-vacina');
        }
    }

    // Editar vacinacao
    public function editar($id, $data, $doses, $id_vacina, $id_pet, $proxima_dose = null) {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Usuario nao autenticado.';
            redirect('/loginForm');
            return;
        }

        // Verificar se a vacinação existe
        $model = new Vacinacao();
        $vacina = $model->buscarPorId($id);

        if (!$vacina) {
            $_SESSION['error_message'] = 'Vacinacao nao encontrada.';
            redirect('/list-vacinas');
            return;
        }

        // Verificar se o pet pertence ao usuário logado
        $petModel = new Pet();
        if (!$petModel->pertenceAoUsuario($id_pet, $_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Voce nao tem permissao para editar esta vacinacao.';
            redirect('/list-vacinas');
            return;
        }

        // Validar que vacina existe
        if (!$model->vacinaExiste($id_vacina)) {
            $_SESSION['error_message'] = 'Vacina invalida.';
            redirect('/vacinacao-pet/' . $id_pet);
            return;
        }

        // Validar data (não futura)
        if (strtotime($data) > time()) {
            $_SESSION['error_message'] = 'A data da vacinacao nao pode ser futura.';
            redirect('/vacinacao-pet/' . $id_pet);
            return;
        }

        // Editar a vacinação
        if ($model->editar($id, $data, $doses, $id_vacina, $id_pet, $proxima_dose)) {
            $_SESSION['success_message'] = 'Vacinacao atualizada com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao atualizar a vacinacao.';
        }

        redirect('/vacinacao-pet/' . $id_pet);
    }

    // Excluir vacinacao
    public function excluir($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Usuario nao autenticado.';
            redirect('/loginForm');
            return;
        }

        $model = new Vacinacao();
        // Busca a vacinação antes de excluir
        $vacina = $model->buscarPorId($id);

        if (!$vacina) {
            $_SESSION['error_message'] = 'Vacinacao nao encontrada.';
            redirect('/cadastrar-vacina');
            return;
        }

        // Verifica se o pet pertence ao usuário logado
        $petModel = new Pet();
        if (!$petModel->pertenceAoUsuario($vacina['id_pet'], $_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Voce nao tem permissao para excluir esta vacinacao.';
            redirect('/cadastrar-vacina');
            return;
        }

        // Exclui a vacinação
        $model->excluir($id);
        $_SESSION['success_message'] = 'Vacinacao excluida com sucesso!';
        redirect('/cadastrar-vacina');
    }

    // Buscar vacinação por ID
    public function buscarPorId($id) {
        $model = new Vacinacao();
        return $model->buscarPorId($id);
    }


    // Exibir carteirinha individual de um pet
    public function vacinacaoPet($id_pet) {
        if (!$this->usuarioId) {
            echo "Usuário não autenticado.";
            return;
        }

        $petModel = new Pet();
        $vacinacaoModel = new Vacinacao();

        $pet = $petModel->getById($id_pet);

        if (!$pet) {
            echo "Pet não encontrado.";
            return;
        }

        if ($pet['id_usuario'] != $this->usuarioId) {
            echo "Acesso negado. Este pet não pertence ao seu usuário.";
            return;
        }

        $vacinas = $vacinacaoModel->listarPorPet($id_pet);

        // Buscar dados do tutor
        $usuarioModel = new Usuario();
        $tutor = $usuarioModel->buscarPorId($this->usuarioId);

        include __DIR__ . '/../views/vacinacao_pet.php';
    }
}
