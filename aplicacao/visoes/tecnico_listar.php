<?php
// aplicacao/visoes/tecnico_listar.php
$mysqli = new mysqli("localhost", "root", "", "utierp");
$result = $mysqli->query("SELECT * FROM tecnico WHERE ativo=1 ORDER BY nome ASC");

// Conteúdo específico
ob_start();
?>
<h2>Técnicos</h2>

<a href="tecnico_cadastrar.php" class="btn btn-primary mb-3">+ Novo Técnico</a>

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
    <?php while($t = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $t['id'] ?></td>
        <td><?= htmlspecialchars($t['nome']) ?></td>
        <td><?= htmlspecialchars($t['email']) ?></td>
        <td><?= htmlspecialchars($t['telefone']) ?></td>
        <td>
          <a href="tecnico_editar.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php
$conteudo = ob_get_clean();
$titulo = "Listagem de Técnicos";
include __DIR__ . "/layout.php";
