<?php
require_once __DIR__ . '/../modelos/os_modelo.php';
$mysqli = new mysqli("localhost", "root", "", "utierp");

// pegar ID da OS
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// buscar OS
$result = $mysqli->prepare("
    SELECT os.*, clientes.nome AS cliente_nome, tecnico.nome AS tecnico_nome
    FROM os
    LEFT JOIN clientes ON os.cliente_id = clientes.id
    LEFT JOIN tecnico  ON os.tecnico_id = tecnico.id
    WHERE os.id = ?
");
$result->bind_param("i", $id);
$result->execute();
$os = $result->get_result()->fetch_assoc();

if (!$os) {
    die("OS não encontrada.");
}

// buscar clientes ativos (tabela é PLURAL: clientes)
$clientes = $mysqli->query("SELECT id, nome FROM clientes WHERE ativo=1 ORDER BY nome ASC");

// buscar técnicos ativos (tabela é singular: tecnico)
$tecnicos = $mysqli->query("SELECT id, nome FROM tecnico WHERE ativo=1 ORDER BY nome ASC");
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Editar OS</title>
  <link rel="stylesheet" href="../../publico/css/estilo.css">
</head>
<body>
  <h2>Editar Ordem de Serviço</h2>
  <form method="post" action="../controladores/os_controlador.php">
    <input type="hidden" name="id" value="<?= $os['id'] ?>">
    <input type="hidden" name="atualizar" value="1">
    
    <!-- seleção de cliente -->
    <label>Cliente:</label><br>
    <select name="cliente_id" required>
      <option value="">-- selecione --</option>
      <?php while($c = $clientes->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>" <?= $c['id'] == $os['cliente_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($c['nome']) ?>
        </option>
      <?php endwhile; ?>
    </select><br><br>

    <!-- descrição -->
    <label>Descrição:</label><br>
    <textarea name="descricao" required><?= htmlspecialchars($os['descricao']) ?></textarea><br><br>

    <!-- valor total -->
    <label>Valor Total:</label><br>
    <input type="number" step="0.01" name="valor_total"
           value="<?= number_format((float)$os['valor_total'], 2, '.', '') ?>"><br><br>

    <!-- técnico -->
    <label>Técnico Responsável:</label><br>
    <select name="tecnico_id">
      <option value="">-- selecione --</option>
      <?php while($t = $tecnicos->fetch_assoc()): ?>
        <option value="<?= $t['id'] ?>" <?= $t['id'] == $os['tecnico_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($t['nome']) ?>
        </option>
      <?php endwhile; ?>
    </select><br><br>

    <!-- observações -->
    <label>Observações:</label><br>
    <textarea name="observacoes"><?= htmlspecialchars($os['observacoes']) ?></textarea><br><br>

    <button type="submit">Salvar Alterações</button>
  </form>
</body>
</html>
