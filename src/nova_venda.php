<?php
    session_start();

    // Remove os dados da venda que acabou de ser fechada da memória
    if (isset($_SESSION['ultima_venda'])) {
        unset($_SESSION['ultima_venda']);
    }

    // Garante que nenhuma mensagem de sucesso antiga fique perdida na tela
    if (isset($_SESSION['sucesso'])) {
        unset($_SESSION['sucesso']);
    }

    // Redireciona o caixa de volta para o estado inicial pronto para bipar
    header("Location: ../index.php");
    exit;