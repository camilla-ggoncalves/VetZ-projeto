-- Migration para criar a tabela de pets do VetZ
CREATE TABLE IF NOT EXISTS pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    raca VARCHAR(100) NOT NULL,
    idade INT,
    porte VARCHAR(20),
    peso FLOAT,
    sexo VARCHAR(10),
    imagem VARCHAR(255),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
