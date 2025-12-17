<?php

echo "=== Verificação de Configuração MySQL ===\n\n";

// Ler configurações do .env
$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    die("❌ Arquivo .env não encontrado!\n");
}

$config = [];
$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    if (strpos($line, '=') === false) continue;
    list($key, $value) = explode('=', $line, 2);
    $config[trim($key)] = trim($value);
}

echo "Configurações do .env:\n";
echo "DB_CONNECTION: " . ($config['DB_CONNECTION'] ?? 'não definido') . "\n";
echo "DB_HOST: " . ($config['DB_HOST'] ?? 'não definido') . "\n";
echo "DB_PORT: " . ($config['DB_PORT'] ?? 'não definido') . "\n";
echo "DB_DATABASE: " . ($config['DB_DATABASE'] ?? 'não definido') . "\n";
echo "DB_USERNAME: " . ($config['DB_USERNAME'] ?? 'não definido') . "\n";
echo "DB_PASSWORD: " . str_repeat('*', strlen($config['DB_PASSWORD'] ?? '')) . "\n\n";

// Testar conexão
$host = $config['DB_HOST'] ?? '127.0.0.1';
$port = $config['DB_PORT'] ?? 3306;
$database = $config['DB_DATABASE'] ?? 'votacao';
$username = $config['DB_USERNAME'] ?? 'roboflex';
$password = $config['DB_PASSWORD'] ?? 'Roboflex12@';

echo "Testando conexão...\n";

try {
    // Testar conexão sem especificar banco
    $pdo = new PDO(
        "mysql:host=$host;port=$port",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "✅ Conexão estabelecida!\n\n";
    
    // Verificar usuários existentes
    echo "Usuários MySQL disponíveis:\n";
    $stmt = $pdo->query("SELECT User, Host FROM mysql.user WHERE User LIKE '%roboflex%' OR User LIKE '%root%' ORDER BY User");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($users)) {
        echo "  (nenhum usuário encontrado)\n";
    } else {
        foreach ($users as $user) {
            echo "  - {$user['User']}@{$user['Host']}\n";
        }
    }
    
    echo "\nBancos de dados disponíveis:\n";
    $stmt = $pdo->query("SHOW DATABASES");
    $dbs = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach ($dbs as $db) {
        $mark = ($db === $database) ? " ✅" : "";
        echo "  - $db$mark\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n\n";
    echo "=== SOLUÇÕES ===\n\n";
    echo "1. Se você tem acesso root, execute:\n";
    echo "   mysql -u root -p\n";
    echo "   Depois execute:\n";
    echo "   CREATE DATABASE votacao CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
    echo "   CREATE USER 'roboflex'@'localhost' IDENTIFIED BY 'Roboflex12@';\n";
    echo "   GRANT ALL PRIVILEGES ON votacao.* TO 'roboflex'@'localhost';\n";
    echo "   FLUSH PRIVILEGES;\n\n";
    
    echo "2. Se você já tem outro usuário MySQL, edite o .env:\n";
    echo "   nano .env\n";
    echo "   E altere DB_USERNAME e DB_PASSWORD\n\n";
    
    echo "3. Execute o script de configuração:\n";
    echo "   ./configurar-mysql.sh\n";
}

