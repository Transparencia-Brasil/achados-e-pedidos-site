<?php
use Cake\Core\Configure;

$this->layout = 'front';
?>
<?php
/*<h2>Erro: <?= h($message) ?></h2>
<p class="error">
    <?= sprintf(
        __d('cake', 'O endereço %s não foi encontrado no servidor.'),
        "<strong>'{$url}'</strong>"
    ) ?>
</p>*/
?>
<div class="container-fluid breadcrumbLinha">
  <div class="container">
    <div class="row">
      <ul class="breadcrumb">
        <li class="completed">Home</li>
        <li class="active">Erro 400</li>
      </ul>
    </div>
  </div>
</div>

<section>
  <div class="container erro400">
    <div class="row">
      <h1 class="text-center">Opsss... Página não encontrada.</h1>
    </div>
    <div class="row">       
        <div class="col-md-12">
            <div class="form-group">
              <div class="bntVer text-center"><a href="<?=BASE_URL?>">Ir para Home</a></div>
            </div>
        </div>
        
    </div>   
  </div>
  
</section>