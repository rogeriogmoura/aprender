<?php
require_once __DIR__ . '/../modelos/financeiro_modelo.php';
$mysqli = new mysqli("localhost", "root", "", "utierp");
if ($mysqli->connect_errno) {
  die("Erro ao conectar no banco: " . $mysqli->connect_error);
}

// período padrão: últimos 6 meses
$inicio = $_GET['inicio'] ?? date('Y-m-01', strtotime('-5 months'));
$fim    = $_GET['fim']    ?? date('Y-m-d');

// busca receitas agrupadas por OS
$sql = "
  SELECT f.os_id, 
         c.nome AS cliente_nome,
         SUM(f.valor) AS total_receita,
         MIN(f.data_lancamento) AS primeira_data,
         MAX(f.data_lancamento) AS ultima_data
  FROM financeiro f
  LEFT JOIN os o ON f.os_id = o.id
  LEFT JOIN clientes c ON o.cliente_id = c.id
  WHERE f.tipo = 'receita'
    AND f.data_lancamento BETWEEN ? AND ?
  GROUP BY f.os_id, c.nome
  ORDER BY ultima_data DESC
";
$stmt = $mysqli->prepare($sql);

$inicio_fmt = $inicio . ' 00:00:00';
$fim_fmt    = $fim . ' 23:59:59';

$stmt->bind_param("ss", $inicio_fmt, $fim_fmt);
$stmt->execute();
$res = $stmt->get_result();

ob_start();
?>
<h2>Relatório de Receitas por OS</h2>

<form class="form-inline mb-3" method="get">
  <label class="mr-2">Início:</label>
  <input type="date" name="inicio" class="form-control mr-2" value="<?= htmlspecialchars($inicio) ?>">
  <label class="mr-2">Fim:</label>
  <input type="date" name="fim" class="form-control mr-2" value="<?= htmlspecialchars($fim) ?>">
  <button class="btn btn-primary">Filtrar</button>
</form>

<div class="card card-outline card-secondary">
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <thead>
        <tr>
          <th>OS</th>
          <th>Cliente</th>
          <th>Receita (R$)</th>
          <th>Data Primeira</th>
          <th>Data Última</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($res->num_rows > 0): 
          while($row = $res->fetch_assoc()): ?>
          <tr>
            <td>#<?= (int)$row['os_id'] ?></td>
            <td><?= htmlspecialchars($row['cliente_nome'] ?? '-') ?></td>
            <td><strong>R$ <?= number_format($row['total_receita'],2,',','.') ?></strong></td>
            <td><?= $row['primeira_data'] ? date('d/m/Y', strtotime($row['primeira_data'])) : '-' ?></td>
            <td><?= $row['ultima_data'] ? date('d/m/Y', strtotime($row['ultima_data'])) : '-' ?></td>
            <td>
              <?php if ($row['os_id']): ?>
                <a href="../visoes/os_detalhar.php?id=<?= (int)$row['os_id'] ?>" class="btn btn-xs btn-info">🔎 Ver OS</a>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; else: ?>
          <tr><td colspan="6">Nenhuma receita encontrada no período.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php
$conteudo = ob_get_clean();
$titulo = "Relatório Receitas por OS";
include __DIR__ . "/layout.php";
