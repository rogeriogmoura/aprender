<?php
// aplicacao/visoes/dashboard_admin.php
session_start();

$mysqli = new mysqli("localhost", "root", "", "utierp");
if ($mysqli->connect_errno) { die("Erro MySQL: ".$mysqli->connect_error); }

// ======== Dados básicos para alertas ========
function contagem($mysqli, $sql) {
  $r = $mysqli->query($sql);
  return (int)($r ? $r->fetch_row()[0] : 0);
}
$osAguardando = contagem($mysqli, "SELECT COUNT(*) FROM os WHERE status='aguardando_peca'");
$osAtrasadas  = contagem($mysqli, "SELECT COUNT(*) FROM os WHERE status IN('aberta','em_andamento') AND data_abertura < DATE_SUB(NOW(), INTERVAL 7 DAY)");

// ======== Conteúdo HTML do dashboard ========
ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Dashboard</h2>
</div>

<!-- Abas -->
<ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
  <li class="nav-item"><a class="nav-link active" id="alert-tab" data-toggle="tab" href="#alert" role="tab">Alertas</a></li>
  <li class="nav-item"><a class="nav-link" id="prod-tab" data-toggle="tab" href="#prod" role="tab">Produção</a></li>
  <li class="nav-item"><a class="nav-link" id="fin-tab" data-toggle="tab" href="#fin" role="tab">Financeiro</a></li>
  <li class="nav-item"><a class="nav-link" id="crm-tab" data-toggle="tab" href="#crm" role="tab">CRM</a></li>
</ul>

<div class="tab-content mt-3" id="dashboardTabsContent">

  <!-- Alertas -->
  <div class="tab-pane fade show active" id="alert" role="tabpanel">
    <div class="row">
      <div class="col-md-6">
        <div class="info-box bg-warning">
          <span class="info-box-icon"><i class="fas fa-tools"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">OS aguardando peça</span>
            <span class="info-box-number"><?= $osAguardando ?></span>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="info-box bg-danger">
          <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">OS atrasadas (+7 dias)</span>
            <span class="info-box-number"><?= $osAtrasadas ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Produção -->
  <div class="tab-pane fade" id="prod" role="tabpanel">
    <p>Aba de Produção — em breve gráficos e indicadores aqui.</p>
  </div>

  <!-- Financeiro -->
  <div class="tab-pane fade" id="fin" role="tabpanel">
    <p>Aba de Financeiro — em breve receita, despesa e saldo aqui.</p>
  </div>

  <!-- CRM -->
  <div class="tab-pane fade" id="crm" role="tabpanel">
    <p>Aba de CRM — em breve clientes e contratos aqui.</p>
  </div>

</div>
<?php
$conteudo = ob_get_clean();

// chama layout consolidado
$titulo = "Dashboard";
include __DIR__ . "/layout.php";
