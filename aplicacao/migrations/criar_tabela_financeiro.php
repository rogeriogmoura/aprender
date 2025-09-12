<?php
// aplicacao/migrations/criar_tabela_financeiro.php
require_once __DIR__ . '/_conexao_mysqli.php'; 
// OBS: vamos criar este _conexao_mysqli.php para centralizar conexões com mysqli

class CriarTabelaFinanceiro {
  public function up($mysqli) {
    $sql = "
      CREATE TABLE IF NOT EXISTS financeiro (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tipo ENUM('receita','despesa') NOT NULL,
        descricao VARCHAR(255) NOT NULL,
        valor DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        data_lancamento DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        forma_pagamento ENUM('dinheiro','cartao','pix','boleto','transferencia','outro') DEFAULT 'outro',
        categoria VARCHAR(60) NULL,
        os_id INT NULL,
        observacoes VARCHAR(255) NULL,
        referencia VARCHAR(50) NULL UNIQUE, /* exemplo: OS#123 evita duplicidade */
        criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT fk_financeiro_os FOREIGN KEY (os_id) REFERENCES os(id) ON DELETE SET NULL ON UPDATE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    if (!$mysqli->query($sql)) {
      throw new Exception("Erro ao criar tabela: " . $mysqli->error);
    }
  }

  public function down($mysqli) {
    $sql = "DROP TABLE IF EXISTS financeiro";
    if (!$mysqli->query($sql)) {
      throw new Exception("Erro ao remover tabela: " . $mysqli->error);
    }
  }
}

// executa no navegador
try {
  $mysqli = conexao_mysqli();
  $m = new CriarTabelaFinanceiro();

  if (isset($_GET['acao']) && $_GET['acao'] === 'down') {
    $m->down($mysqli);
    echo 'DOWN: tabela financeiro removida.';
  } else {
    $m->up($mysqli);
    echo 'UP: tabela financeiro criada.';
  }
} catch (Exception $e) {
  http_response_code(500);
  echo 'Erro na migration: ' . htmlspecialchars($e->getMessage());
}
