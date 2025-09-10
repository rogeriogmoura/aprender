<?php
// aplicacao/visoes/os_listar.php
require_once __DIR__ . '/../modelos/os_modelo.php';
$mysqli = new mysqli("localhost", "root", "", "utierp");
$osModelo = new OSModelo($mysqli);
$lista = $osModelo->listar();

// Conteúdo específico
ob_start();
?>
<h2>Ordens de Serviço</h2>

<a href="os_cadastrar.php" class="btn btn-primary mb-3">+ Nova OS</a>

<div class="table-responsive">
  <table class="table table-striped table-bordered">
    <thead class="thead-dark">
      <tr>
        <th>#</th>
        <th>Cliente</th>
        <th>Técnico</th>
        <th>Status</th>
        <th>Descrição</th>
        <th>Valor</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
    <?php while($os = $lista->fetch_assoc()): ?>
      <tr>
        <td><?= $os['id'] ?></td>
        <td><?= htmlspecialchars($os['cliente_nome']) ?></td>
        <td><?= htmlspecialchars($os['tecnico_nome']) ?></td>
        <td><?= htmlspecialchars($os['status']) ?></td>
        <td><?= nl2br(htmlspecialchars($os['descricao'])) ?></td>
        <td>R$ <?= number_format($os['valor_total'],2,',','.') ?></td>
        <td>
          <a href="os_detalhar.php?id=<?= $os['id'] ?>" class="btn btn-sm btn-info">🔎</a>
          <a href="os_editar.php?id=<?= $os['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php
$conteudo = ob_get_clean();
$titulo = "Listagem de OS";
include __DIR__ . "/layout.php";
