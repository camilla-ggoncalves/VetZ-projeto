-- ================================================
-- Migracao: Adicionar campo proxima_dose na tabela vacinacao
-- Data: 2025-11-22
-- Descricao: Adiciona campo para registrar a proxima dose
-- ================================================

USE vetz;

-- Adicionar coluna proxima_dose
ALTER TABLE vacinacao
ADD COLUMN proxima_dose DATE DEFAULT NULL AFTER data_vacinacao;

-- Verificar alteracoes
DESCRIBE vacinacao;

-- ================================================
-- Fim da Migracao
-- ================================================
