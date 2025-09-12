<?php
require_once __DIR__ . '/_conexao_mysqli.php';

class CriarTabelaTecnico {
  public function up($mysqli) {
    $sql = "
      CREATE TABLE IF NOT EXISTS tecnico (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(150) NOT NULL,
        email VARCHAR(150),
        telefone VARCHAR(50),
        ativo TINYINT(1) NOT NULL DEFAULT 1,
        criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    if (!$mysqli->query($sql)) throw new Exception($mysqli->error);
  }

  public function down($mysqli) {
    if (!$mysqli->query("DROP TABLE IF EXISTS tecnico")) throw new Exception($mysqli->error);
  }
}

try {
  $mysqli = conexao_mysqli();
  $m = new CriarTabelaTecnico();
  if (isset($_GET['acao']) && $_GET['acao'] === 'down') {
    $m->down($mysqli);
    echo "DOWN: tabela tecnico removida.";
  } else {
    $m->up($mysqli);
    echo "UP: tabela tecnico criada.";
  }
} catch (Exception $e) {
  echo "Erro: " . $e->getMessage();
}
