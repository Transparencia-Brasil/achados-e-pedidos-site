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
        <h1>CRIE SUA CONTA</h1>
        <img src="<?=BASE_URL?>assets/images/home/linhas.png" alt="Como Funciona">
        <p>Preencha o formulário abaixo para criar sua conta:</p>
          <?=$this->Form->create($usuario, ['action' => 'index', "id" => "frmCadastro"]) ?>
            <div class="col-md-12">
              <div class="form-group">
                  <?=$this->Form->text('Nome', ['id' => 'nome', 'class' => 'form-control', 'placeholder' => "Digite seu nome", 'maxlength' => 100]) ?>
                  <?=$this->ValidationText->exibirErro($erros, "Nome"); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  <?=$this->Form->text('Documento', ['id' => 'documento', 'class' => 'form-control', 'placeholder' => "Digite seu CPF ou CNPJ", 'maxlength' => 20]) ?>
					<?=$this->ValidationText->exibirErro($erros, "Documento"); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  	<?=$this->Form->text('Email', ['id' => 'email', 'class' => 'form-control', 'placeholder' => "E-mail", 'maxlength' => 100]) ?>
					<?=$this->ValidationText->exibirErro($erros, "Email"); ?>
              </div>
            </div>
			       <div class="col-md-12">
              <div class="form-group">
                  <?=$this->Form->text('ConfirmarEmail', ['id' => 'confirmarEmail', 'class' => 'form-control', 'placeholder' => "Confirme seu e-mail", 'maxlength' => 100]) ?>
					<?=$this->ValidationText->exibirErro($erros, "ConfirmarEmail"); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  <?=$this->Form->password('Senha', ['id' => 'senha', 'class' => 'form-control', 'placeholder' => 'Digite sua senha', 'maxlength' => 20]) ?>
					       <?=$this->ValidationText->exibirErro($erros, "Senha"); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  <?=$this->Form->password('ConfirmarSenha', ['id' => 'confirmarSenha', 'class' => 'form-control', 'placeholder' => "Confirme sua senha", 'maxlength' => 20]) ?>
					       <?=$this->ValidationText->exibirErro($erros, "ConfirmarSenha"); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <span>Aceito receber mensagens do Achados e Pedidos.</span>
                <?=$this->Form->checkbox('AceiteComunicacao', ['id' => 'AceiteComunicacao', 'class' => 'regular-checkbox']) ?>
                <label for="AceiteComunicacao"></label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group checkbox-2">
                <span>Concordo com os <a href="<?=$this->Url->build('/termos-de-uso/')?>" target="_blank">termos de uso</a> e com a<br> <a href="<?=$this->Url->build('/termosdeprivacidade/')?>" target="_blank">política de privacidade</a> do Achados e Pedidos.</span>
                <?=$this->Form->checkbox('AceiteRegulamento', ['id' => 'AceiteRegulamento', 'class' => 'regular-checkbox']) ?>
                <label for="AceiteRegulamento"></label>
                <?=$this->ValidationText->exibirErro($erros, "AceiteRegulamento"); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group btnContinuar">
                <input type="submit" class="bntVer btnCadastro" id="btnFinalizar" value="Continuar">
              </div>
            </div>
            
        <?=$this->Form->end();?>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript" src="<?=BASE_URL?>/assets/js/minhaconta/cadastro.js" ></script>