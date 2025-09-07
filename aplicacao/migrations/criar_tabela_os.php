<?php
$mysqli = new mysqli("localhost", "root", "", "utierp");

$sql = "
CREATE TABLE IF NOT EXISTS os (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    descricao TEXT NOT NULL,
    status ENUM('aberta','em andamento','aguardando peça','concluida','cancelada') DEFAULT 'aberta',
    valor_total DECIMAL(10,2) DEFAULT 0,
    data_abertura DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_conclusao DATETIME NULL,
    tecnico_id INT NULL,
    observacoes TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if ($mysqli->query($sql) === TRUE) {
    echo "Tabela OS criada com sucesso!";
} else {
    echo "Erro ao criar tabela: " . $mysqli->error;
}
