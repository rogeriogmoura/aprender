<?php
// aplicacao/visoes/tecnico_editar.php
$mysqli = new mysqli("localhost", "root", "", "utierp");

$id = $_GET['id'] ?? 0;
$tecnico = $mysqli->query("SELECT * FROM tecnico WHERE id=$id")->fetch_assoc();
if (!$tecnico) { die("Técnico não encontrado."); }

ob_start();
?>
<h2>Editar Técnico</h2>

<form method="post" action="../controladores/tecnico_controlador.php">
  <input type="hidden" name="id" value="<?= $tecnico['id'] ?>">

  <div class="form-group">
    <label>Nome:</label>
    <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($tecnico['nome']) ?>" required>
  </div>

  <div class="form-group">
    <label>Email:</label>
    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($tecnico['email']) ?>">
  </div>

  <div class="form-group">
    <label>Telefone:</label>
    <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($tecnico['telefone']) ?>">
  </div>

  <button type="submit" name="atualizar" class="btn btn-success">Salvar Alterações</button>
  <a href="tecnico_listar.php" class="btn btn-secondary">Cancelar</a>
</form>
<?php
$conteudo = ob_get_clean();
$titulo = "Editar Técnico";
include __DIR__ . "/layout.php";

