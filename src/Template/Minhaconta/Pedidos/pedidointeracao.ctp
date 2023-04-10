<div class="container-fluid breadcrumbLinha">
  <div class="container">
    <div class="row">
      <ul class="breadcrumb">
        <li class="completed"><a href="<?=BASE_URL?>">Home</a></li>
        <li class="completed"><a href="<?=BASE_URL?>minhaconta/home/index/1">Meus pedidos</a></li>
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
         <button type="button" class="btn btn-default btn-circle" data-toggle="tab" formstep="menu1">1</button>
         <p><small>Órgãos Públicos</small></p>
         <hr>
        </div>
        <div class="process-step">
         <button type="button" class="btn btn-default btn-circle" data-toggle="tab" formstep="menu2">2</button>
         <p><small>Pedido</small></p>
         <hr>
        </div>
        <div class="process-step">
         <button type="button" class="btn btn-circle btn-info" data-toggle="tab" formstep="menu3">3</button>
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
         <?php
         if($sucesso == false || $sucesso == null){
         ?>
         <div id="menu3" formstep="menu2" class="tab-pane fade active in">
            <img src="<?=BASE_URL?>assets/images/pedidos/dados-do-pedido.png" alt="Dados do Pedido">

            <h3>Dados do pedido</h3>
            
            <?php 
            if($primeiraVez == true){
            ?>
            <div class="alert alert-success fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
              <div style="text-align:center;">
              <h2 style="margin-top:35px;">Pedido criado com sucesso!</h2>
              <h2>Próximo passo</h2>
              <h4>Finalize o seu pedido ou insira uma resposta/recurso abaixo.</h4>
              <div class="bntVerMais" style="text-align:center;margin-top:20px;"><a href="<?=$this->Url->build('/minhaconta/pedidos/sucesso/' . $slug)?>"><button type="button" class="btn-info">Finalizar pedido</button></a></div>
            </div>
            </div>
            <?php
            }
            ?>
            <?=$this->ValidationText->exibirErro($erros, "Pedido"); ?>
            <?=$this->Form->create($pedidoInteracao, ['action' => 'pedidointeracao/' . $slug . "?processed=1", "id" => "frmPedidoInteracao",'enctype' => 'multipart/form-data']) ?>
              <?=$this->Form->hidden("CodigoPedido",["value" => $pedidoInteracao->CodigoPedido]); ?>
              <p><strong>Qual é o tipo da resposta ou recurso ?</strong></p>
              
              <div class="col-xs-12 col-md-6 no-gutter-left">
                  <?=$this->Form->select("CodigoTipoPedidoResposta", $respostas, ['class' => 'form-control', 'empty' => 'Selecione', 'required' => 'required']) ?>
                  <?=$this->ValidationText->exibirErro($erros, "CodigoTipoPedidoResposta"); ?>
              </div>
            
              <div class="col-xs-12 col-md-6 no-gutter-right">
                <?=$this->Form->text('DataResposta', ['id' => 'dataResposta', 'dataPedidoEnvio'=> $pedidoDataEnvio, 'class' => 'form-control datePicker', 'placeholder' => 'insira a data de resposta/recurso']) ?>
                <?=$this->ValidationText->exibirErro($erros, "DataResposta"); ?>
              </div>
            
              <div class="clear37"></div>
                <div id="alerta-atraso" class="alert alert-info hide">
                  <p><strong>Parece que seu pedido demorou mais do que o prazo de 20 dias para ser respondido. O orgão público pediu extensão do prazo?</strong></p>
                  <div class="btn-radio-inline">
                  <?= $this->Form->radio('CodigoStatusPedido', [['value'=>1, 'text'=>'Sim', 'checked'=>'checked'],['value'=>2, 'text'=>'Não']]);?>
                  </div>
                </div>
              <div class="t-info">
                <div class="col-xs-12 col-md-12 no-gutter">
                  <?=$this->ValidationText->exibirErro($erros, "Descricao"); ?>
                  <?=$this->Form->textarea('Descricao', ['id' => 'descricao', 'class' => 'form-control', 'rows' => 10, 'cols' => 30, 'placeholder' => 'Escreva a resposta']) ?>
                </div>
                <div class="col-xs-12 col-md-12 no-gutter">
                  <?= $this->element('fileuploader', array('arquivos' => $arquivos,'errosArquivo' => $errosArquivo)) ?>
                </div>
            </div>
            <div style="clear:both"></div>
            <div style="height:50px;text-align:center;">
              <div class="bntVerMaisNao">
                <button type="submit" class="btn-info" style="float:none;">Enviar</button>
              </div>
            </div>

            <?=$this->Form->end();?>
          </div>

         <?php
        } 
         elseif($sucesso == true){
         ?>
         <div id="menu6" formstep="menu5" class="tab-pane fade active in">
           <img src="<?=BASE_URL?>assets/images/geral/success.png">
           <p><strong>Obrigado!</strong></p>
           <p><strong>Seu pedido foi inserido com sucesso e pode ser moderado antes de sua publicação. Caso queira inserir mais respostas, clique no botão abaixo.</strong></p>
           <div class="buttons">
              <div class="bntVerMaisNao">
                <button type="button" class="btn-info" onclick="window.location.href='<?=$this->Url->build('/minhaconta/pedidos/editar/' . $slug)?>'" >Visualizar pedido</button>
              </div>
            </div>
         </div>
        </div>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" tabindex="-1" role="dialog" id="stepModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <p class="text"><strong>Você não salvou seus registros!</strong></p>
        </div>
        <div class="row">
          <p>Você possui registros que não estão salvos nlo sistema, caso finalize este pedido os dados não adicionado serão perdido.</p>
        </div>
        <div class="row">
          <div class="buttons">
            <div class="bntVerMaisNao">
              <button type="button" class="btn-info next-step">Voltar</button>
            </div>
            <a href="#" class="link">Finalizar assim mesmo</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
      $("#dataResposta").mask('99/99/9999');
      $("#dataResposta").change(function(){
          verificaExtensaoPrazo($(this).val());
      });

      function verificaExtensaoPrazo(dataResposta) {
          if (dataResposta.length > 0) {
            var dataResposta = dataResposta.split("/").reverse().join("-");
            var dataPedidoEnvio = $("#dataResposta").attr("datapedidoenvio");

            console.log (dataResposta + " - " + dataPedidoEnvio)

            diff  = new Date(Date.parse(dataResposta) - Date.parse(dataPedidoEnvio));
            console.log(diff);
            days  = diff/1000/60/60/24;
            console.log(days);
            if (days >= 20) {
              $("#alerta-atraso").removeClass("hide");
              $("#alerta-atraso").addClass("show");
            } else {
              $("#alerta-atraso").removeClass("show");
              $("#alerta-atraso").addClass("hide");
            }
          }
      }

  })
</script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/minhaconta/arquivos.js"></script>
