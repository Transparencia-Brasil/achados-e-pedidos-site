<div class="container-fluid breadcrumbLinha">
  <div class="container">
    <div class="row">
      <ul class="breadcrumb">
        <li class="completed"><a href="/">Home</a></li>
        <li class="active"><a href="#">Dados</a></li>
      </ul>
    </div>
  </div>
</div>

<section class="dados">
  <div class="container">
      <div class="row">
          <h1>DADOS</h1>
          <img src="<?=BASE_URL?>assets/images/home/linhas.png" alt="--">
          <p>Veja qual foi a classificação de atendimento dos pedidos de Acesso à Informação cadastrados no Achados e Pedidos.</p>

          <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInLeft animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInLeft;">
            <img src="<?=BASE_URL?>assets/images/home/icon-pedidos-base.jpg" alt="Pedidos na Base"/>
            <h2>Pedidos<br> na base</h2>
            <h3 class="qnt"><?=$sumario['totalPedidos']?></h3>
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12 box wow fadeInDown animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: fadeInDown;">
            <img src="<?=BASE_URL?>assets/images/home/icon-pedidos-atendidos.jpg" alt="Pedidos Atendidos"/>
            <h2>Pedidos<br> atendidos</h2>
            <h3 class="qnt"><?=number_format($sumario['totalPedidosAtendidos']/$sumario['totalPedidos'] * 100, 1)?>%</h3>
            <h4 class="numbers"><?=$sumario['totalPedidosAtendidos']?></h4>
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInRight animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInRight;">
            <img src="<?=BASE_URL?>assets/images/home/icon-pedidos-nao-atendidos.jpg" alt="Pedidos Atendidos"/>
            <h2>Pedidos<br> não atendidos</h2>
            <h3 class="qnt"><?=number_format($sumario['totalPedidosNaoAtendidos']/$sumario['totalPedidos'] * 100, 1)?>%</h3>
            <h4 class="numbers"><?=$sumario['totalPedidosNaoAtendidos']?></h4>
          </div>
      </div>
      <div class="row">
          <div class="col-md-2">&nbsp;</div>
          <div class="col-md-4 col-sm-6 box wow slideInLeft animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInLeft;">
            <img src="<?=BASE_URL?>assets/images/pedidos/icon-atendidos-parcialmente.png" alt="Pedidos atendidos parcialmente"/>
            <h2>Pedidos<br> parcialmente atendidos</h2>
            <h3 class="qnt"><?=number_format($sumario['totalPedidosParcialAtendidos']/$sumario['totalPedidos'] * 100, 1)?>%</h3>
            <h4 class="numbers"><?=$sumario['totalPedidosParcialAtendidos']?></h4>
          </div>

          <div class="col-md-4 col-sm-6 box wow slideInRight animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInRight;">
            <img src="<?=BASE_URL?>assets/images/pedidos/icon-pedidos-nao-classificados.png" alt="Pedidos não classificados"/>
            <h2>Pedidos<br> não<br>classificados</h2>
            <h3 class="qnt"><?=number_format($sumario['totalPedidosNaoClassificados']/$sumario['totalPedidos'] * 100, 1)?>%</h3>
            <h4 class="numbers"><?=$sumario['totalPedidosNaoClassificados']?></h4>
          </div>
      </div>
      <h2 class="text-center">Classificações de atendimento por ano</h2>
      <div id="chart-atendimento"></div>
      <p>&nbsp;</p>
      <h2 class="text-center">Atendimento da LAI no Brasil</h2>

      <div class="row">
          <div class="col-xs-4">
              <div class="form-group">
                  <label for="filter-tipo" class="form-inline-label">Classificação do pedido</label>
                  <select id="filter-tipo" class="form-control" name="filter-tipo">
                      <option value="Atendido">Atendidos</option>
                      <option value="Não Atendido">Não atendidos</option>
                      <option value="Parcialmente Atendido">Parcialmente atendidos</option>
                      <option value="Não Classificado">Não classificados</option>
                  </select>
              </div>
          </div>
          <div class="col-xs-4">
              <div class="form-group">
                  <label for="filter-nivel">Nível federativo</label>
                  <select id="filter-nivel" class="form-control" name="filter-nivel">
                      <option value="--">--</option>
                      <option value="Federal">Federal</option>
                      <option value="Estadual">Estadual</option>
                      <option value="Municipal">Municipal</option>
                  </select>
              </div>
          </div>
          <div class="col-xs-4">
              <div class="form-group">
                  <label for="filter-poder">Esfera de poder</label>
                  <select id="filter-poder" class="form-control" name="filter-poder">
                      <option value="--">--</option>
                      <option value="Executivo">Executivo</option>
                      <option value="Legislativo">Legislativo</option>
                      <option value="Judiciário">Judiciário</option>
                      <option value="Tribunal de Contas">Tribunal de Contas</option>
                      <option value="Ministério Público">Ministério Público</option>
                  </select>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-xs-4 col-xs-offset-8">
            <div class="form-group" style="margin-bottom: 0;">
              <label for="order-by-perc">Mostrar gráfico em ordem:</label>
            </div>
            <label class="radio-inline">
              <input type="radio" name="order-by" id="order-by-perc" class="order-by" value="perc" checked> Crescente
            </label>
            <label class="radio-inline">
              <input type="radio" name="order-by" id="order-by-uf" class="order-by" value="uf"> Alfabética
            </label>
          </div>
      </div>

      <div class="row">
          <div class="col-md-7">
              <div id="chart-pedidos-uf-mapa"></div>
              <div id="chart-pedidos-uf-info" class="chart-info-wrapper" style="display: none;">
                <h4 id="chart-info-uf" class="chart-info-title chart-info-text"></h4>
                <div class="chart-info" id="chart-info-error"></div>
                <div class="chart-info" id="chart-info-all">
                    <span id="chart-info-nivel-w">No nível <span id="chart-info-nivel" class="chart-info-text"></span>,</span><span id="chart-info-poder-w"> no <br>
                    <span id="chart-info-poder" class="chart-info-text"></span>,</span> <span id="chart-info-qtd" class="chart-info-text"></span> pedidos<br>
                    foram <span id="chart-info-tipo" class="chart-info-text"></span>, <br>
                    <span id="chart-info-perc" class="chart-info-text"></span> do total de pedidos<br>correspondentes para este filtro.
                </div>
              </div>
          </div>
          <div class="col-md-5">
              <div id="chart-pedidos-uf-barras"></div>
          </div>
          <div class="col-xs-12">
              <br>
              <span id="chart-pedidos-uf-footer" style="display: none;">Soma dos pedidos de todos os municípios da UF selecionada disponíveis na base.</span>
          </div>
      </div>
      <p>&nbsp;</p>
  </div>
</section>

<section class="dados" style="background-color: #edf0f5; background-image: none;">
  <div class="container">
      <div class="row">
          <h1>TEMPO DE RESPOSTA</h1>
          <p>Segundo a Lei de Acesso (LAI), os órgãos públicos têm um prazo de até 20 dias para responder, prorrogáveis por mais dez.</p>

          <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInLeft animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInLeft;">
            <img src="<?=BASE_URL?>assets/images/home/icon-pedidos-base.jpg" alt="Pedidos na Base"/>
            <h2>Tempo médio da resposta ao pedido inicial</h2>
            <h3 class="qnt"><?=number_format($sumario['tempoMedioPrimeiraResposta'], 1)?> dias</h3>
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12 box wow fadeInDown animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: fadeInDown;">
            <img src="<?=BASE_URL?>assets/images/home/icon-pedidos-atendidos.jpg" alt="Pedidos Atendidos"/>
            <h2>Tempo médio de tramitação com recurso</h2>
            <h3 class="qnt"><?=number_format($sumario['tempoMedioEmTramitacao'], 1)?> dias</h3>
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInRight animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInRight;">
            <img src="<?=BASE_URL?>assets/images/home/icon-pedidos-nao-atendidos.jpg" alt="Pedidos Atendidos"/>
            <h2>Pedidos respondidos em até 20 dias</h2>
            <h3 class="qnt"><?=number_format($sumario['totalPedidosRespondidosEmAteVinteDias']/$sumario['totalPedidos'], 1)?>%</h3>
          </div>
      </div>
      <h2 class="text-center">Quanto tempo leva para um pedido ser respondido?</h2>
      <div class="row">
          <div class="col-xs-4 col-xs-offset-4">
              <div class="form-group">
                  <label for="filter-tipo-tempo" class="form-inline-label">Classificação do pedido</label>
                  <select id="filter-tipo-tempo" class="form-control" name="filter-tipo-tempo">
                      <option value="--">--</option>
                      <option value="Atendido">Atendidos</option>
                      <option value="Não Atendido">Não atendidos</option>
                      <option value="Parcialmente Atendido">Parcialmente atendidos</option>
                      <option value="Não Classificado">Não classificados</option>
                  </select>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-xs-10 col-xs-offset-1">
              <div id="chart-tempo-resposta"></div>
          </div>
      </div>
  </div>
</section>

<section class="dados">
  <div class="container">
      <div class="row">
          <h1>RECURSOS</h1>
          <p>Caso o órgão não conceda ou conceda apenas acesso parcial à informação, o cidadão pode entrar com recurso em até dez dias. O órgão terá o prazo de cinco dias para responder.</p>

          <div class="col-md-2">&nbsp;</div>
          <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInLeft animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInLeft;">
            <img src="<?=BASE_URL?>assets/images/home/icon-pedidos-base.jpg" alt="Pedidos na Base"/>
            <h2>Pedidos que tiveram recurso</h2>
            <h3 class="qnt"><?=number_format($sumario['totalPedidosComRecursos']/$sumario['totalPedidos'], 1)?>%</h3>
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInRight animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInRight;">
            <img src="<?=BASE_URL?>assets/images/home/icon-pedidos-atendidos.jpg" alt="Pedidos Atendidos"/>
            <h2>Pedidos com recursos e atendidos</h2>
            <h3 class="qnt"><?=number_format($sumario['totalPedidosComRecursosAtendidos']/$sumario['totalPedidosComRecursos'], 1)?>%</h3>
          </div>
      </div>
      <h2 class="text-center">Taxa de atendimento por instância recursal</h2>
      <div id="chart-taxa-reversao"></div>
  </div>
</section>

<script type="text/javascript">
(function() {
    var
        order = 0,
        scriptMap = [
        "<?=BASE_URL?>assets/js/d3/4.12.0/d3.min.js",
        "<?=BASE_URL?>assets/js/topojson/3.0.2/topojson.min.js",
        "<?=BASE_URL?>assets/js/lodash.js/4.17.4/lodash.min.js",
        "<?=BASE_URL?>assets/js/dados.chart.js"];
    function loadScriptInOrder() {
        if (order == scriptMap.length) return;
        var
            link = scriptMap[order],
            element = document.createElement('script');
        element.src = link;
        element.onload = callback;
        document.getElementsByTagName('body')[0].appendChild(element);
        function callback() {
            order++;
            loadScriptInOrder();
        }
    };
    loadScriptInOrder();
}());
</script>
