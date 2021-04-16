<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="active"><a href="#">Orgãos Público</a></li>
    </ul>
  </div>
</div>

<div class="container pedidosOrgaos">
    <div class="row">
      <div class="col-md-12 busca">
        <form onsubmit="return false;">
          <h2>Órgãos Públicos</h2>
          <div id="custom-search-input">
              <div class="input-group col-md-12">
                  <?=$this->Form->text('busca', ["id" => "busca", "class" => "form-control input-lg", "placeholder" => "Digite aqui a palavra do pedido que deseja encontrar.", "value" => $textoBusca])?>
                  <span style="color:red;"></span>
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
            <form action="<?=$this->Url->build("/agentes/")?>" method="post" id="frmFiltro" data-parsley-validate data-parsley-errors-messages-disabled>
              <input type="hidden" value="" name="textoBusca" id="textoBusca" />
              <input type="hidden" value="<?=$pagina?>" name="pagina" id="pagina" />
              <input type="hidden" id="CodigoPoder" name="codigoPoder" value="" />
              <input type="hidden" id="CodigoNivelFederativo" name="codigoNivelFederativo" value="" />
              <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              <i class="more-less glyphicon glyphicon-chevron-down"></i>
                              Nível:
                          </a>
                      </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
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
                              <input type="submit" class="form-control" value="Filtrar" id="btnFiltrarNivelFederativo">
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
                                Tipo:
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                              <div class="form-group bgCheckbox">
                                <input type="checkbox" id="checkbox-1-4" class="regular-checkbox">
                                <label for="checkbox-1-4">Administração direta</label>
                              </div>
                              <div class="form-group bgCheckbox">
                                <input type="checkbox" id="checkbox-1-5" class="regular-checkbox">
                                <label for="checkbox-1-5">Administração indireta</label>
                              </div>
                         </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <i class="more-less glyphicon glyphicon-chevron-down"></i>
                                Poder:
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
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
                            <div class="col-md-12">
                              <div class="form-group">
                                  <input type="submit" class="form-control" value="Filtrar" id="btnFiltrarPoder">
                              </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!--<div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFour">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <i class="more-less glyphicon glyphicon-chevron-down"></i>
                            Órgão Especiais:
                        </a>
                    </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                    <div class="panel-body">
                        <form action="" method="post" data-parsley-validate data-parsley-errors-messages-disabled>
                         <div class="form-group bgCheckbox">
                            <input type="checkbox" id="checkbox-1-10" class="regular-checkbox">
                            <label for="checkbox-1-10">Ministério público</label>
                          </div>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="checkbox-1-11" class="regular-checkbox">
                            <label for="checkbox-1-11">Tribunal de contas</label>
                          </div>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="checkbox-1-12" class="regular-checkbox">
                            <label for="checkbox-1-12">Fundação pública</label>
                          </div>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="checkbox-1-13" class="regular-checkbox">
                            <label for="checkbox-1-13">Empresa pública</label>
                          </div>
                        </form>
                    </div>
                </div>
            </div>-->

            <!--<div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFive">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            <i class="more-less glyphicon glyphicon-chevron-down"></i>
                            Outros:
                        </a>
                    </h4>
                </div>
                <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                    <div class="panel-body">
                      <form action="" method="post" data-parsley-validate data-parsley-errors-messages-disabled>

                         <div class="form-group bgCheckbox">
                            <input type="checkbox" id="checkbox-1-14 class="regular-checkbox">
                            <label for="checkbox-1-14">Economia mista</label>
                          </div>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="checkbox-1-15" class="regular-checkbox">
                            <label for="checkbox-1-15">Economia antiquaria</label>
                          </div>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="checkbox-1-16" class="regular-checkbox">
                            <label for="checkbox-1-16">Outros tipo de órgãos</label>
                          </div>

                        </form>
                    </div>
                </div>
            </div>-->

            </form>
        </div><!-- panel-group -->
      </div>
      <div class="col-md-9 agentes">
        <h1><?php
          if($total == 1){
            echo $total . " Órgão Público cadastrado";
          }else{
            echo $total . " Órgãos Públicos encontrados";
          }?> </h1>

          <div class="row">
            <?php foreach($agentes as $agente){ ?>
            <div class="col-md-4 cartao">
              <h4>
                <strong><?=$agente["Nome"]?></strong>
              </h4>
              <p>
                <?=html_entity_decode(nl2br($agente["Descricao"]),ENT_QUOTES,"UTF-8")?>
              </p>
              <div class="btnVerMais pull-right">
                <a href="<?=$this->Url->build('/agentes/' . $agente["Slug"])?>">Ver <div class="seta seta-direita"></div></a>
              </div>
            </div>
            <?php } ?>
          </div>


        </div>
         <div class="text-center">
          <?php
          if($total > 0){ ?>
            <ul class="pagination pagination-large">
              <li class="disabled"><span>«</span></li>
              <?=$this->FrontEnd->Paging($pagina, $total, 10)?>
              <li><a href="#" rel="next">»</a></li>
            </ul>
          <?php } ?>
        </div>
      </div>
    </div>

</div>

<script type="text/javascript" src="<?=BASE_URL?>assets/js/agentes.js"></script>
