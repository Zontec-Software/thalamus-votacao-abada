#!/bin/bash
echo "=========================================="
echo "Criando usuário e banco MySQL"
echo "=========================================="
echo ""
echo "Este script criará:"
echo "  - Banco: votacao"
echo "  - Usuário: roboflex"
echo "  - Senha: Roboflex12@"
echo ""
echo "Você precisará da senha do ROOT do MySQL"
echo ""
read -p "Pressione ENTER para continuar..."

mysql -u root -p < criar-usuario-mysql.sql

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ SUCESSO! Agora execute:"
    echo "   php artisan migrate"
else
    echo ""
    echo "❌ Erro. Verifique a senha do root."
fi
