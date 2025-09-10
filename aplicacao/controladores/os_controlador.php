<?php
// aplicacao/controladores/os_controlador.php
require_once __DIR__ . '/../modelos/os_modelo.php';

$mysqli = new mysqli("localhost", "root", "", "utierp");
if ($mysqli->connect_errno) {
    die("Erro ao conectar no banco: " . $mysqli->connect_error);
}
$osModelo = new OSModelo($mysqli);

// ========== CRIAR OS ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['atualizar']) && !isset($_POST['atualizar_status'])) {
    $cliente_id   = $_POST['cliente_id'];
    $descricao    = $_POST['descricao'];
    $valor_total  = $_POST['valor_total'] ?? 0;
    $tecnico_id   = $_POST['tecnico_id'] ?? null;
    $observacoes  = $_POST['observacoes'] ?? null;

    $osModelo->criar($cliente_id, $descricao, $valor_total, $tecnico_id, $observacoes);

    header("Location: ../visoes/os_listar.php");
    exit;
}

// ========== ATUALIZAR OS ==========
if (isset($_POST['atualizar'])) {
    $id          = $_POST['id'];
    $cliente_id  = $_POST['cliente_id'];
    $descricao   = $_POST['descricao'];
    $valor_total = $_POST['valor_total'] ?? 0;
    $tecnico_id  = $_POST['tecnico_id'] ?? null;
    $observacoes = $_POST['observacoes'] ?? null;

    $osModelo->atualizar($id, $cliente_id, $descricao, $valor_total, $tecnico_id, $observacoes);

    header("Location: ../visoes/os_detalhar.php?id=$id");
    exit;
}

// ========== ATUALIZAR STATUS ==========
if (isset($_POST['atualizar_status'])) {
    $id     = (int)$_POST['id'];
    $status = $_POST['status'];

    $osModelo->atualizar_status($id, $status);

    header("Location: ../visoes/os_detalhar.php?id=$id");
    exit;
}

// ========== FUTURO: ITENS DA OS (peças/serviços) ==========
// Exemplo de uso posterior:
// if (isset($_POST['adicionar_item'])) { ... }
// if (isset($_POST['remover_item'])) { ... }

