<?php
// aplicacao/controladores/os_itens_controlador.php
session_start();

function flash($tipo,$msg){ $_SESSION['flash_'.$tipo]=$msg; }
function normaliza_moeda($s){ if($s===null||$s==='')return 0.0; return (float)str_replace(['. ',',','.'],['','','.'],$s); } // robusto p/ inputs diversos
function normaliza_num($s){ return (float)str_replace(',','.',$s); }

$mysqli = new mysqli("localhost","root","","utierp");
if ($mysqli->connect_errno) { http_response_code(500); die('MySQL: '.$mysqli->connect_error); }

require_once __DIR__ . '/../modelos/os_modelo.php';
$modelo = new OSModelo($mysqli);

$os_id = isset($_POST['os_id']) ? (int)$_POST['os_id'] : 0;
$acao  = $_POST['acao'] ?? '';

if ($acao === 'adicionar') {
    $tipo = ($_POST['tipo'] === 'servico') ? 'servico' : 'peca';
    $descricao = trim($_POST['descricao'] ?? '');
    $quantidade = isset($_POST['quantidade']) ? normaliza_num($_POST['quantidade']) : 1;
    $valor_unitario = isset($_POST['valor_unitario']) ? normaliza_num($_POST['valor_unitario']) : 0;

    if ($descricao === '') { flash('erro','Descrição é obrigatória.'); header('Location: ../visoes/os_detalhar.php?id='.$os_id); exit; }

    $ok = $modelo->item_adicionar($os_id, $tipo, $descricao, $quantidade, $valor_unitario);
    $ok ? flash('sucesso','Item adicionado.') : flash('erro','Falha ao adicionar item.');
    header('Location: ../visoes/os_detalhar.php?id='.$os_id); exit;
}

if ($acao === 'remover') {
    $id = (int)($_POST['id'] ?? 0);
    $ok = $modelo->item_remover($id, $os_id);
    $ok ? flash('sucesso','Item removido.') : flash('erro','Falha ao remover item.');
    header('Location: ../visoes/os_detalhar.php?id='.$os_id); exit;
}

if ($acao === 'atualizar') {
    $id = (int)($_POST['id'] ?? 0);
    $tipo = ($_POST['tipo'] === 'servico') ? 'servico' : 'peca';
    $descricao = trim($_POST['descricao'] ?? '');
    $quantidade = isset($_POST['quantidade']) ? normaliza_num($_POST['quantidade']) : 1;
    $valor_unitario = isset($_POST['valor_unitario']) ? normaliza_num($_POST['valor_unitario']) : 0;

    if ($descricao === '') { flash('erro','Descrição é obrigatória.'); header('Location: ../visoes/os_detalhar.php?id='.$os_id); exit; }

    $ok = $modelo->item_atualizar($id, $os_id, $tipo, $descricao, $quantidade, $valor_unitario);
    $ok ? flash('sucesso','Item atualizado.') : flash('erro','Falha ao atualizar item.');
    header('Location: ../visoes/os_detalhar.php?id='.$os_id); exit;
}

// fallback
header('Location: ../visoes/os_detalhar.php?id='.$os_id);
