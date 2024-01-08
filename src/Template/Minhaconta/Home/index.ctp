
<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed"><a href="<?=BASE_URL?>">Home</a></li>
      <li class="active">Minha Conta</li>
    </ul>
  </div>
</div>

<div class="perfil">
  <form method="post" id="frmMinhaContaPedidos"><input type="hidden" id="pagina" name="pagina" value="<?=$pagina?>"/></form>
  <div class="container-fluid bgPerfil">
    <div class="container">
      <div class="col-md-3 sidebarPerfil">
        <div class="col-md-12">
          <div class="panel panel-default">
             <div class="panel-body">
              <div class="box-info">
                <div class="box-body">
                  <div class="col-sm-12">
                    <h5><strong><?=$usuarioLogado->Nome?></strong></h5>
                  </div>
                  <div class="col-sm-12">
                    <div class="pedidos">
                      <h5 class="text-center"><a href="<?=$this->Url->build('/minha-conta/meus-pedidos?filtro=total')?>">Total de Pedidos: ( <?=$totalPedidos?> )</a></h5>
                      <p class="text-center"><a href="<?=$this->Url->build('/minha-conta/meus-pedidos?filtro=moderacao')?>">Em moderação: ( <?=$totalPedidosEmModeracao?> )</a></p>
                      <p class="text-center"><a href="<?=$this->Url->build('/minha-conta/meus-pedidos?filtro=aprovados')?>">Aprovados: ( <?=$totalPedidosAprovados?> )</a></p>
                      <p class="text-center"><a href="<?=$this->Url->build('/minha-conta/meus-pedidos?filtro=reprovados')?>">Reprovados: ( <?=$totalPedidosReprovados?> )</a></p>
                    </div>
                  </div>
                  <div class="col-sm-6 bgBox">
                    <div class="pedidos">
                      <h5 class="text-center">
                        <a href="<?=$this->Url->build('/usuarios/'.$usuarioLogado["Slug"].'/seguidores')?>"><strong>Seguidores</strong></a><br><br> ( <?=$seguidores?> )
                      </h5>
                    </div>
                  </div>
                  <div class="col-sm-6 bgBox">
                    <div class="pedidos">
                      <h5 class="text-center">
                      <a href="<?=$this->Url->build('/usuarios/'.$usuarioLogado["Slug"].'/seguindo')?>"><strong>Seguindo</strong></a><br><br> ( <?=$seguindo?> )</h5>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="pedidos">
                      <h5 class="text-center"><strong>Avaliação</strong></h5>
                    </div>                  </div>
                  <div class="col-sm-12">
                      <div class="estrelas text-center">
                        Média: <?=number_format(ceil($nota), 2)?>
                        ( <?=$totalAvaliacao?> )
                      </div>
                  </div>
                  <div class="config">
                    <a href="<?=$this->Url->build('/minhaconta/perfil/')?>">
                      <div class="col-sm-4">
                        <div class="pull-left">
                          <img src="<?=BASE_URL?>assets/images/perfil/img-roda.png" alt="Configurações">
                        </div>
                      </div>
                      <div class="col-sm-8">
                        <h5>Configurações<br> da conta</h5>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 meusPedidos <?=$abaPedidos ? "active" : ""?>">
        <a href="<?=$this->Url->build('/minha-conta/meus-pedidos')?>"><strong>MEUS PEDIDOS</strong></a>
      </div>

      <div class="col-md-3 meuFeed <?=!$abaPedidos ? "active" : ""?>">
        <a href="<?=$this->Url->build('/minhaconta/home')?>"><strong>MEU FEED</strong></a>
      </div>


    </div>
  </div>

  <div class="container">
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-7">
          <div class="seguindo">
            <div class="por">
              <?php if(!$abaPedidos){?>
              <!--<a href="#">Nome do Usuário</a>-->
              <h3>MEU FEED:</h3>
              <?php } ?>
            </div>

          </div>
          <?php
          if(!$abaPedidos){
            if($totalItens == 0){
              echo "<h4>Seu feed ainda não possui atualizações.</h4>";
            }
            foreach($feed as $elemento){
              $urlUsuario = BASE_URL . "usuarios/" . $elemento["SlugUsuario"];
              $urlPedido = BASE_URL . "pedidos/" . $elemento["SlugPedido"];
              ?>
              <div class="col-md-12 col-sm-12 col-xs-12 box">
                  <p>
                    <?php
                    switch($elemento["TipoFeed"]){

                      case 1:
                        echo "<a href='".$urlUsuario."'>" . $elemento["NomeUsuario"] . "</a> começou a seguir o pedido \"" . $elemento["NomePedido"] . "\"";
                        break;
                      case 2:
                        echo "<a href='".$urlUsuario."'>" . $elemento["NomeUsuario"] . "</a> inseriu um novo pedido \"" . $elemento["NomePedido"] . "\"";
                        break;
                      case 3:
                        echo "<a href='".$urlUsuario."'>" . $elemento["NomeUsuario"] . "</a> atualizou o pedido \"" . $elemento["NomePedido"] . "\"";
                          break;
                    }

                    ?>
                  </p>
                  <div class="em">Em: <?=date("d/m/Y H:i:s", strtotime($elemento["Criacao"]))?></div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="bntVerMais pull-right">
                      <a href="<?=$urlPedido?>">Ver<div class="seta seta-direita"></div></a>
                    </div>
                  </div>
              </div>
            <?php
            }
          }else{
            if($totalPedidos == 0){
              echo "<h4>Você ainda não possui nenhum pedido cadastrado.</h4>";
            } else {
              echo "<h4>".$tituloPedidos. $totalItens ."</h4>";
            }
            foreach($pedidos as $pedido){ ?>
        <!-- card pedido simples -->
        <div class="col-md-12 col-sm-12 col-xs-12 box">
          <h4>
            <?=$pedido["Titulo"]?>
          </h4>
          <p class="title">
            <?=nl2br($pedido["Descricao"])?> 
          </p>
          <div class="enviado">Pedido enviado para: <a href="<?=$this->Url->build('/agentes/' . $pedido["SlugAgente"])?>"><?=$pedido["NomeAgente"]?></a></div>
          <div class="por">Pedido disponibilizado por: <a href="<?=$this->Url->build('/usuarios/' . $pedido["SlugUsuario"])?>"><?=$pedido["NomeUsuario"]?></a></div>
          <div class="em">Pedido LAI realizado em: <?=date_format(new DateTime($pedido["DataEnvio"]), "d/m/Y")?></div>
          <div class="situacao">
            <div class="col-md-8 col-sm-8 col-xs-12">
               <?php
                      $arrSituacaoPedido = $this->FrontEnd->statusPedido($pedido["CodigoStatusPedido"],$pedido["CodigoStatusPedidoInterno"])
                    ?>
                    <div class="span2">
                      <?=$arrSituacaoPedido["imagem"];?>
                    </div>
                    <div style="float:left;margin-right:4px;">                
                      <?=$arrSituacaoPedido["texto"];?>
                    </div>
                    <div>
                      <img src="<?=BASE_URL?>assets/images/pedidos/pergunta.png" alt="" data-tooltip="tooltip-resposta-pedido" class="img-responsive tooltip-ajuda-action" style="cursor:pointer;">
                    </div>
                    <?= $this->element('Pedidos/tooltip');?> 
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="btnVerMais pull-right">
                <a href="<?=$this->Url->build('/minhaconta/pedidos/editar/' . $pedido["Slug"])?>">Ver <div class="seta seta-direita"></div></a>
              </div>
            </div>
          </div>
        </div>
        <!--//card pedido simples -->

            <?php
            }
?>
         <div class="text-center">
          <?php
            if($totalItens >= 5){
              $qtd = 5;
              ?>
              <ul class="pagination pagination-large">
                <?=$this->FrontEnd->Paging($pagina, $totalPedidosPaginacao, $qtd)?>
              </ul>
            <?php } else { ?>
            <div style="margin:20px;display:block;float:left;"></div>
            <?php } ?>
        </div>

        </div>
      </div>
<?php
          }
          ?>

  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
      $("ul.pagination > li").click(function(){
        pagina = $(this).data("val");
        $("#pagina").val(pagina);
        $("#frmMinhaContaPedidos").submit();
      });
  })
</script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/minhaconta/interacao.js" ></script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/tooltip-ajuda.js" ></script>