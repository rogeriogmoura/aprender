<?php 
session_start();
if(!isset($_SESSION['logado'])){header("location: login.php");exit;}

/* timezone e saudação dinâmica */
date_default_timezone_set('America/Sao_Paulo');
$hora = (int)date('H');
$saudacao = ($hora>=18) ? 'boa noite' : (($hora>=12) ? 'boa tarde' : 'bom dia');

/* dados do usuário */
$nome   = isset($_SESSION['nome'])   ? $_SESSION['nome']   : 'administrador';
$funcao = isset($_SESSION['funcao']) ? $_SESSION['funcao'] : 'admin';

/* conexão com banco */
$mysqli = new mysqli("localhost", "root", "", "utierp");
if ($mysqli->connect_error) {
    die("Erro ao conectar: " . $mysqli->connect_error);
}

/* gráfico de barras - serviços concluídos nos últimos 7 dias */
$sqlBarras = "
  SELECT DATE(data_conclusao) as dia, COUNT(*) as total
  FROM os
  WHERE status = 'concluida'
  GROUP BY DATE(data_conclusao)
  ORDER BY dia DESC
  LIMIT 7
";
$resBarras = $mysqli->query($sqlBarras);

$labelsBarras = [];
$dadosBarras = [];
while($row = $resBarras->fetch_assoc()){
    $labelsBarras[] = date('d/m', strtotime($row['dia']));
    $dadosBarras[] = $row['total'];
}

/* gráfico de pizza - status das OS */
$sqlPizza = "
  SELECT status, COUNT(*) as total
  FROM os
  GROUP BY status
";
$resPizza = $mysqli->query($sqlPizza);

$labelsPizza = [];
$dadosPizza = [];
while($row = $resPizza->fetch_assoc()){
    $labelsPizza[] = $row['status'];
    $dadosPizza[] = $row['total'];
}


/* avatar dinâmico */
$avatar_url = 'https://ui-avatars.com/api/?background=2c1f4a&color=fff&name='.urlencode($nome);
?>
<!doctype html>
<html lang="pt-br">
<head>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>dashboard <?= htmlspecialchars($funcao,ENT_QUOTES,'UTF-8'); ?></title>

<!-- google fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


  <!-- cdn css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />

  <style>

/* logomarca ocupando toda a largura da sidebar */
.main-sidebar .brand-link {
  background: inherit !important;  /* mesma cor da sidebar */
  border-bottom: 1px solid rgba(0,0,0,.1);
  height: 80px; /* altura ajustável */
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
}

.main-sidebar .brand-link img {
  max-height: 60px;  /* controla altura da logo */
  width: 100%;       /* ocupa toda a largura */
  object-fit: contain; /* mantém proporção */
}


    /* fonte global do sistema */
     body, .content-wrapper, .card, .navbar, .form-control, button, h1, h2, h3, h4, h5, h6 {
      font-family: 'Poppins', sans-serif !important;
     letter-spacing: 0.2px;
  }

        /* saudação */
    .saudacao {
      padding:16px 20px;
      background:#f7f7fb;
      border-bottom:1px solid #ddd;
    }
    .dark-mode .saudacao {
      background:#1f1f28;
      border-color:#2a2a36;
    }

    /* ===============================
   PALETA DE CORES - ERP UTI NOTEBOOK
   =============================== */

/* 🌙 DARK MODE */
body.dark-mode {
  background-color: #18122B !important;
  color: #e0e0e0 !important;
}

body.dark-mode .main-header {
  background-color: #1e1b2e !important;
}

body.dark-mode .main-sidebar {
  background-color: #1b1730 !important;
}

body.dark-mode .content-wrapper {
  background-color: #201c35 !important;
}

body.dark-mode .card {
  background-color: #2a2344 !important;
  color: #f5f5f5 !important;
  border: none !important;
}

body.dark-mode .card-header {
  background-color: #241f3a !important;
  border-bottom: 1px solid #3a345a !important;
}

/* ☀️ LIGHT MODE */
body:not(.dark-mode) {
  background-color: #f7f7fb !important;
  color: #222 !important; /* texto principal mais escuro */
}

body:not(.dark-mode) .main-header {
  background-color: #f0f0f5 !important;
}

body:not(.dark-mode) .main-sidebar {
  background-color: #ffffff !important;
  color: #222 !important;
}

body:not(.dark-mode) .nav-sidebar .nav-link {
  color: #444 !important; /* links padrão */
}

body:not(.dark-mode) .nav-sidebar .nav-link.active {
  background-color: #6c5ce7 !important; /* cor da identidade visual */
  color: #fff !important; /* texto branco no ativo */
}

body:not(.dark-mode) .nav-sidebar .nav-icon {
  color: #6c5ce7 !important; /* ícones com cor da identidade */
}

body:not(.dark-mode) .nav-sidebar .nav-link.active .nav-icon {
  color: #fff !important; /* ícone branco no item ativo */
}

body:not(.dark-mode) .content-wrapper {
  background-color: #f7f7fb !important;
}

body:not(.dark-mode) .card {
  background-color: #ffffff !important;
  color: #333 !important;
  border: 1px solid #e5e5e5 !important;
}

body:not(.dark-mode) .card-header {
  background-color: #fafafa !important;
  border-bottom: 1px solid #ddd !important;
}

/* rodapé fixo dentro da sidebar */
.sidebar-footer{
  position: sticky;      /* fica colado no final da área rolável */
  bottom: 0;
  z-index: 10;
  display: flex;
  justify-content: space-between;
  gap: .5rem;
  padding: .5rem;
  border-top: 1px solid rgba(0,0,0,.1); /* borda sutil */
  background: inherit;  /* usa a mesma cor da sidebar */
}

/* light mode: fundo claro e bom contraste */
body:not(.dark-mode) .sidebar-footer{
  background:#ffffff;
  border-top:1px solid #eee;
}
body:not(.dark-mode) .sidebar-footer .btn-outline-light{
  color:#6c5ce7; border-color:#6c5ce7;
}
body:not(.dark-mode) .sidebar-footer .btn-outline-light:hover{
  background:#6c5ce7; color:#fff;
}

/* fundo da área da logomarca igual ao sidebar */
.main-sidebar .brand-link {
  background: inherit !important;  /* mesma cor da sidebar */
  border-bottom: 1px solid rgba(0,0,0,.1); /* borda discreta */
  height: 70px; /* mantém altura padrão */
  display: flex;
  align-items: center;
  justify-content: center;
}


  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  
    <!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background:#2c1f4a;">

  <!-- logomarca ocupando toda a largura -->
<a href="#" class="brand-link">
  <img src="../../publico/imagens/logo.png" alt="logo" class="brand-image">
</a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- busca no menu -->
    <div class="form-inline mt-2 mb-3">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Buscar..." aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button>
        </div>
      </div>
    </div>

    <!-- notificações -->
<div class="px-3 py-2">
  <ul class="list-unstyled mb-0 small">
    <li><i class="fas fa-tools text-danger"></i> 2 OS atrasadas</li>
    <li><i class="fas fa-box-open text-warning"></i> 3 peças em falta</li>
    <li><i class="fas fa-receipt text-info"></i> 1 conta vence hoje</li>
  </ul>
</div>


    <!-- menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p> Dashboard </p>
          </a>
        </li>

        <!-- financeiro -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-dollar-sign"></i>
            <p> Financeiro <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Contas a pagar</p></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Contas a receber</p></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Relatórios</p></a></li>
          </ul>
        </li>

        <!-- os -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tools"></i>
            <p> Ordens de Serviço <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Nova OS</p></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Listar OS</p></a></li>
          </ul>
        </li>

        <!-- estoque -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-boxes"></i>
            <p> Estoque <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Produtos</p></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Movimentações</p></a></li>
          </ul>
        </li>

        <!-- crm -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p> CRM <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Clientes</p></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Contratos</p></a></li>
          </ul>
        </li>

        <!-- relatórios -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p> Relatórios </p>
          </a>
        </li>

      </ul>
    </nav>
  </div>


  <!-- rodapé fixo da sidebar (dark/light + sair) -->
  <div class="sidebar-footer mt-3 p-2 d-flex justify-content-between">
    <button id="btn-dark-mode" class="btn btn-sm btn-outline-light" title="alternar tema">
      <i class="far fa-moon"></i>
    </button>
    <a href="../controladores/logout.php" class="btn btn-sm btn-danger" title="sair">
      <i class="fas fa-sign-out-alt"></i>
    </a>
  </div>
</div> <!-- fecha .sidebar -->
  
</aside>


  <!-- Conteúdo principal -->
  <div class="content-wrapper p-4">
    <h2>Bem-vindo <?= htmlspecialchars($nome,ENT_QUOTES,'UTF-8'); ?>!</h2>
    <p>Este é o seu painel inicial.</p>
  </div>

</div>

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
  (function(){
    const btn = document.getElementById('btn-dark-mode');
    if(!btn) return;

    function aplicar(modoEscuro){
      document.body.classList.toggle('dark-mode', modoEscuro);
      const icone = btn.querySelector('i');
      if(icone){
        icone.classList.toggle('fa-moon', !modoEscuro);
        icone.classList.toggle('fa-sun',  modoEscuro);
      }
      localStorage.setItem('modo', modoEscuro ? 'escuro' : 'claro');
    }

    // carrega preferência (padrão: escuro)
    const salvo = localStorage.getItem('modo') || 'escuro';
    aplicar(salvo === 'escuro');

    // alterna ao clicar
    btn.addEventListener('click', function(e){
      e.preventDefault();
      aplicar(!document.body.classList.contains('dark-mode'));
    });
  })();
</script>

</body>

</html>
