<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
  <!-- Botão hambúrguer -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
  </ul>

  <!-- Barra de busca central -->
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

  <!-- Ícones e atalhos lado direito -->
  <ul class="navbar-nav ml-auto">
    <!-- Atalho rápido: Nova OS -->
    <li class="nav-item">
      <a class="nav-link" href="/aplicacao/visoes/os_nova.php" title="Nova OS">
        <i class="fas fa-plus-circle"></i>
      </a>
    </li>

    <!-- Mensagens -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge">3</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">3 mensagens</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> Nova mensagem de João
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">Ver todas mensagens</a>
      </div>
    </li>

    <!-- Notificações -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">5</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">5 notificações</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-exclamation-circle mr-2"></i> 2 OS atrasadas
          <span class="float-right text-muted text-sm">10 mins</span>
        </a>
        <a href="#" class="dropdown-item">
          <i class="fas fa-tools mr-2"></i> 1 OS aguardando peça
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">Ver todas notificações</a>
      </div>
    </li>

    <!-- Usuário -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <img src="/aprender/publico/imagens/usuario_mockup.png"
             class="img-circle elevation-2"
             alt="Usuário"
             width="30">
        Administrador
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="#" class="dropdown-item">
          <i class="fas fa-user mr-2"></i> Perfil
        </a>
        <div class="dropdown-divider"></div>
        <a href="/logout.php" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Sair
        </a>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

