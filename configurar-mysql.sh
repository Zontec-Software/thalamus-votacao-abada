#!/bin/bash

echo "=========================================="
echo "Configuração do MySQL para Votação"
echo "=========================================="
echo ""
echo "Este script irá criar:"
echo "  - Banco de dados: votacao"
echo "  - Usuário: roboflex"
echo "  - Senha: Roboflex12@"
echo ""
echo "Você precisará da senha do usuário root do MySQL."
echo ""
read -p "Pressione ENTER para continuar ou CTRL+C para cancelar..."

mysql -u root -p << EOF
CREATE DATABASE IF NOT EXISTS votacao CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'roboflex'@'localhost' IDENTIFIED BY 'Roboflex12@';
GRANT ALL PRIVILEGES ON votacao.* TO 'roboflex'@'localhost';
FLUSH PRIVILEGES;
SELECT 'Banco de dados e usuário criados com sucesso!' AS Status;
EOF

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Configuração concluída!"
    echo ""
    echo "Agora você pode executar:"
    echo "  php artisan migrate"
else
    echo ""
    echo "❌ Erro ao configurar. Verifique a senha do root."
fi
