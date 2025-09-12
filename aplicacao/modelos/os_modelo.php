<?php
class OSModelo {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    // ============================
    // CRUD OS
    // ============================

    public function criar($cliente_id, $descricao, $valor_total, $tecnico_id = null, $observacoes = null) {
        $stmt = $this->db->prepare("
            INSERT INTO os (cliente_id, descricao, valor_total, tecnico_id, observacoes, status, data_abertura)
            VALUES (?, ?, ?, ?, ?, 'aberta', NOW())
        ");
        $stmt->bind_param("isdss", $cliente_id, $descricao, $valor_total, $tecnico_id, $observacoes);
        return $stmt->execute();
    }

    public function listar() {
        $sql = "
            SELECT os.*, 
                   clientes.nome AS cliente_nome, 
                   tecnico.nome AS tecnico_nome
            FROM os
            LEFT JOIN clientes ON os.cliente_id = clientes.id
            LEFT JOIN tecnico  ON os.tecnico_id = tecnico.id
            ORDER BY os.data_abertura DESC
        ";
        return $this->db->query($sql);
    }

    public function buscar($id) {
        $stmt = $this->db->prepare("
            SELECT os.*, 
                   clientes.nome AS cliente_nome, 
                   tecnico.nome AS tecnico_nome
            FROM os
            LEFT JOIN clientes ON os.cliente_id = clientes.id
            LEFT JOIN tecnico  ON os.tecnico_id = tecnico.id
            WHERE os.id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function atualizar($id, $cliente_id, $descricao, $valor_total, $tecnico_id = null, $observacoes = null) {
        $stmt = $this->db->prepare("
            UPDATE os 
               SET cliente_id = ?, descricao = ?, valor_total = ?, tecnico_id = ?, observacoes = ?
             WHERE id = ?
        ");
        $stmt->bind_param("isdssi", $cliente_id, $descricao, $valor_total, $tecnico_id, $observacoes, $id);
        return $stmt->execute();
    }

    public function atualizar_status($id, $status) {
        $stmt = $this->db->prepare("
            UPDATE os 
               SET status = ?, data_conclusao = IF(? = 'concluida', NOW(), NULL)
             WHERE id = ?
        ");
        $stmt->bind_param("ssi", $status, $status, $id);
        return $stmt->execute();
    }

    // ============================
    // ITENS DA OS
    // ============================

    public function itens_listar($os_id) {
        $stmt = $this->db->prepare("SELECT *, (quantidade*valor_unitario) AS total FROM os_item WHERE os_id=? ORDER BY id ASC");
        $stmt->bind_param("i", $os_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function item_adicionar($os_id, $tipo, $descricao, $quantidade, $valor_unitario) {
        $stmt = $this->db->prepare("INSERT INTO os_item (os_id, tipo, descricao, quantidade, valor_unitario) VALUES (?,?,?,?,?)");
        $stmt->bind_param("issdd", $os_id, $tipo, $descricao, $quantidade, $valor_unitario);
        $ok = $stmt->execute();
        if ($ok) { $this->recalcular_valor_total($os_id); }
        return $ok;
    }

    public function item_remover($id, $os_id) {
        $stmt = $this->db->prepare("DELETE FROM os_item WHERE id=? AND os_id=?");
        $stmt->bind_param("ii", $id, $os_id);
        $ok = $stmt->execute();
        if ($ok) { $this->recalcular_valor_total($os_id); }
        return $ok;
    }

    public function recalcular_valor_total($os_id) {
        $stmt = $this->db->prepare("SELECT SUM(quantidade*valor_unitario) AS total FROM os_item WHERE os_id=?");
        $stmt->bind_param("i", $os_id);
        $stmt->execute();
        $total = (float)($stmt->get_result()->fetch_assoc()['total'] ?? 0);
        $u = $this->db->prepare("UPDATE os SET valor_total=? WHERE id=?");
        $u->bind_param("di", $total, $os_id);
        $u->execute();
        return $total;
    }
}
