			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>FAQ - Categoria <?=$categoria->Nome?></h2>
						<div class="box-icon">
							<a href="javascript:void(0);" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div class="messagesList">
							<span class='title'>
								<span class="label label-warning"><?= $this->Flash->render();?></span>
							</span>
						</div>
						<div>
							<a href='<?=$this->Url->build(["controller" => "Faq", "action" => "editPergunta", $categoria->Codigo]);?>' class="btn btn-primary" type="submit">Nova pergunta</a>
						</div>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Nome</th>
								  <th>Ano</th>
								  <th>Criação</th>
								  <th>Ações</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php foreach($faq_perguntas as $pergunta): ?>
							<tr>
								<td><?=$pergunta->Pergunta ?></td>
								<td class="center">
									<span class="label label-success"><?=$this->Ativo->exibirStatus($pergunta->Ativo)?></span>
								</td>
								<td class="center"><?=$pergunta->Criacao->i18nFormat('dd/MM/Y hh:mm:ss') ?></td>
								<td class="center">
									<a class="btn btn-info" href="<?=$this->Url->build(["controller" => "Faq", "action" => "editPergunta", $categoria->Codigo, $pergunta->Codigo]); ?>" title="Editar">
										<i class="halflings-icon white edit"></i>  
									</a>
									<a class="btn btn-success" href="<?=$this->Url->build(["controller" => "Faq", "action" => "respostas", $pergunta->Codigo]); ?>" title="Editar perguntas">
										<i class="halflings-icon white zoom-in"></i>  
									</a>
									<a class="btn btn-danger btn-excluir" href="<?=$this->Url->build(["controller" => "Faq", "action" => "excluirPergunta", $pergunta->Codigo]); ?>" title="Excluir">
										<i class="halflings-icon white trash"></i> 
									</a>
								</td>
							</tr>
							<?php endforeach; ?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->