<?php
require_once __DIR__ . '/../modelos/os_modelo.php';
require_once __DIR__ . '/../modelos/financeiro_modelo.php';

$mysqli = new mysqli("localhost", "root", "", "utierp");
if ($mysqli->connect_errno) { die("Erro ao conectar no banco: " . $mysqli->connect_error); }

$osModelo  = new OSModelo($mysqli);
$finModelo = new FinanceiroModelo($mysqli);

// helper
function normaliza_num($s){ if($s===null||$s==='') return 0.0; return (float)str_replace([','],['.'],$s); }

// ========== CRIAR OS ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['atualizar']) && !isset($_POST['atualizar_status']) && !isset($_POST['adicionar_item']) && !isset($_POST['remover_item'])) {
    $cliente_id   = (int)$_POST['cliente_id'];
    $descricao    = trim($_POST['descricao']);
    $valor_total  = normaliza_num($_POST['valor_total'] ?? 0);
    $tecnico_id   = !empty($_POST['tecnico_id']) ? (int)$_POST['tecnico_id'] : null;
    $observacoes  = $_POST['observacoes'] ?? null;

    $osModelo->criar($cliente_id, $descricao, $valor_total, $tecnico_id, $observacoes);
    header("Location: ../visoes/os_listar.php");
    exit;
}

// ========== ATUALIZAR OS ==========
if (isset($_POST['atualizar'])) {
    $id          = (int)$_POST['id'];
    $cliente_id  = (int)$_POST['cliente_id'];
    $descricao   = trim($_POST['descricao']);
    $valor_total = normaliza_num($_POST['valor_total'] ?? 0);
    $tecnico_id  = !empty($_POST['tecnico_id']) ? (int)$_POST['tecnico_id'] : null;
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

    if ($status === 'concluida') {
        $os = $osModelo->buscar($id);
        $valor = (float)($os['valor_total'] ?? 0);
        $cliente = $os['cliente_nome'] ?? 'Cliente';

        $referencia = 'OS#'.$id;
        if (!$finModelo->existe_referencia($referencia) && $valor > 0) {
            $descricao = "Recebimento OS #{$id} - {$cliente}";
            $finModelo->criar(
                'receita',
                $descricao,
                $valor,
                date('Y-m-d H:i:s'),
                'outro',
                'OS',
                $id,
                'auto:os_concluida',
                $referencia
            );
        }
    }

    header("Location: ../visoes/os_detalhar.php?id=$id");
    exit;
}

// ========== ITENS ==========
if (isset($_POST['adicionar_item'])) {
    $id         = (int)$_POST['os_id'];
    $tipo       = $_POST['tipo'];
    $descricao  = trim($_POST['descricao']);
    $quantidade = (float)$_POST['quantidade'];
    $valor      = (float)$_POST['valor_unitario'];

    $osModelo->item_adicionar($id, $tipo, $descricao, $quantidade, $valor);
    header("Location: ../visoes/os_detalhar.php?id=$id");
    exit;
}

if (isset($_POST['remover_item'])) {
    $id     = (int)$_POST['id'];
    $os_id  = (int)$_POST['os_id'];
    $osModelo->item_remover($id, $os_id);
    header("Location: ../visoes/os_detalhar.php?id=$os_id");
    exit;
}

header("Location: ../visoes/os_listar.php");
