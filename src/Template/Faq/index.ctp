<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed"><a href="index.php">Home</a></li>
      <li class="active">Dúvidas</li>
    </ul>
  </div>
</div>

<div class="container duvidas">
  <div class="row">
    <div class="col-md-4 col-sm-12 col-xs-12 sidebar">
      <div class="categorias">
      <h1>Categorias</h1>
        <ul>
          <?php
            foreach($categorias as $categoria){
              echo '<li><a href="javascript:void(0);" onclick="javascript:filtrarFaq(' . $categoria->Codigo . ')">' . $categoria->Nome . '</a></li>';
            }
          ?> 
          <li><a href="javascript:void(0);" onclick="javascript:filtrarFaq(0)">Todas</a></li>
        </ul>
      </div>

      <div class="contato">
        <h1>Contato</h1>
        <p>Caso sua dúvida não tenha sido<br> esclarecida entre em contato.</p>
        <div class="bntVerMais"><a href="<?=$this->Url->build('/contato/')?>">Contato</a></div>
      </div>
    </div>

    <div class="col-md-8 col-sm-12 col-xs-12 duvidasBox">
      <h1>Dúvidas</h1>
      <p>Está com dúvidas sobre a Lei de Acesso ou sobre como fazer um pedido de informação? Procure aqui sua resposta:</p>
      <div id="custom-search-input">
          <div class="input-group col-md-12">
              <input type="text" class="form-control input-lg" id="btnPesquisarFaq" placeholder="Digite aqui sua busca" />
              <span class="input-group-btn">
                  <button class="btn btn-info btn-lg" type="button">
                      <i class="glyphicon glyphicon-search"></i>
                  </button>
              </span>
          </div>
      </div>

        <div class="panel-group" id="accordion">
          <?php
          foreach($dados as $item){
            $perguntas = $item->Perguntas;
            ?>
            <div data-val="<?=$item->Codigo?>" class="faq-elementos">
              <h2 ><?=$item->Nome?></h2>
              <?php
                foreach($item->Perguntas as $pergunta){ 

                  if(count($pergunta->Respostas) > 0){
                    $respostaUnica = $pergunta->Respostas[0]->Resposta;
                  }else{
                    $respostaUnica = "Resposta indisponível no momento.";
                  }
                  ?>
                  <div class="panel panel-default" data-categoria="<?=$item->Codigo?>">
                    <div class="panel-heading">      
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$pergunta->Codigo?>">
                          <h4 class="panel-title"><?=$pergunta->Pergunta?></h4>
                        </a>      
                    </div>
                    <div id="collapse<?=$pergunta->Codigo?>" class="panel-collapse collapse">
                      <div class="panel-body">
                        <?=$respostaUnica?>
                      </div>
                    </div>
                  </div>
              <?php
                }
              ?>
            </div>
          <?php
          }
          ?>
        </div>

    </div>
  </div>
</div>

<script type="text/javascript" src="<?=BASE_URL?>assets/js/faq.js" ></script>