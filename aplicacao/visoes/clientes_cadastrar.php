<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Cadastrar Cliente</title>
  <link rel="stylesheet" href="../../publico/css/estilo.css">
</head>
<body>
  <h2>Novo Cliente</h2>
  <form method="post" action="../controladores/clientes_controlador.php">

    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Telefone:</label><br>
    <input type="text" name="telefone"><br><br>

    <label>CPF/CNPJ:</label><br>
    <input type="text" name="cpf_cnpj"><br><br>

    <label>Endereço:</label><br>
    <input type="text" name="endereco"><br><br>

    <label>Cidade:</label><br>
    <input type="text" name="cidade"><br><br>

    <label>UF:</label><br>
    <input type="text" name="uf" maxlength="2"><br><br>

    <button type="submit">Salvar</button>
  </form>
</body>
</html>
