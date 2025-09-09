<?php
// aplicacao/migrations/criar_tabela_os_item.php
require_once __DIR__ . '/_conexao.php';

class CriarTabelaOsItem {
  public function up(PDO $pdo) {
    $pdo->exec("
      CREATE TABLE IF NOT EXISTS os_item (
        id INT AUTO_INCREMENT PRIMARY KEY,
        os_id INT NOT NULL,
        tipo ENUM('peca','servico') NOT NULL,
        descricao VARCHAR(255) NOT NULL,
        quantidade DECIMAL(10,2) NOT NULL DEFAULT 1.00,
        valor_unitario DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT fk_os_item_os FOREIGN KEY (os_id) REFERENCES os(id) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
    try { $pdo->exec("CREATE INDEX idx_os_item_os_id ON os_item (os_id)"); } catch (Exception $e) {}
  }
  public function down(PDO $pdo) {
    $pdo->exec("DROP TABLE IF EXISTS os_item");
  }
}
if (php_sapi_name() !== 'cli') {
  try {
    $pdo = conexao();
    $m = new CriarTabelaOsItem();
    if (isset($_GET['acao']) && $_GET['acao']==='down') { $m->down($pdo); echo 'DOWN: os_item removida.'; }
    else { $m->up($pdo); echo 'UP: os_item criada.'; }
  } catch (Exception $e) { http_response_code(500); echo 'Erro: '.htmlspecialchars($e->getMessage()); }
}
