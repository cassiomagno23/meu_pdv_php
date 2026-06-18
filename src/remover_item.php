<?php

    session_start();
    require_once '../config/connection.php';

    // Verificar se o método GET foi executado
    if(isset($_GET['index']) && is_numeric($_GET['index'])) {
        
        $index = (int)$_GET['index'];

        // Verificar se o item existe dentro do carrinho antes de apagar
        if(isset($_SESSION['carrinho'][$index])){

            // Armazena o nome do produto na variável
            $nome_produto = $_SESSION['carrinho'][$index]['nome'];

            // exclui o item de dentro do carrinho
            unset($_SESSION['carrinho'][$index]);

            // reorganiza os indices - O array_values é uma função de array
            $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);

            $_SESSION['sucesso'] = "Produto '$nome_produto' removido com sucesso";
        }else {
            $_SESSION['erro'] = "Item não encontre no carrinho";
        }
    } else {
        $_SESSION['erro'] = "Requisição inválida.";
    }

    header("Location: ../index.php");
    exit;