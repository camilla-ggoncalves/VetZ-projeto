<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Pet.php';
require_once __DIR__ . '/../models/Vacinacao.php';

class PetController
{
    private $petModel;

    public function __construct()
    {
        $this->petModel = new Pet();
    }

    public function listarPorUsuario($usuarioId) {
        try {
            return $this->petModel->getPetsByUsuario($usuarioId);
        } catch (Exception $e) {
            error_log("Erro ao listar pets do usuário: " . $e->getMessage());
            return [];
        }
    }

    public function buscarPorId($id) {
        try {
            return $this->petModel->getById($id);
        } catch (Exception $e) {
            error_log("Erro ao buscar pet por ID: " . $e->getMessage());
            return null;
        }
    }

    public function buscarPorUsuario($usuarioId) {
        return $this->listarPorUsuario($usuarioId);
    }

    public function showForm() {
        include __DIR__ . '/../views/pet_form.php';
    }

    public function savePet() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            echo "Usuário não logado.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $pet = new Pet();
        $pet->nome = $_POST['nome'] ?? '';
        $pet->raca = $_POST['raca'] ?? '';
        $pet->idade = $_POST['idade'] ?? '';
        $pet->porte = $_POST['porte'] ?? '';
        $pet->peso = $_POST['peso'] ?? '';
        $pet->sexo = $_POST['sexo'] ?? '';
        $pet->id_usuario = $_SESSION['user_id'];

        if (empty($pet->nome)) {
            $_SESSION['error_message'] = 'Preencha todos os campos obrigatorios.';
            redirect('/formulario');
        }

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $nomeImagem = uniqid() . '.' . $extensao;
            $caminhoDestino = __DIR__ . '/../uploads/' . $nomeImagem;

            if (!is_dir(dirname($caminhoDestino))) {
                mkdir(dirname($caminhoDestino), 0777, true);
            }

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
                $pet->imagem = $nomeImagem;
            }
        }

        if ($pet->save()) {
            $_SESSION['success_message'] = 'Pet cadastrado com sucesso!';
            redirect('/list-pet');
        } else {
            $_SESSION['error_message'] = 'Erro ao cadastrar o pet.';
            redirect('/formulario');
        }
    }

    public function listPet() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/loginForm');
        }

        try {
            // Paginação
            $petsPerPage = 6;
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $currentPage = max(1, $currentPage);

            $allPets = $this->petModel->getPetsByUsuario($_SESSION['user_id']);
            $totalPets = count($allPets);
            $totalPages = ceil($totalPets / $petsPerPage);
            $offset = ($currentPage - 1) * $petsPerPage;

            // Pegar apenas os pets da página atual
            $pets = array_slice($allPets, $offset, $petsPerPage);

            // Buscar quantidade de vacinas para cada pet
            $vacinacaoModel = new Vacinacao();
            foreach ($pets as $key => $pet) {
                $vacinas = $vacinacaoModel->listarPorPet($pet['id']);
                $pets[$key]['total_vacinas'] = count($vacinas);
            }
            unset($key, $pet);

            include __DIR__ . '/../views/pet_list.php';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erro ao carregar lista de pets.';
            $pets = [];
            $currentPage = 1;
            $totalPages = 0;
            $totalPets = 0;
            include __DIR__ . '/../views/pet_list.php';
        }
    }

    public function showUpdateForm($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/loginForm');
        }

        if (!$this->petModel->pertenceAoUsuario($id, $_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Pet nao encontrado ou acesso negado.';
            redirect('/list-pet');
        }

        $pet = $this->petModel->getById($id);

        if ($pet) {
            include __DIR__ . '/../views/update_pet.php';
        } else {
            $_SESSION['error_message'] = 'Pet nao encontrado.';
            redirect('/list-pet');
        }
    }

    public function updatePet() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        if (session_status() === PHP_SESSION_NONE) session_start();

        $petId = $_POST['id'] ?? '';

        if (!$this->petModel->pertenceAoUsuario($petId, $_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Acesso negado.';
            redirect('/list-pet');
        }

        $pet = new Pet();
        $pet->id = $petId;
        $pet->nome = $_POST['nome'] ?? '';
        $pet->raca = $_POST['raca'] ?? '';
        $pet->idade = $_POST['idade'] ?? '';
        $pet->porte = $_POST['porte'] ?? '';
        $pet->peso = $_POST['peso'] ?? '';
        $pet->sexo = $_POST['sexo'] ?? '';

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $nomeImagem = uniqid() . '.' . $extensao;
            $caminhoDestino = __DIR__ . '/../uploads/' . $nomeImagem;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
                $pet->imagem = $nomeImagem;
            }
        }

        if ($pet->update()) {
            $_SESSION['success_message'] = 'Pet atualizado com sucesso!';
            redirect('/list-pet');
        } else {
            $_SESSION['error_message'] = 'Erro ao atualizar o pet.';
            redirect('/update-pet/' . $petId);
        }
    }

    public function perfilPet($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            echo "Usuário não logado.";
            return;
        }

        $petModel = new Pet();
        $pet = $petModel->getById($id);
        if (!$pet) {
            echo "Pet não encontrado.";
            return;
        }

        $pet['user_name'] = $_SESSION['user_name'];
        $pet['user_email'] = $_SESSION['user_email'];

        include __DIR__ . '/../views/perfil_pet.php';
    }

    public function deletePetById($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            redirect('/loginForm');
        }

        if (!$this->petModel->pertenceAoUsuario($id, $_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Acesso negado.';
            redirect('/list-pet');
        }

        $naoTemVacinas = $this->petModel->verificarVacinas($id);

        if ($naoTemVacinas) {
            $this->petModel->id = $id;
            if ($this->petModel->delete()) {
                $_SESSION['success_message'] = 'Pet excluido com sucesso!';
            } else {
                $_SESSION['error_message'] = 'Erro ao excluir o pet.';
            }
        } else {
            $_SESSION['error_message'] = 'Este pet possui vacinas registradas e nao pode ser excluido.';
        }

        redirect('/list-pet');
    }

    public function listarPetsComVacinas() {
        $petModel = new Pet();
        $pets = $petModel->getAll();

        $vacinacaoModel = new Vacinacao();
        foreach ($pets as &$pet) {
            $pet['tem_vacina'] = $vacinacaoModel->petTemVacina($pet['id']);
        }
        unset($pet);
        return $pets;
    }


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
}