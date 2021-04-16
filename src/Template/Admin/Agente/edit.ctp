			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Editando Agente: <?=$agente->Nome?></h2>
						<div class="box-icon"></div>
					</div>

					<div class="box-content">
						<div class="alert-error"><?= $this->Flash->render();?></div>
						<?=$this->Form->create($agente, ['class' => 'form-horizontal', 'method' => 'post']) ?>
						  <fieldset>
						  	<div class="control-group">
							  <label class="control-label" for="CodigoPoder">Poder *</label>
							  <div class="controls">
								<?=$this->Form->select('Agentes.CodigoPoder', $poderes, ['class' => 'span3']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="CodigoNivelFederativo">Nível Federativo *</label>
							  <div class="controls">
								<?=$this->Form->select('Agentes.CodigoNivelFederativo', $niveis, ['class' => 'span3']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="CodigoPai">Pai</label>
							  <div class="controls">
								<?=$this->Form->select('Agentes.CodigoPai', $pais, ['class' => 'span3', 'empty' => 'Selecione']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="CodigoPais">País</label>
							  <div class="controls">
								<?=$this->Form->select('CodigoPais', $paises, ['class' => 'span3', 'empty' => 'Selecione', 'id' => 'CodigoPais', 'value' => $codigoPais]);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="CodigoUF">UF</label>
							  <div class="controls">
								<?=$this->Form->select('Agentes.CodigoUF', [], ['class' => 'span3', 'empty' => 'Selecione um País', 'id' => 'CodigoUF']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="CodigoCidade">Cidade</label>
							  <div class="controls">
								<?=$this->Form->select('Agentes.CodigoCidade', [], ['class' => 'span3', 'empty' => 'Selecione uma UF', 'id' => 'CodigoCidade']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Nome">Nome *</label>
							  <div class="controls">
								<?=$this->Form->text('Agentes.Nome', ['class' => 'span6']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Link">Slug *</label>
							  <div class="controls">
								<?=$this->Form->text('Agentes.Slug', ['class' => 'span6']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Link">Link *</label>
							  <div class="controls">
								<?=$this->Form->text('Agentes.Link', ['class' => 'span6']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Resumo">Descrição</label>
							  <div class="controls">
								<?=$this->Form->textarea('Agentes.Descricao', ['class' => 'span6']);?>
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

<script>

	codigoCidade = <?=is_null($agente->CodigoCidade) ? 0 : $agente->CodigoCidade;?>;
	siglaUF = '<?=$siglaUF?>';
</script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/cidades.js"></script>
