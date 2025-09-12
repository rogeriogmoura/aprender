<?php
require_once __DIR__ . '/../modelos/os_modelo.php';
$mysqli = new mysqli("localhost", "root", "", "utierp");
$osModelo = new OSModelo($mysqli);

$id = $_GET['id'] ?? 0;
$os = $osModelo->buscar($id);
if (!$os) { die("OS não encontrada."); }

ob_start();
?>
<h2>Detalhes da Ordem de Serviço #<?= $os['id'] ?></h2>

<div class="card">
  <div class="card-body">
    <table class="table table-bordered">
      <tr><th>Cliente</th><td><?= htmlspecialchars($os['cliente_nome'] ?? '-') ?></td></tr>
      <tr><th>Técnico</th><td><?= htmlspecialchars($os['tecnico_nome'] ?? '-') ?></td></tr>
      <tr><th>Status</th><td><span class="badge badge-info"><?= htmlspecialchars($os['status']) ?></span></td></tr>
      <tr><th>Descrição</th><td><?= nl2br(htmlspecialchars($os['descricao'])) ?></td></tr>
      <tr><th>Observações</th><td><?= nl2br(htmlspecialchars($os['observacoes'] ?? '')) ?></td></tr>
      <tr><th>Data de Abertura</th><td><?= date('d/m/Y H:i', strtotime($os['data_abertura'])) ?></td></tr>
      <tr><th>Data de Conclusão</th><td><?= $os['data_conclusao'] ? date('d/m/Y H:i', strtotime($os['data_conclusao'])) : '-' ?></td></tr>
      <tr><th>Valor Total</th><td>R$ <?= number_format($os['valor_total'], 2, ',', '.') ?></td></tr>
    </table>
  </div>
</div>

<!-- Ações -->
<div class="mt-3">
  <form method="post" action="../controladores/os_controlador.php" class="d-inline">
    <input type="hidden" name="id" value="<?= $os['id'] ?>">
    <input type="hidden" name="status" value="em_andamento">
    <button type="submit" name="atualizar_status" class="btn btn-info">▶ Iniciar</button>
  </form>
  <form method="post" action="../controladores/os_controlador.php" class="d-inline">
    <input type="hidden" name="id" value="<?= $os['id'] ?>">
    <input type="hidden" name="status" value="aguardando_peca">
    <button type="submit" name="atualizar_status" class="btn btn-warning">⏸ Aguardar Peça</button>
  </form>
  <form method="post" action="../controladores/os_controlador.php" class="d-inline">
    <input type="hidden" name="id" value="<?= $os['id'] ?>">
    <input type="hidden" name="status" value="concluida">
    <button type="submit" name="atualizar_status" class="btn btn-success">✔ Concluir</button>
  </form>
  <form method="post" action="../controladores/os_controlador.php" class="d-inline">
    <input type="hidden" name="id" value="<?= $os['id'] ?>">
    <input type="hidden" name="status" value="cancelada">
    <button type="submit" name="atualizar_status" class="btn btn-danger">✖ Cancelar</button>
  </form>
  <a href="os_listar.php" class="btn btn-secondary">⬅ Voltar</a>
</div>

<!-- ITENS -->
<h3 class="mt-4">Itens da OS</h3>
<div class="card">
  <div class="card-body">
    <form method="post" action="../controladores/os_controlador.php" class="form-inline mb-3">
      <input type="hidden" name="os_id" value="<?= $os['id'] ?>">
      <input type="hidden" name="adicionar_item" value="1">

      <select name="tipo" class="form-control mr-2" required>
        <option value="peca">Peça</option>
        <option value="servico">Serviço</option>
      </select>
      <input type="text" name="descricao" class="form-control mr-2" placeholder="Descrição" required>
      <input type="number" step="0.01" name="quantidade" class="form-control mr-2" placeholder="Qtd" required>
      <input type="number" step="0.01" name="valor_unitario" class="form-control mr-2" placeholder="Valor" required>
      <button class="btn btn-success">+ Adicionar</button>
    </form>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Tipo</th>
          <th>Descrição</th>
          <th>Qtd</th>
          <th>V.Unitário</th>
          <th>Total</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $itens = $osModelo->itens_listar($os['id']);
      if ($itens->num_rows == 0): ?>
        <tr><td colspan="6">Nenhum item lançado.</td></tr>
      <?php else:
        while($item = $itens->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($item['tipo']) ?></td>
          <td><?= htmlspecialchars($item['descricao']) ?></td>
          <td><?= $item['quantidade'] ?></td>
          <td>R$ <?= number_format($item['valor_unitario'],2,',','.') ?></td>
          <td>R$ <?= number_format($item['total'],2,',','.') ?></td>
          <td>
            <form method="post" action="../controladores/os_controlador.php" onsubmit="return confirm('Remover item?')" style="display:inline;">
              <input type="hidden" name="remover_item" value="1">
              <input type="hidden" name="id" value="<?= $item['id'] ?>">
              <input type="hidden" name="os_id" value="<?= $os['id'] ?>">
              <button class="btn btn-sm btn-danger">🗑</button>
            </form>
          </td>
        </tr>
      <?php endwhile; endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php
$conteudo = ob_get_clean();
$titulo = "Detalhes da OS #".$os['id'];
include __DIR__ . "/layout.php";
