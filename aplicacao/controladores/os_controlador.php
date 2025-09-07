<?php
require_once __DIR__ . '/../modelos/os_modelo.php';
$mysqli = new mysqli("localhost", "root", "", "utierp");
$osModelo = new OSModelo($mysqli);

// exemplo simples: salvar OS
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $descricao = $_POST['descricao'];
    $valor_total = $_POST['valor_total'];
    $tecnico_id = $_POST['tecnico_id'] ?? null;
    $observacoes = $_POST['observacoes'] ?? '';

    if ($osModelo->criar($cliente_id, $descricao, $valor_total, $tecnico_id, $observacoes)) {
        header("Location: ../visoes/os_listar.php?msg=criada");
        exit;
    } else {
        echo "Erro ao criar OS!";
    }
}
