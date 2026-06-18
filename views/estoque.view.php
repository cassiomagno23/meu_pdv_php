<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estoque</title>
    <link rel="stylesheet" href="css/estoque.css">
</head>
<body>

<div class="container">
    <div class="topo">
        <h2>Controle de Estoque (Produtos)</h2>
        <a href="index.php" class="btn-voltar" >Voltar para o Caixa</a>
    </div>

    <?php if ($sucesso): ?>
        <div class="alerta alerta-sucesso">✅ <?= $sucesso ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Produto</th>
                <th>Preço Unitário</th>
                <th>Estoque Atual</th>
                <th>Nova Quantidade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $prod): ?>
                <tr>
                    <td><?= $prod['codigo_barras'] ?></td>
                    <td><strong><?= $prod['nome'] ?></strong></td>
                    <td>R$ <?= number_format($prod['preco'], 2, ',', '.') ?></td>
                    <td>
                        <span style="font-weight: bold; color: <?= $prod['estoque'] <= 5 ? '#e84118' : '#2f3640' ?>;">
                            <?= $prod['estoque'] ?> un
                        </span>
                    </td>
                    <td>
                        <form action="src/atualizar_estoque.php" method="POST" style="display: flex; gap: 10px; align-items: center;">
                            <input type="hidden" name="id" value="<?= $prod['id'] ?>">
                            <input type="number" name="estoque" class="input-qtd" min="0" value="<?= $prod['estoque'] ?>" required>
                            <button type="submit" class="btn-salvar">Atualizar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>