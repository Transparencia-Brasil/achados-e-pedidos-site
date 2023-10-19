

<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="active"><a href="#">Busca</a></li>
    </ul>
  </div>
</div>

<div class="busca">

  <!--Pedidos-->
  <div class="container">
      <section class="buscaForm">
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-4">
             <form role="search" action="<?=BASE_URL.'busca/'.$tipo?>" method="get">
              <div id="custom-search-input">
                  <div class="input-group col-md-12">
                      <input type="text" class="form-control input-lg" value="<?=$termo?>" name="termo" maxlength="50" placeholder="Digite aqui sua busca">
                      <span class="input-group-btn">
                          <button class="btn btn-info btn-lg" type="submit">
                              <i class="glyphicon glyphicon-search"></i>
                          </button>
                      </span>
                  </div>
              </div>
            </form>
          </div>
          <div class="col-md-4"></div>
        </div>
          <div class="row bnts show">
            <div class="col-md-1"></div>
            <div class="col-md-2">
              <div class="btnPadrao buscaFiltroAcao <?=$tipo == "pedidos" ? "selected" : ""?>" repo="pedidos">
                <a href="<?=BASE_URL?>busca/pedidos/?termo=<?=$termo?>">Pedidos</a>
              </div>
            </div>
             <div class="col-md-2">
              <div class="btnPadrao buscaFiltroAcao <?=$tipo == "agentes" ? "selected" : ""?>" repo="orgaospublicos">
                <a href="<?=BASE_URL?>busca/agentes/?termo=<?=$termo?>">Órgãos Públicos</a>
              </div>
            </div>
             <div class="col-md-2">
              <div class="btnPadrao buscaFiltroAcao <?=$tipo == "usuarios" ? "selected" : ""?>" repo="usuarios">
                <a href="<?=BASE_URL?>busca/usuarios/?termo=<?=$termo?>">Usuários</a>
              </div>
            </div>
            <div class="col-md-4"></div>
          </div>
      </section>
  </div>

  <?php
  if($total > 0){
      if($tipo == "pedidos"){
      ?>
      <!--Pedidos-->
      <div class="container-fluid bgColor" session="pedidos">
        <div class="container pedidos pedidosOrgaos">
          <section>
            <h3>Pedidos:</h3>
            <h5><a href="/pedidos/busca-avancada">Busca avançada</a></h5>
            <h4>Resultado para: <?=$termo?></h4>
            <h5>Foram encontrados 150 pedidos - Mostrando 50 de 100.</h5>
            <div class="row">
              <?php
              foreach($resultado as $pedido){
                $nomeUsuario = $pedido["Anonimo"] == 1 ? "Anônimo" : $pedido["NomeUsuario"];
                $slugUsuario = $pedido["Anonimo"] == 1 ? "javascript:void(0);" : "/usuarios/" . $pedido["SlugUsuario"];
              ?>
                <div class="col-md-12 col-sm-12 col-xs-12 box">
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <p class="title">
                      <?=$pedido["Titulo"]?>
                    </p>
                    <div class="enviado">Pedido enviado para: <a href="<?=$this->Url->build('/agentes/' . $pedido["SlugAgente"])?>"><?=$pedido["NomeAgente"]?></a></div>
                    <div class="por">Pedido disponibilizado por: <a href="<?=$this->Url->build($slugUsuario)?>"><?=$nomeUsuario?></a></div>
                    <div class="em">Em: <?=date_format(new DateTime($pedido["DataEnvio"]), "d/m/Y")?></div>
                    <div class="situacao">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=$this->FrontEnd->situacaoPedido($pedido["CodigoTipoPedidoSituacao"])?>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=$this->FrontEnd->statusPedido($pedido["CodigoStatusPedido"],$pedido["CodigoStatusPedidoInterno"])?>
                        <img src="<?=BASE_URL?>assets/images/pedidos/pergunta.png" alt="" data-tooltip="tooltip-resposta-pedido" class="img-responsive tooltip-ajuda-action" style="cursor:pointer;">
                        <?= $this->element('Pedidos/tooltip');?>  
                      </div>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12 highlight-box">
                    <p class="highlight-session bgcolor5">Resposta do recurso - 1º Instância</p>
                    <p class="highlight-text">
                      <span class="highlight">Lorem ispum</span> dolor sit amet lorem isoum dolor sit ispum dolor sit lorem ispum dolor sit amet lorem isoum dolor sit ispum dolor sit amet lorem isoum dolor sit amet lorem isoum dolor sit ispum dolor sit amet orem isoum dolor sit ispum dolor sit amet. Lorem ispum dolor sit amet lorem isoum dolor sit ispum dolor sit
                    </p>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="bntVerMais pull-right">
                      <a href="<?=$this->Url->build('/pedidos/' . $pedido["Slug"])?>">Ver <div class="seta seta-direita"></div></a>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
          </div>
          </section>
        </div>
      </div>
      <?php
      }
      else if($tipo == "agentes"){
      ?>
      <!--Órgãos Públicos:-->
      <div class="container-fluid bgColor show">
        <div class="container agentes">
          <section>
            <h3>Órgãos Públicos:</h3>
            <h4>Resultado para: <?=$termo?></h4>
            <div class="row">
                <?php
                foreach($resultado as $agente)
                {
                  $descricao = strlen($agente["Descricao"]) > 100 ? substr($agente["Descricao"],0,100) . '...' : $agente["Descricao"];
                ?>
                  <div class="col-md-3 cartao">
                    <h4>
                      <strong><?=$agente["Nome"]?></strong>
                    </h4>
                    <p>
                      <?=$descricao?>
                    </p>
                    <div class="btnVerMais pull-right">
                      <a href="<?=$this->Url->build('/agentes/' . $agente["Slug"])?>">Ver
                      <div class="seta seta-direita"></div></a>
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>
          </section>
        </div>
      </div>
      <?php
      }
      else if($tipo == "usuarios"){
      ?>
      <!--Usuarios-->
      <div class="container-fluid bgColor show">
        <div class="container">
         <section class="usuarios perfil">
          <div class="row">
            <h3>Usuários</h3>
            <h4>Resultado para: <?=$termo?></h4>
            <?php
            foreach($resultado as $usuario){
            ?>
            <div class="col-md-3 sidebarPerfil card-bgbranco">
              <div class="col-md-12">
                <div class="panel panel-default">
                   <div class="panel-body">
                    <div class="box-info">
                      <div class="box-body">
                        <div class="col-sm-12">
                          <h5><strong><a href="<?=$this->Url->build('/usuarios/'.$usuario["Slug"])?>"><?=$usuario["Nome"]?></a></strong></h5>
                        </div>
                        <div class="col-sm-12 col-xs-12 bgBox">
                          <div class="pedidos">
                            <h5 class="text-center"><strong>Pedidos Inseridos:</strong><br/><br/> ( <?=$usuario["TotalPedidos"]?> )</h5>
                          </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 bgBox">
                          <div class="pedidos">
                            <h5 class="text-center"><strong>Seguidores</strong><br><br> ( <?=$usuario["TotalSeguidores"]?> )</h5>
                          </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 bgBox margin-bottom">
                          <div class="pedidos">
                            <h5 class="text-center"><strong>Seguindo</strong><br><br> ( <?=$usuario["TotalSeguindo"]?> )</h5>
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
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            }
            ?>
            </div>
          </div>
         </section>
        </div>
       </div>
       <?php
        }
   }else if(strlen($termo) > 0){
      echo '<div class="container-fluid bgColor"><div class="container"><h4>Nada encontrado para o termo digitado.</h4></div></div>';
   }
   ?>
   <div class="row">
      <div class="text-center">
        <ul class="pagination pagination-large">
          <?=$this->FrontEnd->paging($pagina, $total, $qtd)?>
      </ul>
      </div>
    </div>

</div>

<script>
    $(document).ready(function(){
      $(".pagination > li").click(function(){
          pagina = $(this).data("val");
          window.location.href= '<?=BASE_URL?>busca/<?=$tipo?>?termo=<?=$termo?>&pagina=' + pagina;
      });
    });
</script>

<script type="text/javascript" src="<?=BASE_URL?>assets/js/tooltip-ajuda.js" ></script>
