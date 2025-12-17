# Como Iniciar a Aplicação

## ✅ Migrations Executadas!

Agora você pode iniciar a aplicação.

## Passos para Iniciar

### 1. Iniciar o Servidor de Desenvolvimento

```bash
php artisan serve
```

A aplicação estará disponível em: **http://localhost:8000**

### 2. Acessar no Navegador

- **Tela Principal (Votação)**: http://localhost:8000
- **Tela de Apuração**: http://localhost:8000/apuracao

### 3. Para Acessar de Outros Dispositivos na Rede

Se quiser acessar de um smartphone na mesma rede:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Depois acesse pelo IP da máquina: `http://SEU_IP:8000`

Para descobrir seu IP:
```bash
hostname -I
```

## Funcionalidades da Aplicação

✅ **Lista de Funcionários**
- Busca dados da API Thalamus
- Mostra nome completo e foto de cada funcionário
- Interface responsiva para smartphones

✅ **Sistema de Votação**
- Clique em um funcionário para votar
- Modal de confirmação
- Validação de dispositivo único (MAC address)
- Prevenção de votos duplicados

✅ **Apuração/Ranking**
- Visualização do ranking de votos
- Total de votos
- Medalhas para os 3 primeiros colocados

## Estrutura do Banco de Dados

A tabela `votos` foi criada com:
- `id` - ID único do voto
- `pessoa_id` - ID da pessoa votada
- `nome_completo` - Nome completo da pessoa
- `mac_address` - Identificador único do dispositivo
- `created_at` e `updated_at` - Timestamps

## Configuração da API

A aplicação busca os funcionários de:
```
https://api.thalamus.ind.br/api/pessoas-abada
```

As fotos são carregadas de:
```
https://api.thalamus.ind.br/storage/{path_image}
```

## Troubleshooting

### Se a API não responder:
- Verifique sua conexão com a internet
- Os logs estarão em `storage/logs/laravel.log`

### Se houver erro 500:
```bash
# Limpar cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Ver logs em tempo real:
```bash
tail -f storage/logs/laravel.log
```

## Próximos Passos

1. ✅ Migrations executadas
2. ✅ Banco de dados configurado
3. 🚀 Iniciar servidor: `php artisan serve`
4. 📱 Testar em smartphone
5. 🎉 Começar a votar!

