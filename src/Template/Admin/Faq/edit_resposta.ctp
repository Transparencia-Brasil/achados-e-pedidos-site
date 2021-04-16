			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Editando Resposta:</h2>
						<div class="box-icon"></div>
					</div>

					<div class="box-content">
						<div class="alert-error"><?= $this->Flash->render();?></div>
						<?=$this->Form->create($resposta, ['class' => 'form-horizontal']) ?>
						  <fieldset>
						  	<div class="control-group">
							  <label class="control-label" for="CodigoFaqPergunta">Pergunta *</label>
							  <?=$this->Form->hidden('CodigoFaqPergunta', ['value' => $pergunta->Codigo]) ?>
							  <div class="controls">
								<p><?=$pergunta->Pergunta ?></p>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Nome">Resposta *</label>
							  <div class="controls">
								<?=$this->Form->textarea('Resposta', ['class' => 'span6 cleditor']);?>
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