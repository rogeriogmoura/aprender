<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Logo -->
  <a href="dashboard.php" class="brand-link">
    <img src="/aprender/publico/imagens/logo_redonda.png" alt="Logo UTI do Notebook" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">UTI do Notebook</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Barra de pesquisa -->
    <div class="form-inline mt-2 mb-2">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Procurar..." aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="/aplicacao/visoes/dashboard.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              Ordens de Serviço
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/aplicacao/visoes/os_nova.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Nova OS</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/aplicacao/visoes/os_listar.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Listar OS</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="/aplicacao/visoes/clientes_listar.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Clientes</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/aplicacao/visoes/tecnicos_listar.php" class="nav-link">
            <i class="nav-icon fas fa-user-cog"></i>
            <p>Técnicos</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/aplicacao/visoes/financeiro.php" class="nav-link">
            <i class="nav-icon fas fa-wallet"></i>
            <p>Financeiro</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/aplicacao/visoes/crm.php" class="nav-link">
            <i class="nav-icon fas fa-address-book"></i>
            <p>CRM</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/aplicacao/visoes/vendas.php" class="nav-link">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>Vendas</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
