
<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="active"><a href="#">Cursos</a></li>
    </ul>
  </div>
</div>

<div class="container cursos">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <h1>CURSOS</h1>
          <img src="<?=BASE_URL?>assets/images/home/linhas.png" alt="Como Funciona">
          <p>A Abraji oferece treinamentos específicos para jornalistas sobre o uso da Lei <br/>de Acesso à Informação na produção de reportagens. Os cursos são gratuitos<br/> e apresentam os principais pontos da Lei 12.527/2011 e suas aplicações no<br/> trabalho jornalístico por meio da transparência ativa ou de pedidos de acesso.<br/> Acompanhe nesta página o calendário de oferecimento dos cursos, a serem <br/>ministrados em duas modalidades: presencial e online.</p>
        </div>
    </div>
</div>

<div class="container-fluid bgColor">
  <div class="container cursos">
    <?php foreach($cursos as $curso){?>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="box">
          <div class="categoria <?=strtolower($curso->Tipo->Nome)?>">
            Curso <?=$curso->Tipo->Nome?>
          </div>
          <div class="titulo">
            <strong><?=$curso->Nome?></strong> <br><?=$curso->Titulo?>
          </div>
          <div class="boxsub">
            <div class="relogio">
              <img src="<?=BASE_URL?>assets/images/cursos/icon-relogio.png" alt="Relogio">
              <span>Duração</span><br>
              <span><?=$curso->Duracao?></span>
            </div>
            <?php if(strlen($curso->NumeroAlunos) > 0){?>
            <div class="alunos">
              <img src="<?=BASE_URL?>assets/images/cursos/icon-alunos.png" alt="Alunos">
              <span>Número de alunos por curso</span><br>
              <span><?=$curso->NumeroAlunos?></span>
            </div>
            <?php } 

            if(strlen($curso->Endereco) > 0){
            ?>
            <div class="onde">
              <img src="<?=BASE_URL?>assets/images/cursos/icon-maps.png" alt="Maps">
              <span>Endereço</span><br>
              <span><?=$curso->Endereco?> <?= (isset($curso->Cidade->Nome)) ? " - " . $curso->Cidade->Nome : ""; ?> <?= (isset($curso->UF->Sigla)) ? "/".$curso->UF->Sigla : ""; ?></span>
            </div>
            <?php
            }
            ?>
          </div>
          <hr/>
          <div class="botoes">
            <ul class="loginDesk">
              <li><a href="<?=$curso->Link?>" target="_blank">Inscreva-se</a></li>
              <li><a href="#" data-toggle="modal" data-target="#modal<?=$curso->Codigo?>">Saiba Mais</a></li>
            </ul>
          </div>
        </div>

        <!-- line modal -->
          <div class="modal fade" id="modal<?=$curso->Codigo?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true"> 
                    <img src="<?=BASE_URL?>assets/images/cursos/fechar.png" alt="Fechar"></span>
                  <span class="sr-only">Close</span>
                </button>
              </div>
              <div class="modal-body">
              <!-- content goes here -->
                <div class="box">
                  <div class="categoria <?=strtolower($curso->Tipo->Nome)?>">
                    Curso <?=$curso->Tipo->Nome?>
                  </div>
                  <div class="titulo">
                    <strong><?=$curso->Titulo?></strong>
                  </div>
                  <div class="detalhe">
                    <p><?=$curso->Descricao?></p>
                  </div>
                  <div class="boxsub">
                    <div class="relogio">
                      <img src="<?=BASE_URL?>assets/images/cursos/icon-relogio.png" alt="Relogio">
                      <span>Duração</span><br>
                      <span><?=$curso->Duracao?></span>
                    </div>
                    <?php if(isset($curso->NumeroAlunos)){ ?>
                    <div class="alunos">
                      <img src="<?=BASE_URL?>assets/images/cursos/icon-alunos.png" alt="Alunos">
                      <span>Número de alunos por curso</span><br>
                      <span><?=$curso->NumeroAlunos?></span>
                    </div>
                    <?php } 
                    if(isset($curso->Endereco) && strlen($curso->Endereco) > 0){ ?>
                      <div class="onde">
                        <img src="<?=BASE_URL?>assets/images/cursos/icon-maps.png" alt="Maps">
                        <span>Endereço</span><br>
                        <span><?=$curso->Endereco?> <?= (isset($curso->Cidade->Nome)) ? " - " . $curso->Cidade->Nome : ""; ?> <?= (isset($curso->UF->Sigla)) ? "/".$curso->UF->Sigla : ""; ?></span>
                      </div>
                    <?php } ?>
                  </div>
                  <hr/>
                  <div class="clear"></div>
                  <div class="botoes">
                    <ul class="loginDesk">
                      <li><a href="<?=$curso->Link?>" target="_blank">Inscreva-se</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
      <?php }?>
  </div>  
</div>


