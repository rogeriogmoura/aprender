<?php
require_once __DIR__ . '/../modelos/clientes_modelo.php';
$mysqli = new mysqli("localhost", "root", "", "utierp");
if ($mysqli->connect_errno) {
    die("Erro ao conectar: " . $mysqli->connect_error);
}

$res = $mysqli->query("SELECT * FROM clientes ORDER BY nome ASC");

ob_start();
?>
<h2>Clientes</h2>
<a href="clientes_cadastrar.php" class="btn btn-primary mb-3">+ Novo Cliente</a>

<div class="card">
  <div class="card-body table-responsive p-0">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Email</th>
          <th>Telefone</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($res->num_rows > 0): 
        while($c = $res->fetch_assoc()): ?>
        <tr>
          <td><?= $c['id'] ?></td>
          <td><?= htmlspecialchars($c['nome']) ?></td>
          <td><?= htmlspecialchars($c['email']) ?></td>
          <td><?= htmlspecialchars($c['telefone']) ?></td>
          <td>
            <?php if ($c['ativo']): ?>
              <span class="badge badge-success">Ativo</span>
            <?php else: ?>
              <span class="badge badge-secondary">Inativo</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="clientes_editar.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-info">✏️ Editar</a>
            <?php if ($c['ativo']): ?>
              <a href="../controladores/clientes_controlador.php?inativar=<?= $c['id'] ?>" class="btn btn-sm btn-warning" onclick="return confirm('Inativar cliente?')">🚫 Inativar</a>
            <?php else: ?>
              <a href="../controladores/clientes_controlador.php?ativar=<?= $c['id'] ?>" class="btn btn-sm btn-success">✔ Reativar</a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; else: ?>
        <tr><td colspan="6">Nenhum cliente cadastrado.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php
$conteudo = ob_get_clean();
$titulo = "Clientes";
include __DIR__ . "/layout.php";
