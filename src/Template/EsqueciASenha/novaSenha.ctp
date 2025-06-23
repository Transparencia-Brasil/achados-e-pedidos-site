<?
$this->UCaptcha->CaptchaScript();
?>


<div class="container-fluid breadcrumbLinha">
  <div class="container">
    <div class="row">
      <ul class="breadcrumb">
        <li class="completed">Home</li>
        <li class="active"><a href="#">Minha Conta</a></li>
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
          <div class="row">
            <?php
            if($chaveVencida){
              echo '<span class="error">A chave está vencida. <a href="'.BASE_URL.'esqueci-a-senha">Clique aqui</a> para recuperar sua senha.</span>';
            }else if($usuarioNaoEncontrado == true){
              echo '<span class="error">Dados inválidos. <a href="'.BASE_URL.'esqueci-a-senha">Clique aqui</a> para recuperar sua senha.</span>';
            }else{
            ?>
            
            <?= $this->Form->create('', ['method' => 'post']) ?>
                        <?
                            $this->UCaptcha->CaptchaTokenInput();
                        ?>
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
                <div class="col-md-9">
                  <div class="form-group">
                    <input type="submit" class="bntVer" value="Continuar">

                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-9">
                  <span class="error">
                    <?php if($sucesso != null) { 
                        echo $sucesso ? "Senha atualizada com sucesso! <a href='".BASE_URL."login'>Clique aqui</a> para fazer login." : "Erro ao atualizar senha."; 
                    }?>

                  </span>
                </div>
              </div>
          <?=$this->Form->end()?>
          <?php }?>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
</section>