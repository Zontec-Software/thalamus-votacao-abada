# Instruções de Instalação

## Pré-requisitos

- PHP 8.1 ou superior
- Composer
- MySQL 5.7 ou superior
- Extensões PHP: pdo_mysql, mbstring, openssl, tokenizer, xml, ctype, json

## Passos de Instalação

1. **Instalar dependências do Composer:**
```bash
composer install
```

2. **Copiar arquivo de ambiente:**
```bash
cp .env.example .env
```

3. **Gerar chave da aplicação:**
```bash
php artisan key:generate
```

4. **Configurar banco de dados MySQL no arquivo `.env`:**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=votacao
DB_USERNAME=roboflex
DB_PASSWORD=Roboflex12@
```

5. **Criar o banco de dados MySQL (se ainda não existir):**
```bash
mysql -u roboflex -p -e "CREATE DATABASE IF NOT EXISTS votacao;"
```
Ou acesse o MySQL e execute:
```sql
CREATE DATABASE IF NOT EXISTS votacao;
```

6. **Executar migrations:**
```bash
php artisan migrate
```

6. **Dar permissões aos diretórios de storage:**
```bash
chmod -R 775 storage bootstrap/cache
```

7. **Iniciar servidor de desenvolvimento:**
```bash
php artisan serve
```

A aplicação estará disponível em `http://localhost:8000`

## Configuração da API

A URL da API Thalamus está configurada no arquivo `.env`:
```
API_THALAMUS_URL=https://api.thalamus.ind.br
```

## Estrutura do Banco de Dados

A aplicação usa MySQL. A tabela `votos` armazena:
- `id`: ID único do voto
- `pessoa_id`: ID da pessoa votada
- `nome_completo`: Nome completo da pessoa
- `mac_address`: Identificador único do dispositivo
- `created_at` e `updated_at`: Timestamps

## Funcionalidades

- ✅ Lista de funcionários com fotos da API Thalamus
- ✅ Votação com validação de dispositivo único (MAC address)
- ✅ Modal de confirmação antes de votar
- ✅ Tela de apuração com ranking
- ✅ Interface responsiva para smartphones
- ✅ Prevenção de votos duplicados por dispositivo

