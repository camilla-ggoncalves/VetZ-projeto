<?php
require_once '../models/Pet.php';

class PetController {
    private $petModel;

    public function __construct() {
        $this->petModel = new Pet();
    }

    // MÉTODO CORRIGIDO: Listar pets por usuário
    public function listarPorUsuario($usuarioId) {
        try {
            return $this->petModel->getPetsByUsuario($usuarioId);
        } catch (Exception $e) {
            error_log("Erro ao listar pets do usuário: " . $e->getMessage());
            return [];
        }
    }

    // MÉTODO CORRIGIDO: Buscar pet por ID
    public function buscarPorId($id) {
        try {
            return $this->petModel->getById($id);
        } catch (Exception $e) {
            error_log("Erro ao buscar pet por ID: " . $e->getMessage());
            return null;
        }
    }

    // MÉTODO CORRIGIDO: Buscar por usuário (alias para listarPorUsuario)
    public function buscarPorUsuario($usuarioId) {
        return $this->listarPorUsuario($usuarioId);
    }

    public function showForm() {
        include '../views/pet_form.php';
    }

    public function savePet() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            
            $pet = new Pet();
            $pet->nome = $_POST['nome'] ?? '';
            $pet->raca = $_POST['raca'] ?? '';
            $pet->idade = $_POST['idade'] ?? '';
            $pet->porte = $_POST['porte'] ?? '';
            $pet->peso = $_POST['peso'] ?? '';
            $pet->sexo = $_POST['sexo'] ?? '';
            $pet->especie = $_POST['especie'] ?? '';
            $pet->id_usuario = $_SESSION['user_id'] ?? null; // CORREÇÃO: Adicionar usuário

            // Validações básicas
            if (empty($pet->nome) || empty($pet->especie) || empty($pet->id_usuario)) {
                $_SESSION['error_message'] = 'Preencha todos os campos obrigatórios.';
                header('Location: /projeto/vetz/cadastrar-pet');
                exit;
            }

            // Upload de imagem
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                $nomeImagem = uniqid() . '.' . $extensao;
                $caminhoDestino = __DIR__ . '/../uploads/' . $nomeImagem;

                // Criar diretório se não existir
                if (!is_dir(dirname($caminhoDestino))) {
                    mkdir(dirname($caminhoDestino), 0777, true);
                }

                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
                    $pet->imagem = $nomeImagem;
                } else {
                    $_SESSION['error_message'] = 'Erro ao fazer upload da imagem.';
                    header('Location: /projeto/vetz/cadastrar-pet');
                    exit;
                }
            }

            if ($pet->save()) {
                $_SESSION['success_message'] = 'Pet cadastrado com sucesso!';
                header('Location: /projeto/vetz/list-pet');
                exit;
            } else {
                $_SESSION['error_message'] = 'Erro ao cadastrar o pet.';
                header('Location: /projeto/vetz/cadastrar-pet');
                exit;
            }
        }
    }

    public function listPet() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /projeto/vetz/login');
            exit;
        }

        try {
            $pets = $this->petModel->getPetsByUsuario($_SESSION['user_id']);
            include '../views/pet_list.php';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erro ao carregar lista de pets.';
            include '../views/pet_list.php';
        }
    }

    public function showUpdateForm($id) {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /projeto/vetz/login');
            exit;
        }

        // Verificar se o pet pertence ao usuário
        if (!$this->petModel->pertenceAoUsuario($id, $_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Pet não encontrado ou acesso negado.';
            header('Location: /projeto/vetz/list-pet');
            exit;
        }

        $pet = $this->petModel->getById($id);

        if ($pet) {
            include '../views/update_pet.php';
        } else {
            $_SESSION['error_message'] = 'Pet não encontrado.';
            header('Location: /projeto/vetz/list-pet');
            exit;
        }
    }

    public function updatePet() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            
            $petId = $_POST['id'] ?? '';
            
            // Verificar se o pet pertence ao usuário
            if (!$this->petModel->pertenceAoUsuario($petId, $_SESSION['user_id'])) {
                $_SESSION['error_message'] = 'Acesso negado.';
                header('Location: /projeto/vetz/list-pet');
                exit;
            }

            $pet = new Pet();
            $pet->id = $petId;
            $pet->nome = $_POST['nome'] ?? '';
            $pet->raca = $_POST['raca'] ?? '';
            $pet->idade = $_POST['idade'] ?? '';
            $pet->porte = $_POST['porte'] ?? '';
            $pet->peso = $_POST['peso'] ?? '';
            $pet->sexo = $_POST['sexo'] ?? '';
            $pet->especie = $_POST['especie'] ?? '';

            // Só atualiza a imagem se houver upload
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
                header('Location: /projeto/vetz/list-pet');
                exit;
            } else {
                $_SESSION['error_message'] = 'Erro ao atualizar o pet.';
                header('Location: /projeto/vetz/editar-pet?id=' . $petId);
                exit;
            }
        }
    }

    public function deletePetById($id) {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /projeto/vetz/login');
            exit;
        }

        // Verificar se o pet pertence ao usuário
        if (!$this->petModel->pertenceAoUsuario($id, $_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Acesso negado.';
            header('Location: /projeto/vetz/list-pet');
            exit;
        }

        $naoTemVacinas = $this->petModel->verificarVacinas($id);

        if ($naoTemVacinas) {
            $this->petModel->id = $id;
            if ($this->petModel->delete()) {
                $_SESSION['success_message'] = 'Pet excluído com sucesso!';
            } else {
                $_SESSION['error_message'] = 'Erro ao excluir o pet.';
            }
        } else {
            $_SESSION['error_message'] = 'Este pet possui vacinas registradas e não pode ser excluído.';
        }

        header('Location: /projeto/vetz/list-pet');
        exit;
    }

    public function listarPets() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return [];
        }

        try {
            return $this->petModel->getPetsByUsuario($_SESSION['user_id']);
        } catch (Exception $e) {
            error_log("Erro ao listar pets: " . $e->getMessage());
            return [];
        }
    }

    // NOVO MÉTODO: Verificar se usuário tem pets
    public function usuarioTemPets($usuarioId) {
        try {
            $pets = $this->petModel->getPetsByUsuario($usuarioId);
            return !empty($pets);
        } catch (Exception $e) {
            error_log("Erro ao verificar pets do usuário: " . $e->getMessage());
            return false;
        }
    }
}