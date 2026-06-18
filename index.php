<?php
    session_start();
    require_once 'config/connection.php';

// 1. Inicializa as variáveis de controle que a tela vai precisar
    $total_venda = 0;
    $carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];
    $erro = isset($_SESSION['erro']) ? $_SESSION['erro'] : null;
    $ultima_venda = isset($_SESSION['ultima_venda']) ? $_SESSION['ultima_venda'] : null;
    $sucesso = isset($_SESSION['sucesso']) ? $_SESSION['sucesso'] : null;

// Limpa as mensagens de erro da sessão para não repetirem no próximo reload
    if ($erro) {
        unset($_SESSION['erro']);
    }

// 2. Processa a lógica de cálculo do total do carrinho atual (se houver itens)
    if (!empty($carrinho)) {
        foreach ($carrinho as $item) {
            $total_venda += $item['preco'] * $item['quantidade'];
        }
    }

    

// 3. CARREGA A VIEW (O HTML SEPARADO)
// Todas as variáveis criadas aqui em cima ficam disponíveis automaticamente dentro do arquivo abaixo
require_once 'views/caixa.view.php';