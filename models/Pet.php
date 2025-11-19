<?php
require_once '../config/database_site.php';

class Pet {
    private $conn;
    private $table_name = "pets";

    public $id;
    public $nome;
    public $raca;
    public $idade;
    public $porte;
    public $peso;
    public $sexo;
    public $imagem;
    public $id_usuario;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function save() {
        $query = "INSERT INTO pets (nome, raca, idade, porte, peso, sexo, imagem, id_usuario)
                  VALUES (:nome, :raca, :idade, :porte, :peso, :sexo, :imagem, :id_usuario)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':raca', $this->raca);
        $stmt->bindParam(':idade', $this->idade);
        $stmt->bindParam(':porte', $this->porte);
        $stmt->bindParam(':peso', $this->peso);
        $stmt->bindParam(':sexo', $this->sexo);
        $stmt->bindParam(':imagem', $this->imagem);
        $stmt->bindParam(':id_usuario', $this->id_usuario);

        return $stmt->execute();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM pets");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM pets WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE pets 
                  SET nome = :nome, raca = :raca, idade = :idade, porte = :porte, 
                      peso = :peso, sexo = :sexo";

        if (!empty($this->imagem)) $query .= ", imagem = :imagem";

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':raca', $this->raca);
        $stmt->bindParam(':idade', $this->idade);
        $stmt->bindParam(':porte', $this->porte);
        $stmt->bindParam(':peso', $this->peso);
        $stmt->bindParam(':sexo', $this->sexo);
        if (!empty($this->imagem)) $stmt->bindParam(':imagem', $this->imagem);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM pets WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function listar() {
        $stmt = $this->conn->query("SELECT id, nome FROM pets");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verificarVacinas($id_pet) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM vacinacao WHERE id_pet = ?");
        $stmt->execute([$id_pet]);
        return $stmt->fetchColumn() == 0;
    }

    public function getPetsByUsuario($usuarioId) {
        $stmt = $this->conn->prepare("SELECT * FROM pets WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $usuarioId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
