
<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="completed">Orgãos Públicos</li>
      <li class="active"><?=$agente["Nome"]?></li>
    </ul>
  </div>
</div>
<form method="post" id="frmAgente"><input type="hidden" id="pagina" name="pagina" value="<?=$pagina?>"/></form>
<div class="container-fluid bgDetalhes">
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <h2><?=$agente["Nome"]?></h2>

        <p>
          Nível federativo: <?=$agente["NomeNivelFederativo"]?>
<?php
        if (!empty($agente["SiglaUF"])) {
?>
          <br><?=$agente["SiglaUF"]?>
<?php
        }
?>
<?php
        if (!empty($agente["NomeCidade"])) {
?>
          / <?=$agente["NomeCidade"]?>
<?php
        }
?>
        </p>

        <p>
          Nível federativo: <?=$agente["NomeNivelFederativo"]?>
<?php
        if (!empty($agente["SiglaUF"])) {
?>
          <br><?=$agente["SiglaUF"]?>
<?php
        }
?>
<?php
        if (!empty($agente["NomeCidade"])) {
?>
          / <?=$agente["NomeCidade"]?>
<?php
        }
?>
        </p>


        <div class="row">
          <?php
          if($agente["Link"] != null && strlen($agente["Link"]) > 0){
          ?>
          <div class="col-md-4">
            <p>
              Site: <a href="<?=$agente["Link"]?>" target="_blank"><?=$agente["Link"]?></a>
            </p>
          </div>
          <?php } ?>
          <div class="col-md-3">
            <div class="estrelas">
              <?=$this->FrontEnd->calcularAvaliacao($avaliacao)?>
              <span class="error"></span>
            </div>
           </div>

            <div class="col-md-3">
              <div class="numeros"><strong>( <?=$totalAvaliacao?> )</strong></div>
            </div>
          <div class="col-md-12 raizInteracao">
            <input type="hidden" value="<?=$agente["Codigo"]?>" id="co" />
            <input type="hidden" value="2" id="ct" />
            <div class="bntVer pull-left"><a href="javascript:void(0);" id="btnToggleSeguir" class="text-center"><?=$this->FrontEnd->interacao($agente["Codigo"], 2)?></a>
            </div>
            <span class="error" id="erro_seguir"></span>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="sidebar">
          <div>
           <img src="<?=BASE_URL?>assets/images/pedidos/img-pedidos.jpg" alt="Pedidos">
           <h5>Pedidos</h5><h3><?=$totalPedidos?></h3>
           </div>
           <div>
             <img src="<?=BASE_URL?>assets/images/pedidos/img-seguidores.jpg" alt="Seguidores">
             <h5>Seguidores</h5><h3><?=$totalSeguidores?></h3>
          </div>
         </div>
         <div class="compartilhe">
           <h4>Compartilhe nas redes sociais:</h4>
           <div class="redesS">
             <a href="http://www.facebook.com/share.php?u=<?=$this->Url->build('', 'true');?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="<?=BASE_URL?>assets/images/na-midia/icon-face.png" alt="Facebook"></a>
            <a href="https://plus.google.com/share?url={<?=$this->Url->build('', 'true');?>}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="<?=BASE_URL?>assets/images/na-midia/icon-gplus.png" alt="Google Plus"></a>
            <a href="http://www.twitter.com/share?url=<?=$this->Url->build('', 'true');?>" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="<?=BASE_URL?>assets/images/na-midia/icon-twiiter.png" alt="Twitter"></a>
           </div>
         </div>
         </div>
      </div>
    </div>
  </div>
</div>

<div class="container pedidosOrgaos">
    <div class="row">
      <div class="col-md-8">
        <h1>Pedidos para órgãos públicos:</h1>

        <?php
        if(count($pedidos) == 0)
          echo "<h4>Não há pedidos cadastrados para este órgão.</h4>";
        foreach($pedidos as $pedido){
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
          <div class="por">Pedido disponibilizado por: <a href="<?=$this->Url->build('/usuarios/' . $pedido["SlugUsuario"])?>"><?=$pedido["NomeUsuario"]?></a></div>
          <div class="em">Em: <?=date_format(new DateTime($pedido["DataEnvio"]), "d/m/Y")?></div>
          <div class="situacao">
            <div class="col-md-8 col-sm-8 col-xs-12">
               <?php
                      $arrSituacaoPedido = $this->FrontEnd->statusPedido($pedido["CodigoStatusPedido"],$pedido["CodigoStatusPedidoInterno"])
                    ?>
                    <div class="span2">
                      <?=$arrSituacaoPedido["imagem"];?>
                    </div>
                    <div  style="float:left;margin-right:4px;">                
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
            if($totalPedidos > 5){
              $qtd = 5;
              ?>
              <ul class="pagination pagination-large">
                <?=$this->FrontEnd->Paging($pagina, $totalPedidos, $qtd)?>
              </ul>
            <?php } else { ?>
            <div style="margin:20px;display:block;float:left;"></div>
            <?php } ?>
        </div>
      </div>
    </div>

</div>


<script type="text/javascript">
  $(document).ready(function(){
      $("ul.pagination > li").click(function(){
        pagina = $(this).data("val");
        $("#pagina").val(pagina);
        $("#frmAgente").submit();
      });
  })
</script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/minhaconta/interacao.js" ></script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/tooltip-ajuda.js" ></script>