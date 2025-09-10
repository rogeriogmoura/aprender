<?php
// aplicacao/visoes/os_detalhar.php
require_once __DIR__ . '/../modelos/os_modelo.php';
$mysqli = new mysqli("localhost", "root", "", "utierp");
$osModelo = new OSModelo($mysqli);

$id = $_GET['id'] ?? 0;
$os = $osModelo->buscar($id);
if (!$os) { die("OS não encontrada."); }

// Conteúdo da página
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
<?php
$conteudo = ob_get_clean();
$titulo = "Detalhes da OS #".$os['id'];
include __DIR__ . "/layout.php";
