<?php
class OSModelo {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    // criar nova OS
    public function criar($cliente_id, $descricao, $valor_total, $tecnico_id, $observacoes) {
        $stmt = $this->db->prepare("INSERT INTO os (cliente_id, descricao, valor_total, tecnico_id, observacoes) VALUES (?,?,?,?,?)");
        $stmt->bind_param("isdss", $cliente_id, $descricao, $valor_total, $tecnico_id, $observacoes);
        return $stmt->execute();

    // listar todas as OS com nome do cliente
public function listar() {
    $sql = "
        SELECT os.*, clientes.nome AS cliente_nome
        FROM os
        LEFT JOIN clientes ON os.cliente_id = clientes.id
        ORDER BY os.data_abertura DESC
    ";
    return $this->db->query($sql);
}

    // buscar OS específica com nome do cliente
public function buscar($id) {
    $stmt = $this->db->prepare("
        SELECT os.*, clientes.nome AS cliente_nome
        FROM os
        LEFT JOIN clientes ON os.cliente_id = clientes.id
        WHERE os.id=?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


    // atualizar status
    public function atualizar_status($id, $status) {
        $stmt = $this->db->prepare("UPDATE os SET status=?, data_conclusao=IF(?='concluida', NOW(), NULL) WHERE id=?");
        $stmt->bind_param("ssi", $status, $status, $id);
        return $stmt->execute();
    }
}
