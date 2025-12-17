# Sistema de Votação - Melhor Abadá da Festa

Aplicação Laravel com Blade para votação em dispositivos móveis.

## Funcionalidades

- Lista de funcionários da empresa Roboflex com fotos
- Votação com validação de MAC address (um voto por dispositivo)
- Tela de apuração com ranking
- Interface responsiva para smartphones

## Instalação

1. Instalar dependências:
```bash
composer install
```

2. Copiar arquivo de ambiente:
```bash
cp .env.example .env
```

3. Gerar chave da aplicação:
```bash
php artisan key:generate
```

4. Configurar banco de dados MySQL no arquivo `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=votacao
DB_USERNAME=roboflex
DB_PASSWORD=Roboflex12@
```

5. Criar o banco de dados MySQL (se ainda não existir):
```bash
mysql -u roboflex -p -e "CREATE DATABASE IF NOT EXISTS votacao;"
```

6. Executar migrations:
```bash
php artisan migrate
```

7. Iniciar servidor:
```bash
php artisan serve
```

A aplicação estará disponível em `http://localhost:8000`

## Configuração

A URL da API Thalamus pode ser configurada no arquivo `.env`:
```
API_THALAMUS_URL=https://api.thalamus.ind.br
```

## Estrutura

- **Rotas**: `routes/web.php`
- **Controllers**: `app/Http/Controllers/`
- **Models**: `app/Models/Voto.php`
- **Views**: `resources/views/`
- **Migrations**: `database/migrations/`

