
<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="active"><a href="#">Configuraçoes</a></li>
    </ul>
  </div>
</div>

<div class="container configuracao">
  <div class="col-md-6 bg">
    <h3><strong>Dados Pessoais</strong></h3>

    <div style="padding:30px;text-align: center;font-weight: bold;display: none" id="status">
      <span style="color:red;">
      <?php
        if($sucesso === false){
            echo "Erro ao atualizar dados. Tente novamente mais tarde";
        }else{
            echo "Dados Atualizados com sucesso.";
        }
        ?>
      </span>
    </div>
    <?=$this->Form->create($usuario, []) ?>
      <div class="row">
        <hr>
        <div class="col-md-2">
            <div class="form-group">
              <label>Nome:</label>
            </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
              <?=$this->Form->text("Nome", ["class" => "form-control", "id" => "nome", "placeholder" => "Nome"])?>
              <span style="color:red"><?=$this->ValidationText->exibirErro($erros, "Nome"); ?></span>
          </div>
        </div>
      </div>

      <div class="row">
        <hr>
        <div class="col-md-2">
            <div class="form-group">
              <label>E-mail</label>
            </div>
        </div>
        <div class="col-md-10">
          <div class="form-group">
            <?=$this->Form->text("Email", ["class" => "form-control", "id" => "email", "placeholder" => "", "readonly" => "readonly"])?>
          </div>
        </div>
      </div>

      <div class="row">
        <hr>
        <div class="col-md-2">
            <div class="form-group">
              <label>CPF / CNPJ</label>
            </div>
        </div>
        <div class="col-md-10">
          <div class="form-group">
            <?=$this->Form->text("Documento", ["class" => "form-control", "id" => "documento", "placeholder" => "", "readonly" => "readonly"])?>
          </div>
        </div>
      </div>

      <div class="row">
      <hr>
        <div class="col-md-2">
            <div class="form-group">
              <label>Gênero</label>
            </div>
        </div>
        <div class="col-md-10">
          <div class="form-group">
              <?=$this->Form->select('UsuarioPerfil.CodigoTipoGenero', $generos,['class' => 'form-control', 'id' => 'CodigoTipoGenero','empty' => 'Gênero']);?>
              <?=$this->ValidationText->exibirErro($erros, "CodigoTipoGenero"); ?>
          </div>
        </div>
      </div>

      <div class="row">
      <hr>
        <div class="col-md-2">
            <div class="form-group">
              <label>Ocupação</label>
            </div>
        </div>
        <div class="col-md-10">
          <div class="form-group">
              <?=$this->Form->text('UsuarioPerfil.Ocupacao', ['id' => 'Codigo_ocupacao', 'class' => 'form-control', 'placeholder' => 'Ocupação']) ?>
              <?=$this->ValidationText->exibirErro($erros, "Ocupacao"); ?>
          </div>
        </div>
      </div>

      <div class="row">
      <hr>
        <div class="col-md-2">
            <div class="form-group">
              <label>País</label>
            </div>
        </div>
        <div class="col-md-10">
          <div class="form-group">
              <?=$this->Form->select('UsuarioPerfil.CodigoPais', $paises ,['class' => 'form-control', 'id' => 'CodigoPais']);?>
               <?=$this->ValidationText->exibirErro($erros, "CodigoPais"); ?>
          </div>
        </div>
      </div>

      <div class="row">
      <hr>
        <div class="col-md-2">
            <div class="form-group">
              <label>Estado</label>
            </div>
        </div>
        <div class="col-md-10">
          <div class="form-group">
              <?=$this->Form->select('UsuarioPerfil.CodigoUF', [] ,['class' => 'form-control', 'id' => 'CodigoUF', 'empty' => 'Selecione o País']);?>
              <?=$this->ValidationText->exibirErro($erros, "CodigoUF"); ?>
          </div>
        </div>
      </div>

      <div class="row">
      <hr>
        <div class="col-md-2">
            <div class="form-group">
              <label>Cidade</label>
            </div>
        </div>
        <div class="col-md-10">
          <div class="form-group ">
              <?=$this->Form->select('UsuarioPerfil.CodigoCidade', [] ,['class' => 'form-control', 'id' => 'CodigoCidade', 'empty' => 'Selecione a UF']);?>
              <?=$this->ValidationText->exibirErro($erros, "CodigoCidade"); ?>
          </div>
        </div>
      </div>

      <div class="form-group">
          <input type="submit" class="bntVer" value="Salvar alteração">
      </div>
    <?=$this->Form->end();?>
  </div>
  <div class="col-md-6 bg">
    <h3><strong>Status da conta</strong></h3>
    <?=$this->Form->create('ExcluirConta', ['method' => 'post', 'id' => 'frmExcluirConta', 'url' => ['action' => 'excluirConta']])?>
    <div class="row statusConta">
      <hr>
        <div class="col-md-4 col-xs-12">
            <div class="form-group">  
              <input type="text" class="form-control" maxlength="64" id="nome" placeholder="Conta" required="">
            </div>
        </div>
        <div class="col-md-4 col-xs-6">
            <div class="form-group">
              <input type="text" class="form-control text-center" maxlength="64" id="nome" placeholder="Ativada" required="">
            </div>
        </div>
        <div class="col-md-4 col-xs-6">
            <?php
            if(isset($sucessoExclusao) && $sucessoExclusao != null)
            {
              echo '<span class="error">Erro ao excluir cadastro. Por favor, tente novamente mais tarde.</span>';
            }
            ?>
            <div class="form-group">
               <h5><a href="javascript:void(0);"  data-toggle="modal" data-target="#modalExcluir" class="pull-right">Excluir</a></h5>
            </div>
        </div>
        <hr>
        <!-- line modal -->
        <div class="modal fade" id="modalExcluir" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true"> 
                    <img src="<?=BASE_URL?>assets/images/cursos/fechar.png" alt="Fechar"></span>
                  <span class="sr-only">Close</span>
                </button>
              </div>
              <div class="modal-body">              
                <h4 class="text-center"><strong>Tem certeza que deseja excluir sua conta?</strong></h4>
                <p class="text-center">Lembre-se que seus pedidos continuarão em nosso site,<br> mas seu nome não será mais divulgado.</p>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="bntVerMaisEx pull-right"><a href="javascript:void(0);" id="btnExcluirConta">Excluir Conta</a></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="bntVerMais"><a href="#" onclick="$('.close').click();">Cancelar</a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <?=$this->Form->end();?>
  </div>
  <div class="col-md-6 bg privacidadeS">
    <h3><strong>Privacidade e Segurança</strong></h3>
    <form onsubmit="return false;">
    <div class="row">
      <hr>
        <div class="col-md-4">
            <div class="form-group">
              <input type="text" class="form-control" maxlength="64" id="Senha" placeholder="Senha" required="">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
              <input type="password" class="form-control text-center" maxlength="64" id="Senha" placeholder="******" required="">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
              <h5><a href="<?=$this->Url->build('/minhaconta/perfil/alterarsenha')?>" class="pull-right">Alterar</a></h5>
            </div>
        </div>
        <hr>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
              <h4><strong>Notificações</strong></h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
              <h5 class="text-center">Via E-mail</h5>
            </div>
        </div>
        <div class="col-md-4"></div>
        <hr>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="form-group">
              <label class="radio-inline">
                <input type="checkbox" id="optinNewsletter" name="optradio" <?=$usuario->AceiteComunicacao == 1 ? "checked='checked'" : "" ?> >
                Receber atualizações via E-mail.
              </label>
            </div>
        </div>
        <div class="col-md-3"></div>
        <hr>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">                
                <input type="button" class="bntVer pull-left" value="Salvar alteração">
            </div>
        </div>
    </div>
  </form>
  </div>
</div>


<script type="text/javascript">

  siglaUF = '<?=$usuario->UsuarioPerfil->SiglaUF == null ? 0 : $usuario->UsuarioPerfil->SiglaUF?>';
  codigoCidade = <?=$usuario->UsuarioPerfil->CodigoCidade == null ? 0 : $usuario->UsuarioPerfil->CodigoCidade?>;

  sucesso = '<?=$sucesso?>';
  $(document).ready(function(){
    if(window.location.href.indexOf("sucesso") > -1 || sucesso.length > 0){
      $("#status").show();
    }
  });
</script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/minhaconta/perfil.js" ></script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/cidades.js" ></script>
