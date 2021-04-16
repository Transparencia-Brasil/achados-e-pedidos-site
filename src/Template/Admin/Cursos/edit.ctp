			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Editando Curso</h2>
						<div class="box-icon"></div>
					</div>

					<div class="box-content">
						<div class="alert-error"><?= $this->Flash->render();?></div>
						<?=$this->Form->create($curso, ['class' => 'form-horizontal']) ?>
						  <fieldset>
						  	<div class="control-group">
							  <label class="control-label" for="CodigoTipoCurso">Tipo de Curso *</label>
							  <div class="controls">
								<?=$this->Form->select('CodigoTipoCurso', $tipos ,['class' => 'span6']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Nome">Nome *</label>
							  <div class="controls">
								<?=$this->Form->text('Nome', ['class' => 'span6']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Titulo">Título *</label>
							  <div class="controls">
								<?=$this->Form->text('Titulo', ['class' => 'span6']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Nome">Data *</label>
							  <div class="controls">
								<?=$this->Form->text('DataCurso', ['class' => 'span6 datepicker']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Duracao">Descrição *</label>
							  <div class="controls">
								<?=$this->Form->textarea('Descricao', ['class' => 'span6']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Duracao">Duração *</label>
							  <div class="controls">
								<?=$this->Form->text('Duracao', ['class' => 'span6']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="NumeroAlunos">Número de alunos *</label>
							  <div class="controls">
								<?=$this->Form->text('NumeroAlunos', ['class' => 'span6']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Endereco">Endereço</label>
							  <div class="controls">
								<?=$this->Form->text('Endereco', ['class' => 'span6']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Link">Link *</label>
							  <div class="controls">
								<?=$this->Form->text('Link', ['class' => 'span6']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="CodigoUF">UF</label>
							  <div class="controls">
								<?=$this->Form->select('CodigoUF', $estados, ['empty' => '(Selecione um estado)','id' => 'CodigoUF']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="CodigoCidade">Cidade</label>
							  <div class="controls">
								<?=$this->Form->select('CodigoCidade', null, ['id' => 'CodigoCidade']);?>
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
	codigoCidade = <?=is_null($curso->CodigoCidade) ? 0 : $curso->CodigoCidade;?>;
	siglaUF = '<?=$siglaUF?>';
</script>
<script type="text/javascript" src="<?=BASE_URL?>assets/js/cidades.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#CodigoUF option[value='<?=$siglaUF?>']").attr('selected', 'selected');
		$("#CodigoUF").trigger('change');
	});
</script>