

<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed"><a href="<?=BASE_URL?>">Home</a></li>
      <li class="active">Login</a></li>
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
                <h5>Digite seus dados para login:</h5>
                <div class="login-box well">
                    <?= $this->Form->create('User', ['url' => ['prefix' => 'minhaconta', 'controller'=>'Login', 'action'=>'logar']]) ?>
                        <div class="form-group">
                            <?=$this->Form->text('login', ['tabindex' => 1, 'placeholder' => 'Digite seu e-mail', 'class' => 'form-control', 'required' => 'required']);?>
                            <span style="color:red"><?=$this->ValidationText->exibirErro($erros, "Email"); ?></span>
                        </div>
                        <div class="form-group">
                            <?=$this->Form->text('senha', ['type' => 'password', 'tabindex' => 1, 'placeholder' => 'Digite sua senha', 'class' => 'form-control', 'required' => 'required']);?>
                            <span style="color:red"><?=$this->ValidationText->exibirErro($erros, "Senha"); ?></span>
                        </div>      
                        <div class="form-group">                  
                        <span class='esqueciSenha'>
                            <a href="<?=$this->Url->build('/esqueci-a-senha/')?>" class="text-sm">Esqueci minha senha</a>
                        </span>                    
                            <input type="submit" class="pull-right bntVer" value="Entrar" />
                        </div>
                    <?= $this->Form->end() ?>
                </div>
                <div class="form-group ">
                    <a href="<?=$this->Url->build('/cadastro')?>" class="bntVerMais">Criar uma conta</a>
                </div>    
            </div>
            <div class='col-md-3'></div>
        </div>
    </div>
</div>
