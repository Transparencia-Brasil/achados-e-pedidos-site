
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

<section class="configuracao novaSenha">
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6 col-sm-6 col-xs-12 bg">
          <h3><strong>Privacidade e segurança</strong></h3>
          <hr>
          <?php
          if($sucesso != null){
            if($sucesso)
            {
              ?>
              <div style="margin:0 auto;text-align:center;">
                <img src="<?=BASE_URL?>assets/images/geral/success.png">
                <p class="error"><strong>Senha atualizada com sucesso!</strong></p>
              </div>
              <?php
            }else{
              ?>
              <span class="error">Erro ao atualizar senha</span>
              <?php    
            }
          }else{
          ?>
          <?=$this->Form->create('Senha', ['url' => ['prefix' => 'minhaconta', 'controller'=>'Perfil', 'action'=>'alterarsenha'], 'method' => 'post']) ?>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  Senha Atual
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <?=$this->Form->password('SenhaAtual', ['class' => 'form-control', 'placeholder' => 'Digite a senha atual', 'maxlength' => 100])?>
                    <?=$this->ValidationText->exibirErro($erros, "SenhaAtual"); ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    Nova Senha
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <?=$this->Form->password('Senha', ['class' => 'form-control', 'placeholder' => 'Digite a nova senha', 'maxlength' => 100])?>
                    <?=$this->ValidationText->exibirErro($erros, "Senha"); ?>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                Confirmar Senha
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <?=$this->Form->password('ConfirmarSenha', ['class' => 'form-control', 'placeholder' => 'Confirme a nova senha', 'maxlength' => 100])?>
                    <?=$this->ValidationText->exibirErro($erros, "ConfirmarSenha"); ?>

                </div>
              </div> 
            </div> 

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input type="submit" class="bntVer" value="Alterar senha">
                </div>
              </div>
            </div>
        <?=$this->Form->end();
        }
        ?>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
</section>