# 🛒 Sistema de PDV (Ponto de Venda) - Caixa Simplificado

[![PHP Version](https://img.shields.io/badge/php-%5E8.0-777bb4.svg?style=flat-flat)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=flat-flat&logo=mysql&logoColor=white)](https://www.mysql.com/)

Um sistema de Ponto de Venda (PDV) backend desenvolvido em PHP para gerenciamento de um caixa de mercado ou comércio local. O sistema simula o fluxo real de bipe de produtos através de código de barras, gerenciamento de carrinho em sessão e finalização de venda blindada por transações no banco de dados.

---

## 🚀 Funcionalidades

* **Inserção de Produtos por Código de Barras:** Busca automatizada no banco de dados via requisição POST.
* **Gerenciamento Inteligente do Carrinho:** * Se o produto já estiver no carrinho, incrementa a quantidade automaticamente.
    * Se for um item novo, adiciona-o com preço unitário e dados iniciais.
* **Remoção com Reindexação:** Opção de excluir itens do carrinho limpando "buracos" na memória do array (`array_values`).
* **Finalização Segura de Venda (ACID):** Uso de **PDO Transactions** (`beginTransaction`, `commit`, `rollBack`). Se houver falha ao registrar os itens, o banco de dados desfaz a venda inteira automaticamente para evitar dados corrompidos.
* **Validação de Segurança:** Bloqueio contra finalização de vendas vazias.

---

## 🛠️ Tecnologias Utilizadas

* **Linguagem:** PHP 8.x (Estruturado)
* **Banco de Dados:** MySQL
* **Persistência de Dados:** `$_SESSION` do PHP para controle do carrinho de compras.
* **Driver de Conexão:** PDO (PHP Data Objects) com tratamento de exceções (`PDOException`).

---

## 📋 Pré-requisitos & Estrutura do Banco

Antes de rodar o projeto, você precisará de um ambiente de servidor local como o **XAMPP**, **WampServer** ou **Laragon** com o PHP 8.0+.

### Estrutura das Tabelas (SQL)

Crie as tabelas no seu banco de dados utilizando o script abaixo:

```sql
CREATE DATABASE pdv_sistema;
USE pdv_sistema;

-- Tabela de Produtos
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_barras VARCHAR(50) UNIQUE NOT NULL,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL
);

-- Tabela de Vendas
CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total DECIMAL(10,2) NOT NULL,
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Itens da Venda (Relacionamento)
CREATE TABLE itens_venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (venda_id) REFERENCES vendas(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);
```


##🔧 Como Instalar e Rodar
1 - Faça o clone deste repositório para a pasta do seu servidor local (ex: C:/xampp/htdocs/):

git clone LINK DO REPOSITÓRIO DO SEU GIT pdv

2 - Importe o arquivo SQL acima no seu phpMyAdmin.

3 - Configure as credenciais do seu banco de dados no arquivo config/connection.php.

4 - Insira alguns produtos de teste no banco com códigos de barras fictícios (ex: 789123456).

5 - Acesse no navegador: http://localhost/pdv/src/index.php

---

##📂 Estrutura de Pastas do Projeto

<img width="550" height="166" alt="image" src="https://github.com/user-attachments/assets/650ac273-cf50-4c36-8f0d-c309655bc6ab" />

---

##💡 Aprendizados Aplicados

Este projeto foi fundamental para consolidar conceitos críticos de desenvolvimento Web Backend:

Manipulação avançada de arrays superglobais ($_SESSION).

Proteção contra SQL Injection utilizando prepare() e execute() com parâmetros nomeados no PDO.

Importância da atomicidade em sistemas financeiros/vendas utilizando o controle transacional do MySQL via PHP.

Feito com ☕ por Cassio Furtado

---

### 💡 Dicas de customização antes de salvar:

1. Troque onde diz `SEU-USUARIO` nas URLs de clone e do rodapé pelo seu nome de usuário real do GitHub.
2. Altere o nome das pastas na seção de **Estrutura de Pastas** caso o seu projeto real use nomes um pouquinho diferentes.
