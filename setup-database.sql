-- Script para criar banco de dados e usuário para a aplicação de votação
-- Execute este script como root ou usuário com privilégios administrativos

-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS votacao CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Criar usuário (se não existir)
CREATE USER IF NOT EXISTS 'roboflex'@'localhost' IDENTIFIED BY 'Roboflex12@';

-- Conceder privilégios
GRANT ALL PRIVILEGES ON votacao.* TO 'roboflex'@'localhost';

-- Aplicar mudanças
FLUSH PRIVILEGES;

-- Mostrar confirmação
SELECT 'Banco de dados e usuário criados com sucesso!' AS Status;

