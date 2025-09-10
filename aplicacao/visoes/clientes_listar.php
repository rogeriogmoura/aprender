<?php
// aplicacao/visoes/clientes_listar.php
$mysqli = new mysqli("localhost", "root", "", "utierp");
$result = $mysqli->query("SELECT * FROM clientes WHERE ativo=1 ORDER BY nome ASC");

// Conteúdo específico
ob_start();
?>
<h2>Clientes</h2>

<a href="clientes_cadastrar.php" class="btn btn-primary mb-3">+ Novo Cliente</a>

<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead class="thead-dark">
      <tr>
        <th>#</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
    <?php while($c = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= htmlspecialchars($c['nome']) ?></td>
        <td><?= htmlspecialchars($c['email']) ?></td>
        <td><?= htmlspecialchars($c['telefone']) ?></td>
        <td>
          <a href="clientes_editar.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php
$conteudo = ob_get_clean();
$titulo = "Listagem de Clientes";
include __DIR__ . "/layout.php";
