<?php
/**
 * Modelo Financeiro
 * Caminho: aplicacao/modelos/financeiro_modelo.php
 * Funções:
 *  - criar()              : cria lançamento (receita/despesa)
 *  - existe_referencia()  : evita duplicar auto-lançamentos (ex.: "OS#123")
 *  - listar()             : lista lançamentos por período e (opcional) tipo
 *  - resumo()             : retorna totais de receita, despesa e saldo
 *  - deletar()            : remove um lançamento
 *
 * Observações:
 *  - Usa mysqli + prepared statements (segurança contra SQL Injection).
 *  - Colunas NULL são aceitas (categoria, os_id, observacoes, referencia).
 */

class FinanceiroModelo {
    /** @var mysqli */
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    /**
     * Cria lançamento no financeiro.
     * @param string      $tipo            'receita' | 'despesa'
     * @param string      $descricao       descrição do lançamento
     * @param float       $valor           valor (positivo)
     * @param string|null $data_lancamento 'YYYY-mm-dd HH:ii:ss' (se null usa agora)
     * @param string      $forma_pagamento 'dinheiro','cartao','pix','boleto','transferencia','outro'
     * @param string|null $categoria       categoria livre (ex.: 'OS','Peças','Serviços')
     * @param int|null    $os_id           vínculo com OS (opcional)
     * @param string|null $observacoes     observações
     * @param string|null $referencia      texto único para evitar duplicidade (ex.: 'OS#123')
     * @return bool
     */
    public function criar(
        $tipo,
        $descricao,
        $valor,
        $data_lancamento = null,
        $forma_pagamento = 'outro',
        $categoria = null,
        $os_id = null,
        $observacoes = null,
        $referencia = null
    ) {
        $sql = "INSERT INTO financeiro
                  (tipo, descricao, valor, data_lancamento, forma_pagamento, categoria, os_id, observacoes, referencia)
                VALUES
                  (?,    ?,         ?,     ?,               ?,               ?,         ?,     ?,            ?)";
        $stmt = $this->db->prepare($sql);

        // Data padrão: agora
        $data = $data_lancamento ?: date('Y-m-d H:i:s');

        // Tipos: s s d s s s i s s  (9 parâmetros)
        $stmt->bind_param(
            "ssdsssiss",
            $tipo,
            $descricao,
            $valor,
            $data,
            $forma_pagamento,
            $categoria,
            $os_id,
            $observacoes,
            $referencia
        );

        return $stmt->execute();
    }

    /**
     * Verifica se já existe um lançamento com a mesma referência única.
     * Útil para não duplicar receitas automáticas da OS concluída.
     */
    public function existe_referencia($referencia) {
        $stmt = $this->db->prepare("SELECT id FROM financeiro WHERE referencia = ? LIMIT 1");
        $stmt->bind_param("s", $referencia);
        $stmt->execute();
        $res = $stmt->get_result();
        return (bool)$res->fetch_assoc();
    }

    /**
     * Lista lançamentos por período e (opcional) tipo.
     * $inicio/$fim no formato 'YYYY-mm-dd HH:ii:ss'
     * $tipo pode ser 'receita' ou 'despesa' ou null (todos).
     */
    public function listar($inicio, $fim, $tipo = null) {
        if ($tipo && in_array($tipo, ['receita','despesa'], true)) {
            $stmt = $this->db->prepare("
                SELECT * FROM financeiro
                WHERE data_lancamento BETWEEN ? AND ? AND tipo = ?
                ORDER BY data_lancamento DESC, id DESC
            ");
            $stmt->bind_param("sss", $inicio, $fim, $tipo);
        } else {
            $stmt = $this->db->prepare("
                SELECT * FROM financeiro
                WHERE data_lancamento BETWEEN ? AND ?
                ORDER BY data_lancamento DESC, id DESC
            ");
            $stmt->bind_param("ss", $inicio, $fim);
        }
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * Resumo do período: totais de receita, despesa e saldo.
     */
    public function resumo($inicio, $fim) {
        $stmt = $this->db->prepare("
            SELECT
              SUM(CASE WHEN tipo='receita' THEN valor ELSE 0 END) AS total_receita,
              SUM(CASE WHEN tipo='despesa' THEN valor ELSE 0 END) AS total_despesa
            FROM financeiro
            WHERE data_lancamento BETWEEN ? AND ?
        ");
        $stmt->bind_param("ss", $inicio, $fim);
        $stmt->execute();
        $r = $stmt->get_result()->fetch_assoc();

        $receita = (float)($r['total_receita'] ?? 0);
        $despesa = (float)($r['total_despesa'] ?? 0);
        return [
            'receita' => $receita,
            'despesa' => $despesa,
            'saldo'   => $receita - $despesa,
        ];
    }

    /**
     * Exclui um lançamento pelo ID.
     */
    public function deletar($id) {
        $stmt = $this->db->prepare("DELETE FROM financeiro WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
