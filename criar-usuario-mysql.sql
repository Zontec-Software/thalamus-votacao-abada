-- Execute este arquivo como root do MySQL
-- Comando: mysql -u root -p < criar-usuario-mysql.sql

CREATE DATABASE IF NOT EXISTS votacao CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Remover usuário se já existir (para recriar)
DROP USER IF EXISTS 'roboflex'@'localhost';

-- Criar usuário
CREATE USER 'roboflex'@'localhost' IDENTIFIED BY 'Roboflex12@';

-- Conceder privilégios
GRANT ALL PRIVILEGES ON votacao.* TO 'roboflex'@'localhost';

-- Aplicar mudanças
FLUSH PRIVILEGES;

-- Verificar
SELECT 'Banco votacao criado!' AS Status;
SELECT User, Host FROM mysql.user WHERE User='roboflex';

