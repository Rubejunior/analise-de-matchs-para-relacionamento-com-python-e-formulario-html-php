<?php
// Arquivo de configuração com as credenciais do banco de dados
define('DB_HOST', 'localhost'); // Ex: mysql.hostinger.com  // ou localhost
define('DB_NAME', 'colocar_name');
define('DB_USER', 'colocar_name');
define('DB_PASS', 'colocar_senha');


// Função para conectar ao banco de dados
function conectarDB() {
    try {
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
    }
}
?>