-- ================================================
-- Script de Criacao do Banco de Dados - VetZ
-- Sistema de Gestao Veterinaria e Vacinacao
-- ================================================

-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS vetz CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vetz;

-- ================================================
-- Tabela: usuarios
-- Descricao: Armazena os dados dos usuarios do sistema
-- ================================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    imagem VARCHAR(255) DEFAULT NULL,
    telefone VARCHAR(20) DEFAULT NULL,
    endereco VARCHAR(500) DEFAULT NULL,
    nascimento DATE DEFAULT NULL,
    codigo_recuperacao VARCHAR(10) DEFAULT NULL,
    codigo_expira DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_codigo (codigo_recuperacao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- Tabela: pets
-- Descricao: Armazena os dados dos pets cadastrados
-- ================================================
CREATE TABLE IF NOT EXISTS pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    raca VARCHAR(255) DEFAULT NULL,
    idade VARCHAR(50) DEFAULT NULL,
    porte VARCHAR(50) DEFAULT NULL COMMENT 'Pequeno, Medio, Grande',
    peso DECIMAL(5,2) DEFAULT NULL COMMENT 'Peso em kg',
    sexo VARCHAR(20) DEFAULT NULL COMMENT 'Macho, Femea',
    imagem VARCHAR(255) DEFAULT NULL,
    id_usuario INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_usuario (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- Tabela: registro_vacina
-- Descricao: Catalogo de vacinas disponiveis
-- ================================================
CREATE TABLE IF NOT EXISTS registro_vacina (
    id_vacina INT AUTO_INCREMENT PRIMARY KEY,
    vacina VARCHAR(255) NOT NULL,
    descricao TEXT DEFAULT NULL,
    tipo VARCHAR(50) DEFAULT NULL COMMENT 'Cao, Gato, Ambos',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_tipo (tipo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- Tabela: vacinacao
-- Descricao: Registro de vacinacoes aplicadas nos pets
-- ================================================
CREATE TABLE IF NOT EXISTS vacinacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_vacinacao DATE NOT NULL,
    proxima_dose DATE DEFAULT NULL,
    doses INT NOT NULL DEFAULT 1,
    id_vacina INT NOT NULL,
    id_pet INT NOT NULL,
    veterinario VARCHAR(255) DEFAULT NULL,
    local VARCHAR(255) DEFAULT NULL,
    observacoes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_vacina) REFERENCES registro_vacina(id_vacina) ON DELETE RESTRICT,
    FOREIGN KEY (id_pet) REFERENCES pets(id) ON DELETE CASCADE,
    INDEX idx_pet (id_pet),
    INDEX idx_vacina (id_vacina),
    INDEX idx_data (data_vacinacao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- Dados Iniciais: Vacinas Comuns
-- ================================================
INSERT INTO registro_vacina (vacina, descricao, tipo) VALUES
('V8 (Caes)', 'Vacina octupla para caes - protege contra cinomose, parvovirose, hepatite, parainfluenza, adenovirose, coronavirose e leptospirose', 'Cao'),
('V10 (Caes)', 'Vacina decupla para caes - V8 + 2 tipos adicionais de leptospirose', 'Cao'),
('Antirrabica', 'Protecao contra raiva - obrigatoria por lei', 'Ambos'),
('V5 (Gatos)', 'Vacina quintupla para gatos - protege contra rinotraqueite, calicivirose, panleucopenia, clamidiose e leucemia', 'Gato'),
('V4 (Gatos)', 'Vacina quadrupla para gatos - V5 sem leucemia felina', 'Gato'),
('V3 (Gatos)', 'Vacina tripla para gatos - protege contra rinotraqueite, calicivirose e panleucopenia', 'Gato'),
('Giardia', 'Protecao contra giardíase', 'Ambos'),
('Tosse dos Canis', 'Protecao contra traqueobronquite infecciosa canina', 'Cao'),
('Leishmaniose', 'Protecao contra leishmaniose visceral canina', 'Cao'),
('Influenza Canina', 'Protecao contra gripe canina', 'Cao'),
('Parvovirose', 'Protecao especifica contra parvovirus', 'Cao'),
('Cinomose', 'Protecao especifica contra virus da cinomose', 'Cao');

-- ================================================
-- Exemplo de Usuario (senha: senha123)
-- Senha hash gerado com PASSWORD_DEFAULT do PHP
-- ================================================
INSERT INTO usuarios (nome, email, senha) VALUES
('Usuario Teste', 'teste@vetz.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- ================================================
-- Views Uteis
-- ================================================

-- View: Resumo de vacinacoes por pet
CREATE OR REPLACE VIEW v_vacinacao_por_pet AS
SELECT
    p.id AS pet_id,
    p.nome AS pet_nome,
    u.nome AS tutor_nome,
    u.email AS tutor_email,
    COUNT(v.id) AS total_vacinas,
    MAX(v.data_vacinacao) AS ultima_vacina
FROM pets p
LEFT JOIN vacinacao v ON p.id = v.id_pet
INNER JOIN usuarios u ON p.id_usuario = u.id
GROUP BY p.id, p.nome, u.nome, u.email;

-- View: Historico completo de vacinacao
CREATE OR REPLACE VIEW v_historico_vacinacao AS
SELECT
    v.id AS vacinacao_id,
    v.data_vacinacao,
    v.doses,
    rv.vacina AS nome_vacina,
    rv.tipo AS tipo_vacina,
    p.nome AS pet_nome,
    p.raca AS pet_raca,
    u.nome AS tutor_nome,
    u.email AS tutor_email,
    v.veterinario,
    v.local,
    v.observacoes
FROM vacinacao v
INNER JOIN registro_vacina rv ON v.id_vacina = rv.id_vacina
INNER JOIN pets p ON v.id_pet = p.id
INNER JOIN usuarios u ON p.id_usuario = u.id
ORDER BY v.data_vacinacao DESC;


-- ================================================
-- Indices Adicionais para Performance
-- ================================================

-- Indices compostos para queries comuns
CREATE INDEX idx_usuario_data ON vacinacao(id_pet, data_vacinacao);
CREATE INDEX idx_pet_vacina ON vacinacao(id_pet, id_vacina);

-- ================================================
-- Comentarios nas Tabelas
-- ================================================

ALTER TABLE usuarios COMMENT = 'Tabela de usuarios/tutores do sistema';
ALTER TABLE pets COMMENT = 'Tabela de pets cadastrados';
ALTER TABLE registro_vacina COMMENT = 'Catalogo de vacinas disponiveis';
ALTER TABLE vacinacao COMMENT = 'Registro de vacinacoes aplicadas';

-- ================================================
-- Fim do Script
-- ================================================

-- Verificar criacao das tabelas
SHOW TABLES;

-- Verificar estrutura
DESCRIBE usuarios;
DESCRIBE pets;
DESCRIBE registro_vacina;
DESCRIBE vacinacao;
