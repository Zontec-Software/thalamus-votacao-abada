# Configuração do MySQL

## Problema
O usuário `roboflex` não existe ou não tem permissões para acessar o banco `votacao`.

## Solução

### Opção 1: Criar usuário e banco de dados (Recomendado)

Execute os seguintes comandos como usuário root do MySQL:

```bash
mysql -u root -p
```

Depois execute os seguintes comandos SQL:

```sql
-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS votacao CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Criar usuário
CREATE USER IF NOT EXISTS 'roboflex'@'localhost' IDENTIFIED BY 'Roboflex12@';

-- Conceder privilégios
GRANT ALL PRIVILEGES ON votacao.* TO 'roboflex'@'localhost';

-- Aplicar mudanças
FLUSH PRIVILEGES;

-- Verificar
SHOW DATABASES LIKE 'votacao';
SELECT User, Host FROM mysql.user WHERE User='roboflex';
```

### Opção 2: Usar script SQL

```bash
mysql -u root -p < setup-database.sql
```

### Opção 3: Se o usuário já existe mas a senha está diferente

Se o usuário `roboflex` já existe mas com senha diferente, você pode:

1. Alterar a senha do usuário:
```sql
ALTER USER 'roboflex'@'localhost' IDENTIFIED BY 'Roboflex12@';
FLUSH PRIVILEGES;
```

2. Ou atualizar o arquivo `.env` com a senha correta.

### Opção 4: Usar outro usuário existente

Se você já tem um usuário MySQL configurado, edite o arquivo `.env`:

```bash
nano .env
```

E altere as linhas:
```
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

## Testar Conexão

Após configurar, teste a conexão:

```bash
php test-connection.php
```

Ou teste diretamente:

```bash
mysql -u roboflex -p'Roboflex12@' -e "SHOW DATABASES;"
```

## Executar Migrations

Depois de configurar o banco de dados:

```bash
php artisan migrate
```

