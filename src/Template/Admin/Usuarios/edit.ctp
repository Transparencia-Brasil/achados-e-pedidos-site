			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Editando Usuário: <?=$usuario->Nome?></h2>
						<div class="box-icon"></div>
					</div>

					<div class="box-content">
						<div class="alert-error"><?= $this->Flash->render();?></div>
						<?=$this->Form->create($usuario, ['class' => 'form-horizontal', 'method' => 'post']) ?>
						  <fieldset>

							<div class="control-group">
							  <label class="control-label" for="Nome">Nome *</label>
							  <div class="controls">
								<?=$this->Form->text('Usuarios.Nome', ['class' => 'span6']);?>
								<?=$this->ValidationText->exibirErro($erros, "Nome"); ?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Link">Documento *</label>
							  <div class="controls">
           						<?=$this->Form->text('Documentos.Valor', ['id' => 'documento', 'class' => 'form-control','maxlength' => 20, 'value' => $documento]) ?>
								<?=$this->ValidationText->exibirErro($erros, "Documento"); ?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Link">E-mail *</label>
							  <div class="controls">
								<?=$this->Form->text('Usuarios.Email', ['class' => 'span6']);?>
								<?=$this->ValidationText->exibirErro($erros, "Email"); ?>
							  </div>
							</div>
<?php
 if (empty($usuario->Codigo)) {
?>
							<div class="control-group">
							  <label class="control-label" for="Link">Senha *</label>
							  <div class="controls">
                  <?=$this->Form->password('Usuarios.Senha', ['id' => 'senha', 'class' => 'form-control', 'maxlength' => 20]) ?>
					       <?=$this->ValidationText->exibirErro($erros, "Senha"); ?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Link">Confirma Senha *</label>
							  <div class="controls">
                  <?=$this->Form->password('Usuarios.ConfirmaSenha', ['id' => 'confirmarSenha', 'class' => 'form-control', 'maxlength' => 20]) ?>
					       <?=$this->ValidationText->exibirErro($erros, "ConfirmaSenha"); ?>
							  </div>
							</div>
<?php
 }
?>
							<div class="control-group">
							  <label class="control-label" for="Link">Nascimento *</label>
							  <div class="controls">
								<?=$this->Form->text('UsuarioPerfil.Nascimento', ['class' => 'span6 datepicker', 'value' => $nascimento]);?>
								<?=$this->ValidationText->exibirErro($erros, "Nascimento"); ?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="CodigoTipoGenero">Gênero</label>
							  <div class="controls">
								<?=$this->Form->select('UsuarioPerfil.CodigoTipoGenero', $generos, ['class' => 'span3', 'id' => 'CodigoTipoGenero', 'value' => $CodigoTipoGenero ]);?>
								<?=$this->ValidationText->exibirErro($erros, "CodigoTipoGenero"); ?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Link">Ocupação *</label>
							  <div class="controls">
								<?=$this->Form->text('UsuarioPerfil.Ocupacao', ['class' => 'span6', 'value' => $ocupacao]);?>
								<?=$this->ValidationText->exibirErro($erros, "Ocupacao"); ?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="CodigoPais">País *</label>
							  <div class="controls">
								<?=$this->Form->select('UsuarioPerfil.CodigoPais', $paises, ['class' => 'span3', 'empty' => 'Selecione', 'id' => 'CodigoPais', 'value' => $CodigoPais]);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="CodigoUF">UF *</label>
							  <div class="controls">
								<?=$this->Form->select('UsuarioPerfil.CodigoUF', [], ['class' => 'span3', 'empty' => 'Selecione um País', 'id' => 'CodigoUF','value' => $CodigoUF]);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="CodigoCidade">Cidade *</label>
							  <div class="controls">
								<?=$this->Form->select('UsuarioPerfil.CodigoCidade', [], ['class' => 'span3', 'empty' => 'Selecione uma UF', 'id' => 'CodigoCidade','value' => $CodigoCidade]);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Link">Bloqueado *</label>
							  <div class="controls">
								<?=$this->Form->checkbox('Usuarios.Bloqueado');?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Link">Aceite de comunicação *</label>
							  <div class="controls">
								<?=$this->Form->checkbox('Usuarios.AceiteComunicacao');?>
							  </div>
							</div>
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Salvar</button>
							  <button type="button" onclick='javascript:history.back(-1);' class="btn">Cancelar</button>
							</div>
						  </fieldset>
						<?=$this->Form->end();?>
					</div>
				</div><!--/span-->

			</div><!--/row-->

<script type="text/javascript">
	console.log("<?=$CodigoPais?> <?=$CodigoUF?> <?=$CodigoCidade?>");
	$("#CodigoPais option[value='<?=$CodigoPais?>']").attr('selected','selected');
	$("#CodigoUF option[value='<?=$CodigoUF?>']").attr('selected','selected');
	$("#CodigoCidade option[value='<?=$CodigoCidade?>']").attr('selected','selected');
	$("#CodigoCidade option[value='<?=$CodigoCidade?>']").attr('selected','selected');
</script>
<?php if(isset($usuario->Perfil)):?>
<script>
	var codigoCidade = <?=is_null($usuario->Perfil->CodigoCidade) ? 0 : $usuario->Perfil->CodigoCidade?>;
	var siglaUF = '<?=$siglaUF?>';
</script>
<?php endif;?>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/cidades.js"></script>
