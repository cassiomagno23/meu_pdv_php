<?php

    session_start();
    
    // Requisção de conexão com o banco.
    require_once '../config/connection.php';

    // Verificar se o form enviou um código de barras
    if(isset($_POST['codigo_barras']) && !empty(trim($_POST['codigo_barras']))){
        $codigo_barras = trim($_POST['codigo_barras']); // Esse codigo_barras vem la no name do input do form

        try{
        //Realiza a busca do produto lá no banco através do código de barras
            $stmt = $conn->prepare("SELECT * FROM produtos WHERE codigo_barras = :codigo");
            $stmt->execute(['codigo' => $codigo_barras]); // Essa variavel $codigo_barras ja foi declarada abaixo do if
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$produto) {
                $_SESSION['erro'] = "Produto com o código '$codigo_barras' não cadastrado!";
            }else {
                if(!isset($_SESSION['carrinho'])) {
                    $_SESSION['carrinho'] = [];
                }

                // Verificar se o produto ta no carrinho, e faz a soma da quantidade
                $id_produto = $produto['id'];
                $ja_existe = false;

                foreach($_SESSION['carrinho'] as $index => $item) {
                    if($item['id'] == $id_produto) {
                        $_SESSION['carrinho'][$index]['quantidade'] += 1;
                        $ja_existe = true;
                        break;
                    }
                }
                // Se não existe no carrinho adiciona o item
                if(!$ja_existe) {
                    $_SESSION['carrinho'][] = [
                        'id' => $produto['id'],
                        'codigo_barras' => $produto['codigo_barras'],
                        'nome' => $produto['nome'],
                        'preco' => $produto['preco'],
                        'quantidade' => 1
                    ];
                }
            }  
        } catch (PDOException $e) {
        $_SESSION['erro'] = "Erro na busca do banco de dados: " . $e->getMessage();
    }
}

    // Retorna para pagina inicial do caixa
    header("Location: ../index.php");
    exit;

