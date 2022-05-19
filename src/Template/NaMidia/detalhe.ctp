<?php
//2017-01-22 Paulo Campos: pega as contanstes estaticas da NaMidia. Não sei passar uma classe direto pelo controller utilizando o set sem instanciar
use App\Model\Entity\NaMidia;
$permaLink = $this->Url->build(BASE_URL . "na-midia/" . $midia["Slug"]);
?>
<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
       <li><a href="<?=$this->Url->build('/na-midia/')?>">Notícias</a></li>
       <li class="active"><a href="#">Detalhe da matéria</a></li>


    </ul>
  </div>
</div>


<div class="container-fluid naMidiaDetalhe">
  <div class="bgColor">
    <div class="container">
      <div class="col-md-8 col-sm-12">
        <div class="row">
            <div class="big crop-height bgColor-mobile">
              <img class="scale" src="<?=BASE_URL?>uploads/na-midia/<?=$midia["Codigo"]?>/<?=$midia["ImagemResumo"]?>" alt="<?=$midia["Titulo"]?>">
            </div>
          <div class="publicado">
            <figcaption>Publicado em <time datetime="2016-05-31T11:41:25-03:00"><?=date("d/m/Y", strtotime($midia["Publicacao"]))?></time></figcaption>
          </div>
          <h1><?=$midia["Titulo"]?></h1>
          <div class="redesS">
            <a href="http://www.facebook.com/share.php?u=<?=$permaLink?>" target="_blank"><img src="<?=BASE_URL?>assets/images/na-midia/face-icon.jpg" alt="Facebook"></a>
            <a href="https://plus.google.com/share?url={<?=$permaLink?>}" target="_blank"><img src="<?=BASE_URL?>assets/images/na-midia/gplus-icon.jpg" alt="Google Plus"></a>
            <a href="http://www.twitter.com/share?url=<?=$permaLink?>" target="_blank"><img src="<?=BASE_URL?>assets/images/na-midia/twiiter-icon.jpg" alt="Twitter"></a>
          </div>
          <div class="text-noticia">
            <p><?=$midia["HTML"]?></p>
            <div class="col-md-12 col-sm-6 col-xs-12 text-center">
              <div class="btnVoltar" ><a href="/na-midia">Voltar</a></div>
            </div>
          </div>
        </div>
      </div>


      <div class="col-md-4 col-sm-6">
        <div class="box-midia">
          <h1 class="box-midia-h1">Matérias Recentes</h1>
          <ul class="box-midia-ul">
          <?php
          if(count($relacionados) > 0):
            foreach($relacionados as $relacionado)
            {
              $link = $this->Url->build('/na-midia/' . $relacionado["Slug"]);
              $target = "";

              if (!empty($relacionado["Link"])) {
                $link = $relacionado["Link"];
                $target = "target='_blank'";
              }
              ?>
              <li class="box-midia-li">
                <a href="<?=$link?>" <?=$target?> class="box-midia">
                  <div class="row">
                      <div class="thumbr crop-height"> 
                        <img class="scale" src="<?=BASE_URL?>uploads/na-midia/<?=$relacionado["Codigo"]?>/<?=$relacionado["ImagemResumo"]?>" alt="<?=$relacionado["Titulo"]?>">
                      </div>
                      <div> 
                          <div class="box-midia-tit"><?=$relacionado["Titulo"]?></div>
                          <div class="box-midia-data"><?=date("d/m/Y", strtotime($relacionado["Publicacao"]))?></div>
                      </div>
                  </div>
                </a>
              </li>
              <?php
            }
          endif;
          ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
