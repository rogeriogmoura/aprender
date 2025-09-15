<?php include __DIR__ . '/partials/header.php'; ?>
<?php include __DIR__ . '/partials/sidebar.php'; ?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Início</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Conteúdo -->
  <section class="content">
    <div class="container-fluid">

      <!-- Abas -->
      <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="financeiro-tab" data-toggle="tab" href="#financeiro" role="tab">Financeiro</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="producao-tab" data-toggle="tab" href="#producao" role="tab">Produção / OS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="crm-tab" data-toggle="tab" href="#crm" role="tab">CRM</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="vendas-tab" data-toggle="tab" href="#vendas" role="tab">Vendas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="executivo-tab" data-toggle="tab" href="#executivo" role="tab">Executivo</a>
        </li>
      </ul>

      <div class="tab-content mt-3" id="dashboardTabsContent">

        <!-- Aba Financeiro -->
        <div class="tab-pane fade show active" id="financeiro" role="tabpanel">
          <div class="row">
            <div class="col-md-6">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Resultado Mensal</h3>
                </div>
                <div class="card-body text-center">
                  <div class="row">
                    <div class="col-sm-4 bg-success p-3 text-white">Receita<br><b>R$ 12.000,00</b></div>
                    <div class="col-sm-4 bg-danger p-3 text-white">Despesa<br><b>R$ 8.000,00</b></div>
                    <div class="col-sm-4 bg-info p-3 text-white">Saldo<br><b>R$ 4.000,00</b></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Resultado Anual</h3>
                </div>
                <div class="card-body text-center">
                  <div class="row">
                    <div class="col-sm-4 bg-success p-3 text-white">Receita<br><b>R$ 85.000,00</b></div>
                    <div class="col-sm-4 bg-danger p-3 text-white">Despesa<br><b>R$ 62.000,00</b></div>
                    <div class="col-sm-4 bg-info p-3 text-white">Saldo<br><b>R$ 23.000,00</b></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <a href="financeiro.php" class="btn btn-primary">Abrir módulo financeiro</a>
        </div>

        <!-- Aba Produção / OS -->
        <div class="tab-pane fade" id="producao" role="tabpanel">
          <div class="card card-info">
            <div class="card-header"><h3 class="card-title">Resumo de Produção / OS</h3></div>
            <div class="card-body">
              <p>Total de OS abertas: <b>12</b></p>
              <p>OS concluídas este mês: <b>8</b></p>
              <p>Valor total em aberto: <b>R$ 15.000,00</b></p>
            </div>
          </div>
          <a href="os_listar.php" class="btn btn-info">Abrir módulo OS</a>
        </div>

        <!-- Aba CRM -->
        <div class="tab-pane fade" id="crm" role="tabpanel">
          <div class="card card-warning">
            <div class="card-header"><h3 class="card-title">Resumo CRM</h3></div>
            <div class="card-body">
              <p>Novos clientes este mês: <b>5</b></p>
              <p>Total de clientes ativos: <b>120</b></p>
            </div>
          </div>
          <a href="clientes_listar.php" class="btn btn-warning">Abrir módulo CRM</a>
        </div>

        <!-- Aba Vendas -->
        <div class="tab-pane fade" id="vendas" role="tabpanel">
          <div class="card card-success">
            <div class="card-header"><h3 class="card-title">Resumo de Vendas</h3></div>
            <div class="card-body">
              <p>Orçamentos no mês: <b>15</b></p>
              <p>Vendas realizadas: <b>9</b></p>
              <p>Taxa de conversão: <b>60%</b></p>
            </div>
          </div>
          <a href="vendas.php" class="btn btn-success">Abrir módulo Vendas</a>
        </div>

        <!-- Aba Executivo -->
        <div class="tab-pane fade" id="executivo" role="tabpanel">
          <div class="card card-danger">
            <div class="card-header"><h3 class="card-title">Indicadores Estratégicos</h3></div>
            <div class="card-body">
              <p>Crescimento anual: <b>12%</b></p>
              <p>Top 5 clientes por receita</p>
              <ol>
                <li>Cliente A - R$ 20.000</li>
                <li>Cliente B - R$ 18.000</li>
                <li>Cliente C - R$ 15.000</li>
              </ol>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>

