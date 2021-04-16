<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;


$this->layout = 'front';

if (Configure::read('debug')):
  
    $this->assign('title', $message);
    $this->assign('templateName', 'error500.ctp');

    $this->start('file');
?>

<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?= Debugger::dump($error->params) ?>
<?php endif; ?>


<?php
    echo $this->element('auto_table_warning');

    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
?>
<h2>SISTEMA EM MODO DEBUG: <?= __d('cake', 'Um erro interno ocorreu.') ?></h2>
<p class="error">
    <strong><?= __d('cake', 'Error') ?>: </strong>
    <?= h($message) ?>
</p>
<?php
endif;
?>

<div class="container-fluid breadcrumbLinha">
  <div class="container">
    <div class="row">
      <ul class="breadcrumb">
        <li class="completed">Home</li>
        <li class="active">Erro 500</li>
      </ul>
    </div>
  </div>
</div>

<section>
  <div class="container erro">
    <div class="row">
      <h1 class="text-center">Erro interno do sistema. Tente acessar o recurso novamente mais tarde.</h1>
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