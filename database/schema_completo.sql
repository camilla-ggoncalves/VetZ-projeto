-- ================================================
-- Script Completo de Criacao do Banco de Dados - VetZ
-- Sistema de Gestao Veterinaria e Vacinacao
-- Versao: 2.0 (Consolidado)
-- Data: 2025-11-24
-- ================================================
-- Este script contem TUDO necessario para criar o banco:
-- - Estrutura de tabelas
-- - Dados iniciais
-- - Views
-- - Procedures
-- - Triggers
-- ================================================

-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS vetz CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vetz;

-- ================================================
-- TABELAS
-- ================================================

-- ================================================
-- Tabela: usuarios
-- Descricao: Armazena os dados dos usuarios/tutores do sistema
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT = 'Tabela de usuarios/tutores do sistema';

-- ================================================
-- Tabela: pets
-- Descricao: Armazena os dados dos pets cadastrados
-- ================================================
CREATE TABLE IF NOT EXISTS pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    raca VARCHAR(255) DEFAULT NULL,
    idade VARCHAR(50) DEFAULT NULL,
    data_nascimento DATE DEFAULT NULL,
    porte VARCHAR(50) DEFAULT NULL COMMENT 'Pequeno, Medio, Grande',
    peso DECIMAL(5,2) DEFAULT NULL COMMENT 'Peso em kg',
    sexo VARCHAR(20) DEFAULT NULL COMMENT 'Macho, Femea',
    imagem VARCHAR(255) DEFAULT NULL,
    id_usuario INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_usuario (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT = 'Tabela de pets cadastrados';

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT = 'Catalogo de vacinas disponiveis';

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
    INDEX idx_data (data_vacinacao),
    INDEX idx_usuario_data (id_pet, data_vacinacao),
    INDEX idx_pet_vacina (id_pet, id_vacina)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT = 'Registro de vacinacoes aplicadas';

-- ================================================
-- DADOS INICIAIS
-- ================================================

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
-- VIEWS
-- ================================================

-- ================================================
-- View: Resumo de vacinacoes por pet
-- ================================================
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

-- ================================================
-- View: Historico completo de vacinacao
-- ================================================
CREATE OR REPLACE VIEW v_historico_vacinacao AS
SELECT
    v.id AS vacinacao_id,
    v.data_vacinacao,
    v.proxima_dose,
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
-- PROCEDURES
-- ================================================

-- Remover procedures existentes se houver
DROP PROCEDURE IF EXISTS sp_vacinas_pendentes;
DROP PROCEDURE IF EXISTS sp_relatorio_vacinacao;

-- ================================================
-- Procedure: Buscar vacinas pendentes (proxima dose)
-- ================================================
DELIMITER //

CREATE PROCEDURE sp_vacinas_pendentes(IN pet_id INT)
BEGIN
    SELECT
        v.id,
        rv.vacina,
        v.data_vacinacao AS ultima_aplicacao,
        v.proxima_dose,
        v.doses AS doses_aplicadas,
        CASE
            WHEN v.proxima_dose IS NOT NULL THEN v.proxima_dose
            ELSE DATE_ADD(v.data_vacinacao, INTERVAL 30 DAY)
        END AS proxima_dose_estimada
    FROM vacinacao v
    INNER JOIN registro_vacina rv ON v.id_vacina = rv.id_vacina
    WHERE v.id_pet = pet_id
    AND v.doses < 3
    ORDER BY v.data_vacinacao DESC;
END //

DELIMITER ;

-- ================================================
-- Procedure: Relatorio de vacinacao por periodo
-- ================================================
DELIMITER //

CREATE PROCEDURE sp_relatorio_vacinacao(
    IN data_inicio DATE,
    IN data_fim DATE
)
BEGIN
    SELECT
        DATE_FORMAT(v.data_vacinacao, '%Y-%m') AS mes_ano,
        COUNT(*) AS total_vacinacoes,
        COUNT(DISTINCT v.id_pet) AS total_pets,
        COUNT(DISTINCT p.id_usuario) AS total_tutores
    FROM vacinacao v
    INNER JOIN pets p ON v.id_pet = p.id
    WHERE v.data_vacinacao BETWEEN data_inicio AND data_fim
    GROUP BY DATE_FORMAT(v.data_vacinacao, '%Y-%m')
    ORDER BY mes_ano;
END //

DELIMITER ;

-- ================================================
-- TRIGGERS
-- ================================================

-- Remover triggers existentes se houver
DROP TRIGGER IF EXISTS trg_validar_data_vacinacao;

-- ================================================
-- Trigger: Validar data de vacinacao (nao pode ser futura)
-- ================================================
DELIMITER //

CREATE TRIGGER trg_validar_data_vacinacao
BEFORE INSERT ON vacinacao
FOR EACH ROW
BEGIN
    IF NEW.data_vacinacao > CURDATE() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Data de vacinacao nao pode ser futura';
    END IF;
END //

DELIMITER ;

-- ================================================
-- VERIFICACOES FINAIS
-- ================================================

-- Verificar criacao das tabelas
SHOW TABLES;

-- Verificar estrutura das tabelas
DESCRIBE usuarios;
DESCRIBE pets;
DESCRIBE registro_vacina;
DESCRIBE vacinacao;

-- Verificar views
SHOW FULL TABLES WHERE Table_type = 'VIEW';

-- Verificar procedures
SHOW PROCEDURE STATUS WHERE Db = 'vetz';

-- Verificar triggers
SHOW TRIGGERS FROM vetz;

-- ================================================
-- FIM DO SCRIPT
-- ================================================
-- Para usar este script:
-- 1. Execute: mysql -u root -p < schema_completo.sql
-- 2. Ou copie e cole no MySQL Workbench / phpMyAdmin
-- ================================================
