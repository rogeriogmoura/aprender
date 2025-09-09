<?php
require_once __DIR__ . '/../modelos/os_modelo.php';
$mysqli = new mysqli("localhost", "root", "", "utierp");

// buscar clientes ativos (tabela é PLURAL: clientes)
$clientes = $mysqli->query("SELECT id, nome FROM clientes WHERE ativo=1 ORDER BY nome ASC");

// buscar técnicos ativos (aqui está certo, a tabela é singular: tecnico)
$tecnicos = $mysqli->query("SELECT id, nome FROM tecnico WHERE ativo=1 ORDER BY nome ASC");
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Cadastrar OS</title>
  <link rel="stylesheet" href="../../publico/css/estilo.css">
</head>
<body>
  <h2>Nova Ordem de Serviço</h2>
  <form method="post" action="../controladores/os_controlador.php">
    
    <!-- seleção de cliente -->
    <label>Cliente:</label><br>
    <select name="cliente_id" required>
      <option value="">-- selecione --</option>
      <?php while($c = $clientes->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
      <?php endwhile; ?>
    </select><br><br>

    <!-- descrição -->
    <label>Descrição:</label><br>
    <textarea name="descricao" required></textarea><br><br>

    <!-- valor total -->
    <label>Valor Total:</label><br>
    <input type="number" step="0.01" name="valor_total"><br><br>

    <!-- técnico -->
    <label>Técnico Responsável:</label><br>
    <select name="tecnico_id">
      <option value="">-- selecione --</option>
      <?php while($t = $tecnicos->fetch_assoc()): ?>
        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nome']) ?></option>
      <?php endwhile; ?>
    </select><br><br>

    <!-- observações -->
    <label>Observações:</label><br>
    <textarea name="observacoes"></textarea><br><br>

    <button type="submit">Salvar</button>
  </form>
</body>
</html>
