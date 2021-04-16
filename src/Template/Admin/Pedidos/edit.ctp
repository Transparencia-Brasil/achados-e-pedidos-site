<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header" data-original-title>
      <h2><i class="halflings-icon edit"></i><span class="break"></span>Editando pedido: <?=$pedido->Titulo?></h2>
      <div class="box-icon"></div>
    </div>

    <div class="box-content">
      <div class="alert-error"><?= $this->Flash->render();?></div>
      <?=$this->Form->create($pedido, ['class' => 'form-horizontal']) ?>
        <fieldset>
          <div class="control-group">
          <label class="control-label" for="CodigoAgente">Agente *</label>
          <div class="controls">
          <?=$this->Form->select('Pedidos.CodigoAgente', $agentes, ['class' => 'span3']);?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="CodigoTipoPedidoOrigem">Origem *</label>
          <div class="controls">
          <?=$this->Form->select('Pedidos.CodigoTipoPedidoOrigem', $tipo_origem, ['class' => 'span3']);?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="CodigoTipoPedidoSituacao">Situação *</label>
          <div class="controls">
          <?=$this->Form->select('Pedidos.CodigoTipoPedidoSituacao', $tipo_situacao, ['class' => 'span3']);?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="CodigoStatusPedido">Status *</label>
          <div class="controls">
          <?=$this->Form->select('Pedidos.CodigoStatusPedido', $status_pedido, ['class' => 'span3']);?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="CodigoStatusPedidoInterno">Status Interno*</label>
          <div class="controls">
          <?=$this->Form->select('Pedidos.CodigoStatusPedidoInterno', $status_pedido, ['class' => 'span3']);?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="Titulo">Título *</label>
          <div class="controls">
          <?=$this->Form->text('Pedidos.Titulo', ['class' => 'span6']);?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="Protocolo">Protocolo *</label>
          <div class="controls">
          <?=$this->Form->text('Pedidos.Protocolo', ['class' => 'span6']);?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="Protocolo">Identificador Externo *</label>
          <div class="controls">
          <?=$this->Form->text('Pedidos.IdentificadorExterno', ['class' => 'span6']);?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="Resumo">Descrição</label>
          <div class="controls">
          <?=$this->Form->textarea('Pedidos.Descricao', ['class' => 'span6']);?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="Inicio">Data de envio *</label>
          <div class="controls">
          <?=$this->Form->text('Pedidos.DataEnvio',
            ['class' => 'input-xlarge datepicker'],
            ['error'=> array('attributes' => ['escape' => false])]
          );?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="Resumo">Anônimo</label>
          <div class="controls">
          <?=$this->Form->checkbox('Pedidos.Anonimo');?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="Resumo">Foi prorrogado</label>
          <div class="controls">
          <?=$this->Form->checkbox('Pedidos.FoiProrrogado');?>
          </div>
        </div>
        <?php
        if($pedido->Revisoes != null && count($pedido->Revisoes->toArray()) > 0):
        ?>
        <div class="control-group">
          <p style="color:red">Pedidos de revisão:</p>
          <p>Clique no checkbox para marcar o item como respondido.</p>
          <ul style="list-style-type: none;">
            <?php
            foreach($pedido->Revisoes as $revisao):
            ?>
            <li><input type="checkbox" value="<?=$revisao->Codigo?>" name="pedidoRevisao" /><?=$revisao->Texto?></li>
            <?php
            endforeach;
            ?>
          </ul>
        </div>
        <?php endif;?>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Salvar</button>
          <button type="button" onclick='javascript:history.back(-1);' class="btn">Cancelar</button>
        </div>
        </fieldset>
      <?=$this->Form->end();?>
    </div>

    <?php
    if(isset($pedido->Respostas) && count($pedido->Respostas->toArray()) > 0){
      echo '<div class="box-content">
          <h2>Respostas</h2>
        </div>';
    }
    if(isset($pedido->Respostas)){

      foreach($pedido->Respostas as $resposta):

      $resposta->DataResposta = date("d/m/Y", strtotime($resposta->DataResposta));
      ?>
      <div class="box-content">
        <div class="alert-error"><?= $this->Flash->render();?></div>
        <?=$this->Form->create($resposta, ['action' => 'editInteracao', 'class' => 'form-horizontal']) ?>

          <?=$this->Form->hidden("PedidosInteracoes.Codigo", ['value' => $resposta->Codigo])?>
          <?=$this->Form->hidden("PedidosInteracoes.CodigoPedido", ['value' => $resposta->CodigoPedido])?>
          <fieldset>
            <div class="control-group">
            <label class="control-label" for="CodigoTipoPedidoResposta">Tipo Resposta *</label>
            <div class="controls">
            <?=$this->Form->select('PedidosInteracoes.CodigoTipoPedidoResposta', $tipo_resposta, ['class' => 'span3']);?>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="Resumo">Descrição</label>
            <div class="controls">
            <?=$this->Form->textarea('PedidosInteracoes.Descricao', ['class' => 'span6']);?>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="Inicio">Data da resposta</label>
            <div class="controls">
            <?=$this->Form->text('PedidosInteracoes.DataResposta',
              ['class' => 'input-xlarge datepicker'],
              ['error'=> array('attributes' => ['escape' => false])]
            );?>
            </div>
          </div>
          <div class="control-group">
            <h4>Arquivos</h4>
                    <?php
                    $contador = 1;
                    foreach($resposta->Arquivos as $arquivo){
                    ?>
                      <div style="border:1px solid black;padding:1%;margin:1px;float:left;">
                        <a href="<?=$this->Url->build('/uploads/pedidos/' . $arquivo->Arquivo)?>" target="_blank">
                        <strong><?=$arquivo->Arquivo?></strong>
                        </a><br/><br/>
                        <a href="javascript:void(0);" onclick="removerArquivo(this)" data-val="<?=$arquivo->Codigo?>" style="color:red;font-size:10px;">Remover</a>
                      </div>

                    <?php
                    $contador++;
                    }
                    ?>
                  </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <button type="button" onclick='javascript:history.back(-1);' class="btn">Cancelar</button>
          </div>
          </fieldset>
        <?=$this->Form->end();?>
      </div>
      <?php
      endforeach;
    }
      ?>
  </div><!--/span-->

</div><!--/row-->

<script type="text/javascript">

function responderRevisao(obj){

codigo = $(obj).val();

$.ajax({
url : '<?=BASE_URL?>admin/pedidos/responderRevisao/' + codigo,
method : 'POST',
success : function(data)
{
if(data.erro != null)
{
  alert('Erro ao atualizar revisão. Tente novamente mais tarde');
}else{
  $(obj).parents('li').hide();
}
},
error : function(){
alert('Erro ao atualizar revisão. Tente novamente mais tarde');
}
});
}

function removerArquivo(obj){

codigo = $(obj).data('val');

$.ajax({
url : '<?=BASE_URL?>admin/pedidos/removerArquivo/' + codigo,
method : 'POST',
success : function(data)
{
if(data.erro != null)
{
  alert('Erro ao remover arquivo. Tente novamente mais tarde');
}else{
  $(obj).parents('.control-group').hide();
}
},
error : function(){
alert('Erro ao remover arquivo. Tente novamente mais tarde');
}
});
}

$(document).ready(function(){

$("input[name='pedidoRevisao']").click(function()
{
responderRevisao($(this));
});
})
</script>
