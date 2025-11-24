-- ================================================
-- Migracao: Adicionar campos de perfil na tabela usuarios
-- Data: 2025-11-22
-- Descricao: Adiciona telefone, endereco e nascimento
-- ================================================

USE vetz;

-- Adicionar coluna telefone
ALTER TABLE usuarios
ADD COLUMN telefone VARCHAR(20) DEFAULT NULL AFTER imagem;

-- Adicionar coluna endereco
ALTER TABLE usuarios
ADD COLUMN endereco VARCHAR(500) DEFAULT NULL AFTER telefone;

-- Adicionar coluna nascimento
ALTER TABLE usuarios
ADD COLUMN nascimento DATE DEFAULT NULL AFTER endereco;

-- Verificar alteracoes
DESCRIBE usuarios;

-- ================================================
-- Fim da Migracao
-- ================================================
