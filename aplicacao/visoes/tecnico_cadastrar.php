<?php
// aplicacao/visoes/tecnico_cadastrar.php

// Conteúdo
ob_start();
?>
<h2>Novo Técnico</h2>

<form method="post" action="../controladores/tecnico_controlador.php">
  <div class="form-group">
    <label>Nome:</label>
    <input type="text" name="nome" class="form-control" required>
  </div>
  <div class="form-group">
    <label>Email:</label>
    <input type="email" name="email" class="form-control">
  </div>
  <div class="form-group">
    <label>Telefone:</label>
    <input type="text" name="telefone" class="form-control">
  </div>
  <button type="submit" class="btn btn-success">Salvar</button>
  <a href="tecnico_listar.php" class="btn btn-secondary">Cancelar</a>
</form>
<?php
$conteudo = ob_get_clean();
$titulo = "Cadastrar Técnico";
include __DIR__ . "/layout.php";
