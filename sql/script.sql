DROP DATABASE IF EXISTS meu_pdv;
CREATE DATABASE meu_pdv;
USE meu_pdv;

-- 1. Tabela de Produtos (Estoque/cadastro)
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_barras VARCHAR(50) NOT NULL UNIQUE,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    estoque INT NOT NULL DEFAULT 10
) ENGINE=InnoDB;

-- 2. Tabela de Vendas (Cabeçalho da venda)
CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total DECIMAL(10, 2) NOT NULL,
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. Tabela de Itens da Venda (O que foi comprado em cada venda)
CREATE TABLE itens_venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (venda_id) REFERENCES vendas(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
) ENGINE=InnoDB;

-- POPULANDO PARA TESTE / TEMPORÁRIO, AS ADIÇÕES SERÃO FEITAS PELO SISTEMA
INSERT INTO produtos (codigo_barras, nome, preco, estoque) VALUES 
('78910001', 'Coca-Cola Lata 350ml', 4.50, 15),
('78910002', 'Salgadinho Doritos 140g', 8.90, 20),
('78910003', 'Chocolate Bis Ao Leite', 6.20, 30);