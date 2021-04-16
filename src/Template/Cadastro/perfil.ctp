<div class="container-fluid breadcrumbLinha">
  <div class="container">
    <div class="row">
      <ul class="breadcrumb">
        <li class="completed">Home</li>
        <li class="active"><a href="#">Cadastro</a></li>
      </ul>
    </div>
  </div>
</div>

<section class="cadastro">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <?php 

          if($sucesso != null){
              if($sucesso){
                ?>
                  <h1>OBRIGADO</h1>
                  <img src="<?=BASE_URL?>assets/images/home/linhas.png" alt="Como Funciona">
                  <p>Seu cadastro foi realizado com sucesso.<br/><br/>
                    <a href="<?=$this->Url->build('/minhaconta/pedidos/novopedido')?>" class="perfil-novo-pedido">
                    Clique aqui para inserir um novo pedido</a>
                  </p>
                <?php
              }else{
                ?>
                <h1>Erro</h1>
                  <img src="<?=BASE_URL?>assets/images/home/linhas.png" alt="Como Funciona">
                  <p class="error">Erro ao finalizar seu cadastro. Por favor, tente novamente mais tarde.</p>
                <?php
              }
          }else{
          ?>
        
          <?=$this->Form->create($usuario_perfil, ['action' => 'perfil', "id" => "frmPerfil"]) ?>
          <p>
            A equipe do Achados e Pedidos gostaria de conhecer você melhor para aprimorar nossa análise de perfil de uso da LAI e do site.<br><br>
            Se desejar, preencha os campos abaixo; caso contrário, continue navegando pelo nosso site.
          </p>
            <div class="col-md-6">
              <div class="form-group">
                  <?=$this->Form->text('Nascimento', ['id' => 'data_nascimento', 'class' => 'form-control', 'placeholder' => 'Nascimento']) ?>
                  <?=$this->ValidationText->exibirErro($erros, "Nascimento"); ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
	                 <?=$this->Form->select('CodigoTipoGenero', $generos,['class' => 'form-control', 'id' => 'CodigoTipoGenero', 'name'=> 'CodigoTipoGenero','empty' => 'Gênero']);?>
					         <?=$this->ValidationText->exibirErro($erros, "CodigoTipoGenero"); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  <?=$this->Form->text('Ocupacao', ['id' => 'Codigo_ocupacao', 'class' => 'form-control', 'placeholder' => 'Ocupação']) ?>
					<?=$this->ValidationText->exibirErro($erros, "Ocupacao"); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
	              <?=$this->Form->select('CodigoPais', $paises ,['class' => 'form-control', 'id' => 'CodigoPais']);?>
					     <?=$this->ValidationText->exibirErro($erros, "CodigoPais"); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
              	<?=$this->Form->select('CodigoUF', [] ,['class' => 'form-control', 'id' => 'CodigoUF', 'empty' => 'Selecione o País']);?>
				        <?=$this->ValidationText->exibirErro($erros, "CodigoUF"); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  	<?=$this->Form->select('CodigoCidade', [] ,['class' => 'form-control', 'id' => 'CodigoCidade', 'empty' => 'Selecione a UF']);?>
				           <?=$this->ValidationText->exibirErro($erros, "CodigoCidade"); ?>
              </div>
            </div>

            <input type="submit" class="bntVer btnCadastro" value="Continuar" id="btnFinalizar">
        <?=$this->Form->end();?>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript" src="<?=BASE_URL?>/assets/js/minhaconta/perfil.js" ></script>
<script type="text/javascript">
  siglaUF = '';
  codigoCidade = 0;

  $("#CodigoPais option[value='33']").attr('selected','selected');
</script>
<script type="text/javascript" src="<?=BASE_URL?>/assets/js/cidades.js" ></script>