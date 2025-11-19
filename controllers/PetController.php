<?php
require_once '../models/Pet.php';
require_once '../models/Vacinacao.php';

class PetController
{
    private $petModel;

    public function __construct()
    {
        $this->petModel = new Pet();
    }

    // ========================================
    // LISTAGEM E BUSCA
    // ========================================

    /** Lista todos os pets do usuário logado */
    public function listarPets()
    {
        $this->garantirSessao();
        try {
            return $this->petModel->getPetsByUsuario($_SESSION['user_id']);
        } catch (Exception $e) {
            error_log("Erro ao listar pets: " . $e->getMessage());
            return [];
        }
    }

    /** Busca um pet específico por ID (com verificação de dono) */
    public function buscarPorId($id)
    {
        $this->garantirSessao();

        $pet = $this->petModel->getById($id);

        if (!$pet || !$this->petModel->pertenceAoUsuario($id, $_SESSION['user_id'])) {
            return null;
        }

        return $pet;
    }

    /** Verifica se o usuário tem pelo menos um pet cadastrado */
    public function usuarioTemPets($usuarioId = null)
    {
        $id = $usuarioId ?? $_SESSION['user_id'] ?? null;
        if (!$id) return false;

        try {
            $pets = $this->petModel->getPetsByUsuario($id);
            return !empty($pets);
        } catch (Exception $e) {
            error_log("Erro ao verificar pets do usuário: " . $e->getMessage());
            return false;
        }
    }

    // ========================================
    // CADASTRO
    // ========================================

    public function showForm()
    {
        $this->garantirSessao();
        include '../views/pet_form.php';
    }

    public function savePet()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
            return;
        }

        $this->garantirSessao();

        // Validação básica
        $nome     = trim($_POST['nome'] ?? '');
        $especie  = trim($_POST['especie'] ?? '');
        $idUsuario = $_SESSION['user_id'];

        if (empty($nome) || empty($especie)) {
            $_SESSION['error_message'] = 'Nome e espécie são obrigatórios.';
            header('Location: /projeto/vetz/cadastrar-pet');
            exit;
        }

        $pet = new Pet();
        $pet->nome       = $nome;
        $pet->raca       = $_POST['raca'] ?? '';
        $pet->idade      = $_POST['idade'] ?? '';
        $pet->porte      = $_POST['porte'] ?? '';
        $pet->peso       = $_POST['peso'] ?? '';
        $pet->sexo       = $_POST['sexo'] ?? '';
        $pet->especie    = $especie;
        $pet->id_usuario = $idUsuario;

        // Upload de imagem
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            $nomeImagem = uniqid('pet_') . '.' . $extensao;
            $caminho = __DIR__ . '/../uploads/' . $nomeImagem;

            // Cria pasta se não existir
            if (!is_dir(dirname($caminho))) {
                mkdir(dirname($caminho), 0755, true);
            }

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
                $pet->imagem = $nomeImagem;
            } else {
                $_SESSION['error_message'] = 'Erro ao salvar imagem.';
            }
        }

        if ($pet->save()) {
            $_SESSION['success_message'] = 'Pet cadastrado com sucesso!';
            header('Location: /projeto/vetz/list-pet');
        } else {
            $_SESSION['error_message'] = 'Erro ao cadastrar o pet.';
            header('Location: /projeto/vetz/cadastrar-pet');
        }
        exit;
    }

    // ========================================
    // EDIÇÃO
    // ========================================

    public function showUpdateForm($id)
    {
        $this->garantirSessao();

        if (!$this->petModel->pertenceAoUsuario($id, $_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Você não tem permissão para editar este pet.';
            header('Location: /projeto/vetz/list-pet');
            exit;
        }

        $pet = $this->petModel->getById($id);

        if (!$pet) {
            $_SESSION['error_message'] = 'Pet não encontrado.';
            header('Location: /projeto/vetz/list-pet');
            exit;
        }

        include '../views/update_pet.php';
    }

    public function updatePet()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $this->garantirSessao();

        $petId = $_POST['id'] ?? '';

        if (!$this->petModel->pertenceAoUsuario($petId, $_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Acesso negado.';
            header('Location: /projeto/vetz/list-pet');
            exit;
        }

        $pet = $this->petModel->getById($petId); // carrega dados atuais
        if (!$pet) {
            $_SESSION['error_message'] = 'Pet não encontrado.';
            header('Location: /projeto/vetz/list-pet');
            exit;
        }

        // Atualiza apenas os campos enviados
        $pet->nome    = trim($_POST['nome'] ?? $pet->nome);
        $pet->raca    = $_POST['raca'] ?? $pet->raca;
        $pet->idade   = $_POST['idade'] ?? $pet->idade;
        $pet->porte   = $_POST['porte'] ?? $pet->porte;
        $pet->peso    = $_POST['peso'] ?? $pet->peso;
        $pet->sexo    = $_POST['sexo'] ?? $pet->sexo;
        $pet->especie = $_POST['especie'] ?? $pet->especie;

        // Upload de nova imagem (opcional)
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            $nomeImagem = uniqid('pet_') . '.' . $extensao;
            $caminho = __DIR__ . '/../uploads/' . $nomeImagem;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
                // Remove imagem antiga se existir
                if ($pet->imagem && file_exists(__DIR__ . '/../uploads/' . $pet->imagem)) {
                    unlink(__DIR__ . '/../uploads/' . $pet->imagem);
                }
                $pet->imagem = $nomeImagem;
            }
        }

        if ($pet->update()) {
            $_SESSION['success_message'] = 'Pet atualizado com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao atualizar o pet.';
        }

        header('Location: /projeto/vetz/list-pet');
        exit;
    }

    // ========================================
    // EXCLUSÃO
    // ========================================

    public function deletePetById($id)
    {
        $this->garantirSessao();

        if (!$this->petModel->pertenceAoUsuario($id, $_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Você não tem permissão para excluir este pet.';
            header('Location: /projeto/vetz/list-pet');
            exit;
        }

        // Verifica se o pet tem vacinas
        $vacinacaoModel = new Vacinacao();
        if ($vacinacaoModel->petTemVacina($id)) {
            $_SESSION['error_message'] = 'Não é possível excluir: este pet possui vacinas registradas.';
            header('Location: /projeto/vetz/list-pet');
            exit;
        }

        if ($this->petModel->delete($id)) {
            $_SESSION['success_message'] = 'Pet excluído com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao excluir o pet.';
        }

        header('Location: /projeto/vetz/list-pet');
        exit;
    }

    // ========================================
    // PERFIL DO PET
    // ========================================

    public function perfilPet($id)
    {
        $this->garantirSessao();

        $pet = $this->buscarPorId($id);
        if (!$pet) {
            $_SESSION['error_message'] = 'Pet não encontrado ou acesso negado.';
            header('Location: /projeto/vetz/list-pet');
            exit;
        }

        // Dados do dono para exibir no perfil
        $pet['nome_dono']  = $_SESSION['user_name'] ?? '';
        $pet['email_dono'] = $_SESSION['user_email'] ?? '';

        include '../views/perfil_pet.php';
    }

    // ========================================
    // LISTA PÚBLICA / ADMIN (opcional)
    // ========================================

    public function listarTodosComVacinas()
    {
        $pets = $this->petModel->getAll();
        $vacinacaoModel = new Vacinacao();

        foreach ($pets as &$pet) {
            $pet['tem_vacina'] = $vacinacaoModel->petTemVacina($pet['id']);
        }
        unset($pet);

        return $pets;
    }

    // ========================================
    // UTILITÁRIO
    // ========================================

    private function garantirSessao()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /projeto/vetz/login');
            exit;
        }
    }
}