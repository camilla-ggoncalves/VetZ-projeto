-- Migration para criar a tabela de vacinações do VetZ
CREATE TABLE IF NOT EXISTS vacinacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATE NOT NULL,
    doses INT NOT NULL,
    id_vacina INT NOT NULL,
    id_pet INT NOT NULL,
    id_usuario INT NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pet) REFERENCES pets(id) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Migration para criar a tabela de vacinas
CREATE TABLE IF NOT EXISTS vacinas (
    id_vacina INT AUTO_INCREMENT PRIMARY KEY,
    vacina VARCHAR(100) NOT NULL
);
