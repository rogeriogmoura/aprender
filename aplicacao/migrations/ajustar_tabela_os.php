<?php
// aplicacao/migrations/ajustar_tabela_os.php
// Ajusta a tabela os para alinhar com o sistema (tecnico_id, valor_total, observacoes, status completo).

require_once __DIR__ . '/_conexao.php';

class AjustarTabelaOs {

    public function up(PDO $pdo) {
        // Adicionar tecnico_id se não existir
        $col = $pdo->query("SHOW COLUMNS FROM os LIKE 'tecnico_id'")->fetch();
        if (!$col) {
            $pdo->exec("ALTER TABLE os ADD COLUMN tecnico_id INT NULL AFTER cliente_id");
            try {
                $pdo->exec("ALTER TABLE os ADD CONSTRAINT fk_os_tecnico FOREIGN KEY (tecnico_id) REFERENCES tecnico(id) ON DELETE SET NULL ON UPDATE CASCADE");
            } catch (Exception $e) {}
        }

        // Adicionar valor_total se não existir
        $col = $pdo->query("SHOW COLUMNS FROM os LIKE 'valor_total'")->fetch();
        if (!$col) {
            $pdo->exec("ALTER TABLE os ADD COLUMN valor_total DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER status");
        }

        // Adicionar observacoes se não existir
        $col = $pdo->query("SHOW COLUMNS FROM os LIKE 'observacoes'")->fetch();
        if (!$col) {
            $pdo->exec("ALTER TABLE os ADD COLUMN observacoes VARCHAR(1000) NULL AFTER valor_total");
        }

        // Ajustar status para incluir todos
        try {
            $pdo->exec("
                ALTER TABLE os MODIFY status 
                ENUM('aberta','em_andamento','aguardando_peca','concluida','cancelada') 
                NOT NULL DEFAULT 'aberta'
            ");
        } catch (Exception $e) {}
    }

    public function down(PDO $pdo) {
        // Remover colunas extras (cuidado: pode apagar dados!)
        try { $pdo->exec("ALTER TABLE os DROP FOREIGN KEY fk_os_tecnico"); } catch (Exception $e) {}
        try { $pdo->exec("ALTER TABLE os DROP COLUMN tecnico_id"); } catch (Exception $e) {}
        try { $pdo->exec("ALTER TABLE os DROP COLUMN valor_total"); } catch (Exception $e) {}
        try { $pdo->exec("ALTER TABLE os DROP COLUMN observacoes"); } catch (Exception $e) {}

        // Restaurar status original
        try {
            $pdo->exec("
                ALTER TABLE os MODIFY status 
                ENUM('aberta','em_andamento','aguardando_peca') 
                NOT NULL DEFAULT 'aberta'
            ");
        } catch (Exception $e) {}
    }
}

// Execução via navegador
if (php_sapi_name() !== 'cli') {
    try {
        $pdo = conexao();
        $m = new AjustarTabelaOs();
        if (isset($_GET['acao']) && $_GET['acao'] === 'down') {
            $m->down($pdo);
            echo 'Migration DOWN executada: ajustes removidos.';
        } else {
            $m->up($pdo);
            echo 'Migration UP executada: ajustes aplicados na tabela os.';
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo 'Erro na migration: ' . htmlspecialchars($e->getMessage());
    }
}
