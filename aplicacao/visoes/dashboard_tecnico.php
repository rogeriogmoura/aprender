<?php 
session_start(); 
if(!isset($_SESSION['logado'])){header("location: login.php");exit;} 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>dashboard <?= $_SESSION['funcao']; ?></title>
  <link rel="stylesheet" href="../../assets/adminlte/css/adminlte.min.css">
  <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">painel principal</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <span class="nav-link">👤 <?= $_SESSION['nome']; ?> (<?= $_SESSION['funcao']; ?>)</span>
      </li>
      <li class="nav-item">
        <a href="../controladores/logout.php" class="btn btn-danger btn-sm">sair</a>
      </li>
    </ul>
  </nav>

  <!-- sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link text-center">
      <span class="brand-text font-weight-light">erp uti do notebook</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i> <p>dashboard</p></a></li>
          <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-tools"></i> <p>ordens de serviço</p></a></li>
          <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-dollar-sign"></i> <p>financeiro</p></a></li>
          <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-user-friends"></i> <p>crm</p></a></li>
          <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-shopping-cart"></i> <p>vendas</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- content -->
  <div class="content-wrapper p-4">
    <h1>bem-vindo <?= $_SESSION['funcao']; ?>, <?= $_SESSION['nome']; ?>!</h1>
    <p>este é o seu painel inicial.</p>
  </div>

</div>
<script src="../../assets/plugins/jquery/jquery.min.js"></script>
<script src="../../assets/adminlte/js/adminlte.min.js"></script>
</body>
</html>
