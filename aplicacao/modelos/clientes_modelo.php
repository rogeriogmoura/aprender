<?php
/**
 * Modelo de Clientes
 * Responsável por todas as operações no banco de dados da tabela clientes
 */
class ClientesModelo {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    // Listar todos os clientes
    public function listar() {
        return $this->db->query("SELECT * FROM clientes ORDER BY nome ASC");
    }

    // Buscar cliente específico
    public function buscar($id) {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Criar novo cliente
    public function criar($nome, $email, $telefone) {
        $stmt = $this->db->prepare("INSERT INTO clientes (nome, email, telefone, ativo) VALUES (?,?,?,1)");
        $stmt->bind_param("sss", $nome, $email, $telefone);
        return $stmt->execute();
    }

    // Atualizar cliente existente
    public function atualizar($id, $nome, $email, $telefone) {
        $stmt = $this->db->prepare("UPDATE clientes SET nome=?, email=?, telefone=? WHERE id=?");
        $stmt->bind_param("sssi", $nome, $email, $telefone, $id);
        return $stmt->execute();
    }

    // Inativar cliente
    public function inativar($id) {
        $stmt = $this->db->prepare("UPDATE clientes SET ativo=0 WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Reativar cliente
    public function ativar($id) {
        $stmt = $this->db->prepare("UPDATE clientes SET ativo=1 WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
