			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Pedidos de revisão</h2>
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
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Texto</th>
								  <th>Pedido</th>
								  <th>Usuário</th>
								  <th>Criação</th>
								  <th>Ações</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php foreach($lista as $item): ?>
							<tr>
								<td><?=substr($item->Texto, 0, 50)?>...</td>
								<td><?=substr($item->Pedido->Titulo, 0, 50) ?></td>
								<td><?=$item->Usuario->Nome . " - " . $item->Usuario->Email ?></td>
								<td class="center"><?=$item->Criacao->i18nFormat('dd/MM/Y hh:mm:ss') ?></td>
								<td class="center">
									<a class="btn btn-info" href="<?=$this->Url->build(["controller" => "Pedidos", "action" => "edit", $item->Pedido->Codigo]); ?>" title="Editar" target="_blank">
										<i class="halflings-icon white edit"></i>  
									</a>
									<a class="btn btn-success" href="<?=$this->Url->build(["controller" => "PedidosRevisoes", "action" => "index", $item->Codigo]); ?>" title="Marcar como respondido">
										<i class="halflings-icon white remove"></i> 
									</a>
								</td>
							</tr>
							<?php endforeach; ?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->