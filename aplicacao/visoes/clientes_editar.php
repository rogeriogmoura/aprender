<?php
$mysqli = new mysqli("localhost", "root", "", "utierp");
$id = $_GET['id'] ?? 0;
$stmt = $mysqli->prepare("SELECT * FROM clientes WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$cliente = $stmt->get_result()->fetch_assoc();
if(!$cliente){ die("Cliente não encontrado!"); }
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Editar Cliente</title>
  <link rel="stylesheet" href="../../publico/css/estilo.css">
</head>
<body>
  <h2>Editar Cliente</h2>
  <form method="post" action="../controladores/clientes_controlador.php">
    <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

    <label>Nome:</label><br>
    <input type="text" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>"><br><br>

    <label>Telefone:</label><br>
    <input type="text" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>"><br><br>

    <label>CPF/CNPJ:</label><br>
    <input type="text" name="cpf_cnpj" value="<?= htmlspecialchars($cliente['cpf_cnpj']) ?>"><br><br>

    <label>Endereço:</label><br>
    <input type="text" name="endereco" value="<?= htmlspecialchars($cliente['endereco']) ?>"><br><br>

    <label>Cidade:</label><br>
    <input type="text" name="cidade" value="<?= htmlspecialchars($cliente['cidade']) ?>"><br><br>

    <label>UF:</label><br>
    <input type="text" name="uf" value="<?= htmlspecialchars($cliente['uf']) ?>" maxlength="2"><br><br>

    <button type="submit" name="atualizar">Atualizar</button>
  </form>
</body>
</html>
