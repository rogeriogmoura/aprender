<?php
// aplicacao/controladores/os_controlador.php
// Controller de Ordens de Serviço (mysqli) – criar, atualizar e alterar status.

session_start();

/* ========================= Helpers ========================= */

function flash($tipo, $mensagem) {
    $_SESSION['flash_' . $tipo] = $mensagem;
}

function normaliza_moeda($str) {
    // Converte "1.234,56" ou "1234,56" -> 1234.56 (float)
    if ($str === null || $str === '') return 0.0;
    $s = str_replace(['.', ','], ['', '.'], $str);
    return (float) $s;
}

function verifica_csrf_se_enviado() {
    // Apenas valida se o campo csrf vier no POST (para não quebrar telas antigas).
    if (isset($_POST['csrf'])) {
        if (!isset($_SESSION['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
            flash('erro', 'Falha de segurança (CSRF). Tente novamente.');
            header('Location: ../visoes/os_listar.php');
            exit;
        }
    }
}

/* ===================== Conexão (mysqli) ==================== */
// Se você já tem um include central com mysqli, substitua pelo require do seu projeto.
$host  = '127.0.0.1';
$user  = 'root';
$pass  = '';
$banco = 'utierp';

$mysqli = @new mysqli($host, $user, $pass, $banco);
if ($mysqli->connect_errno) {
    http_response_code(500);
    die('Erro ao conectar MySQL: ' . $mysqli->connect_error);
}

require_once __DIR__ . '/../modelos/os_modelo.php';
$modelo = new OSModelo($mysqli);

/* ====================== Roteamento POST ===================== */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Sem ação -> volta para listagem
    header('Location: ../visoes/os_listar.php');
    exit;
}

/* =========== 1) Alterar Status (com histórico) ============== */
if (isset($_POST['alterar_status'])) {
    verifica_csrf_se_enviado();

    $os_id      = isset($_POST['os_id']) ? (int)$_POST['os_id'] : 0;
    $status     = isset($_POST['status']) ? trim($_POST['status']) : '';
    $observacao = isset($_POST['observacao']) ? trim($_POST['observacao']) : null;

    // Regras simples de status
    $permitidos = ['aberta','em_andamento','aguardando_peca','concluida','cancelada'];
    if (!in_array($status, $permitidos, true)) {
        flash('erro', 'Status inválido.');
        header('Location: ../visoes/os_detalhar.php?id=' . $os_id);
        exit;
    }

    try {
        $mysqli->begin_transaction();

        // Atualiza status na OS (ajusta data_conclusao se "concluida")
        $ok = $modelo->atualizar_status($os_id, $status);
        if (!$ok) {
            throw new Exception('Falha ao atualizar status da OS.');
        }

        // Tenta gravar histórico (tabela os_status). Se não existir, ignora com grace.
        $usuario_id = isset($_SESSION['usuario_id']) ? (int)$_SESSION['usuario_id'] : null;

        $stmtHist = $mysqli->prepare("
            INSERT INTO os_status (os_id, status_novo, observacao, usuario_id)
            VALUES (?, ?, ?, ?)
        ");
        if ($stmtHist) {
            // 'i s s i' -> os_id, status, observacao, usuario_id
            $stmtHist->bind_param('issi', $os_id, $status, $observacao, $usuario_id);
            $stmtHist->execute(); // se tabela não existir, cairá no catch abaixo
        }

        $mysqli->commit();
        flash('sucesso', 'Status da OS atualizado com sucesso.');
    } catch (Throwable $e) {
        $mysqli->rollback();
        flash('erro', 'Não foi possível atualizar o status: ' . $e->getMessage());
    }

    header('Location: ../visoes/os_detalhar.php?id=' . $os_id);
    exit;
}

/* ================== 2) Atualizar (editar) =================== */
if (isset($_POST['atualizar'])) {
    verifica_csrf_se_enviado();

    $id          = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $cliente_id  = isset($_POST['cliente_id']) ? (int)$_POST['cliente_id'] : 0;
    $tecnico_id  = (isset($_POST['tecnico_id']) && $_POST['tecnico_id'] !== '') ? (int)$_POST['tecnico_id'] : null;
    $descricao   = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $valor_total = isset($_POST['valor_total']) ? normaliza_moeda($_POST['valor_total']) : 0.0;
    $observacoes = isset($_POST['observacoes']) ? trim($_POST['observacoes']) : null;

    if ($cliente_id <= 0 || $descricao === '') {
        flash('erro', 'Preencha os campos obrigatórios (Cliente e Descrição).');
        header('Location: ../visoes/os_editar.php?id=' . $id);
        exit;
    }

    $ok = $modelo->atualizar($id, $cliente_id, $descricao, $valor_total, $tecnico_id, $observacoes);

    if ($ok) {
        flash('sucesso', 'OS atualizada com sucesso.');
        header('Location: ../visoes/os_detalhar.php?id=' . $id);
    } else {
        flash('erro', 'Não foi possível atualizar a OS.');
        header('Location: ../visoes/os_editar.php?id=' . $id);
    }
    exit;
}

/* ==================== 3) Criar (cadastrar) ================== */
{
    verifica_csrf_se_enviado();

    $cliente_id  = isset($_POST['cliente_id']) ? (int)$_POST['cliente_id'] : 0;
    $tecnico_id  = (isset($_POST['tecnico_id']) && $_POST['tecnico_id'] !== '') ? (int)$_POST['tecnico_id'] : null;
    $descricao   = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $valor_total = isset($_POST['valor_total']) ? normaliza_moeda($_POST['valor_total']) : 0.0;
    $observacoes = isset($_POST['observacoes']) ? trim($_POST['observacoes']) : null;

    if ($cliente_id <= 0 || $descricao === '') {
        flash('erro', 'Preencha os campos obrigatórios (Cliente e Descrição).');
        header('Location: ../visoes/os_cadastrar.php');
        exit;
    }

    $ok = $modelo->criar($cliente_id, $descricao, $valor_total, $tecnico_id, $observacoes);

    if ($ok) {
        flash('sucesso', 'OS criada com sucesso.');
        header('Location: ../visoes/os_listar.php');
    } else {
        flash('erro', 'Não foi possível criar a OS.');
        header('Location: ../visoes/os_cadastrar.php');
    }
    exit;
}
