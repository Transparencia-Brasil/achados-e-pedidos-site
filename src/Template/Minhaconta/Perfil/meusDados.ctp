<div>
	<?=$this->Form->create($usuarioPerfil, ['action' => 'index', "id" => "frmPerfil"]) ?>
		
		<?=$this->Form->input('Ocupacao', ['id' => 'nome', 'class' => '']) ?>
		<?=$this->ValidationText->exibirErro($erros, "Nome"); ?>

		<?=$this->Form->input('Documento', ['id' => 'documento', 'class' => '']) ?>
		<?=$this->ValidationText->exibirErro($erros, "Documento"); ?>

		<?=$this->Form->input('Email', ['id' => 'email', 'class' => '']) ?>
		<?=$this->ValidationText->exibirErro($erros, "Email"); ?>
		
		<?=$this->Form->input('Senha', ['id' => 'senha', 'class' => '']) ?>
		<?=$this->ValidationText->exibirErro($erros, "Senha"); ?>

		<?=$this->Form->input('ConfirmarEmail', ['id' => 'confirmarEmail', 'class' => '']) ?>
		<?=$this->ValidationText->exibirErro($erros, "ConfirmarEmail"); ?>

		<?=$this->Form->checkbox('AceiteComunicacao', ['id' => 'AceiteComunicacao', 'class' => '']) ?>
		<span>Aceito comunicações</span>
		<?=$this->Form->checkbox('AceiteRegulamento', ['id' => 'AceiteRegulamento', 'class' => '']) ?>		
		<span>Aceito Regulamento</span>
		<input type="submit" class="btn" value="Finalizar" id="btnFinalizar" />
	<?=$this->Form->end();?>
</div>