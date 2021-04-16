
<div class="container-fluid breadcrumbLinha">
  <div class="container">
    <div class="row">
      <ul class="breadcrumb">
        <li class="completed"><a href="<?=BASE_URL?>">Home</a></li>
        <li class="completed"><a href="<?=BASE_URL?>minha-conta/meus-pedidos">Meus pedidos</a></li>
        <li class="active">Inserir Pedidos</li>
      </ul>
    </div>
  </div>
</div>
<section class="pedidos">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <h1>INSERIR PEDIDOS</h1>
        <img src="<?=BASE_URL?>assets/images/home/linhas.png" alt="Como Funciona">
      </div>
      <div class="process">
       <div class="process-row nav nav-tabs">
        <div class="process-step">
         <button type="button" class="btn btn-info btn-circle" data-toggle="tab" formstep="menu1">1</button>
         <p><small>Órgãos Públicos</small></p>
         <hr>
        </div>
        <div class="process-step">
         <button type="button" class="btn btn-default btn-circle" data-toggle="tab" formstep="menu2">2</button>
         <p><small>Pedido</small></p>
         <hr>
        </div>
        <div class="process-step">
         <button type="button" class="btn btn-default btn-circle" data-toggle="tab" formstep="menu3">3</button>
         <p><small>Respostas e Recursos</small></p>
        </div>

       </div>
      </div>
    </div>
  </div>
  <div class="container-fluid bg">
     <div class="container">
      <div class="row">
        <div class="tab-content">
         <div id="menu1" formstep="menu1" class="tab-pane fade">
          <div id="pesquisa">
            <img src="<?=BASE_URL?>assets/images/pedidos/img-step1.png" alt="Orgão Publico">
            <p><strong>Para qual órgão público você fez o pedido?</strong></p>
            <form role="search" action="" onsubmit="return false;" class="buscaForm">
              <div id="custom-search-input">
                  <div class="input-group col-md-12">
                      <input type="text" class="form-control input-lg" id="btnPesquisarAgente" placeholder="Buscar por órgão público">
                      <span class="input-group-btn">
                          <!--<button class="btn btn-info btn-lg buscarOrgao" type="button">
                              <i class="glyphicon glyphicon-search"></i>
                          </button>-->
                      </span>
                  </div>
                  <div class="clearfix"></div>
                  <ul class="list-unstyled list-inline pull-right" style="display:none">
                    <li><i class="fa fa-chevron-left"></i>início</li>
                    <li><button type="button" class="btn btn-info next-step" id="passo1">Next
                    <i class="fa fa-chevron-right"></i></button></li>
                  </ul>
              </div>
            </form>
          </div>
          <div class="resultadoBusca">
            <h5><strong id="nomeAgenteBusca"></strong></h5>
            <p id="descricaoAgenteBusca"></p>
            <div class="bntVerMais">
              <a href="javascript:void(0);" onclick="$('#passo1').click();">Inserir Pedido</a>
            </div>
          </div>
          <div class="resultadoBuscaNao" style="display:block">
            <p ><strong id="mensagemAgenteNaoEncontrado"></strong></p>
            <p>Clique <a href="javascript:void(0);" onclick="novoCadastroOrgao();">aqui</a> caso não tenha encontrado o órgão público.</p>
            <!--<div class="bntVerMais sim">
              <a href="javascript:void(0);" onclick="novoCadastroOrgao();">Sim</a>
            </div>
            <div class="bntVerMaisNao">
              <a href="javascript:void(0);" onclick="$('.resultadoBuscaNao').hide();">Não</a>
            </div>-->
          </div>
          <div class="cadastraNovo">
            <form action="" onsubmit="return false;" method="post">
              <img src="<?=BASE_URL?>assets/images/pedidos/img-step1.png" alt="Orgão Publico">
              <p><strong>Inserir novo Órgão Público</strong></p>
              <?=$this->Form->hidden('CodigoOrgaoPublico', ['id' => 'codigoOrgaoPublico', 'class' => '']) ?>
              <a href="javascript:;" data-toggle="popover" class="pergunta">
                <img src="<?=BASE_URL?>assets/images/pedidos/pergunta.png" alt="Pergunta">
              </a>
              <div id="popover-table" class="hide">
                <p>O órgão superior é a instância superior ao órgão que você fez o pedido. Se tiver duvida qual o órgão superior, coloque o órgão mais alto do nível que você está pedindo. Exemplo: se você fez um pedido de informação para Receita Federal o órgão superior é o Ministério da Fazenda. Se estiver em dúvida entre Ministério Fazenda e Planejamente pode colocar Presidência da República.</p>
            </div>
              <div class="col-md-12">
                <div class="form-group">
                    <?=$this->Form->text('OrgaoSuperior', ['id' => 'orgaoSuperior', 'class' => 'form-control', 'placeholder' => 'Insira Órgão Público Superior', 'required' => 'required']) ?>
                    <span class="resultadoBuscaSuperiorNao error"></span>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                    <?=$this->Form->text('NomeAgente', ['id' => 'nomeAgente', 'class' => 'form-control', 'placeholder' => 'Insira o nome do Órgão Público ao qual fez o pedido', 'required' => 'required']) ?>
                    <span id="nomeAgenteError" class="error"></span>
                </div>
              </div>
            </form>
            <div class="bntVerMais">
              <ul class="list-unstyled list-inline">
               <li><button type="button" class="btn-info" onclick="novoAgente()">Cadastrar órgão público</button></li>
              </ul>
            </div>
            <div class="bntVerMaisNao">
              <a href="javascript:void(0);" onclick="pesquisarAgente()">Voltar</a>
            </div>
          </div>

         </div>
         <div id="menu2" formstep="menu2" class="tab-pane fade">
          <img src="<?=BASE_URL?>assets/images/pedidos/dados-do-pedido.png" alt="Dados do Pedido">
          <h3>Dados do pedido</h3>
          <p class="t-text" id="nomeAgentePedido"><?=strlen($nomeAgente) > 0 ? "<strong>Pedido enviado para:</strong> " . $nomeAgente : ""?></p>
          <div class="t-info">
            <p><strong>Pedido:</strong></p>
            <p>Neste formulário, insira apenas a solicitação do pedido. Recursos, reclamações e respostas dos órgãos públicos podem ser inseridos na próxima etapa.</p>
          </div>
          <?php
          if($sucesso === false){
            echo '<div class="alert alert-danger fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <h3>Não foi possível salvar seu pedido. Por favor tente novamente mais tarde.</h3>
              </div>';
          }
          ?>
          <?=$this->Form->create($pedido, ['action' => 'novopedido', "id" => "frmPedido", "method" => "post"]) ?>
            <?=$this->Form->hidden('CodigoAgente', ['id' => 'codigoAgente', 'class' => '']) ?>
            <?=$this->ValidationText->exibirErro($erros, "CodigoAgente"); ?>
            <div class="col-xs-12 col-md-6 no-gutter-left">
              <?=$this->Form->text('DataEnvio', ['id' => 'dataEnvio', 'class' => 'form-control datePicker', 'placeholder' => 'insira a data do pedido']) ?>
              <?=$this->ValidationText->exibirErro($erros, "DataEnvio"); ?>
            </div>
            <div class="col-xs-12 col-md-6 no-gutter-right">
              <?=$this->Form->text('Protocolo', ['id' => 'protocolo', 'class' => 'form-control', 'placeholder' => 'insira o número do protocolo']) ?>
              <?=$this->ValidationText->exibirErro($erros, "Protocolo"); ?>
            </div>
            <div class="t-info">
              <div class="col-xs-12 col-md-12 no-gutter">
                <?=$this->ValidationText->exibirErro($erros, "Titulo"); ?>
                <?=$this->Form->text('Titulo', ['id' => 'titulo', 'class' => 'form-control', 'placeholder' => 'Digite o título do seu pedido']) ?>
              </div>
              <div class="col-xs-12 col-md-12 no-gutter">
                <?=$this->ValidationText->exibirErro($erros, "Descricao"); ?>
                <?=$this->Form->textarea('Descricao', ['id' => 'descricao', 'class' => 'form-control', 'placeholder' => 'Digite seu pedido', 'rows' => 10, 'cols' => 30]) ?>
              </div>
            </div>
            <div class="form-group">
              <p>Este pedido foi atendido?</p>
              <div class="radio-inline">
                <?= $this->Form->radio('CodigoStatusPedido', [['value'=>1, 'text'=>'Sim'],['value'=>3, 'text'=>'Parcialmente'],['value'=>2, 'text'=>'Não¹'],['value'=>4, 'text'=>'Não aplicável²']]);?>
                <?=$this->ValidationText->exibirErro($erros, "CodigoStatusPedido"); ?>
              </div>
                <p>
                <span class="obs">¹ - Informação negada ou sem resposta após 30 dias.</span><br />
                <span class="obs">² - Aguardando resposta - até 30 dias.</span>
                </p>
                <input type="hidden" name="CodigoTipoPedidoSituacao" value="3">
            </div>  
            <div class="buttons">
              <div class="bntVerMais" style="text-align:right;">
                <button type="submit" class="btn-info">Enviar</button>
              </div>
            </div>
            <?=$this->Form->end();?>
         </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="<?=BASE_URL?>assets/js/minhaconta/pedidos.js" type="text/javascript" ></script>
