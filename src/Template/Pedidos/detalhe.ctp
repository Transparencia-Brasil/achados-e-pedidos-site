<?php header("Content-type: text/html; charset=utf-8"); ?>
<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="active"><a href="#">Pedidos</a></li>
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
          </div>
        </div>
        <div class="col-md-10 no-gutter">
          <div class="column-detalhe-3">
            <h2><?=$pedido["Titulo"]?></h2>
            <p><?=nl2br($pedido["Descricao"])?></p>
            <p>
              <span>Pedido enviado para: </span> <a href="<?=$this->Url->build('/agentes/' . $pedido["SlugAgente"])?>"><?=$pedido["NomeAgente"]?></a>
              <br>Nível federativo: <?=$pedido["NomeNivelFederativo"]?>
<?php
        if (!empty($pedido["SiglaUF"])) {
?>
          <br><?=$pedido["SiglaUF"]?>
<?php
        }
?>
<?php
        if (!empty($pedido["NomeCidade"])) {
?>
          / <?=$pedido["NomeCidade"]?>
<?php
        }
?>
            
            </p>
            <ul class="list">
              <li class="item"> Pedido disponibilizado por: <span><?=$pedido["Anonimo"] == 1 ? "Anônimo" : $pedido["NomeUsuario"]?></span></li>
              <li class="item">Em: <?=date_format(new DateTime($pedido["DataEnvio"]), "d/m/Y")?></li>
            </ul>
            <div class="col-md-6">
              <div class="resposta-pedido">
                <div class="span2">
                <?php
                $arrStatusPedido = $this->FrontEnd->statusPedido($pedido["CodigoStatusPedido"],$pedido["CodigoStatusPedidoInterno"]);
                echo $arrStatusPedido["imagem"];
                ?>
                </div>
                <div  style="float:left;margin-right:4px;">                
                  <ul>
                    <li>Resposta:</li>
                    <li><?=$arrStatusPedido["texto"];?></li>
                  </ul>
                </div>
                <div>
                  <img src="<?=BASE_URL?>assets/images/pedidos/pergunta.png" alt="" data-tooltip="tooltip-resposta-pedido" class="img-responsive tooltip-ajuda-action" style="cursor:pointer;">
                </div>
                <?= $this->element('Pedidos/tooltip');?>                
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
      if(count($interacoes) == 0){
        echo "<div><h3>Este pedido ainda não possui respostas.</h3></div>";
      }
      foreach($interacoes as $interacao){
          $imagem = $interacao->CodigoTipoPedidoResposta == 6 ? "detalhe3" : "detalhe2"; // tipo de resposta do órgão
          ?>
          <div class="col-md-offset-2 n-column-detalhe">
            <a name="#interacao_<?=$interacao["Codigo"]?>"></a>
            <div class="col-md-2 no-gutter">
              <div class="column-detalhe-2">

                <img src="<?=BASE_URL?>assets/images/detalhes/<?=$imagem?>.png" alt="" class="img-responsive">
              </div>
            </div>
            <div class="col-md-10 no-gutter">
              <div class="column-detalhe">
                <div class="situacao">
                  <p><?=$interacao->TipoResposta->Nome?></p>
                </div>
                <ul class="list">
                  <li class="item">Por: <span><?=$pedido["Anonimo"] == 1 ? "Anônimo" : $pedido["NomeUsuario"]?></span></li>
                  <li class="item">Em: <?=date('d/m/Y', strtotime($interacao->DataResposta))?></li>
                </ul>
                <p class="description" style="font-weight:300;"><?=nl2br($interacao->Descricao)?></p>
                <div class="doc">
                  <?php
                  $contador = 1;
                  foreach($interacao->Arquivos as $arquivo){
                  ?>
                  

<?php
                    if ((strpos(strtolower($arquivo->Arquivo),"protegida_pela_lai") ===  false) && (strpos(strtolower($arquivo->Arquivo),"o_de_cunho_pessoal") === 
 false)) {
                         $path_parts = pathinfo($arquivo->Arquivo);
                  ?>
                    <a href="<?=$this->Url->build('/uploads/pedidos/' . $arquivo->Arquivo)?>" target="_blank"><img src="/assets/images/detalhes/<?=strtolower($path_parts['extension']);?>.png" alt="ico" class="icon-img">
                    Arquivo <?=$contador?>
                    </a>
<?php
                    } else {
?>
			<div style="background-color:#f6a237;border-radius:5px;clear:both;padding:24px 10px;margin-bottom:5px;"><img src="/assets/images/detalhes/png.png" alt="ico" class="icon-img" style="float:left;"><p>Anexo não disponível. Contém dados pessoais cujo acesso é restrito, de acordo com a Lei de Acesso a Informações e a Lei Geral de Proteção de Dados Pessoais.</p></div>
<?php
                   }
?>


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
      <div class="col-md-offset-2 n-column-detalhe" style="border:2px solid #edf0f5;padding-top:0px;">
        <div class="row">
            <div class="comentario">
              <div class="col-md-12">
                <form>
                  <input type="hidden" value="<?=$pedido["Codigo"]?>" id="co" />
                  <input type="hidden" value="1" id="ct" />
                  <textarea cols="30" rows="7" class="form-control" id="textoComentario" placeholder="Deixe seu comentário"></textarea>
                  <span class="error" id="erro_comentario"></span>
                  <button type="button" id="btnComentar">
                    <i class="fa fa-comment" aria-hidden="true"></i> Comentar
                  </button>
                </form>
                <hr>
                <?php
                foreach($comentarios as $comentario){
                  ?>
                  <div class="comments">
                    <ul class="list">
                      <li class="item">Por: <span><?=$comentario["NomeUsuario"]?></span></li>
                      <li class="item">Em: <?=date('d/m/Y', strtotime($comentario["Criacao"]))?></li>
                    </ul>
                    <p class="description"><?=$comentario["Texto"]?></p>
                  </div>
                  <hr>
                  <?php
                }

                if(count($comentarios) > 3){
                  echo '<button type="button" class="btnCarregarMais">Carregar Mais</button>';
                }
                ?>
              </div>
            </div>
          </div>
      </div>
    </div>
    <div class="col-xs-12 col-md-4">      
       <div class="column-footer">
         <p>Encontrou algo errado?</p>
         <a href="#" class="btnSolicitar" data-toggle="modal" data-target="#modalRevisao">Solicitar Revisão</a>
       </div>
       <div class="column-avaliacao bgDetalhes">
         <h3>Avaliação</h3>
         <div class="estrelas">
           <?=$this->FrontEnd->calcularAvaliacao($nota)?>
           <span class="count">(<?=$totalAvaliacoes?>)</span><br/>
           <span class="error"></span>
         </div>
       </div>       
       <div class="column-seguidores">
         <img src="<?=BASE_URL?>assets/images/detalhes/s-icon-user.png" alt="" class="img-responsive">
         <div class="count-seguidores"><?=$totalSeguidores?> seguidores</div>
         <a href="javascript:void(0);" class="btnFollow" id="btnToggleSeguir"><?=$this->FrontEnd->interacao($pedido["Codigo"], 1)?></a>
         <span class="error" id="erro_seguir"></span>
       </div>
    </div>
    <div class="col-md-offset-1 col-md-7">
       <div class="column-detalhe-footer">
        <div class="col-xs-12 col-md-6" >
          <a href="" class="btnDownloadFile" style="display:none;">Download de todos os arquivos</a>
        </div>
        <div class="col-xs-12 col-md-6">
          <div class="redes-sociais">
            <p>Compartilhe nas redes sociais</p>
            <a href="https://www.facebook.com/sharer/sharer.php?u=http://www.achadosepedidos.org.br/pedidos/<?=$pedido['Slug']?>"class="link"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="http://twitter.com/home?status=http://www.achadosepedidos.org.br/pedidos/<?=$pedido['Slug']?>" class="link" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="https://plus.google.com/share?url=http://www.achadosepedidos.org.br/pedidos/<?=$pedido['Slug']?>" class="link" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modalRevisao">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="s-content">
          <div class="row">
            <p class="text"><strong>Solicitar revisão</strong></p>
          </div>
          <div class="row">
            <div class="col-md-10">
              <form>
                <textarea cols="30" rows="10" class="form-control" id="textoRevisao" placeholder="Descreva o motivo para a solicitação de revisão"></textarea>
                <span class="error" id="erro_revisao"></span>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="buttons">
              <div class="bntVerMaisNao">
                <button type="button" class="btn-info" id="btnPedidoRevisao">Solicitar</button>
              </div>
            </div>
          </div>
        </div>
        <div class="msg-success-content">
          <div class="row">
            <p class="text"><strong>Obrigado!</strong></p>
            <p>Sua solicitação foi enviada com sucesso.</p>
          </div>
          <div class="row">
            <img src="<?=BASE_URL?>assets/images/detalhes/check-success.png" alt="" class="img-responsive">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="comentario-sucesso-template" style="display:none">
  <div style="margin:0 auto;text-align:center;">
      <img src="<?=BASE_URL?>assets/images/geral/success.png">
      <p><strong>Comentário recebido.</strong><br/>Aguarde pela moderação.</p>
  </div>
</div>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/minhaconta/interacao.js" ></script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/tooltip-ajuda.js" ></script>
