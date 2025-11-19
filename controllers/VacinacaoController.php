<?php
require_once '../models/Vacinacao.php';
require_once '../models/Pet.php';
require_once '../models/Usuario.php';

class VacinacaoController {

    private $usuarioId;

    public function __construct($usuarioId = null) {
        $this->usuarioId = $usuarioId; // id do usuário logado
    }

    // Listar todas as vacinações
    public function listVacina() {
        $model = new Vacinacao();
        $vacinas = $model->listar();
        include '../views/vacinacao_list.php';
    }

    // Listar vacinações de um usuário específico
    public function listarVacinasUsuario() {
        if (!$this->usuarioId) return [];

        $petModel = new Pet();
        $vacinacaoModel = new Vacinacao();

        // Pega todos os pets do usuário
        $pets = $petModel->getPetsByUsuario($this->usuarioId);

        $vacinasUsuario = [];
        foreach ($pets as $pet) {
            $vacinas = $vacinacaoModel->listarPorPet($pet['id']);
            foreach ($vacinas as $v) {
                $v['nome_pet'] = $pet['nome'];
                $vacinasUsuario[] = $v;
            }
        }

        return $vacinasUsuario;
    }

    // Exibir formulário de cadastro
    public function exibirFormulario() {
        $vacinacaoModel = new Vacinacao();
        $vacinas = $vacinacaoModel->listarVacinas();

        $pets = (new Pet())->getPetsByUsuario($this->usuarioId);
        include '../views/vacinacao_form.php';
    }

    // Cadastrar vacinação
    public function cadastrarVacina() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Usuário não logado.';
            header('Location: /projeto/vetz/login'); exit;
        }

        $data_vacinacao = $_POST['data'] ?? '';
        $doses = $_POST['doses'] ?? '';
        $id_vacina = $_POST['id_vacina'] ?? '';
        $id_pet = $_POST['id_pet'] ?? '';

        // Valida campos obrigatórios
        if (empty($data) || empty($doses) || empty($id_vacina) || empty($id_pet)) {
            $_SESSION['error_message'] = 'Preencha todos os campos obrigatórios.';
            header('Location: /projeto/vetz/cadastrar-vacina'); exit;
        }

        // Valida que pet pertence ao usuário
        $petModel = new Pet();
        if (!$petModel->pertenceAoUsuario($id_pet, $_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Pet inválido ou não pertence a este usuário.';
            header('Location: /projeto/vetz/cadastrar-vacina'); exit;
        }

        // Valida que vacina existe
        $vacinacaoModel = new Vacinacao();
        if (!$vacinacaoModel->vacinaExiste($id_vacina)) {
            $_SESSION['error_message'] = 'Vacina inválida.';
            header('Location: /projeto/vetz/cadastrar-vacina'); exit;
        }

        // Valida data (não futura)
        if (strtotime($data) > time()) {
            $_SESSION['error_message'] = 'A data da vacinação não pode ser futura.';
            header('Location: /projeto/vetz/cadastrar-vacina'); exit;
        }

        // Insere a vacinação
        if ($vacinacaoModel->cadastrar($data_vacinacao, $doses, $id_vacina, $id_pet)) {
            $_SESSION['success_message'] = 'Vacinação cadastrada com sucesso!';
            header('Location: /projeto/vetz/listar-vacinas'); exit;
        } else {
            $_SESSION['error_message'] = 'Erro ao cadastrar a vacinação.';
            header('Location: /projeto/vetz/cadastrar-vacina'); exit;
        }
    }

    // Editar vacinação
    public function editar($id, $data, $doses, $id_vacina, $id_pet) {
        $model = new Vacinacao();
        $model->editar($id, $data, $doses, $id_vacina, $id_pet);
        header("Location: ../views/vacinacao_pet.php");
        exit;
    }

    // Excluir vacinação
    public function excluir($id) {
        $model = new Vacinacao();
        $model->excluir($id);
        header("Location: ../views/vacinacao_pet.php");
        exit;
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

        $pet = $petModel->buscarPorId($id_pet);

        if (!$pet) {
            echo "Pet não encontrado.";
            return;
        }

        if ($pet['id_usuario'] != $this->usuarioId) {
            echo "Acesso negado. Este pet não pertence ao seu usuário.";
            return;
        }

        $vacinas = $vacinacaoModel->listarPorPet($id_pet);

        include '../views/vacinacao_pet.php';
    }
}
