<?php
// aplicacao/visoes/layout.php
// $titulo -> título da página
// $conteudo -> conteúdo HTML da tela

if (!isset($conteudo)) { $conteudo = "<p>Conteúdo não definido.</p>"; }
if (!isset($titulo)) { $titulo = "UTI do Notebook"; }
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($titulo) ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../publico/css/estilo.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Sidebar único -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="dashboard_admin.php" class="brand-link">
      <span class="brand-text font-weight-light">UTI do Notebook</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
          <li class="nav-item">
            <a href="dashboard_admin.php" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a>
          </li>
          <li class="nav-item">
            <a href="os_listar.php" class="nav-link"><i class="nav-icon fas fa-clipboard-list"></i><p>Ordens de Serviço</p></a>
          </li>
          <li class="nav-item">
            <a href="clientes_listar.php" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Clientes</p></a>
          </li>
          <li class="nav-item">
            <a href="tecnico_listar.php" class="nav-link"><i class="nav-icon fas fa-user-cog"></i><p>Técnicos</p></a>
          </li>
          <li class="nav-item">
            <a href="financeiro_listar.php" class="nav-link"><i class="nav-icon fas fa-wallet"></i><p>Financeiro</p></a>
          </li>
          <li class="nav-item">
            <a href="crm_listar.php" class="nav-link"><i class="nav-icon fas fa-handshake"></i><p>CRM</p></a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Conteúdo -->
  <div class="content-wrapper" style="padding:20px;">
    <?= $conteudo ?>
  </div>

</div>
</body>
</html>

