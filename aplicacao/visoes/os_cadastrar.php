<?php
// aplicacao/visoes/os_cadastrar.php
$mysqli = new mysqli("localhost", "root", "", "utierp");

// buscar clientes ativos
$clientes = $mysqli->query("SELECT id, nome FROM clientes WHERE ativo=1 ORDER BY nome ASC");
// buscar técnicos ativos
$tecnicos = $mysqli->query("SELECT id, nome FROM tecnico WHERE ativo=1 ORDER BY nome ASC");

// Conteúdo da tela
ob_start();
?>
<h2>Nova Ordem de Serviço</h2>

<form method="post" action="../controladores/os_controlador.php">
  <div class="form-group">
    <label>Cliente:</label>
    <select name="cliente_id" class="form-control" required>
      <option value="">-- selecione --</option>
      <?php while($c = $clientes->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="form-group">
    <label>Descrição:</label>
    <textarea name="descricao" class="form-control" required></textarea>
  </div>

  <div class="form-group">
    <label>Valor Total:</label>
    <input type="number" step="0.01" name="valor_total" class="form-control">
  </div>

  <div class="form-group">
    <label>Técnico Responsável:</label>
    <select name="tecnico_id" class="form-control">
      <option value="">-- selecione --</option>
      <?php while($t = $tecnicos->fetch_assoc()): ?>
        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nome']) ?></option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="form-group">
    <label>Observações:</label>
    <textarea name="observacoes" class="form-control"></textarea>
  </div>

  <button type="submit" class="btn btn-success">Salvar</button>
  <a href="os_listar.php" class="btn btn-secondary">Cancelar</a>
</form>
<?php
$conteudo = ob_get_clean();
$titulo = "Cadastrar OS";
include __DIR__ . "/layout.php";
