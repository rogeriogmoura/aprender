<?php
// aplicacao/migrations/ajustar_status_os.php
// Atualiza a coluna status da tabela os para incluir todos os estados.

require_once __DIR__ . '/_conexao.php';

class AjustarStatusOs {

    public function up(PDO $pdo) {
        $pdo->exec("
            ALTER TABLE os 
            MODIFY status ENUM('aberta','em_andamento','aguardando_peca','concluida','cancelada') 
            NOT NULL DEFAULT 'aberta'
        ");
    }

    public function down(PDO $pdo) {
        $pdo->exec("
            ALTER TABLE os 
            MODIFY status ENUM('aberta','em_andamento','aguardando_peca') 
            NOT NULL DEFAULT 'aberta'
        ");
    }
}

// Execução via navegador
if (php_sapi_name() !== 'cli') {
    try {
        $pdo = conexao();
        $m = new AjustarStatusOs();
        if (isset($_GET['acao']) && $_GET['acao'] === 'down') {
            $m->down($pdo);
            echo 'Migration DOWN executada: status voltou para 3 valores.';
        } else {
            $m->up($pdo);
            echo 'Migration UP executada: status atualizado para 5 valores.';
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo 'Erro na migration: ' . htmlspecialchars($e->getMessage());
    }
}
