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

<link rel="stylesheet" href="../../publico/css/estilo.css">

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
