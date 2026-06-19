<?php

    session_start();
    require_once '../config/connection.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = (int)$_POST['id'];
        $novo_estoque = (int)$_POST['estoque'];

        try {
            $stmt = $conn->prepare("UPDATE produtos SET estoque = :estoque WHERE id = :id");
            $stmt->execute([
                'estoque' => $novo_estoque,
                'id' => $id
            ]);

            $_SESSION['sucesso'] = "Quantidade de estoque atualizada com sucesso!";
    } catch (PDOException $e) {
        $_SESSION['erro'] = "Erro ao atualizar estoque: " . $e->getMessage();
    }
}

// Redireciona de volta para a página de estoque
header("Location: ../estoque.php");
exit;