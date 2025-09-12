<?php
require_once __DIR__ . '/_conexao_mysqli.php';

class CriarTabelaOS {
  public function up($mysqli) {
    $sql = "
      CREATE TABLE IF NOT EXISTS os (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cliente_id INT NOT NULL,
        tecnico_id INT NULL,
        descricao TEXT NOT NULL,
        status ENUM('aberta','em_andamento','aguardando_peca','concluida','cancelada') DEFAULT 'aberta',
        valor_total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        observacoes TEXT NULL,
        data_abertura DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        data_conclusao DATETIME NULL,
        CONSTRAINT fk_os_cliente FOREIGN KEY (cliente_id) REFERENCES clientes(id),
        CONSTRAINT fk_os_tecnico FOREIGN KEY (tecnico_id) REFERENCES tecnico(id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    if (!$mysqli->query($sql)) throw new Exception($mysqli->error);
  }

  public function down($mysqli) {
    if (!$mysqli->query("DROP TABLE IF EXISTS os")) throw new Exception($mysqli->error);
  }
}

try {
  $mysqli = conexao_mysqli();
  $m = new CriarTabelaOS();
  if (isset($_GET['acao']) && $_GET['acao'] === 'down') {
    $m->down($mysqli);
    echo "DOWN: tabela os removida.";
  } else {
    $m->up($mysqli);
    echo "UP: tabela os criada.";
  }
} catch (Exception $e) {
  echo "Erro: " . $e->getMessage();
}
