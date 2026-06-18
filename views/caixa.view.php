<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDV - Frente de Caixa</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div class="container">

    <div class="col-esquerda">
        <h2><i class="fa-solid fa-cart-shopping"></i> Caixa Aberto - Registro de Itens</h2>

        <?php if ($erro): ?>
            <div class="alerta alerta-erro">
                <i class="fa-solid fa-xmark"></i> <?= $erro ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['sucesso'])): ?>
            <div class="alerta" style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
                <i class="fa-solid fa-check"></i> <?= $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?>
            </div>
        <?php endif; ?>

        <form action="src/adicionar_produto.php" method="POST" class="form-grupo">
            <input type="text" name="codigo_barras" class="input-barras" placeholder="Bipe o código de barras aqui..." autofocus required>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Código</th>
                    <th>Produto</th>
                    <th>Qtd</th>
                    <th>Preço Unit.</th>
                    <th>Subtotal</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($carrinho)): ?>
                    <?php 
                    $contador = 1;
                    foreach ($carrinho as $index => $item): 
                        $subtotal = $item['preco'] * $item['quantidade'];
                    ?>
                        <tr>
                            <td><?= $contador++ ?></td>
                            <td><?= $item['codigo_barras'] ?></td>
                            <td><?= $item['nome'] ?></td>
                            <td><?= $item['quantidade'] ?></td>
                            <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                            <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                            <td>
                                <a href="src/remover_item.php?index=<?= $index ?>" style="text-decoration: none;"><i class="fa-solid fa-xmark"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: #7f8c8d; padding: 30px;">
                            Nenhum produto registrado nesta venda.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="col-direita">
        <?php if ($ultima_venda): ?>
            <div>
                <h3 style="color: #4cd137;"><i class="fa-solid fa-basket-shopping"></i> VENDA Nº <?= $ultima_venda['id'] ?> REALIZADA</h3>
                <hr style="border-color: #555;">
                <ul style="text-align: left; padding-left: 10px; list-style: none;">
                    <?php foreach ($ultima_venda['itens'] as $item_comprado): ?>
                        <li style="font-size: 14px; margin-bottom: 5px;">
                            <?= $item_comprado['quantidade'] ?>x - <?= $item_comprado['nome'] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <div class="total-box">R$ <?= number_format($ultima_venda['total'], 2, ',', '.') ?></div>
                <button onclick="window.open('cupom.php', 'Cupom', 'width=320,height=600')" class="btn" style="background-color: #00a8ff; color: white;"> <i class="fa-solid fa-print"></i> Imprimir Cupom</button>
                <form action="src/nova_venda.php" method="POST">
                    <button type="submit" class="btn btn-finalizar">Próximo Cliente</button>
                </form>
            </div>
        <?php else: ?>
            <div>
                <h2 style="margin-top: 0; color: #dcdde1;">TOTAL DA COMPRA</h2>
                <div class="total-box">
                    R$ <?= number_format($total_venda, 2, ',', '.') ?>
                </div>
            </div>
            <div>
                <form action="src/finalizar_venda.php" method="POST">
                    <button type="submit" class="btn btn-finalizar">Finalizar Venda (F2)</button>
                </form>
                <form action="src/limpar_carrinho.php" method="POST">
                    <button type="submit" class="btn btn-cancelar">Cancelar Venda</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

</div>

</body>
</html>