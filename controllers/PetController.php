<?php
require_once '../models/Pet.php';
require_once '../models/Vacinacao.php';

class PetController {

    public function showForm() {
        include '../views/pet_form.php';
    }

    public function savePet() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { echo "Usuário não logado."; return; }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $pet = new Pet();
        $pet->nome = $_POST['nome'];
        $pet->raca = $_POST['raca'];
        $pet->idade = $_POST['idade'];
        $pet->porte = $_POST['porte'];
        $pet->peso = $_POST['peso'];
        $pet->sexo = $_POST['sexo'];
        $pet->id_usuario = $_SESSION['user_id'];

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $nome = uniqid() . "." . $ext;
            $destino = __DIR__ . '/../uploads/' . $nome;
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                $pet->imagem = $nome;
            }
        }

        if ($pet->save()) {
            header('Location: /projeto/vetz/list-pet');
            exit;
        } else echo "Erro ao cadastrar o pet.";
    }

    public function listPet() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { echo "Usuário não logado."; return; }

        $pet = new Pet();
        $pets = $pet->getPetsByUsuario($_SESSION['user_id']);
        include '../views/pet_list.php';
    }

    public function showUpdateForm($id) {
        $petModel = new Pet();
        $pet = $petModel->getById($id);
        if ($pet) include '../views/update_pet.php';
        else echo "Pet não encontrado.";
    }

    public function updatePet() {
        $pet = new Pet();
        $pet->id = $_POST['id'];
        $pet->nome = $_POST['nome'];
        $pet->raca = $_POST['raca'];
        $pet->idade = $_POST['idade'];
        $pet->porte = $_POST['porte'];
        $pet->peso = $_POST['peso'];
        $pet->sexo = $_POST['sexo'];

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $nome = uniqid() . "." . $ext;
            $destino = __DIR__ . '/../uploads/' . $nome;
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                $pet->imagem = $nome;
            }
        }

        if ($pet->update()) {
            header('Location: /projeto/vetz/list-pet');
            exit;
        } else echo "Erro ao atualizar o pet.";
    }

    public function perfilPet($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { echo "Usuário não logado."; return; }

        $petModel = new Pet();
        $pet = $petModel->getById($id);
        if (!$pet) { echo "Pet não encontrado."; return; }

        $pet['user_name'] = $_SESSION['user_name'];
        $pet['user_email'] = $_SESSION['user_email'];

        include '../views/perfil_pet.php';
    }

    public function deletePetById($id) {
        $petModel = new Pet();
        $semVacinas = $petModel->verificarVacinas($id);

        if ($semVacinas) {
            $petModel->id = $id;
            $petModel->delete();
            header('Location: /projeto/vetz/list-pet');
            exit;
        } else echo "Erro: este pet possui vacinas e não pode ser excluído.";
    }

    public function listarPets() {
        $model = new Pet();
        return $model->listar();
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
}
