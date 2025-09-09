<?php
// aplicacao/visoes/os_listar.php
// Lista de OS com cliente e técnico, busca e ações.

session_start();

// Conexão rápida (se você já tem um include central, pode trocar por ele)
$mysqli = new mysqli("localhost", "root", "", "utierp");
if ($mysqli->connect_errno) {
  http_response_code(500);
  die("Erro MySQL: " . $mysqli->connect_error);
}

// Busca simples (por cliente, técnico ou descrição)
$termo = isset($_GET['q']) ? trim($_GET['q']) : '';
$where = '';
$param = null;
if ($termo !== '') {
  $where = "WHERE (COALESCE(clientes.nome,'') LIKE CONCAT('%', ?, '%')
            OR COALESCE(tecnico.nome,'') LIKE CONCAT('%', ?, '%')
            OR COALESCE(os.descricao,'') LIKE CONCAT('%', ?, '%'))";
}

// Monta consulta
$sql = "
  SELECT 
    os.id, os.cliente_id, os.tecnico_id, os.descricao, os.status, os.valor_total,
    os.data_abertura, os.data_conclusao, os.observacoes,
    clientes.nome AS cliente_nome,
    tecnico.nome  AS tecnico_nome
  FROM os
  LEFT JOIN clientes ON os.cliente_id = clientes.id
  LEFT JOIN tecnico  ON os.tecnico_id  = tecnico.id
  $where
  ORDER BY os.data_abertura DESC, os.id DESC
";

// Executa
if ($where) {
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('sss', $termo, $termo, $termo);
  $stmt->execute();
  $lista = $stmt->get_result();
} else {
  $lista = $mysqli->query($sql);
}

// helper de badge de status
function badge_status($s) {
  $map = [
    'aberta'          => 'background:#6c757d;color:#fff;',   // secondary
    'em_andamento'    => 'background:#17a2b8;color:#fff;',   // info
    'aguardando_peca' => 'background:#ffc107;color:#212529;',// warning
    'concluida'       => 'background:#28a745;color:#fff;',   // success
    'cancelada'       => 'background:#dc3545;color:#fff;',   // danger
  ];
  $estilo = $map[$s] ?? 'background:#adb5bd;color:#212529;';
  // rótulo amigável
  $label = [
    'aberta' => 'Aberta',
    'em_andamento' => 'Em andamento',
    'aguardando_peca' => 'Aguardando peça',
    'concluida' => 'Concluída',
    'cancelada' => 'Cancelada'
  ][$s] ?? htmlspecialchars($s);
  return '<span style="display:inline-block;padding:.20rem .5rem;border-radius:.375rem;font-size:.85rem;'.$estilo.'">'.$label.'</span>';
}

// helper de flash
function flash($key) {
  if (!empty($_SESSION['flash_'.$key])) {
    $msg = $_SESSION['flash_'.$key];
    unset($_SESSION['flash_'.$key]);
    $cls = $key === 'sucesso' ? 'background:#d4edda;color:#155724;border:1px solid #c3e6cb;' 
                              : 'background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;';
    echo '<div style="margin:10px 0;padding:10px;border-radius:6px;'.$cls.'">'.htmlspecialchars($msg).'</div>';
  }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Listar OS</title>
  <link rel="stylesheet" href="../../publico/css/estilo.css">
  <style>
    .tabela { width:100%; border-collapse: collapse; }
    .tabela th, .tabela td { padding:10px; border-bottom:1px solid #e9ecef; vertical-align: top; }
    .tabela th { background:#f8f9fa; text-align:left; }
    .acoes a { margin-right:8px; text-decoration:none; }
    .topbar { display:flex; gap:10px; align-items:center; margin:12px 0; }
    .topbar input[type="text"] { padding:8px 10px; border:1px solid #ced4da; border-radius:8px; width:280px; }
    .btn { padding:8px 12px; border-radius:8px; border:1px solid #ced4da; background:#fff; cursor:pointer; }
    .btn-prim { background:#0d6efd; border-color:#0d6efd; color:#fff; }
    .muted { color:#6c757d; font-size:.9rem; }
    .nowrap { white-space: nowrap; }
  </style>
</head>
<body>

  <h2>Ordens de Serviço</h2>

  <?php flash('sucesso'); flash('erro'); ?>

  <div class="topbar">
    <form method="get" action="">
      <input type="text" name="q" value="<?= htmlspecialchars($termo) ?>" placeholder="Buscar por cliente, técnico ou descrição">
      <button class="btn">Buscar</button>
      <?php if($termo !== ''): ?>
        <a class="btn" href="os_listar.php">Limpar</a>
      <?php endif; ?>
    </form>
    <a class="btn btn-prim" href="os_cadastrar.php">+ Nova OS</a>
  </div>

  <div class="muted">
    <?php
      $qtd = $lista ? $lista->num_rows : 0;
      echo $qtd . ' registro' . ($qtd == 1 ? '' : 's') . ' encontrado' . ($qtd == 1 ? '' : 's') . '.';
    ?>
  </div>

  <div class="table-responsive">
    <table class="tabela">
      <thead>
        <tr>
          <th class="nowrap">#</th>
          <th>Cliente</th>
          <th>Técnico</th>
          <th>Descrição</th>
          <th class="nowrap">Status</th>
          <th class="nowrap">Valor (R$)</th>
          <th class="nowrap">Abertura</th>
          <th class="nowrap">Conclusão</th>
          <th class="nowrap">Ações</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($lista && $lista->num_rows): ?>
        <?php while($r = $lista->fetch_assoc()): ?>
          <tr>
            <td class="nowrap"><?= (int)$r['id'] ?></td>
            <td><?= htmlspecialchars($r['cliente_nome'] ?? '-') ?></td>
            <td><?= htmlspecialchars($r['tecnico_nome'] ?? '-') ?></td>
            <td><?= nl2br(htmlspecialchars($r['descricao'])) ?></td>
            <td class="nowrap"><?= badge_status($r['status']) ?></td>
            <td class="nowrap"><?= number_format((float)$r['valor_total'], 2, ',', '.') ?></td>
            <td class="nowrap"><?= htmlspecialchars($r['data_abertura']) ?></td>
            <td class="nowrap"><?= htmlspecialchars($r['data_conclusao'] ?? '') ?></td>
            <td class="acoes nowrap">
              <a href="os_detalhar.php?id=<?= (int)$r['id'] ?>" title="Detalhar">🔎 detalhar</a>
              <a href="os_editar.php?id=<?= (int)$r['id'] ?>" title="Editar">✏️ editar</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="9" class="muted">Nenhuma OS encontrada.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>

</body>
</html>
