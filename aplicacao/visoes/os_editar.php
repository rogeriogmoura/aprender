<?php
// aplicacao/visoes/os_editar.php
require_once __DIR__ . '/../modelos/os_modelo.php';
$mysqli = new mysqli("localhost", "root", "", "utierp");
$osModelo = new OSModelo($mysqli);

$id = $_GET['id'] ?? 0;
$os = $osModelo->buscar($id);
if (!$os) { die("OS não encontrada."); }

// buscar clientes ativos
$clientes = $mysqli->query("SELECT id, nome FROM clientes WHERE ativo=1 ORDER BY nome ASC");
// buscar técnicos ativos
$tecnicos = $mysqli->query("SELECT id, nome FROM tecnico WHERE ativo=1 ORDER BY nome ASC");

ob_start();
?>
<h2>Editar Ordem de Serviço #<?= $os['id'] ?></h2>

<form method="post" action="../controladores/os_controlador.php">
  <input type="hidden" name="id" value="<?= $os['id'] ?>">

  <div class="form-group">
    <label>Cliente:</label>
    <select name="cliente_id" class="form-control" required>
      <?php while($c = $clientes->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>" <?= $c['id']==$os['cliente_id']?'selected':'' ?>>
          <?= htmlspecialchars($c['nome']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="form-group">
    <label>Descrição:</label>
    <textarea name="descricao" class="form-control" required><?= htmlspecialchars($os['descricao']) ?></textarea>
  </div>

  <div class="form-group">
    <label>Valor Total:</label>
    <input type="number" step="0.01" name="valor_total" class="form-control" value="<?= $os['valor_total'] ?>">
  </div>

  <div class="form-group">
    <label>Técnico:</label>
    <select name="tecnico_id" class="form-control">
      <option value="">-- selecione --</option>
      <?php while($t = $tecnicos->fetch_assoc()): ?>
        <option value="<?= $t['id'] ?>" <?= $t['id']==$os['tecnico_id']?'selected':'' ?>>
          <?= htmlspecialchars($t['nome']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="form-group">
    <label>Observações:</label>
    <textarea name="observacoes" class="form-control"><?= htmlspecialchars($os['observacoes']) ?></textarea>
  </div>

  <button type="submit" name="atualizar" class="btn btn-success">Salvar Alterações</button>
  <a href="os_listar.php" class="btn btn-secondary">Cancelar</a>
</form>
<?php
$conteudo = ob_get_clean();
$titulo = "Editar OS";
include __DIR__ . "/layout.php";

