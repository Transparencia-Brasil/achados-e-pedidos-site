<?php
//2017-01-22 Paulo Campos: pega as contanstes estaticas da NaMidia. Não sei passar uma classe direto pelo controller utilizando o set sem instanciar
use App\Model\Entity\NaMidia;
?>
<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="active"><a href="#">Notícias</a></li>
    </ul>
  </div>
</div>

  <div class="container naMidia">
      <form method="post" id="frmMidia"><input type="hidden" id="pagina" name="pagina" value="<?=$pagina?>"/></form>
      <?php
      $contador = 1;
      $contadorInterno = 1;
      foreach($dados as $midia){

      $permaLink = $this->Url->build(BASE_URL . "na-midia/" . $midia["Slug"]);


        $header = "4";
        //2017-01-22 Paulo Campos. Não iremos mais usar o ImagemThumb. Agora as imagens são redimensionadas pelo GD
        //$imagem = $midia["ImagemThumb"];
        //$imagem = NaMidia::PREFIX_THUMB2.$midia["ImagemResumo"];

        if($pagina == 1 && $contador == 1){
          $header = "8";
        }
        $imagem = $midia["ImagemResumo"];
        $data = date("d/m/Y", strtotime($midia["Publicacao"]));

        if($contadorInterno == 1){
          echo "<div class='row'>";
        }
        ?>
        <div class="col-md-<?=$header?> col-sm-6">
          <div class="card hovercard">
            <div class="cardheader <?=($pagina == 1 &&  $contador == 1 ? "img1" : "")?>">
              <div class="crop-height">
                <img class="scale" src="<?=BASE_URL?>uploads/na-midia/<?=$midia["Codigo"]?>/<?=$imagem?>" alt="">
              </div>
            </div>
            <div class="info">
                <div class="publicado<?=($contador > 1 || $pagina > 1) ? "2" : ""?>">
                    Publicado em <?=$data?>
                </div>
                <div class="desc"><strong><?=$midia["Titulo"]?></strong></div>
                <div class="desc2"><?=$midia["SubTitulo"]?></div>
            </div>
            <div class="bottom">
              <a href="http://www.facebook.com/share.php?u=<?=$permaLink?>" target="_blank"><img src="<?=BASE_URL?>assets/images/na-midia/icon-face.png" alt="Facebook"></a>
              <a href="https://plus.google.com/share?url={<?=$permaLink?>}" target="_blank"><img src="<?=BASE_URL?>assets/images/na-midia/icon-gplus.png" alt="Google Plus"></a>
              <a href="http://www.twitter.com/share?url=<?=$permaLink?>" target="_blank"><img src="<?=BASE_URL?>assets/images/na-midia/icon-twiiter.png" alt="Twitter"></a>
              <?=$this->UrlNoticia->getLink($midia["Link"],$this->Url->build("/na-midia/". $midia["Slug"])); ?>
            </div>
          </div>
        </div>
        <?php
        if($contadorInterno == 3 || $contador == 2)
        {
          echo "</div>";
          $contadorInterno = 1;
        }else{
          $contadorInterno++;
        }
        $contador++;
      }

      if($contador % 3 != 0 && $contador != 1)
      {
          echo "</div>";
      }
      ?>
      <div class="row">
          <div class="text-center">
            <?php
            if($total > 5){
              $qtd = $pagina == 1 ? 5 : 6;
              ?>
              <ul class="pagination pagination-large">
                <?=$this->FrontEnd->Paging($pagina, $total, $qtd)?>
              </ul>
            <?php } ?>
          </div>
      </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
      $("ul.pagination > li").click(function(){
        pagina = $(this).data("val");
        $("#pagina").val(pagina);
        $("#frmMidia").submit();
      });
  })
</script>
