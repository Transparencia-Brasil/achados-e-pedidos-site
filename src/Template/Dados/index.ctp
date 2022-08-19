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
          <p>Veja a taxa de resposta dos pedidos de acesso à informação cadastrados no Achados e Pedidos.<br>Pedidos respondidos são aqueles que receberam algum tipo de resposta do órgão público (sem considerar recursos)<br>Pedidos não respondidos são aqueles que não receberam resposta do órgão público (mesmo depois de uma reclamação pela omissão ter sido apresentada)<br>Os dados não indicam se a resposta foi satisfatória ou adequada.</p>
          <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInLeft animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInLeft;">
            <img src="<?=BASE_URL?>assets/images/home/icon-pedidos-base.jpg" alt="Pedidos na Base"/>
            <h2>Pedidos<br> na base</h2>
            <h3 class="qnt"><?=$sumario['totalPedidos']?></h3>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInRight animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInRight;">
            <img src="<?=BASE_URL?>assets/images/home/icon-pedidos-nao-atendidos.jpg" alt="Pedidos não respondidos"/>
            <h2>Pedidos<br> não respondidos</h2>
            <h3 class="qnt"><?=$sumario['totalPedidosNaoRespondidos']?></h3>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 box wow fadeInDown animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: fadeInDown;">
            <img src="<?=BASE_URL?>assets/images/home/icon-pedidos-atendidos.jpg" alt="Pedidos respondidos"/>
            <h2>Pedidos<br> respondidos</h2>
            <h3 class="qnt"><?=$sumario['totalPedidosRespondidos']?></h3>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInLeft animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInLeft;">
            <img src="<?=BASE_URL?>assets/images/pedidos/icon-atendido.png" alt="<?=$sumario['totalPedidosClassificacao']['Atendido']['label']?>" height="150px"/>
            <h2><?=$sumario['totalPedidosClassificacao']['Atendido']['label']?></h2>
            <h3 class="qnt"><?=$sumario['totalPedidosClassificacao']['Atendido']['count']?></h3>
            <h3 class="qnt" style="font-size:18px;"><?=$sumario['totalPedidosClassificacao']['Atendido']['percent']?></h3>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInRight animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInRight;">
            <img src="<?=BASE_URL?>assets/images/pedidos/icon-nao-atendido.png" alt="<?=$sumario['totalPedidosClassificacao']['Não Atendido']['label']?>"  height="150px"/>
            <h2><?=$sumario['totalPedidosClassificacao']['Não Atendido']['label']?></h2>
            <h3 class="qnt"><?=$sumario['totalPedidosClassificacao']['Não Atendido']['count']?></h3>
            <h3 class="qnt" style="font-size:18px;"><?=$sumario['totalPedidosClassificacao']['Não Atendido']['percent']?></h3>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 box wow fadeInDown animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: fadeInDown;">
            <img src="<?=BASE_URL?>assets/images/pedidos/icon-parcialmente-atendido.png" alt="<?=$sumario['totalPedidosClassificacao']['Parcialmente Atendido']['label']?>"  height="150px"/>
            <h2><?=$sumario['totalPedidosClassificacao']['Parcialmente Atendido']['label']?></h2>
            <h3 class="qnt"><?=$sumario['totalPedidosClassificacao']['Parcialmente Atendido']['count']?></h3>
            <h3 class="qnt" style="font-size:18px;"><?=$sumario['totalPedidosClassificacao']['Parcialmente Atendido']['percent']?></h3>
          </div>          
      </div>
      <h2 class="text-center">Taxa de resposta por ano</h2>
      <div id="my_dataviz"></div>
      <div id="taxa-resposta-ano"></div>
      <p>&nbsp;</p>
      <h2 class="text-center">Taxa de atendimento por ano</h2>
      <div id="my_dataviz"></div>
      <div id="taxa-atendimento-ano"></div>
      <p>&nbsp;</p>      
      <h2 class="text-center">Pedidos respondidos - Brasil e UFs</h2>

      <div class="row">
          <!--<div class="col-xs-4">
              <div class="form-group">
                  <label for="filter-tipo" class="form-inline-label">Classificação do pedido</label>
                  <select id="filter-tipo" class="form-control" name="filter-tipo">
                      <option value="Respondido">Respondido</option>
                      <option value="Não respondido">Não Respondido</option>
                  </select>
              </div>
          </div>-->
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
                      <option value="Tribunais de Contas">Tribunais de Contas</option>
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
                   <!-- <span id="chart-info-nivel-w">No nível <span id="chart-info-nivel" class="chart-info-text"></span>,</span><span id="chart-info-poder-w"> no <br>
                    <span id="chart-info-poder" class="chart-info-text"></span>,</span> -->
                    <span id="chart-info-qtd" class="chart-info-text"></span> pedidos<br>
                    foram <span id="chart-info-tipo" class="chart-info-text">respondidos</span>, <br>
                    <span id="chart-info-perc" class="chart-info-text"></span>% do total de pedidos<br>correspondentes para este filtro.
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
          <p>Segundo a Lei de Acesso (LAI), os órgãos públicos têm até 20 dias para responder a um pedido. O prazo pode ser prorrogado por 10 dias.</p>
  
          <div class="col-md-2">&nbsp;</div>
          <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInLeft animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInLeft;">
            <img src="<?=BASE_URL?>assets/images/home/icon-pedidos-base.jpg" alt="Pedidos na Base"/>
            <h2>Tempo médio da resposta ao pedido inicial</h2>
            <h3 class="qnt"><?=number_format($sumario['tempoMedioPrimeiraResposta'], 1)?> dias</h3>
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInRight animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInRight;">
            <img src="<?=BASE_URL?>assets/images/home/icon-pedidos-atendidos.jpg" alt="Pedidos Atendidos"/>
            <h2>Pedidos respondidos em até 20 dias</h2>
            <h3 class="qnt"><?=$sumario['totalPedidosRespondidosEmAteVinteDias']?>%</h3>
          </div>
      </div>
      <h2 class="text-center">Quanto tempo leva para um pedido ser respondido?</h2>
      <p>Tempo expresso em dias. Refere-se ao tempo que levou para o órgão dar algum tipo de resposta ao pedido (sem considerar se a resposta foi satisfatória ou adequada). Não inclui respostas a recursos.</p>
      <div class="row">
        <div class="col-xs-4">
              <div class="form-group">
                  <label for="filter-tempo-esfera">Nível federativo</label>
                  <select id="filter-tempo-esfera" class="form-control" name="filter-tempo-esfera">
                      <option value="--">--</option>
                      <option value="Federal">Federal</option>
                      <option value="Estadual">Estadual</option>
                      <option value="Municipal">Municipal</option>
                  </select>
              </div>
          </div>
          <div class="col-xs-4">
              <div class="form-group">
                  <label for="filter-tipo-tempo" class="form-inline-label">Esfera de poder</label>
                  <select id="filter-tipo-tempo" class="form-control" name="filter-tipo-tempo">
                      <option value="--">--</option>
                      <option value="Executivo">Executivo</option>
                      <option value="Legislativo">Legislativo</option>
                      <option value="Judiciário">Judiciário</option>
                      <option value="Tribunais de Contas">Tribunais de Contas</option>
                      <option value="Ministério Público">Ministério Público</option>
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
<script type="text/javascript">
(function() {
    var
        order = 0,
        scriptMap = [
        "<?=BASE_URL?>assets/js/d3/4.12.0/d3.min.js",
        "<?=BASE_URL?>assets/js/d3/4.12.0/d3.legend.min.js",
        "https://d3js.org/d3-scale-chromatic.v1.min.js",
        "https://d3js.org/d3-geo-projection.v2.min.js",
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
