<?php
$mysqli = new mysqli("localhost", "root", "", "utierp");
$result = $mysqli->query("SELECT * FROM clientes ORDER BY data_cadastro DESC");
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Clientes</title>
  <link rel="stylesheet" href="../../publico/css/estilo.css">
</head>
<body>
  <h2>Clientes</h2>
  <a href="clientes_cadastrar.php">+ Novo Cliente</a>
  <table border="1" cellpadding="8">
  <tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Email</th>
    <th>Telefone</th>
    <th>Cidade</th>
    <th>UF</th>
    <th>Status</th>
    <th>Ações</th>
  </tr>
  <?php while($c = $result->fetch_assoc()): ?>
  <tr>
    <td><?= $c['id'] ?></td>
    <td><?= htmlspecialchars($c['nome']) ?></td>
    <td><?= htmlspecialchars($c['email']) ?></td>
    <td><?= htmlspecialchars($c['telefone']) ?></td>
    <td><?= htmlspecialchars($c['cidade']) ?></td>
    <td><?= htmlspecialchars($c['uf']) ?></td>
    <td><?= $c['ativo'] ? 'Ativo' : 'Inativo' ?></td>
    <td>
      <a href="clientes_editar.php?id=<?= $c['id'] ?>">✏️ Editar</a> | 
      <a href="../controladores/clientes_controlador.php?inativar=<?= $c['id'] ?>" onclick="return confirm('Deseja inativar este cliente?')">🚫 Inativar</a>
    </td>
  </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
