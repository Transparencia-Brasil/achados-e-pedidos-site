
<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="active"><a href="#">Perfil</a></li>
    </ul>
  </div>
</div>

<div class="perfil seguidores">
  <div class="container-fluid">
    <div class="container">
      <div class="col-md-3 sidebarPerfil">
        <div class="col-md-12">
          <div class="panel panel-default">
             <div class="panel-body">       
              <div class="box-info">
                <div class="box-body">
                  <div class="col-sm-8">
                    <h5><strong><?=$usuario["Nome"]?></strong></h5>       
                  </div>
                  <div class="col-sm-12">
                    <div class="pedidos">
                      <h5 class="text-center">Pedidos aprovados: ( <?=$usuario["TotalPedidos"]?> )</h5> 
                    </div>   
                  </div>
                  <div class="col-sm-6 bgBox">
                    <div class="pedidos">
                      <h5 class="text-center"><a href="<?=$this->Url->build('/usuarios/'.$usuario["Slug"].'/seguidores')?>"><strong>Seguidores</strong></a><br><br> ( <?=$usuario["TotalSeguidores"]?> )</h5> 
                    </div>   
                  </div>
                  <div class="col-sm-6 bgBox">
                    <div class="pedidos">
                      <h5 class="text-center"><a href="<?=$this->Url->build('/usuarios/'.$usuario["Slug"].'/seguindo')?>"><strong>Seguindo</strong></a><br><br> ( <?=$usuario["TotalSeguindo"]?> )</h5> 
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
                      </div>
                  </div>
                  <?php
                    if(!$this->FrontEnd->EhUsuarioLogado($usuario["Codigo"])){
                    ?>
                    <div class="col-sm-12 raizInteracao">
                      <input type="hidden" value="<?=$usuario["Codigo"]?>" id="co" />
                      <input type="hidden" value="3" id="ct" />
                      <div class="bntVerMais">
                        <a href="javascript:void(0);" id="btnToggleSeguir">
                          <?=$this->FrontEnd->interacao($usuario["Codigo"], 3)?>
                        </a>
                      </div>
                      <span class="error" id="erro_seguir"></span>
                    </div>
                    <?php
                    }else{
                    ?>
                      <div class="config">
                        <a href="<?=$this->Url->build('/minhaconta/perfil/')?>">
                          <div class="col-sm-4">
                            <div class="pull-left"> 
                              <img src="<?=BASE_URL?>assets/images/perfil/img-roda.png" alt="Configurações">
                            </div>
                          </div>
                          <div class="col-sm-8">
                            <h5>Configurações<br> da conta</h5>       
                          </div>
                        </a>
                      </div>
                    <?php 
                    }
                    ?>
                </div>
              </div>
            </div> 
          </div>
        </div>  
      </div>

        <div class="col-md-3"></div>
        <div class="col-md-7">
          <div class="seguindo">
            <div class="por">
              <h4><strong><?=count($feed)?> - <?=ucfirst($tipo)?></strong></h4>
            </div>

          </div>
          <?php
          if(count($feed) == 0){
            echo $tipo == "seguidores" ? "<h4>Este usuário ainda não possui seguidores.</h4>" : "<h4>Este usuário ainda não segue ninguém.</h4>";
          }
          foreach($feed as $elemento){

            switch($elemento["CodigoTipoObjeto"]){
                case 1:
                  $imagem = "img-3.jpg";break;
                case 2:
                  $imagem = "img-1.jpg";break;
                case 3:
                  $imagem = "img-2.jpg";break;
            }
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12 box raizInteracao">
               <div class="col-md-2 col-xs-2">
                <img src="<?=BASE_URL?>assets/images/perfil/<?=$imagem?>" alt="">
               </div>
               <div class="col-md-8 col-xs-8">
                <div class="por">
                  <span><?=$elemento["NomeTipo"]?>:</span><a href="<?=$this->Url->build($elemento["Url"] . $elemento["Slug"])?>"><?=$elemento["Nome"]?></a>
                  <br/><span class="error"></span>
                </div>
               </div>
               <div class="col-md-2">
                <div class="bntVerMais">
                  <a href="javascript:void(0);" class="interacao" data-co="<?=$elemento["Codigo"]?>" data-ct="<?=$elemento["CodigoTipoObjeto"]?>"><?=$this->FrontEnd->interacao($elemento["Codigo"], $elemento["CodigoTipoObjeto"])?></a>
                </div>
                
               </div>
            </div>
            <?php
          }
          ?>
           <div class="text-center">
            <ul class="pagination pagination-large">
              <?=$this->FrontEnd->paging($pagina, $total, 15)?>
            </ul>
          </div>
        </div>
      </div>
   
  </div>
</div>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/minhaconta/interacao.js" ></script>
<script>
  $(document).ready(function(){
    $(".interacao").click(function(){
      ct = $(this).data("ct");
      co = $(this).data("co");

      toogleSeguir(co, ct, $(this));
    });
  });
</script>

