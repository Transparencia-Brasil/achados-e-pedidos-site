			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Editando Pergunta: <?=$pergunta->Nome?></h2>
						<div class="box-icon"></div>
					</div>

					<div class="box-content">
						<div class="alert-error"><?= $this->Flash->render();?></div>
						<?=$this->Form->create($pergunta, ['class' => 'form-horizontal']) ?>
						  <fieldset>
						  	<div class="control-group">
							  <label class="control-label" for="CodigoBannerTipo">Categoria *</label>
							  <div class="controls">
								<?=$this->Form->select('FaqPergunta.CodigoFaqCategoria', $categorias, ['class' => 'span3', 'value' => $codigoCategoria]);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Nome">Pergunta *</label>
							  <div class="controls">
								<?=$this->Form->text('FaqPergunta.Pergunta', ['class' => 'span6']);?>
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