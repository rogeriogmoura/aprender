<?php
$titulo = "Dashboard — Visão 360º";
$breadcrumb = ["Início", "Dashboard"];

// ===== Mock de dados =====
$os = [
  "abertas" => 5,
  "andamento" => 3,
  "peca" => 2,
  "concluidas" => 8,
  "canceladas" => 1
];

$financeiro = [
  "receita_mes" => 12000,
  "despesa_mes" => 8000,
  "saldo_mes" => 4000,
  "a_receber" => 3500,
  "a_pagar" => 2000
];

$crm = [
  "clientes_ativos" => 120,
  "clientes_inativos" => 15,
  "novos_mes" => 10
];

$vendas = [
  "orc_pendentes" => 12,
  "orc_aprovados" => 7,
  "orc_recusados" => 3,
  "taxa_conv" => 58
];
?>

<?php ob_start(); ?>
<div class="container-fluid">

  <!-- Linha 1: OS -->
  <div class="row">
    <div class="col-lg-2 col-6">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3><?= $os['abertas'] ?></h3>
          <p>OS Abertas</p>
        </div>
        <div class="icon"><i class="fas fa-folder-open"></i></div>
      </div>
    </div>
    <div class="col-lg-2 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?= $os['andamento'] ?></h3>
          <p>Em Andamento</p>
        </div>
        <div class="icon"><i class="fas fa-spinner"></i></div>
      </div>
    </div>
    <div class="col-lg-2 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?= $os['peca'] ?></h3>
          <p>Aguardando Peça</p>
        </div>
        <div class="icon"><i class="fas fa-cogs"></i></div>
      </div>
    </div>
    <div class="col-lg-2 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?= $os['concluidas'] ?></h3>
          <p>Concluídas Hoje</p>
        </div>
        <div class="icon"><i class="fas fa-check-circle"></i></div>
      </div>
    </div>
    <div class="col-lg-2 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3><?= $os['canceladas'] ?></h3>
          <p>Canceladas</p>
        </div>
        <div class="icon"><i class="fas fa-times-circle"></i></div>
      </div>
    </div>
  </div>

  <!-- Linha 2: Financeiro -->
  <div class="row">
    <div class="col-lg-2 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>R$ <?= number_format($financeiro['receita_mes'],2,',','.') ?></h3>
          <p>Receita</p>
        </div>
        <div class="icon"><i class="fas fa-arrow-up"></i></div>
      </div>
    </div>
    <div class="col-lg-2 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>R$ <?= number_format($financeiro['despesa_mes'],2,',','.') ?></h3>
          <p>Despesa</p>
        </div>
        <div class="icon"><i class="fas fa-arrow-down"></i></div>
      </div>
    </div>
    <div class="col-lg-2 col-6">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>R$ <?= number_format($financeiro['saldo_mes'],2,',','.') ?></h3>
          <p>Saldo</p>
        </div>
        <div class="icon"><i class="fas fa-wallet"></i></div>
      </div>
    </div>
    <div class="col-lg-2 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>R$ <?= number_format($financeiro['a_receber'],2,',','.') ?></h3>
          <p>À Receber</p>
        </div>
        <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
      </div>
    </div>
    <div class="col-lg-2 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>R$ <?= number_format($financeiro['a_pagar'],2,',','.') ?></h3>
          <p>À Pagar</p>
        </div>
        <div class="icon"><i class="fas fa-credit-card"></i></div>
      </div>
    </div>
  </div>

  <!-- Linha 3: CRM e Vendas -->
  <div class="row">
    <div class="col-lg-2 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?= $crm['clientes_ativos'] ?></h3>
          <p>Clientes Ativos</p>
        </div>
        <div class="icon"><i class="fas fa-users"></i></div>
      </div>
    </div>
    <div class="col-lg-2 col-6">
      <div class="small-box bg-secondary">
        <div class="inner">
          <h3><?= $crm['clientes_inativos'] ?></h3>
          <p>Clientes Inativos</p>
        </div>
        <div class="icon"><i class="fas fa-user-slash"></i></div>
      </div>
    </div>
    <div class="col-lg-2 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?= $crm['novos_mes'] ?></h3>
          <p>Novos no Mês</p>
        </div>
        <div class="icon"><i class="fas fa-user-plus"></i></div>
      </div>
    </div>
    <div class="col-lg-2 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?= $vendas['orc_pendentes'] ?></h3>
          <p>Orç. Pendentes</p>
        </div>
        <div class="icon"><i class="fas fa-hourglass-half"></i></div>
      </div>
    </div>
    <div class="col-lg-2 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?= $vendas['orc_aprovados'] ?></h3>
          <p>Orç. Aprovados</p>
        </div>
        <div class="icon"><i class="fas fa-check"></i></div>
      </div>
    </div>
    <div class="col-lg-2 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3><?= $vendas['orc_recusados'] ?></h3>
          <p>Orç. Recusados</p>
        </div>
        <div class="icon"><i class="fas fa-times"></i></div>
      </div>
    </div>
  </div>

  <!-- Gráficos -->
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header"><h3 class="card-title">OS Criadas x Concluídas</h3></div>
        <div class="card-body"><canvas id="graficoOS"></canvas></div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header"><h3 class="card-title">Receita x Despesa (Últimos 6 meses)</h3></div>
        <div class="card-body"><canvas id="graficoFinanceiro"></canvas></div>
      </div>
    </div>
  </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // OS Criadas x Concluídas
  new Chart(document.getElementById('graficoOS'), {
    type: 'bar',
    data: {
      labels: ['Jan','Fev','Mar','Abr','Mai','Jun'],
      datasets: [
        {label: 'Criadas', data: [5,8,6,10,7,12], backgroundColor:'rgba(54,162,235,0.7)'},
        {label: 'Concluídas', data: [3,7,5,8,6,10], backgroundColor:'rgba(75,192,192,0.7)'}
      ]
    }
  });

  // Receita x Despesa
  new Chart(document.getElementById('graficoFinanceiro'), {
    type: 'line',
    data: {
      labels: ['Abr','Mai','Jun','Jul','Ago','Set'],
      datasets: [
        {label: 'Receita', data: [2000,3000,2500,4000,3500,4500], borderColor:'green', fill:false},
        {label: 'Despesa', data: [1500,2000,2200,2800,2600,3000], borderColor:'red', fill:false}
      ]
    }
  });
</script>
<?php
$conteudo = ob_get_clean();
include "layout.php";

