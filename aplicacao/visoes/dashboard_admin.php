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

  <!-- cdn css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />

  <style>
    /* navbar roxa full width */
    .main-header {
      background:#2c1f4a !important;
      margin-left:0 !important;
    }
    .main-header .nav-link { color:#fff !important; }
    .navbar-badge { font-size:0.75rem; }

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
  </style>
</head>
<body class="hold-transition layout-navbar-fixed layout-top-nav">
<div class="wrapper">

  <!-- navbar -->
  <nav class="main-header navbar navbar-expand">
    <!-- logo + nome -->
    <ul class="navbar-nav">
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link font-weight-bold">
          <i class="fas fa-laptop-code mr-2"></i> uti do notebook
        </a>
      </li>
    </ul>

    <!-- lado direito -->
    <ul class="navbar-nav ml-auto">

      <!-- notificações -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-label="notificações">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">6</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">6 notificações</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-tools mr-2 text-danger"></i> 2 os atrasadas
          </a>
          <a href="#" class="dropdown-item">
            <i class="fas fa-box-open mr-2 text-warning"></i> 3 peças com estoque baixo
          </a>
          <a href="#" class="dropdown-item">
            <i class="fas fa-receipt mr-2 text-info"></i> 1 conta vence hoje
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">ver todas</a>
        </div>
      </li>

      <!-- dark mode -->
      <li class="nav-item">
        <a id="btn-dark-mode" class="nav-link" href="#" title="alternar modo escuro">
          <i class="far fa-moon"></i>
        </a>
      </li>

      <!-- usuário -->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img src="<?= htmlspecialchars($avatar_url,ENT_QUOTES,'UTF-8'); ?>" class="user-image img-circle elevation-2" alt="avatar">
          <span class="d-none d-md-inline"><?= htmlspecialchars($nome,ENT_QUOTES,'UTF-8'); ?> (<?= htmlspecialchars($funcao,ENT_QUOTES,'UTF-8'); ?>)</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-item">
            <div class="media">
              <img src="<?= htmlspecialchars($avatar_url,ENT_QUOTES,'UTF-8'); ?>" class="img-size-50 mr-3 img-circle" alt="avatar">
              <div class="media-body">
                <h3 class="dropdown-item-title mb-1"><?= htmlspecialchars($nome,ENT_QUOTES,'UTF-8'); ?></h3>
                <p class="text-sm mb-0"><?= htmlspecialchars($funcao,ENT_QUOTES,'UTF-8'); ?></p>
              </div>
            </div>
          </div>
          <div class="dropdown-divider"></div>
          <a href="../controladores/logout.php" class="dropdown-item dropdown-footer text-danger">sair</a>
        </div>
      </li>
    </ul>
  </nav>

  <!-- saudação -->
  <section class="saudacao">
    <h2 class="m-0">
      <?= $saudacao; ?>, <?= htmlspecialchars($nome,ENT_QUOTES,'UTF-8'); ?>! aqui está o resumo de hoje 👇
    </h2>
  </section>

      <!-- conteúdo principal com abas -->
  <section class="content p-4">
    <div class="card card-primary card-outline">
      <div class="card-header p-2 border-bottom-0">
        <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="tab-geral" data-toggle="tab" href="#aba-geral" role="tab">
              <i class="fas fa-chart-line"></i> visão geral
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab-financeiro" data-toggle="tab" href="#aba-financeiro" role="tab">
              💰 financeiro
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab-os" data-toggle="tab" href="#aba-os" role="tab">
              🛠️ ordens de serviço
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab-estoque" data-toggle="tab" href="#aba-estoque" role="tab">
              📦 estoque
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab-clientes" data-toggle="tab" href="#aba-clientes" role="tab">
              👥 clientes & crm
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab-metas" data-toggle="tab" href="#aba-metas" role="tab">
              🎯 metas & equipe
            </a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="dashboardTabsContent">


<!-- aba visão geral -->
<div class="tab-pane fade show active" id="aba-geral" role="tabpanel">

  <!-- linha 1: KPIs -->
  <div class="row">
    <div class="col-lg-3 col-md-6 col-12">
      <div class="small-box bg-gradient-success shadow rounded-xl">
        <div class="inner">
          <h3>R$ 4.200,00</h3>
          <p>saldo em caixa</p>
        </div>
        <div class="icon"><i class="fas fa-dollar-sign"></i></div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
      <div class="small-box bg-gradient-info shadow rounded-xl">
        <div class="inner">
          <h3>14</h3>
          <p>os abertas</p>
        </div>
        <div class="icon"><i class="fas fa-tools"></i></div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
      <div class="small-box bg-gradient-warning shadow rounded-xl">
        <div class="inner">
          <h3>320</h3>
          <p>clientes ativos</p>
        </div>
        <div class="icon"><i class="fas fa-user-friends"></i></div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
      <div class="small-box bg-gradient-danger shadow rounded-xl">
        <div class="inner">
          <h3>R$ 500</h3>
          <p>faturamento do dia</p>
        </div>
        <div class="icon"><i class="fas fa-shopping-cart"></i></div>
      </div>
    </div>
  </div>

  <!-- linha 2: gráficos -->
  <div class="row">
    <div class="col-lg-6 col-12">
      <div class="card shadow rounded-xl">
        <div class="card-header bg-white border-0">
          <h3 class="card-title"><i class="fas fa-chart-bar text-primary"></i> serviços concluídos (30 dias)</h3>
        </div>
        <div class="card-body">
          <canvas id="graficoBarras"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-12">
      <div class="card shadow rounded-xl">
        <div class="card-header bg-white border-0">
          <h3 class="card-title"><i class="fas fa-chart-pie text-success"></i> distribuição de os por status</h3>
        </div>
        <div class="card-body">
          <canvas id="graficoPizza"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- linha 3: ticket médio -->
  <div class="row">
    <div class="col-12">
      <div class="card shadow rounded-xl">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h5 class="mb-1">ticket médio</h5>
            <p class="mb-0">este mês: <strong>R$ 340</strong> | mês passado: <strong>R$ 295</strong></p>
          </div>
          <span class="badge badge-success p-2">📈 +15%</span>
        </div>
      </div>
    </div>
  </div>

  <!-- linha 4: alertas rápidos -->
  <div class="row">
    <div class="col-12">
      <div class="card shadow rounded-xl">
        <div class="card-header bg-white border-0">
          <h3 class="card-title"><i class="fas fa-exclamation-triangle text-danger"></i> alertas rápidos</h3>
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><span class="text-danger">🔴 2 os atrasadas</span></li>
            <li class="list-group-item"><span class="text-warning">🟠 3 peças com estoque baixo</span></li>
            <li class="list-group-item"><span class="text-info">🟡 1 conta vence hoje</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

</div>



          <!-- aba financeiro -->
          <div class="tab-pane fade" id="aba-financeiro" role="tabpanel">
            <div class="alert alert-success">💰 aqui vão entrar resumo financeiro, gráficos e metas.</div>
          </div>

          <!-- aba ordens de serviço -->
          <div class="tab-pane fade" id="aba-os" role="tabpanel">
            <div class="alert alert-primary">🛠️ aqui vão entrar status de OS, gráficos e alertas.</div>
          </div>

          <!-- aba estoque -->
          <div class="tab-pane fade" id="aba-estoque" role="tabpanel">
            <div class="alert alert-warning">📦 aqui vamos mostrar itens em falta, top peças e reposição.</div>
          </div>

          <!-- aba clientes -->
          <div class="tab-pane fade" id="aba-clientes" role="tabpanel">
            <div class="alert alert-secondary">👥 aqui entram dados de clientes, top cliente e aniversariantes.</div>
          </div>

          <!-- aba metas -->
          <div class="tab-pane fade" id="aba-metas" role="tabpanel">
            <div class="alert alert-danger">🎯 aqui vamos colocar produtividade da equipe, metas e avisos internos.</div>
          </div>

        </div>
      </div>
    </div>
  </section>



</div>

<!-- cdn js principais -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- chart.js via cdn -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // gráfico de barras
  new Chart(document.getElementById('graficoBarras'), {
    type: 'bar',
    data: {
      labels: <?= json_encode($labelsBarras); ?>,
      datasets: [{
        label: 'serviços concluídos',
        data: <?= json_encode($dadosBarras); ?>,
        backgroundColor: '#2c1f4a',
        borderRadius: 8
      }]
    },
    options: { responsive: true, maintainAspectRatio: false }
  });

  // gráfico de pizza
  new Chart(document.getElementById('graficoPizza'), {
    type: 'pie',
    data: {
      labels: <?= json_encode($labelsPizza); ?>,
      datasets: [{
        data: <?= json_encode($dadosPizza); ?>,
        backgroundColor: ['#ffc107', '#17a2b8', '#28a745', '#dc3545']
      }]
    },
    options: { responsive: true, maintainAspectRatio: false }
  });
</script>

<!-- dark mode com persistência -->
<script>
  (function(){
    const btn = document.getElementById('btn-dark-mode');
    const apply = (isDark)=>{
      document.body.classList.toggle('dark-mode', isDark);
      const icon = btn.querySelector('i');
      icon.classList.toggle('fa-moon', !isDark);
      icon.classList.toggle('fa-sun',  isDark);
      localStorage.setItem('modo', isDark ? 'escuro' : 'claro');
    };
    apply(localStorage.getItem('modo') === 'escuro');
    btn.addEventListener('click', function(e){
      e.preventDefault();
      apply(!document.body.classList.contains('dark-mode'));
    });
  })();
</script>
</body>
</html>
