<!--Cards-->
  <section class="cards">
    <div class="container">
      <div class="row">
        <div class="">
          <?php
          /* Destaques da home. exibe item padrão caso não existam */
          $destaquePrincipal = $destaques->where(["CodigoTipoDestaqueHome" => 1])->first();
          $destaqueSecundarioUm = $destaques2->where(["CodigoTipoDestaqueHome" => 2])->first();
          $destaqueSecundarioDois = $destaques3->where(["CodigoTipoDestaqueHome" => 3])->first();

          //echo ($destaquePrincipal);

          if($destaquePrincipal != null){
            ?>
            <div class="col-md-6 col-sm-6 col-xs-12 primeiroCard">
              <a href="<?=$destaquePrincipal->Link?>">
                <img src="uploads/banners/<?=$destaquePrincipal->Imagem?>" alt="<?=$destaquePrincipal->Nome?>" class="img-responsive">
                <h1><?=$destaquePrincipal->Nome?></h1>
                <p><?=$destaquePrincipal->Resumo?></p>
              </a>
            </div>
            <?php
          }else{
          ?>
          <div class="col-md-6 col-sm-6 col-xs-12 primeiroCard">
            <a href="<?=$this->Url->build('/institucional/')?>">
              <img src="assets/images/home/img-na-midia-1.jpg" alt="Institucional" class="img-responsive">
              <h1>Institucional</h1>
              <p>Conheça mais sobre o trabalho da Transparência Brasil junto a Abraji.</p>
            </a>
          </div>
          <?php
          }

          if($destaqueSecundarioUm != null){
            ?>
            <div class="col-md-6 col-sm-6 col-xs-12 pull-right segundoCard">
              <a href="<?=$destaqueSecundarioUm->Link?>"><img src="uploads/banners/<?=$destaqueSecundarioUm->Imagem?>" alt="<?=$destaqueSecundarioUm->Nome?>" class="img-responsive">
              <h1><?=$destaqueSecundarioUm->Nome?></h1>
              <p><?=$destaqueSecundarioUm->Resumo?></p></a>
            </div>
          <?php
          }else{
          ?>
          <div class="col-md-6 col-sm-6 col-xs-12 pull-right segundoCard">
            <a href="<?=$this->Url->build('/na-midia/')?>">
              <img src="assets/images/home/img-na-midia-2.jpg" alt="Institucional" class="img-responsive">
              <h1>Na Mídia</h1>
              <p>Veja os destaques que sairam na mídia sobre o projeto!</p>
            </a>
          </div>
          <?php
          }

          if($destaqueSecundarioDois != null){
            ?>
            <div class="col-md-6 col-sm-6 col-xs-12 pull-right ultimoCard">
              <a href="<?=$destaqueSecundarioDois->Link?>">
                <h1><?=$destaqueSecundarioDois->Nome?></h1>
                <p><?=$destaqueSecundarioDois->Resumo?></p>
              </a>
            </div>
          <?php
          }else{
          ?>
            <div class="col-md-6 col-sm-6 col-xs-12 pull-right ultimoCard">
              <a href="<?=$this->Url->build('/cursos/')?>">
                <h1>Cursos</h1>
                <p>Confira os cursos oferecidos pela Abraji.</p>
              </a>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </section>

  <!--Como Funciona-->
  <section class="comoFunciona" id="parallaxBar" data-speed="25" data-type="background">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <h1>COMO FUNCIONA</h1>
          <img src="assets/images/home/linhas.png" alt="Como Funciona">
          <p>
          O Achados e Pedidos reúne solicitações de cidadãos e respostas da administração
          pública feitas via Lei de Acesso à Informação (LAI).
            <br><br>
            Todo cidadão tem direito de obter informações públicas a<br> respeito de qualquer assunto, por exemplo: quanto se gasta<br> com funcionários em determinado órgão público? Ou quanto<br> de água é desperdiçado por problemas de encanamento da<br> própria empresa pública? <br><br>
            <strong>O que você quer saber? Busque uma resposta ou<br> base de dados disponibilizada pelo governo no<br> nosso site.</strong>
          </p>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 lupa">
          <img src="assets/images/home/img-como-funciona.png" alt="Como Funciona" class="img-responsive">
        </div>
      </div>
    </div>
  </section>

   <!--Pedidos Recentes-->
  <section class="pedidosRecentes">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
          <h1>PEDIDOS RECENTES</h1>
          <img src="<?=BASE_URL?>assets/images/home/linhas.png" alt="Como Funciona">
        </div>
        <?php
        $ultimosPedidos = $viewModel["UltimosPedidos"];
        $contador = 0;

        foreach ($ultimosPedidos as $pedido) {
          $nomeUsuario = $pedido["Anonimo"] == 1 ? "Anônimo" : $pedido["NomeUsuario"];
          $slugUsuario = $pedido["Anonimo"] == 1 ? "javascript:void(0);" : "/usuarios/" . $pedido["SlugUsuario"];

          $slide = $contador % 2 == 0 ? "slideInLeft" : "slideInRight";
          ?>
          <div class="col-md-6 col-sm-6 col-xs-12 box wow <?=$slide?> animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="min-height:340px;visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: <?=$slide?>;">
            <p>
              <?=truncate($pedido["Titulo"],200)?>
            </p>
            <div class="enviado">Pedido enviado para: <a href="<?=$this->Url->build('/agentes/' . $pedido["SlugAgente"])?>"><?=$pedido["NomeAgente"]?></a></div>
            <div class="porr">Pedido disponibilizado por: <a href="<?=$this->Url->build($slugUsuario)?>"><?=$nomeUsuario?></a></div>
            <div class="em">Em: <?=$pedido["DataEnvio"]?></div>
            <div class="btnVerMais btn-size-small pull-right">
              <a href="<?=$this->Url->build('/pedidos/' . $pedido["Slug"])?>">Ver
                <div class="seta seta-direita"></div>
              </a>
            </div>
          </div>
        <?php
          $contador++;
        }
        ?>
      </div>
        <div class="col-md-12 col-sm-6 col-xs-12 text-center">
          <div class="bntVer"><a href="<?=$this->Url->build('/pedidos')?>">Ver mais</a></div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  cor1 = "#fe9301";cor2 = "#cccc00";cor3 = "#00ccff";cor4 = "#3366ff";

  function pickColor(total)
  {
      if(total == 0 || total < 100){
        return cor1;
      }else if(total > 100 && total < 500)
      {
        return cor2;
      }else if(total > 500 && total < 10000)
      {
        return cor3;
      }else{
        return cor4;
      }
  }

  $(document).ready(function(){


<?php
  //2017-03-09 Paulo Campos -> Não era para estar aqui, mas... Função para "cropar" os títulos dos pedidos nos cards da seção Pedidos Recentes
  function truncate($text, $chars = 50) {
      $text = $text." ";
      $text = substr($text,0,$chars);
      $text = substr($text,0,strrpos($text,' '));
      $text = $text."...";
      return $text;
  }

  /* GERA O SCRIPT DAS BARRAS DE DADOS PARA CADA ESTADO.
    O SCRIPT NÃO FOI ADICIONADO DENTRO DO LOOP DOS GRÁFICOS PORQUE O SCRIPT
    DO SLICK IDENTIFICA OS VALORES ABAIXO COMO OUTRO GRÁFICO (BUG!)
  */
  $relatorioPorEstado = $viewModel["RelatorioPorEstado"];
  foreach($relatorioPorEstado as $estado){
  ?>

      var ctx = document.getElementById("myChart<?=$estado["Codigo"]?>");
      var myChart<?=$estado["Codigo"]?> = new Chart(ctx, {
          type: 'bar',
          responsive: true,
          height:960,
          data: {
              labels: ["Respostas atendidas", "Respostas negativas"],
              datasets: [{
                  data: [<?=$estado["TotalAtendidos"]?>, <?=$estado["TotalNaoAtendidos"]?>],
                  backgroundColor: [
                      'rgba(255, 243, 224, 0.8)',
                      'rgba(251, 215, 218, 0.8)'
                  ],
                  borderColor: [
                      'rgba(255,181,157,2)',
                      'rgba(189, 131, 158, 1)'
                  ],
                  borderWidth: 1
              }]
          },
           options: {
              legend: {display: false,},
              scales: {xAxes: [{stacked: true,ticks: {min: 0,max: 100,stepWidth: 2}}],
                  yAxes: [{stacked: true,ticks: {min: 0,max: <?=$estado["Total"]?> + 5,stepWidth: 2}}]}
                }
      });

      elementoMapa = $("a[data-uf='<?=$estado["Sigla"]?>']");

      cor = pickColor(<?=$estado["Total"]?>)
      elementoMapa.find('path').css('fill', cor);
      // mudar a cor do elemento do mapa
  <?php
  }
?>
  });
</script>
