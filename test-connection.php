<?php

// Script de teste de conexão MySQL
$host = '127.0.0.1';
$port = 3306;
$database = 'votacao';
$username = 'roboflex';
$password = 'Roboflex12@';

echo "Testando conexão MySQL...\n";
echo "Host: $host\n";
echo "Port: $port\n";
echo "Database: $database\n";
echo "Username: $username\n";
echo "Password: " . str_repeat('*', strlen($password)) . "\n\n";

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "✅ Conexão estabelecida com sucesso!\n\n";
    
    // Verificar se o banco existe
    $stmt = $pdo->query("SHOW DATABASES LIKE '$database'");
    $dbExists = $stmt->rowCount() > 0;
    
    if ($dbExists) {
        echo "✅ Banco de dados '$database' existe.\n";
    } else {
        echo "❌ Banco de dados '$database' NÃO existe.\n";
        echo "   Execute: CREATE DATABASE $database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
    }
    
    // Tentar usar o banco
    try {
        $pdo->exec("USE $database");
        echo "✅ Conseguiu acessar o banco '$database'.\n";
    } catch (PDOException $e) {
        echo "❌ Não conseguiu acessar o banco '$database': " . $e->getMessage() . "\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Erro de conexão: " . $e->getMessage() . "\n\n";
    echo "Possíveis soluções:\n";
    echo "1. Verifique se o MySQL está rodando: sudo systemctl status mysql\n";
    echo "2. Crie o usuário e banco de dados:\n";
    echo "   mysql -u root -p\n";
    echo "   CREATE DATABASE votacao CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
    echo "   CREATE USER 'roboflex'@'localhost' IDENTIFIED BY 'Roboflex12@';\n";
    echo "   GRANT ALL PRIVILEGES ON votacao.* TO 'roboflex'@'localhost';\n";
    echo "   FLUSH PRIVILEGES;\n";
}

