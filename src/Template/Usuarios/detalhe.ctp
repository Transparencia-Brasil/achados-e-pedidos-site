
<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="active">Usuários</li>
    </ul>
  </div>
</div>
<form method="post" id="frmUsuario"><input type="hidden" id="pagina" name="pagina" value="<?=$pagina?>"/></form>
<div class="perfil naoLogado">
  <div class="container-fluid">
    <div class="container">
      <div class="col-md-3 sidebarPerfil">
        <div class="col-md-12">
          <div class="panel panel-default">
             <div class="panel-body">       
              <div class="box-info">
                <div class="box-body">
                  <div class="col-sm-12">
                    <h5><strong><?=$usuario["Nome"]?></strong></h5>       
                  </div>
                  <div class="col-sm-12">
                    <div class="pedidos">
                      <h5 class="text-center">Pedidos Inseridos: ( <?=$usuario["TotalPedidos"]?> )</h5> 
                    </div>   
                  </div>
                  <div class="col-sm-6 bgBox">
                    <div class="pedidos">
                      <h5 class="text-center"><a href="<?=$this->Url->build('/usuarios/'.$usuario["Slug"].'/seguidores')?>"><strong>Seguidores</strong></a><br><br> ( <?=$usuario["TotalSeguidores"]?> )</h5> 
                    </div>   
                  </div>
                  <div class="col-sm-6 bgBox">
                    <div class="pedidos">
                      <h5 class="text-center"><a href="<?=$this->Url->build('/usuarios/'.$usuario["Slug"].'/seguindo')?>"><strong>Seguindo</strong></a><br><br> ( <?=$usuario["TotalSeguindo"]?> )</h5> 
                    </div>   
                  </div>
                  <div class="col-sm-12">
                    <div class="pedidos">
                      <h5 class="text-center"><strong>Avaliação</strong></h5> 
                    </div>   
                  </div>
                  <div class="col-sm-12">
                      <div class="estrelas text-center">

                        <?php
                        if($this->FrontEnd->EhUsuarioLogado($usuario["Codigo"]))
                          echo "Media: " . $usuario["Avaliacao"];
                        else{
                          $this->FrontEnd->calcularAvaliacao($usuario["Avaliacao"]);
                        }
                        ?>

                        ( <?=$usuario["TotalAvaliacoes"]?> )
                        <span class="error"></span>
                      </div>
                  </div>
                    <?php
                    if(!$this->FrontEnd->EhUsuarioLogado($usuario["Codigo"])){
                    ?>
                    <div class="col-sm-12 raizInteracao">
                      <input type="hidden" value="<?=$usuario["Codigo"]?>" id="co" />
                      <input type="hidden" value="3" id="ct" />
                      <div class="btnVerMais btn-size-big"><a href="javascript:void(0);" id="btnToggleSeguir"><?=$this->FrontEnd->interacao($usuario["Codigo"], 3)?></a></div>
                      <span class="error" id="erro_seguir"></span>
                    </div>
                    <?php
                    }else{
                    ?>
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
                    <?php 
                    }
                    ?>
                </div>
              </div>
            </div> 
          </div>
        </div>  
      </div>

        <div class="col-md-3"></div>
        <div class="col-md-7">
          <div class="seguindo">
            <div class="por">
              <h3><strong>Pedidos:</strong></h3>
            </div>

          </div>
          <?php
          if($usuario["TotalPedidos"] == 0){
            echo "<h3>Este usuário ainda não possui pedidos cadastrados.</h3>";
          }
          foreach($pedidos as $pedido)
          {
            ?>
            <!-- card pedido simples -->
            <div class="col-md-12 col-sm-12 col-xs-12 box">
              <h4>
                <?=$pedido["Titulo"]?>
              </h4>
              <p class="title">
                <?=nl2br($pedido["Descricao"])?>
              </p>
              <div class="enviado">Pedido enviado para: <a href="<?=$this->Url->build('/agentes/' . $pedido["SlugAgente"])?>"><?=$pedido["NomeAgente"]?></a></div>
              <div class="porr">Pedido disponibilizado por: <a href="<?=$this->Url->build('/usuarios/' . $pedido["SlugUsuario"])?>"><?=$pedido["NomeUsuario"]?></a></div>
              <div class="em">Em: <?=$pedido["DataEnvio"]?></div>
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
                    <a href="<?=$this->Url->build('/pedidos/' . $pedido["Slug"])?>">Ver <div class="seta seta-direita"></div></a>
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
            if($usuario["TotalPedidos"] > 5){ 
              $qtd = 5;
              ?>
              <ul class="pagination pagination-large">
                <?=$this->FrontEnd->Paging($pagina, $usuario["TotalPedidos"], $qtd)?>
              </ul>
            <?php } else { ?>
            <div style="margin:20px;display:block;float:left;"></div>
            <?php } ?>
          </div>
        </div>
      </div>
   
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
      $("ul.pagination > li").click(function(){
        pagina = $(this).data("val");
        $("#pagina").val(pagina);
        $("#frmUsuario").submit();
      });
  })
</script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/minhaconta/interacao.js" ></script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/tooltip-ajuda.js" ></script>