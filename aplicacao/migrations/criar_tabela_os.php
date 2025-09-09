<?php
// aplicacao/migrations/criar_tabela_os.php
// Cria/ajusta a tabela `os` com FKs para clientes e tecnico.

require_once __DIR__ . '/_conexao.php';

class CriarTabelaOs {

    public function up(PDO $pdo) {
        // 1) Criar tabela se não existir
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS os (
                id INT AUTO_INCREMENT PRIMARY KEY,
                cliente_id INT NOT NULL,
                tecnico_id INT NULL,
                descricao TEXT NOT NULL,
                status ENUM('aberta','em_andamento','aguardando_peca','concluida','cancelada') NOT NULL DEFAULT 'aberta',
                valor_total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                data_conclusao DATETIME NULL,
                observacoes VARCHAR(1000) NULL,
                criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        // 2) Garantir colunas/ajustes leves (idempotentes)
        // valor_total
        try { $pdo->exec("ALTER TABLE os MODIFY valor_total DECIMAL(10,2) NOT NULL DEFAULT 0.00"); } catch (Exception $e) {}
        // status enum
        try {
            $pdo->exec("
                ALTER TABLE os MODIFY status 
                ENUM('aberta','em_andamento','aguardando_peca','concluida','cancelada') 
                NOT NULL DEFAULT 'aberta'
            ");
        } catch (Exception $e) {}
        // data_conclusao (caso não exista)
        $col = $pdo->query("SHOW COLUMNS FROM os LIKE 'data_conclusao'")->fetch();
        if (!$col) { $pdo->exec("ALTER TABLE os ADD COLUMN data_conclusao DATETIME NULL AFTER valor_total"); }

        // 3) Criar índices e FKs (se existirem as tabelas alvo)
        // Índices
        try { $pdo->exec("CREATE INDEX idx_os_cliente ON os (cliente_id)"); } catch (Exception $e) {}
        try { $pdo->exec("CREATE INDEX idx_os_tecnico ON os (tecnico_id)"); } catch (Exception $e) {}

        // FKs (somente se colunas existirem e evitar duplicar constraints)
        // clientes (tabela plural já existente)
        $this->criarFKSeNaoExiste($pdo, 'fk_os_clientes', "
            ALTER TABLE os ADD CONSTRAINT fk_os_clientes
            FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE RESTRICT ON UPDATE CASCADE
        ");
        // tecnico (tabela singular)
        $this->criarFKSeNaoExiste($pdo, 'fk_os_tecnico', "
            ALTER TABLE os ADD CONSTRAINT fk_os_tecnico
            FOREIGN KEY (tecnico_id) REFERENCES tecnico(id) ON DELETE SET NULL ON UPDATE CASCADE
        ");
    }

    public function down(PDO $pdo) {
        // Remover FKs (tolerante a erro)
        foreach (['fk_os_clientes','fk_os_tecnico'] as $fk) {
            try { $pdo->exec("ALTER TABLE os DROP FOREIGN KEY $fk"); } catch (Exception $e) {}
        }
        // Dropar tabela
        $pdo->exec("DROP TABLE IF EXISTS os");
    }

    private function criarFKSeNaoExiste(PDO $pdo, string $nome, string $sqlAddFk) {
        $existe = $pdo->query("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME='os' AND CONSTRAINT_NAME='{$nome}'
        ")->fetch();
        if (!$existe) {
            try { $pdo->exec($sqlAddFk); } catch (Exception $e) { /* ignora se tabela alvo não existir ainda */ }
        }
    }
}

// Execução via navegador
if (php_sapi_name() !== 'cli') {
    try {
        $pdo = conexao();
        $m = new CriarTabelaOs();
        if (isset($_GET['acao']) && $_GET['acao'] === 'down') {
            $m->down($pdo);
            echo 'Migration DOWN executada: os removida.';
        } else {
            $m->up($pdo);
            echo 'Migration UP executada: os criada/ajustada.';
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo 'Erro na migration: ' . htmlspecialchars($e->getMessage());
    }
}
