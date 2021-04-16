

<div class="container-fluid breadcrumbLinha">
  <div class="container">
    <div class="row">
      <ul class="breadcrumb">
        <li class="completed">Home</li>
        <li class="active"><a href="#">Contato</a></li>
      </ul>
    </div>
  </div>
</div>

<section class="contato">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <h1>CONTATO</h1>
        <?php
        if($sucesso != null){
          ?>
          <img src="<?=BASE_URL?>assets/images/home/linhas.png" alt="Contato">
           <img src="<?=BASE_URL?>assets/images/geral/success.png">
           <p><strong>Obrigado!</strong></p>
           <p class="margin"><strong>Sua mensagem, foi enviada com sucesso.</strong></p>
        <?php
        }else{
        ?>
        <img src="<?=BASE_URL?>assets/images/home/linhas.png" alt="Como Funciona">
        <p>Para dúvidas sobre o projeto, consulte o nosso FAQ. Para sugestões e<br> feedbacks, entre em contato conosco pelo formulário abaixo.</p>
          <?=$this->Form->create($contato, ['action' => 'novoContato', "id" => "frmContato"]) ?>
            <?=$this->Form->hidden('guid', ['value' => $guid])?>
            <div class="col-md-6">
              <div class="form-group">
                  <?=$this->Form->text('Nome', ['id' => 'nome', 'class' => 'form-control', 'required' => 'required', 'placeholder' => 'Nome']) ?>
                  <span style="color:red"><?=$this->ValidationText->exibirErro($erros, "Nome"); ?></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <?=$this->Form->text('Email', ['id' => 'email', 'class' => 'form-control', 'required' => 'required', 'placeholder' => 'Email']) ?>
                  <span style="color:red"><?=$this->ValidationText->exibirErro($erros, "Email"); ?></span>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  <?=$this->Form->text('Assunto', ['id' => 'assunto', 'class' => 'form-control', 'required' => 'required', 'placeholder' => 'Assunto']) ?>
                  <span style="color:red"><?=$this->ValidationText->exibirErro($erros, "Assunto"); ?></span>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  <?=$this->Form->textarea('Mensagem', ['id' => 'mensagem', 'class' => 'form-control', 'required' => 'required', 'placeholder' => 'Mensagem', 'rows' => 5]) ?>
                  <span style="color:red"><?=$this->ValidationText->exibirErro($erros, "Mensagem"); ?></span>
              </div>
            </div>
            <div class="form-group">
              <span>Aceito receber mensagens do Achados e Pedidos.</span>
              <input type="checkbox" id="Novidades" name="Novidades" value="1" class="regular-checkbox">
              <label for="Novidades"></label>
            </div>

            <input type="submit" class="bntVer" value="Enviar">
        <?=$this->Form->end();?>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</section>
