<?php
session_start();
require_once 'config/connection.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$erro = isset($_SESSION['erro']) ? $_SESSION['erro'] : null;
$sucesso = isset($_SESSION['sucesso']) ? $_SESSION['sucesso'] : null;

if ($erro) { unset($_SESSION['erro']); }
if ($sucesso) { unset($_SESSION['sucesso']); }

try {
    $stmt = $conn->query("SELECT * FROM produtos ORDER BY nome ASC");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Se o banco não trouxer nada, avisa o desenvolvedor
    if (empty($produtos)) {
        echo "<p style='color:red; font-weight:bold; text-align:center;'>Aviso: A consulta funcionou, mas a tabela 'produtos' está totalmente vazia no seu banco de dados!</p>";
    }
} catch (PDOException $e) {
    die("Erro crítico ao buscar estoque no banco de dados: " . $e->getMessage());
}

require_once 'views/estoque.view.php';