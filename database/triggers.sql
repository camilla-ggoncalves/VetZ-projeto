-- ================================================
-- Triggers para VetZ
-- Execute este arquivo APOS executar schema.sql
-- ================================================

USE vetz;

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

-- Verificar criacao
SHOW TRIGGERS FROM vetz;
