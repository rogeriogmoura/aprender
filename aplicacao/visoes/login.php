<?php
session_start();
if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
    header("Location: dashboard_admin.php");
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - UTI do Notebook ERP</title>

  <!-- google fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- adminlte + fontawesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />

  <style>
    /* fonte global */
    body, .card, .form-control, button, h1, h2, h3, h4, h5, h6 {
      font-family: 'Poppins', sans-serif !important;
      letter-spacing: 0.2px;
    }

    body {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #1e1433, #2c1f4a);
    }

    .login-card {
      width: 100%;
      max-width: 380px;
      border-radius: 16px;
      background: none; /* sem fundo na parte da logo */
    }

    .login-logo {
      background: none !important;
      padding: 20px 0 10px;
      text-align: center;
      box-shadow: none !important; /* remove sombra atrás da logo */
    }

    .login-logo img {
      max-height: 80px;
      margin-bottom: 10px;
    }

    .login-logo h2 {
      font-weight: 600;
      color: #fff;
      font-size: 1.2rem;
      margin: 0;
    }

    .card-body {
      background: #2b2340;
      color: #fff;
      border-radius: 16px; /* cantos arredondados */
      box-shadow: 0px 4px 15px rgba(0,0,0,0.4); /* sombra externa */
      padding: 25px;
    }

    .input-group-text {
      background: #2c1f4a;
      border: none;
      color: #fff;
    }

    .form-control {
      border: none;
      background: #1f1830;
      color: #fff;
    }

    .form-control:focus {
      box-shadow: none;
      border: 1px solid #6c5ce7;
    }

    .btn-primary {
      background: #6c5ce7;
      border: none;
      font-weight: 600;
      border-radius: 8px;
    }

    .btn-primary:hover {
      background: #5941d6;
    }

    .login-footer {
      text-align: center;
      margin-top: 10px;
    }

    .login-footer a {
      color: #bbb;
      font-size: 0.9rem;
      text-decoration: none;
    }

    .login-footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="login-card">
  <!-- logo e nome do sistema -->
  <div class="login-logo">
    <img src="../../publico/imagens/logo.png" alt="Logo">
    <h2>Sistema Integrado</h2>
  </div>

  <!-- formulário -->
  <div class="card-body">
    <form action="../controladores/login.php" method="post">

      <!-- campo e-mail -->
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        </div>
        <input type="email" name="email" class="form-control" placeholder="Digite seu e-mail" required>
      </div>

      <!-- campo senha -->
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
        </div>
        <input type="password" name="senha" class="form-control" placeholder="Digite sua senha" required>
      </div>

      <!-- botão login -->
      <div class="row">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block">entrar</button>
        </div>
      </div>
    </form>

    <div class="login-footer">
      <a href="#">esqueci minha senha</a>
    </div>
  </div>
</div>

<!-- js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
