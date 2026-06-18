<?php
session_start();

// Segurança: Se não houver uma última venda gravada na sessão, não abre o cupom
if (!isset($_SESSION['ultima_venda'])) {
    die("Erro: Nenhuma venda activa para impressão de cupom.");
}

$venda = $_SESSION['ultima_venda'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cupom Não Fiscal - Venda Nº <?= $venda['id'] ?></title>
    <link rel="stylesheet" href="css/cupom.css">
</head>
<body>

    <div class="text-center">
        <strong>MINI MERCADO PHP LTDA</strong><br>
        Rua do Código, 123 - Centro<br>
        CNPJ: 00.000.000/0001-00<br>
        <span style="font-size: 10px;"><?= date('d/m/Y H:i:s') ?></span>
    </div>

    <div class="linha-divisoria"></div>

    <div class="text-center">
        <strong>CUPOM NÃO FISCAL</strong><br>
        Venda ID: #<?= $venda['id'] ?>
    </div>

    <div class="linha-divisoria"></div>

    <table class="tabela-itens">
        <thead>
            <tr>
                <th>Item (Qtd x Nome)</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($venda['itens'] as $item): ?>
                <tr>
                    <td>
                        <?= $item['quantidade'] ?>x <?= substr($item['nome'], 0, 20) ?><br>
                        <small><?= $item['quantidade'] ?> x R$ <?= number_format($item['preco'], 2, ',', '.') ?></small>
                    </td>
                    <td class="text-right" style="vertical-align: bottom;">
                        R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="linha-divisoria"></div>

    <table class="total-box">
        <tr>
            <td><strong>TOTAL VALOR:</strong></td>
            <td class="text-right"><strong>R$ <?= number_format($venda['total'], 2, ',', '.') ?></strong></td>
        </tr>
    </table>

    <div class="linha-divisoria"></div>

    <div class="text-center" style="font-size: 10px; margin-bottom: 20px;">
        Obrigado pela preferência!<br>
        Volte Sempre.
    </div>

    <div class="text-center btn-print">
        <button onclick="window.print()" style="padding: 8px 15px; font-weight: bold; cursor: pointer;">
            <i class="fa-solid fa-print"></i> Mandar Imprimir
        </button>
    </div>

</body>
</html>