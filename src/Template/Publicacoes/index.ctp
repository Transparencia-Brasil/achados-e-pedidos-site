

<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="active"><a href="#">Publicações</a></li>
    </ul>
  </div>
</div>

<div class="container publicacoes">
    <form action="<?=$this->Url->build('/publicacoes/')?>" id="frmFiltro" method="post">
      <?=$this->Form->hidden("pagina", ["value" => 1])?>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <h3 class="pull-right">
          Pesquisar em<br><?=$totalGeral?> publicações
        </h3>
      </div>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <?=$this->Form->select("Ano", $anos,["id" => "Ano", "class" => "selectAno", "empty" => "Selecione"])?>
        <?=$this->Form->select("CodigoCategoria", $categorias,["id" => "Categoria", "class" => "selectCat", "empty" => "Selecione"])?>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <h4>
          ou
        </h4>
        <?=$this->Form->text("busca", ["id" => "id", "placeholder" => "Insira uma palavra chave."])?>
      </div>
      <div class="col-md-2 col-sm-12 col-xs-12">
        <input type="submit" value="Pesquisar" id="btnBusca" />
        <div class="limpar-filtros"><a href="#" onclick="window.location.href=window.location.href;">Limpar Filtros</a></div>
      </div>
  </form>

<?php 
      if($total == 0)
      {
          echo  '<div class="resultadoBusca">
              <strong>Não encontramos nenhum resultado para o filtro utilizado.</strong>
          </div>';
      }
      $count = 0;
      foreach($publicacoes as $publicacao){
        $data = date("d/m/Y", strtotime($publicacao["DataPublicacao"]));
        $descricao = $publicacao["Descricao"];
        $descricao = strlen($publicacao["Descricao"]) > 150 ? substr($publicacao["Descricao"], 0, 150) . "..." : $descricao;


	if ($count % 3 === 0) {
?>
		<div class="clearfix"></div>
<?php
       } 
?>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box">
          <div class="categoria">
            <?=$publicacao["NomeCategoria"]?>
          </div>
          <div class="publicado">
            Publicado em <?=$data?>
          </div>
          <h2><?=$publicacao["Nome"]?></h2>
          <p><?=$descricao?></p>
          <div class="download">
            <a href="<?=empty($publicacao["Arquivo"]) ? $publicacao["Link"] : "/uploads/publicacoes/" . $publicacao["Arquivo"] ?>" target="_blank">
              <img src="<?=BASE_URL?>assets/images/publicacoes/download.png" alt="Download">
            </a>
          </div>
        </div>
      </div>
      <?php $count++; } ?>

      <div class="row">
          <div class="text-center">
            <?php
            if($total > 30){ ?>
              <ul class="pagination pagination-large">
                <?=$this->FrontEnd->Paging($pagina, $total, 30)?>
              </ul>
          <?php } ?>
          </div>
      </div>

</div>

<script type="text/javascript" src="<?=BASE_URL?>assets/js/publicacoes.js"></script>
