<?php

    session_start();
    require_once '../config/connection.php';

    if(isset($_SESSION['carrinho'])){
        
        unset($_SESSION['carrinho']);

        $_SESSION['sucesso'] = "Venda cencelada com sucesso";
    }

    header("Location: ../index.php");
    exit;