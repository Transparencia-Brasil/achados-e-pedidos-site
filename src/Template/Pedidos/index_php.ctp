<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="active"><a href="#">Pedidos</a></li>
    </ul>
  </div>
</div>

<div class="container pedidosOrgaos">
    <div class="row">
      <div class="col-md-12 busca">
        <form onsubmit="return false;">
            <h2>Pedidos</h2>
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <?=$this->Form->text('busca', ["id" => "busca", "class" => "form-control input-lg", "placeholder" => "Digite aqui a palavra do pedido que deseja encontrar", "value" => $textoBusca])?>
                    <span style="color:red;" id="erroBusca"></span>
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" id="btnFiltrarTextoBusca" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </div>
        </form>
      </div>
    </div>
   
    <div class="row">
      <div class="col-md-3 filtro">
        <h1>Filtrar por:</h1>
         <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <form action="<?=$this->Url->build("/pedidos/")?>" method="post" id="frmFiltro" data-parsley-validate data-parsley-errors-messages-disabled>
              <input type="hidden" value="" name="textoBusca" id="textoBusca" />
              <input type="hidden" value="<?=$pagina?>" name="pagina" id="pagina" />
              <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              <i class="more-less glyphicon glyphicon-chevron-down"></i>
                              Data:
                          </a>
                      </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                         <div class="col-md-6">
                            <div class="form-group">
                                <?=$this->Form->text("dataInicial", ["id" => "dataInicial", "class" => "form-control datePicker"])?>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <?=$this->Form->text("dataFinal", ["id" => "dataFinal", "class" => "form-control datePicker"])?>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" class="form-control" id="btnFiltrarData" value="selecionar">
                            </div>
                          </div>
                      </div>                    
                  </div>
                </div>

              <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              <i class="more-less glyphicon glyphicon-chevron-down"></i>
                              Situação do pedido
                          </a>
                      </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">
                          <input type="hidden" name="codigoTipoPedidoSituacao" id="CodigoTipoPedidoSituacao" value="" />
                         <div class="form-group bgCheckbox">                          
                            <input type="checkbox" id="EmTramitacao" name="CodigoTipoPedidoSituacaoChk" <?=$this->FrontEnd->elementoChecked("1", $this->request->data["codigoTipoPedidoSituacao"]);?> value="1" class="regular-checkbox">
                            <label for="EmTramitacao">Em tramitação</label>
                          </div>
                          <div class="form-group bgCheckbox">                          
                            <input type="checkbox" id="Finalizado" name="CodigoTipoPedidoSituacaoChk" <?=$this->FrontEnd->elementoChecked("2", $this->request->data["codigoTipoPedidoSituacao"]);?> value="2" class="regular-checkbox">
                            <label for="Finalizado">Finalizado</label>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" class="form-control" id="btnFiltrarSituacaoPedido" value="Filtrar">
                            </div>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                              <i class="more-less glyphicon glyphicon-chevron-down"></i>
                              Pedidos com recurso
                          </a>
                      </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
                          <div class="form-group">
                            <label class="radio-inline">
                              <input type="radio" name="recurso" value="1" <?=$this->FrontEnd->elementoChecked("1", $recurso);?> >Sim
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="recurso" <?=$this->FrontEnd->elementoChecked("2", $recurso);?> value="2">Não
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="recurso" <?=$this->FrontEnd->elementoChecked("3", $recurso);?> value="3">Todos
                            </label>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" class="form-control" value="Filtrar">
                            </div>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingFour">
                      <h4 class="panel-title">
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                              <i class="more-less glyphicon glyphicon-chevron-down"></i>
                              Respostas do órgão público:
                          </a>
                      </h4>
                  </div>
              </div>

              <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingFive">
                      <h4 class="panel-title">
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                              <i class="more-less glyphicon glyphicon-chevron-down"></i>
                              Órgãos públicos
                          </a>
                      </h4>
                  </div>
                  <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                      <div class="panel-body">
                           <input type="hidden" id="CodigoPoder" name="codigoPoder" value="" />
                           <input type="hidden" id="CodigoNivelFederativo" name="codigoNivelFederativo" value="" />
                           <h5>Poder:</h5>
                           <div class="form-group bgCheckbox">                          
                              <input type="checkbox" id="CodigoPoderLegislativo" <?=$this->FrontEnd->elementoChecked("1", $this->request->data["codigoPoder"]);?> name="CodigoPoderChk" value="1"  class="regular-checkbox">
                              <label for="CodigoPoderLegislativo">Legislativo e Tribunais de Contas</label>
                            </div>
                            <div class="form-group bgCheckbox">                          
                              <input type="checkbox" id="CodigoPoderExecutivo" <?=$this->FrontEnd->elementoChecked("2", $this->request->data["codigoPoder"]);?> name="CodigoPoderChk" value="2" class="regular-checkbox">
                              <label for="CodigoPoderExecutivo">Executivo</label>
                            </div>
                            <div class="form-group bgCheckbox">                          
                              <input type="checkbox" id="CodigoPoderJudiciario" <?=$this->FrontEnd->elementoChecked("3", $this->request->data["codigoPoder"]);?> name="CodigoPoderChk" value="3" class="regular-checkbox">
                              <label for="CodigoPoderJudiciario">Judiciário</label>
                            </div>
                            <div class="form-group bgCheckbox">                          
                              <input type="checkbox" id="CodigoPoderJudiciario" <?=$this->FrontEnd->elementoChecked("3", $this->request->data["codigoPoder"]);?> name="CodigoPoderChk" value="3" class="regular-checkbox">
                              <label for="CodigoPoderJudiciario">Ministério Público</label>
                            </div>
                            <h5>Nível:</h5>
                            <div class="form-group bgCheckbox">                          
                              <input type="checkbox" id="CodigoPoderFederal" <?=$this->FrontEnd->elementoChecked("1", $this->request->data["codigoNivelFederativo"]);?> name="CodigoNivelFederativoChk" value="1" class="regular-checkbox">
                              <label for="CodigoPoderFederal">Federal</label>
                            </div>
                            <div class="form-group bgCheckbox">                          
                              <input type="checkbox" id="CodigoPoderEstadual" <?=$this->FrontEnd->elementoChecked("2", $this->request->data["codigoNivelFederativo"]);?> name="CodigoNivelFederativoChk" value="2" class="regular-checkbox">
                              <label for="CodigoPoderEstadual">Estadual</label>
                            </div>
                            <div class="form-group bgCheckbox">                          
                              <input type="checkbox" id="CodigoPoderMunicipal" <?=$this->FrontEnd->elementoChecked("3", $this->request->data["codigoNivelFederativo"]);?> name="CodigoNivelFederativoChk" value="3" class="regular-checkbox">
                              <label for="CodigoPoderMunicipal">Municipal</label>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                  <input type="submit" class="form-control" value="Filtrar" id="btnFiltrarOrgaoPublico">
                              </div>
                            </div>
                      </div>
                  </div>
              </div>
              
          </form>
          <div class="col-md-12">
            <div class="form-group">
                <input type="reset" onclick="window.location.href=window.location.href;" class="form-control" value="Limpar Filtros">
            </div>
          </div>
        </div><!-- panel-group -->
      </div>
      <div class="col-md-9">
        <h1>
        <?php 
          if($total == 1){
            echo $total . " Pedido cadastrado";
          }else{
            echo $total . " Pedidos encontrados";
          }?> 
          </h1>
          
        <?php
        if($total == 0)
        {
            echo  '<div class="resultadoBusca">
                <strong>Não encontramos nenhum resultado para o filtro utilizado.</strong>
            </div>';
        }
        foreach($pedidos as $pedido){ 

          $nomeUsuario = $pedido["Anonimo"] == 1 ? "Anônimo" : $pedido["NomeUsuario"];
          $slugUsuario = $pedido["Anonimo"] == 1 ? "javascript:void(0);" : "/usuarios/" . $pedido["SlugUsuario"];
          $descricao = strlen($pedido["Descricao"]) > 500 ? substr($pedido["Descricao"], 0, 500) . "..." : $pedido["Descricao"];
          ?>
            <div class="col-md-12 col-sm-12 col-xs-12 box">
              <p><strong><?=$pedido["Titulo"]?></strong></p>
              <p><?=$descricao?></p>
              <div class="enviado">Pedido enviado para: <a href="<?=$this->Url->build('/agentes/' . $pedido["SlugAgente"])?>"><?=$pedido["NomeAgente"]?></a></div>
              <div class="por">Pedido disponibilizado por: <a href="<?=$this->Url->build($slugUsuario)?>"><?=$nomeUsuario?></a></div>
              <div class="em">Pedido LAI realizado em: <?=date_format(new DateTime($pedido["DataEnvio"]), "d/m/Y")?></div>
              <div class="situacao">
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <?=$this->FrontEnd->situacaoPedido($pedido["CodigoTipoPedidoSituacao"])?>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <?=$this->FrontEnd->statusPedido($pedido["CodigoStatusPedido"],$pedido["CodigoStatusPedidoInterno"])?>

                  <ul>
                    <img src="<?=BASE_URL?>assets/images/pedidos/pergunta.png" alt="" data-tooltip="tooltip-resposta-pedido" class="img-responsive tooltip-ajuda-action" style="cursor:pointer;">
                  </ul>
                  <?= $this->element('Pedidos/tooltip');?>    
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <div class="btnVerMais pull-right">
                    <a href="<?=$this->Url->build('/pedidos/' . $pedido["Slug"])?>">Ver <div class="seta seta-direita"></div></a>
                  </div>
                </div>
              </div>
              
            </div>
        <?php 
        }
        ?>
        
         <div class="text-center">
          <?php
          if($total > 0){ ?>
            <ul class="pagination pagination-large">
              <?=$this->FrontEnd->Paging($pagina, $total, 10)?>
            </ul>
          <?php } ?>
        </div>
      </div>
    </div>
 
</div>

<script type="text/javascript" src="<?=BASE_URL?>assets/js/pedidos.js"></script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/tooltip-ajuda.js" ></script>