<?php
// layout.php - Estrutura base do sistema
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UTI do Notebook</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../publico/plugins/fontawesome-free/css/all.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="../publico/dist/css/adminlte.min.css">
  <!-- Estilo personalizado -->
  <link rel="stylesheet" href="../publico/css/custom.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Botão para recolher sidebar -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Busca global -->
    <form class="form-inline mx-auto">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Buscar em OS, Clientes, Técnicos..." aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Ícones lado direito -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-plus-circle"></i></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-users"></i></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-calculator"></i></a></li>
      <!-- Notificações -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">5</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">5 Notificações</span>
        </div>
      </li>
      <!-- Usuário -->
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-user-circle"></i> Administrador</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="../publico/imagens/logo_redonda.png" alt="Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light">UTI do Notebook</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Busca no sidebar -->
      <div class="form-inline mt-2 mb-2">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Procurar...">
          <div class="input-group-append">
            <button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button>
          </div>
        </div>
      </div>

      <!-- Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
          <li class="nav-item"><a href="os_listar.php" class="nav-link"><i class="nav-icon fas fa-tools"></i><p>Ordens de Serviço</p></a></li>
          <li class="nav-item"><a href="clientes_listar.php" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Clientes</p></a></li>
          <li class="nav-item"><a href="tecnicos_listar.php" class="nav-link"><i class="nav-icon fas fa-user-cog"></i><p>Técnicos</p></a></li>
          <li class="nav-item"><a href="financeiro.php" class="nav-link"><i class="nav-icon fas fa-dollar-sign"></i><p>Financeiro</p></a></li>
          <li class="nav-item"><a href="crm.php" class="nav-link"><i class="nav-icon fas fa-handshake"></i><p>CRM</p></a></li>
          <li class="nav-item"><a href="vendas.php" class="nav-link"><i class="nav-icon fas fa-shopping-cart"></i><p>Vendas</p></a></li>
        </ul>
      </nav>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Cabeçalho -->
    <div class="content-header">
      <div class="container-fluid">
        <?php if(isset($titulo)): ?>
          <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0"><?= $titulo ?></h1></div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard.php">Início</a></li>
                <li class="breadcrumb-item active"><?= $titulo ?></li>
              </ol>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Conteúdo dinâmico -->
    <section class="content">
      <div class="container-fluid">
        <?php if(isset($conteudo)) include $conteudo; ?>
      </div>
    </section>
  </div>

  <!-- Rodapé -->
  <footer class="main-footer text-sm text-center">
    <strong>&copy; <?= date("Y") ?> UTI do Notebook.</strong> Todos os direitos reservados.
  </footer>

</div>
<!-- ./wrapper -->

<!-- Scripts AdminLTE -->
<script src="../publico/plugins/jquery/jquery.min.js"></script>
<script src="../publico/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../publico/dist/js/adminlte.min.js"></script>
</body>
</html>
