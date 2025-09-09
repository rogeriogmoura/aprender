<?php
// aplicacao/visoes/os_detalhar.php
session_start();

require_once __DIR__ . '/../modelos/os_modelo.php';

$mysqli = new mysqli("localhost", "root", "", "utierp");
if ($mysqli->connect_errno) { http_response_code(500); die("Erro MySQL: ".$mysqli->connect_error); }

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$osModelo = new OSModelo($mysqli);
$os = $osModelo->buscar($id);
if(!$os){ die("OS não encontrada!"); }

// token CSRF (opcional, só será validado se você enviar)
if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(16)); }

// checa se existe tabela os_status para exibir histórico
$temHistorico = false;
if ($r = $mysqli->query("SHOW TABLES LIKE 'os_status'")) {
  $temHistorico = (bool)$r->num_rows;
  $r->free();
}

// carrega itens
$itens = method_exists($osModelo, 'itens_listar') ? $osModelo->itens_listar($id) : null;

// helpers
function flash($key){
  if (!empty($_SESSION['flash_'.$key])) {
    $msg = $_SESSION['flash_'.$key];
    unset($_SESSION['flash_'.$key]);
    $cls = $key === 'sucesso' ? 'background:#d4edda;color:#155724;border:1px solid #c3e6cb;'
                              : 'background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;';
    echo '<div style="margin:10px 0;padding:10px;border-radius:6px;'.$cls.'">'.htmlspecialchars($msg).'</div>';
  }
}
function badge_status($s){
  $map = [
    'aberta'          => 'background:#6c757d;color:#fff;',
    'em_andamento'    => 'background:#17a2b8;color:#fff;',
    'aguardando_peca' => 'background:#ffc107;color:#212529;',
    'concluida'       => 'background:#28a745;color:#fff;',
    'cancelada'       => 'background:#dc3545;color:#fff;',
  ];
  $rot = [
    'aberta'=>'Aberta','em_andamento'=>'Em andamento','aguardando_peca'=>'Aguardando peça',
    'concluida'=>'Concluída','cancelada'=>'Cancelada'
  ];
  $est = $map[$s] ?? 'background:#adb5bd;color:#212529;';
  $lbl = $rot[$s] ?? $s;
  return '<span style="display:inline-block;padding:.20rem .5rem;border-radius:.375rem;font-size:.85rem;'.$est.'">'.$lbl.'</span>';
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Detalhes da OS #<?= (int)$os['id'] ?></title>
  <link rel="stylesheet" href="../../publico/css/estilo.css">
  <style>
    body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif; padding:16px; }
    table.info { border-collapse:collapse; width:100%; max-width:960px; }
    table.info th, table.info td { border:1px solid #e9ecef; padding:10px; text-align:left; vertical-align:top; }
    table.info th { width:220px; background:#f8f9fa; }
    .top-actions { display:flex; gap:8px; align-items:center; margin:12px 0; flex-wrap:wrap; }
    .btn { padding:8px 12px; border-radius:8px; border:1px solid #ced4da; background:#fff; cursor:pointer; }
    .btn-outline-info { color:#0d6efd; border-color:#0d6efd; }
    .btn-outline-warning { color:#b8860b; border-color:#ffc107; background:#fff8e1; }
    .btn-outline-success { color:#198754; border-color:#198754; }
    .btn-outline-danger { color:#dc3545; border-color:#dc3545; }
    .muted { color:#6c757d; font-size:.9rem; }
    .tabela { width:100%; border-collapse:collapse; }
    .tabela th, .tabela td { padding:10px; border-bottom:1px solid #e9ecef; vertical-align: top; }
    .tabela th { background:#f8f9fa; text-align:left; }
    .nowrap { white-space:nowrap; }
    .card { border:1px solid #e9ecef; border-radius:10px; padding:14px; margin-top:16px; }
    .card h5 { margin:0 0 10px 0; }
    .obs-field { width:100%; max-width:560px; }
  </style>
</head>
<body>

  <h2>Ordem de Serviço #<?= (int)$os['id'] ?> <?= badge_status($os['status']) ?></h2>

  <?php flash('sucesso'); flash('erro'); ?>

  <div class="top-actions">
    <a class="btn" href="os_listar.php">⬅ Voltar para lista</a>
    <a class="btn" href="os_editar.php?id=<?= (int)$os['id'] ?>">✏️ Editar OS</a>
  </div>

  <table class="info">
    <tr><th>Cliente</th><td><?= htmlspecialchars($os['cliente_nome'] ?? 'Não informado') ?></td></tr>
    <tr><th>Técnico</th><td><?= htmlspecialchars($os['tecnico_nome'] ?? 'Não definido') ?></td></tr>
    <tr><th>Status</th><td><?= badge_status($os['status']) ?></td></tr>
    <tr><th>Descrição</th><td><?= nl2br(htmlspecialchars($os['descricao'])) ?></td></tr>
    <tr><th>Observações</th><td><?= nl2br(htmlspecialchars($os['observacoes'] ?? '')) ?></td></tr>
    <tr><th>Data de Abertura</th><td><?= $os['data_abertura'] ? date('d/m/Y H:i', strtotime($os['data_abertura'])) : '-' ?></td></tr>
    <tr><th>Data de Conclusão</th><td><?= $os['data_conclusao'] ? date('d/m/Y H:i', strtotime($os['data_conclusao'])) : '-' ?></td></tr>
    <tr><th>Valor Total</th><td><strong>R$ <?= number_format((float)$os['valor_total'], 2, ',', '.') ?></strong></td></tr>
  </table>

  <!-- ====== Ações de Status ====== -->
  <div class="card">
    <h5>Mudar Status</h5>
    <form method="post" action="../controladores/os_controlador.php" class="top-actions" id="formStatus">
      <input type="hidden" name="alterar_status" value="1">
      <input type="hidden" name="os_id" value="<?= (int)$os['id'] ?>">
      <input type="hidden" name="status" id="statusInput">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
      <div class="obs-field">
        <label>Observação (opcional):</label><br>
        <textarea name="observacao" id="obsTextarea" rows="2" style="width:100%;" placeholder="Ex.: aguardando chegada da placa-mãe..."></textarea>
      </div>
      <div class="top-actions">
        <button type="button" class="btn btn-outline-info" onclick="mudar('em_andamento')">▶ Iniciar</button>
        <button type="button" class="btn btn-outline-warning" onclick="mudar('aguardando_peca')">🛠️ Aguardar peça</button>
        <button type="button" class="btn btn-outline-success" onclick="mudar('concluida')">✔ Concluir</button>
        <button type="button" class="btn btn-outline-danger" onclick="mudar('cancelada')">✖ Cancelar</button>
      </div>
    </form>
    <div class="muted">Dica: registre um motivo curto quando for <em>Aguardar peça</em> ou <em>Cancelar</em>.</div>
  </div>

  <!-- ====== Itens da OS ====== -->
  <div class="card">
    <h5>Itens da OS</h5>
    <form method="post" action="../controladores/os_itens_controlador.php" style="margin:10px 0; display:flex; gap:8px; flex-wrap:wrap;">
      <input type="hidden" name="acao" value="adicionar">
      <input type="hidden" name="os_id" value="<?= (int)$os['id'] ?>">

      <select name="tipo" required>
        <option value="peca">Peça</option>
        <option value="servico">Serviço</option>
      </select>

      <input type="text" name="descricao" placeholder="Descrição do item" required style="min-width:260px;">
      <input type="text" name="quantidade" value="1" style="width:100px;" placeholder="Qtd">
      <input type="text" name="valor_unitario" value="0,00" style="width:120px;" placeholder="Valor unit.">

      <button type="submit" class="btn">+ Adicionar</button>
    </form>

    <div class="table-responsive">
      <table class="tabela">
        <thead>
          <tr>
            <th>#</th>
            <th>Tipo</th>
            <th>Descrição</th>
            <th class="nowrap">Qtd</th>
            <th class="nowrap">V.Unit (R$)</th>
            <th class="nowrap">Total (R$)</th>
            <th class="nowrap">Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $soma = 0;
          if ($itens && $itens->num_rows):
            while ($i = $itens->fetch_assoc()):
              $lin_total = (float)$i['quantidade'] * (float)$i['valor_unitario'];
              $soma += $lin_total;
          ?>
            <tr>
              <td><?= (int)$i['id'] ?></td>
              <td><?= $i['tipo']==='servico' ? 'Serviço' : 'Peça' ?></td>
              <td><?= htmlspecialchars($i['descricao']) ?></td>
              <td class="nowrap"><?= number_format((float)$i['quantidade'], 2, ',', '.') ?></td>
              <td class="nowrap"><?= number_format((float)$i['valor_unitario'], 2, ',', '.') ?></td>
              <td class="nowrap"><strong><?= number_format($lin_total, 2, ',', '.') ?></strong></td>
              <td class="nowrap">
                <form method="post" action="../controladores/os_itens_controlador.php" style="display:inline;">
                  <input type="hidden" name="acao" value="remover">
                  <input type="hidden" name="os_id" value="<?= (int)$os['id'] ?>">
                  <input type="hidden" name="id" value="<?= (int)$i['id'] ?>">
                  <button class="btn" type="submit" onclick="return confirm('Remover este item?')">🗑️ Remover</button>
                </form>
              </td>
            </tr>
          <?php endwhile; else: ?>
            <tr><td colspan="7" class="muted">Nenhum item lançado.</td></tr>
          <?php endif; ?>
          <tr>
            <td colspan="5" class="nowrap" style="text-align:right;"><strong>Total dos itens:</strong></td>
            <td class="nowrap"><strong><?= number_format($soma, 2, ',', '.') ?></strong></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="muted">O valor total da OS é atualizado automaticamente somando os itens.</div>
  </div>

  <!-- ====== Histórico de Status ====== -->
  <?php if ($temHistorico): ?>
  <div class="card">
    <h5>Histórico de Status</h5>
    <div class="table-responsive">
      <table class="tabela">
        <thead>
          <tr>
            <th>#</th>
            <th>Status</th>
            <th>Observação</th>
            <th>Usuário</th>
            <th>Data</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $hist = $mysqli->prepare("SELECT id, status_novo, observacao, usuario_id, criado_em FROM os_status WHERE os_id=? ORDER BY criado_em DESC, id DESC");
          $hist->bind_param("i", $id);
          $hist->execute();
          $hres = $hist->get_result();
          if ($hres && $hres->num_rows):
            while($h = $hres->fetch_assoc()):
          ?>
            <tr>
              <td><?= (int)$h['id'] ?></td>
              <td class="nowrap"><?= badge_status($h['status_novo']) ?></td>
              <td><?= htmlspecialchars($h['observacao'] ?? '') ?></td>
              <td><?= $h['usuario_id'] ? (int)$h['usuario_id'] : '-' ?></td>
              <td class="nowrap"><?= htmlspecialchars($h['criado_em']) ?></td>
            </tr>
          <?php endwhile; else: ?>
            <tr><td colspan="5" class="muted">Sem alterações registradas.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>

  <script>
    function mudar(status){
      if(!confirm('Confirmar mudança de status para "'+status+'"?')) return;
      document.getElementById('statusInput').value = status;
      document.getElementById('formStatus').submit();
    }
  </script>

</body>
</html>
