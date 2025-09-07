<?php
$mysqli = new mysqli("localhost", "root", "", "utierp");

$sql = "
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE,
    telefone VARCHAR(20),
    cpf_cnpj VARCHAR(20),
    endereco VARCHAR(255),
    cidade VARCHAR(100),
    uf CHAR(2),
    ativo TINYINT(1) DEFAULT 1,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if ($mysqli->query($sql) === TRUE) {
    echo 'Tabela clientes criada com sucesso!';
} else {
    echo 'Erro ao criar tabela: ' . $mysqli->error;
}
