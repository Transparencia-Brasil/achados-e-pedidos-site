
<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="active"><a href="#">Esqueci minha senha</a></li>
    </ul>
  </div>
</div>

<div class="container-fluid login">
    <div class="container">
        <div class="row">
            <div class='col-md-3'></div>
            <div class="col-md-6">
                <h1>SEJA BEM VINDO!</h1>
                <img src="<?=BASE_URL?>assets/images/home/linhas.png" alt="Como Funciona">
                <div class="login-box well">
                    <h2>ESQUECI MINHA SENHA</h2>
                    <form method="post" data-parsley-validate data-parsley-errors-messages-disabled>
                    <?=$this->Form->create('EsqueciSenha', ['method' => 'post'])?>
                        <div class="form-group">
                            <?php
                            if($sucesso == null){
                            ?>
                                <?=$this->Form->text('email', ['class' =>'form-control', 'placeholder'=>'Digite seu e-mail de cadastro', 'required' => 'required'])?>
                                <?=$this->ValidationText->exibirErro($erros, "Email"); 
                                ?>
                            <?php
                            }
                            else{
                                if($sucesso){
                                    echo "<span class='error'>
                                    <img src='". BASE_URL . "assets/images/geral/success.png'>
                                    Uma mensagem foi enviada ao seu e-mail com mais informações de como recuperar seu acesso.</span>";
                                }else{
                                    echo "<span class='error'>Erro ao efetuar operação. Por favor, tente novamente mais tarde..</span>";
                                }                             
                            }
                            ?>
                        </div>    
                        <div class="form-group">                  
                        <span class='esqueciSenha'>
                            <a href="<?=$this->Url->build('/login/')?>" class="text-sm">Voltar ao login</a>
                        </span>                    
                            <input type="submit" class="pull-right bntVer" value="Continuar" />
                        </div>
                    <?=$this->Form->end()?>
                </div>
            </div>
            <div class='col-md-3'></div>
        </div>
    </div>
</div>