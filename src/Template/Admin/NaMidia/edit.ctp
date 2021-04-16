			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Editando clipping: <?=$namidia->Nome?></h2>
						<div class="box-icon"></div>
					</div>

					<div class="box-content">
						<div class="alert-error"><?= $this->Flash->render();?></div>
						<?=$this->Form->create($namidia, ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) ?>
						  <fieldset>
							<div class="control-group">
							  <label class="control-label" for="Nome">Nome Interno *</label>
							  <div class="controls">
								<?=$this->Form->text('NaMidia.NomeInterno', ['class' => 'span6']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Titulo">Título *</label>
							  <div class="controls">
								<?=$this->Form->text('NaMidia.Titulo', ['class' => 'span6', 'maxLength' => 150, 'id' => 'titulo']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Título">Sub Título *</label>
							  <div class="controls">
								<?=$this->Form->text('NaMidia.Subtitulo', ['class' => 'span6', 'maxLength' => 100, 'id' => 'subtitulo']);?>
								<div class="contador"></div>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="HTML">HTML</label>
							  <div class="controls">
								<?=$this->Form->textarea('NaMidia.HTML', ['class' => 'span6 cleditor', 'maxLength' => 600000, 'id' => 'html']);?>
								<div class="contador"></div>
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="Link">Link </label>
							  <div class="controls">
								<?=$this->Form->text('NaMidia.Link', ['class' => 'span6']);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Publicacao">Data de publicação *</label>
							  <div class="controls">
								<?=$this->Form->text('NaMidia.Publicacao',
									['class' => 'input-xlarge datepicker'],
									['error'=> array('attributes' => ['escape' => false])]
								);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="NaMidia.InicioExibicao">Início exibição *</label>
							  <div class="controls">
								<?=$this->Form->text('NaMidia.InicioExibicao',
									['class' => 'input-xlarge datepicker'],
									['error'=> array('attributes' => ['escape' => false])]
								);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="NaMidia.TerminoExibicao">Término Exibição </label>
							  <div class="controls">
								<?=$this->Form->text('NaMidia.TerminoExibicao',
									['class' => 'input-xlarge datepicker'],
									['error'=> array('attributes' => ['escape' => false])]
								);?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="Arquivo">Imagem de destaque*</label>
							  <div class="controls">
							  	<?php if (isset($namidia->ImagemResumo)): ?>
							  		<p><b>Nome da imagem atual: <a href='<?=$this->Url->build('/uploads/na-midia/'. $namidia->Codigo . '/' . $namidia->ImagemResumo, true)?>' target="_blank"><?=$namidia->ImagemResumo?></a></b></p>
							  	<?php endif; ?>
								<?=$this->Form->file('NaMidia.ImagemResumo', ['class' => 'span6']);?><br>
								<span class="rel-image">*Tamanho recomendado para uma melhor performance: 770x500px</span>
							  </div>
							</div>
							<!-- 2017-01-22 Paulo Campos: Não precisamos mais do upload de um thumb. O sistema gera automaticamente
							<div class="control-group">
							  <label class="control-label" for="Arquivo">Imagem de destaque 2 (tamanho: 360x199) *</label>
							  <div class="controls">
							  	<?php if (isset($namidia->ImagemThumb)): ?>
							  		<p><b>Nome da imagem atual: <a href='<?=$this->Url->build('/uploads/na-midia/'. $namidia->ImagemThumb, true)?>' target="_blank"><?=$namidia->ImagemThumb?></a></b></p>
							  	<?php endif; ?>
								<?=$this->Form->file('NaMidia.ImagemThumb', ['class' => 'span6']);?>
							  </div>
							</div>
							-->
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Salvar</button>
							  <button type="button" onclick='javascript:history.back(-1);' class="btn">Cancelar</button>
							</div>
							<div id="preview" class="columns" style="display:none;">
								<div class="bx-highlight">
		                            <div class="bx-img">
		                                <a href="javascript:void(0);"><img src="<?=BASE_URL?>assets/images/na-midia/img-grande.png" /></a>
		                            </div>
		                            <div class="bx-txt">
		                                <h4 name="titulo">Título</h4>
		                                <p name="subtitulo">Sub Título</p>
		                                <div class="char-limit-2">
		                                    <p name="html">HTML</p>
		                                </div>
		                                <div class="btn-ver">
		                                    <a href="javascript:void(0);" class="btn">Veja Mais</a>
		                                </div>
		                            </div>
		                        </div>
							</div>
						  </fieldset>
						<?=$this->Form->end();?>
					</div>
				</div><!--/span-->

			</div><!--/row-->

			<script type="text/javascript">
				$('#titulo').bind('keypress keyup keydown',function(){
					$('#preview').find('h4[name="titulo"]').html($(this).val());
				}).trigger('keyup');

				$('#subtitulo').bind('keypress keyup keydown',function(){
					$('#preview').find('h4[name="subtitulo"]').html($(this).val());
				}).trigger('keyup');

				$('#html').bind('keypress keyup keydown',function(){
					$('#preview').find('p[name="html"]').html($(this).val());
				}).trigger('keyup');
			</script>
