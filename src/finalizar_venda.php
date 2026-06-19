<?php

    session_start();
    require_once '../config/connection.php';

    // Validação para não finalizar uma venda sem produto
    if(!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
        
        $_SESSION['erro'] = "Não é possivel finalizar uma venda sem itens no carrinho";    
        
        header("Location: ../index.php");
        exit;
    }

    $total_venda = 0;
    foreach($_SESSION['carrinho'] as $item){
        $total_venda += $item['preco'] * $item['quantidade'];
    }

    try {
        // Esta parte inicia a transação, ela vai bloquear o banco para garantir a segurança
        $conn->beginTransaction();

        $stmtVenda = $conn->prepare("INSERT INTO vendas (total) VALUES (:total)");
        $stmtVenda->execute(['total' => $total_venda]);

        $vendaId = $conn->lastInsertId();

        $stmtItem = $conn->prepare("
            INSERT INTO itens_venda (venda_id, produto_id, quantidade, preco_unitario)
            VALUES (:venda_id, :produto_id, :quantidade, :preco_unitario)
        ");

        $stmtBaixaEstoque = $conn->prepare("
            UPDATE produtos
            SET estoque = estoque - :quantidade_comprada
            WHERE id = :produto_id
        ");

        foreach ($_SESSION['carrinho'] as $item) {
        $stmtItem->execute([
            'venda_id' => $vendaId,
            'produto_id' => $item['id'],
            'quantidade' => $item['quantidade'],
            'preco_unitario' => $item['preco']
        ]);

        $stmtBaixaEstoque->execute([
            'quantidade_comprada' => $item['quantidade'],
            'produto_id' => $item['id']
        ]);
    }
        $conn->commit(); // Confirma e grava no banco

        $_SESSION['ultima_venda'] = [
            'id' => $vendaId,
            'itens' => $_SESSION['carrinho'],
            'total' => $total_venda
        ];

        unset($_SESSION['carrinho']);

        $_SESSION['sucesso'] = "Venda Nº $vendaId finalizada com sucesso!";

    } catch (Exception $e) {
        // Se em algum momento o try falhar o banco cancela tudo o que foi feito
        $conn->rollBack();
        $_SESSION['erro'] = "Erro crítico ao salvar a venda. a operação foi cancelada" . $e->getMessage();
    }

    header("Location: ../index.php");
    exit;