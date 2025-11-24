-- ================================================
-- Procedures para VetZ
-- Execute este arquivo APOS executar schema.sql
-- ================================================

USE vetz;

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
        v.doses AS doses_aplicadas,
        DATE_ADD(v.data_vacinacao, INTERVAL 30 DAY) AS proxima_dose_estimada
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

-- Verificar criacao
SHOW PROCEDURE STATUS WHERE Db = 'vetz';
