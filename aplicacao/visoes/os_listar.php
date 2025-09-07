<?php
require_once __DIR__ . '/../modelos/os_modelo.php';
$mysqli = new mysqli("localhost", "root", "", "utierp");
$osModelo = new OSModelo($mysqli);
$lista = $osModelo->listar();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Ordens de Serviço</title>
  <link rel="stylesheet" href="../../publico/css/estilo.css">
</head>
<body>
  <h2>Ordens de Serviço</h2>
  <a href="os_cadastrar.php">+ Nova OS</a>

  <table border="1" cellpadding="8">
  <tr>
    <th>ID</th>
    <th>Cliente</th>
    <th>Descrição</th>
    <th>Status</th>
    <th>Data Abertura</th>
    <th>Valor</th>
  </tr>
  <?php while($os = $lista->fetch_assoc()): ?>
  <tr>
    <td><?= $os['id'] ?></td>
    <td><?= htmlspecialchars($os['cliente_nome'] ?? 'Não informado') ?></td>
    <td><?= htmlspecialchars($os['descricao']) ?></td>
    <td><?= $os['status'] ?></td>
    <td><?= date('d/m/Y H:i', strtotime($os['data_abertura'])) ?></td>
    <td>R$ <?= number_format($os['valor_total'], 2, ',', '.') ?></td>
  </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
