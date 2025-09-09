<?php
// aplicacao/migrations/criar_tabela_tecnico.php
// Cria/ajusta a tabela `tecnico` (singular conforme definido).

require_once __DIR__ . '/_conexao.php';

class CriarTabelaTecnico {

    public function up(PDO $pdo) {
        // 1) Criar tabela se não existir
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS tecnico (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(150) NOT NULL,
                email VARCHAR(150) NULL,
                telefone VARCHAR(30) NULL,
                ativo TINYINT(1) NOT NULL DEFAULT 1,
                criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        // 2) Ajustes idempotentes
        try { $pdo->exec("CREATE INDEX idx_tecnico_nome ON tecnico (nome)"); } catch (Exception $e) {}
        try { $pdo->exec("ALTER TABLE tecnico MODIFY ativo TINYINT(1) NOT NULL DEFAULT 1"); } catch (Exception $e) {}
    }

    public function down(PDO $pdo) {
        $pdo->exec("DROP TABLE IF EXISTS tecnico");
    }
}

// Execução via navegador
if (php_sapi_name() !== 'cli') {
    try {
        $pdo = conexao();
        $m = new CriarTabelaTecnico();
        if (isset($_GET['acao']) && $_GET['acao'] === 'down') {
            $m->down($pdo);
            echo 'Migration DOWN executada: tecnico removida.';
        } else {
            $m->up($pdo);
            echo 'Migration UP executada: tecnico criada/ajustada.';
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo 'Erro na migration: ' . htmlspecialchars($e->getMessage());
    }
}
