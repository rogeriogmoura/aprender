<?php
if (!isset($titulo)) $titulo = "ERP Assistência";
if (!isset($conteudo)) $conteudo = "<p>Conteúdo não definido</p>";
if (!isset($breadcrumb)) $breadcrumb = ["Início"]; // array com o caminho

// Simulação de usuário logado (em produção isso virá da sessão)
$usuario_nome = "Administrador";
$usuario_email = "admin@utinotebook.com";
$empresa_nome = "UTI do Notebook";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($titulo) ?></title>

  <!-- AdminLTE -->
  <link rel="stylesheet" href="/aprender/publico/dist/css/adminlte.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

  <style>
    .navbar .nav-link i {
      font-size: 1.3rem;
      vertical-align: middle;
    }
    .navbar .navbar-badge {
      font-size: 0.75rem;
      padding: 3px 5px;
      top: 8px;
      right: 5px;
    }
    .navbar-search-block {
      flex: 1;
      margin: 0 20px;
    }
    .breadcrumb {
      background: transparent;
      margin-bottom: 0;
      padding-left: 0;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark bg-dark">
    <!-- Esquerda -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Barra de busca global -->
    <form class="form-inline mx-auto w-50">
      <div class="input-group input-group-sm w-100">
        <input class="form-control form-control-navbar" type="search" placeholder="Buscar em OS, Clientes, Técnicos..." aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit"><i class="fas fa-search"></i></button>
        </div>
      </div>
    </form>

    <!-- Atalhos rápidos -->
    <ul class="navbar-nav ml-2">
      <li class="nav-item">
        <a href="os_cadastrar.php" class="nav-link" title="Nova OS"><i class="fas fa-plus-circle text-info"></i></a>
      </li>
      <li class="nav-item">
        <a href="clientes_cadastrar.php" class="nav-link" title="Novo Cliente"><i class="fas fa-user-plus text-success"></i></a>
      </li>
      <li class="nav-item">
        <a href="financeiro_lancamentos.php" class="nav-link" title="Novo Lançamento"><i class="fas fa-cash-register text-warning"></i></a>
      </li>
    </ul>

    <!-- Direita -->
    <ul class="navbar-nav ml-auto">
      <!-- Mensagens -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-envelope fa-lg"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">3 Mensagens</span>
          <a href="#" class="dropdown-item"><i class="fas fa-envelope mr-2"></i> Mensagem 1</a>
          <a href="#" class="dropdown-item"><i class="fas fa-envelope mr-2"></i> Mensagem 2</a>
          <a href="#" class="dropdown-item"><i class="fas fa-envelope mr-2"></i> Mensagem 3</a>
        </div>
      </li>

      <!-- Notificações -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell fa-lg"></i>
          <span class="badge badge-warning navbar-badge">5</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">5 Notificações</span>
          <a href="#" class="dropdown-item"><i class="fas fa-exclamation-circle mr-2"></i> 2 OS atrasadas</a>
          <a href="#" class="dropdown-item"><i class="fas fa-cash-register mr-2"></i> 3 Contas a pagar</a>
        </div>
      </li>

      <!-- Tarefas -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-flag fa-lg"></i>
          <span class="badge badge-success navbar-badge">2</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">2 Tarefas</span>
          <a href="#" class="dropdown-item"><i class="fas fa-wrench mr-2"></i> OS em andamento</a>
          <a href="#" class="dropdown-item"><i class="fas fa-box mr-2"></i> Aguardando peça</a>
        </div>
      </li>

      <!-- Usuário -->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img src="/aprender/publico/imagens/logo_redonda.png" 
               class="user-image elevation-2" 
               style="border-radius:50%; object-fit:cover; width:35px; height:35px;" 
               alt="User Image">
          <span class="d-none d-md-inline"><?= $usuario_nome ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <li class="user-header bg-primary">
            <img src="/aprender/publico/imagens/logo_redonda.png" 
                 class="img-circle elevation-2" 
                 style="object-fit:cover; width:80px; height:80px;" 
                 alt="User Image">
            <p><?= $usuario_nome ?><small><?= $usuario_email ?></small></p>
          </li>
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Perfil</a>
            <a href="logout.php" class="btn btn-danger btn-flat float-right">Sair</a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="dashboard_admin.php" class="brand-link">
      <img src="/aprender/publico/imagens/logo_redonda.png" 
           alt="Logo" 
           class="brand-image elevation-3" 
           style="opacity:.9; width:40px; height:40px; object-fit:cover;">
      <span class="brand-text font-weight-light"><?= $empresa_nome ?></span>
    </a>

    <div class="sidebar">
      <!-- Busca no sidebar -->
      <div class="form-inline mt-3">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Procurar..." aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button>
          </div>
        </div>
      </div>

      <!-- Menu -->
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
          <li class="nav-item"><a href="dashboard_admin.php" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-tools"></i><p>Ordens de Serviço<i class="right fas fa-angle-left"></i></p></a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="os_cadastrar.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Nova OS</p></a></li>
              <li class="nav-item"><a href="os_listar.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Listar OS</p></a></li>
            </ul>
          </li>
          <li class="nav-item"><a href="clientes_listar.php" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Clientes</p></a></li>
          <li class="nav-item"><a href="tecnicos_listar.php" class="nav-link"><i class="nav-icon fas fa-user-cog"></i><p>Técnicos</p></a></li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-wallet"></i><p>Financeiro<i class="right fas fa-angle-left"></i></p></a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="financeiro_lancamentos.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Lançamentos</p></a></li>
              <li class="nav-item"><a href="financeiro_relatorio_os.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Relatório por OS</p></a></li>
            </ul>
          </li>
          <li class="nav-item"><a href="crm_dashboard.php" class="nav-link"><i class="nav-icon fas fa-handshake"></i><p>CRM</p></a></li>
          <li class="nav-item"><a href="vendas_dashboard.php" class="nav-link"><i class="nav-icon fas fa-shopping-cart"></i><p>Vendas</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Conteúdo -->
  <div class="content-wrapper p-3">
    <!-- Breadcrumb -->
    <div class="content-header">
      <div class="container-fluid">
        <ol class="breadcrumb float-sm-left">
          <?php foreach ($breadcrumb as $item): ?>
            <li class="breadcrumb-item"><?= $item ?></li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>

    <section class="content">
      <?= $conteudo ?>
    </section>
  </div>

  <!-- Rodapé -->
  <footer class="main-footer text-center">
    <strong>&copy; <?= date("Y") ?> <?= $empresa_nome ?>.</strong> Todos os direitos reservados.
  </footer>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/aprender/publico/dist/js/adminlte.min.js"></script>
</body>
</html>
