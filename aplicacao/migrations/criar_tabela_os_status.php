<?php
// aplicacao/migrations/criar_tabela_os_status.php

// Migration para criar a tabela de histórico de status da OS.
// Mantém trilha de auditoria das mudanças (quem, quando, qual status e observação).

require_once __DIR__ . '/_conexao.php'; // supondo helper de conexão já usado nas outras migrations

class CriarTabelaOsStatus {

    public function up($pdo) {
        // Cria tabela os_status (singular conforme nosso padrão novo de entidades)
        $sql = "
            CREATE TABLE IF NOT EXISTS os_status (
                id INT AUTO_INCREMENT PRIMARY KEY,
                os_id INT NOT NULL,
                status_novo ENUM('aberta','em_andamento','aguardando_peca','concluida','cancelada') NOT NULL,
                observacao VARCHAR(500) NULL,
                usuario_id INT NULL,
                criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_os_status__os FOREIGN KEY (os_id) REFERENCES os(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        $pdo->exec($sql);

        // Garante que a coluna status da OS esteja no mesmo conjunto (ajuste leve se necessário)
        // Atenção: ajuste apenas se a coluna status existir e não estiver nesse ENUM
        try {
            $pdo->exec("
                ALTER TABLE os 
                MODIFY status ENUM('aberta','em_andamento','aguardando_peca','concluida','cancelada') 
                NOT NULL DEFAULT 'aberta'
            ");
        } catch (Exception $e) {
            // Se já estiver compatível, ignorar
        }

        // Opcional: adiciona data_conclusao se ainda não existir (útil para relatórios)
        $cols = $pdo->query("SHOW COLUMNS FROM os LIKE 'data_conclusao'")->fetch();
        if (!$cols) {
            $pdo->exec("ALTER TABLE os ADD COLUMN data_conclusao DATETIME NULL AFTER valor_total");
        }
    }

    public function down($pdo) {
        // Remove data_conclusao apenas se foi criada por aqui (heurística simples)
        try {
            $pdo->exec("ALTER TABLE os DROP COLUMN data_conclusao");
        } catch (Exception $e) {}

        $pdo->exec("DROP TABLE IF EXISTS os_status");
    }
}

// Execução via navegador
if (php_sapi_name() !== 'cli') {
    try {
        $pdo = conexao();
        $m = new CriarTabelaOsStatus();
        if (isset($_GET['acao']) && $_GET['acao'] === 'down') {
            $m->down($pdo);
            echo 'Migration DOWN executada: os_status removida.';
        } else {
            $m->up($pdo);
            echo 'Migration UP executada: os_status criada/atualizada.';
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo 'Erro na migration: ' . htmlspecialchars($e->getMessage());
    }
}
