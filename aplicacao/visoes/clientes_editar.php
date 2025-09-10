<?php
// aplicacao/visoes/clientes_editar.php
$mysqli = new mysqli("localhost", "root", "", "utierp");

$id = $_GET['id'] ?? 0;
$cliente = $mysqli->query("SELECT * FROM clientes WHERE id=$id")->fetch_assoc();
if (!$cliente) { die("Cliente não encontrado."); }

ob_start();
?>
<h2>Editar Cliente</h2>

<form method="post" action="../controladores/clientes_controlador.php">
  <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

  <div class="form-group">
    <label>Nome:</label>
    <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($cliente['nome']) ?>" required>
  </div>

  <div class="form-group">
    <label>Email:</label>
    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente['email']) ?>">
  </div>

  <div class="form-group">
    <label>Telefone:</label>
    <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($cliente['telefone']) ?>">
  </div>

  <button type="submit" name="atualizar" class="btn btn-success">Salvar Alterações</button>
  <a href="clientes_listar.php" class="btn btn-secondary">Cancelar</a>
</form>
<?php
$conteudo = ob_get_clean();
$titulo = "Editar Cliente";
include __DIR__ . "/layout.php";
