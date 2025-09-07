<?php
session_start();
$erro = isset($_SESSION['erro']) ? $_SESSION['erro'] : null;
unset($_SESSION['erro']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>login - erp uti do notebook</title>
  <link rel="stylesheet" href="../../assets/adminlte/css/adminlte.min.css">
  <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>erp</b> uti do notebook
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">entre com seu e-mail e senha</p>

      <?php if ($erro): ?>
        <div class="alert alert-danger"><?= $erro ?></div>
      <?php endif; ?>

      <form action="../controladores/login.php" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="e-mail" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="senha" class="form-control" placeholder="senha" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">entrar</button>
      </form>
    </div>
  </div>
</div>
<script src="../../assets/plugins/jquery/jquery.min.js"></script>
<script src="../../assets/adminlte/js/adminlte.min.js"></script>
</body>
</html>
