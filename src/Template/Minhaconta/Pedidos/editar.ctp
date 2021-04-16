
<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed"><a href="<?=BASE_URL?>minha-conta">Home</a></li>
      <li class="completed"><a href="<?=BASE_URL?>minhaconta/home/index/1">Meus pedidos</a></li>
      <li class="active">Detalhes Pedido</a></li>
    </ul>
  </div>
</div>

<div class="detalhes-pedido">
  <div class="container edit-pedido">
    <div class="col-xs-12 col-md-8 no-gutter">
      <div class="column-detalhe-1">
        <div class="col-md-2 no-gutter">
          <div class="column-detalhe-2">
            <img src="<?=BASE_URL?>assets/images/detalhes/detalhe1.png" alt="" class="img-responsive">
            <a href="javascript:void(0);" data-toggle="modal"  data-target="#modalAtualizacaoPedido" class="btnEditPedido btnEditOne" id="btnEditarPedido">
              <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar
            </a>
          </div>
        </div>
        <div class="col-md-10 no-gutter">
          <div class="column-detalhe-3">
            <p class="description"><?=$pedido["Titulo"]?></p>
            <p class="description"><?=nl2br($pedido["Descricao"])?></p>
            <p><span>Pedido enviado para: </span> <a href="<?=$this->Url->build('/agentes/' . $pedido["SlugAgente"])?>"><?=$pedido["NomeAgente"]?></a></p>
            <ul class="list">
              <li class="item">Pedido disponibilizado por: <span>Mim</span></li>
              <li class="item">Em: <?=$pedido["DataEnvio"]?></li>
            </ul>
            <div class="col-md-6">
              <div class="resposta-pedido">
                <div class="span2">
                <?php
                $arrStatusPedido = $this->FrontEnd->statusPedido($pedido["CodigoStatusPedido"],$pedido["CodigoStatusPedidoInterno"]);
                echo $arrStatusPedido["imagem"];
                ?>
                </div>
                <ul>
                  <li>Resposta:</li>
                  <li><?=$arrStatusPedido["texto"];?></li>
                </ul>
              </div>
            </div>


          </div>
        </div>
      </div>
      <?php
      foreach($interacoes as $interacao){
        $imagem = $interacao->CodigoTipoPedidoResposta == 6 ? "detalhe3" : "detalhe2"; // tipo de resposta do órgão
      ?>
      <div class="col-md-offset-2 n-column-detalhe">
        <div class="col-md-2 no-gutter">
          <div class="column-detalhe-2">
            <img src="<?=BASE_URL?>assets/images/detalhes/<?=$imagem?>.png" alt="" class="img-responsive">
            <a href="?t=2&ci=<?=$interacao->Codigo?>" class="btnEditPedido btnEditTwo"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar</a>
          </div>
        </div>
          <div class="col-md-10 no-gutter">
            <div class="column-detalhe">
              <div class="situacao">
                <p><?=$interacao->TipoResposta->Nome?></p>
              </div>
              <ul class="list">
                <li class="item">Por: <span><?=$pedido["NomeUsuario"]?></span></li>
                  <li class="item">Em: <?=date('d/m/Y', strtotime($interacao->DataResposta))?></li>
              </ul>
              <p class="description"><?=nl2br($interacao->Descricao)?></p>
              <div class="doc">
                  <?php
                  $contador = 1;
                  foreach($interacao->Arquivos as $arquivo){
                  ?>
                  <?php
                    $path_parts = pathinfo($arquivo->Arquivo);
                  ?>
                    <a href="<?=$this->Url->build('/uploads/pedidos/' . $arquivo->Arquivo)?>" target="_blank"><img src="/assets/images/detalhes/<?=strtolower($path_parts['extension']);?>.png" alt="ico" class="icon-img" ></i>
                    Arquivo <?=$contador?>.<?=$path_parts['extension'];?>
                    </a>
                  <?php
                  $contador++;
                  }
                  ?>
                </div>
            </div>
          </div>
      </div>
      <?php
      }
      ?>
    </div>
    <div class="col-xs-12 col-md-4">
       <div class="column-seguidores">
         <img src="<?=BASE_URL?>assets/images/detalhes/s-icon-user.png" alt="" class="img-responsive">
         <div class="count-seguidores"><?=$totalSeguidores?> seguidores</div>
       </div>
       <div class="column-avaliacao">
         <h3>Avaliação</h3>
         <button class="btnMedia"><strong>Média geral: <?=number_format($nota, 1)?></strong></button>
         <div class="clearfix"></div>
         <span class="count">Total de avaliações (<?=$totalAvaliacoes?>)</span>
       </div>
    </div>
    <div class="col-md-offset-1 col-md-7">
       <div class="column-detalhe-footer">
        <div class="col-xs-12 col-md-6">
          <a href="?t=2&novo=true" class="btnDownloadFile">Cadastrar nova resposta</a>
        </div>
      </div>
    </div>
  </div>
</div>

<a href="" id="btnEditarInteracao" data-toggle="modal" data-target="#modalAtualizacaoPedidoInteracao" style="display:none"></a>
<div class="modal fade modalAtualizacaoPedido" data-backdrop="static" tabindex="-1" role="dialog" id="modalAtualizacaoPedido">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="atualizacao-pedido">
            <?=$this->Form->create($pedidoEdicao, ["id" => "update-form", "method" => "post"]) ?>
              <input type="hidden" value='1' name="t" >
              <?=$this->ValidationText->exibirErro($errosPedido, "CodigoAgente"); ?>
              <?php
                if($sucessoAtualizadoPedido != null){
                  if($sucessoAtualizadoPedido){
?>
                    <div style="margin:20px auto;text-align:center;">
                      <img src="<?=BASE_URL?>assets/images/geral/success.png"><br>
                      <strong>Pedido atualizado com sucesso!</strong>
                    </div>

                      <script type="text/javascript">
                      $(function(){
                          $('#modalAtualizacaoPedido').on('show.bs.modal', function(){
                              var myModal = $(this);
                              clearTimeout(myModal.data('hideInterval'));
                              myModal.data('hideInterval', setTimeout(function(){
                                  //myModal.modal('hide');
                                  window.location.href = window.location.href;
                              }, 1000));
                          });
                      });
                      </script>
<?php
                  }else{
                    echo '<p class="error"><strong>Erro ao atualizar pedido. Tente novamente mais tarde.</strong><p>';
                  }
                } else {
                ?>
              <div class="clear38"></div>
              <div class="col-xs-12 col-md-6 no-gutter-left">
                <?=$this->Form->text('DataEnvio', ['id' => 'dataEnvio', 'class' => 'form-control datePicker', 'placeholder' => 'insira a data do pedido']) ?>
                <?=$this->ValidationText->exibirErro($errosPedido, "DataEnvio"); ?>
              </div>
              <div class="col-xs-12 col-md-6 no-gutter-right">
                <?=$this->Form->text('Protocolo', ['id' => 'protocolo', 'class' => 'form-control', 'placeholder' => 'insira o número do protocolo']) ?>
                <?=$this->ValidationText->exibirErro($errosPedido, "Protocolo"); ?>
              </div>
              <div class="clear38"></div>
              <div class="form-group">
                <p style="padding-left: 2px;">Este pedido foi atendido?</p>
                <div class="radio-inline">
                  <?= $this->Form->radio('CodigoStatusPedido', [['value'=>1, 'text'=>'Sim'],['value'=>3, 'text'=>'Parcialmente'],['value'=>2, 'text'=>'Não']]);?>
                </div>
                  <input type="hidden" name="CodigoTipoPedidoSituacao" value="3">
              </div>  
              <div class="clear38"></div>
              <div class="col-xs-12 col-md-12 no-gutter">
                <?=$this->ValidationText->exibirErro($errosPedido, "Titulo"); ?>
                <?=$this->Form->text('Titulo', ['id' => 'titulo', 'value' => $pedido["Titulo"], 'class' => 'form-control', 'placeholder' => 'Digite o título do seu pedido','escape'=>false]) ?>
              </div>
              <div class="clear38"></div>
              <div class="col-xs-12 col-md-12 no-gutter">
                <?=$this->ValidationText->exibirErro($errosPedido, "Descricao"); ?>
                <?=$this->Form->textarea('Descricao', ['id' => 'descricao', 'value' => $pedido["Descricao"], 'class' => 'form-control', 'placeholder' => 'Digite seu pedido', 'rows' => 10, 'cols' => 30,'escape'=>false]); ?>
              </div>
              <div class="buttons">
                  <button type="submit" class="btn-default">Enviar atualização</button>
              </div>
          <?=$this->Form->end();?>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- //MODAL ATUALIZACAO PEDIDO -->
<!-- MODAL ATUALIZACAO PEDIDO -->
<!-- MODAL ATUALIZACAO PEDIDO INTERACAO -->
<div class="modal fade modalAtualizacaoPedido" data-backdrop="static" tabindex="-1" role="dialog" id="modalAtualizacaoPedidoInteracao">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="atualizacao-pedido">
            <?=$this->Form->create($pedidoInteracaoEdicao, ["id" => "update-form", "method" => "post", "type" => "file"]) ?>
                <?php
                if($sucessoAtualizadoInteracao != null){
                  if($sucessoAtualizadoInteracao){
?>
                    <div style="margin:20px auto;text-align:center;">
                      <img src="<?=BASE_URL?>assets/images/geral/success.png"><br>
                      <strong>Pedido atualizado com sucesso!</strong>
                    </div>

                      <script type="text/javascript">
                      $(function(){
                          $('#modalAtualizacaoPedidoInteracao').on('show.bs.modal', function(){
                              var myModal = $(this); 
                              clearTimeout(myModal.data('hideInterval'));
                              myModal.data('hideInterval', setTimeout(function(){
                                  //myModal.modal('hide');
                                  var url = window.location.href.split("?")[0];
                                  window.location.href = url;
                              }, 1000));
                          });
                      });
                      </script>
<?php
                  }else{
                    echo '<p class="error"><strong>Erro ao atualizar pedido. Tente novamente mais tarde.</strong><p>';
                  }
                } else {
                ?>
                <input type="hidden" value='2' name="t" >
                <p style="padding-left: 0px;"><strong>Qual é o tipo da resposta ou recurso ?</strong></p>

                <div class="col-xs-12 col-md-6 no-gutter-left">
                    <?=$this->Form->select("CodigoTipoPedidoResposta", $respostas, ['class' => 'form-control', 'empty' => 'Selecione', 'required'=>'required']) ?>
                    <?=$this->ValidationText->exibirErro($errosPedidoInteracao, "CodigoTipoPedidoResposta"); ?>
                </div>

                <div class="col-xs-12 col-md-6 no-gutter-right">
                  <?=$this->Form->text('DataResposta', ['id' => 'dataResposta', 'class' => 'form-control datePicker', 'placeholder' => 'insira a data de resposta/recurso', 'required'=>'required']) ?>
                  <?=$this->ValidationText->exibirErro($errosPedidoInteracao, "DataResposta"); ?>
                </div>
                <div class="clear38"></div>
                <div class="form-group">
                  <p style="padding-left: 2px;">Este pedido foi atendido?</p>
                  <div class="radio-inline">
                    <?= $this->Form->radio('CodigoStatusPedido', [['value'=>1, 'text'=>'Sim'],['value'=>3, 'text'=>'Parcialmente'],['value'=>2, 'text'=>'Não']],['required'=>'required']);
                    ?>
                  </div>
                  <?=$this->ValidationText->exibirErro($errosPedido, "CodigoStatusPedido"); ?>
                </div>  
                <div class="t-info">
                    <div class="col-xs-12 col-md-12 no-gutter">
                      <?=$this->ValidationText->exibirErro($errosPedidoInteracao, "Descricao"); ?>
                      <?=$this->Form->textarea('Descricao', ['id' => 'descricao', 'class' => 'form-control', 'rows' => 10, 'cols' => 30, 'placeholder' => 'Escreva a resposta','escape' => false, 'required'=>'required']) ?>
                    </div>
                    <div class="col-xs-12 col-md-12 no-gutter">
                      <?= $this->element('fileuploader', array('arquivos' => $arquivos,'errosArquivo' => $errosArquivo)) ?>   
                    </div>
                    <div class="buttons">
                        <button type="submit" class="btn-default">Enviar atualização</button>
                    </div>
                </div>
            <?=$this->Form->end();?>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL ATUALIZACAO PEDIDO INTERACAO -->

<script>
  $(document).ready(function(){
    $(".data").mask('99/99/9999');
    <?php
    if($t == 1)
    {
      echo "$('#modalAtualizacaoPedido').modal('show');";
    }else if($t == 2){
      echo "$('#modalAtualizacaoPedidoInteracao').modal('show');";
    }
    ?>
  });
</script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/minhaconta/arquivos.js"></script>
