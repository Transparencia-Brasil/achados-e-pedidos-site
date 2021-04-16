			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Pedido</h2>
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
							<a href='<?=$this->Url->build(["controller" => "Pedidos", "action" => "edit"]);?>' class="btn btn-primary" type="submit">Novo pedido</a>
						</div>
						<div style="margin-top:15px;">
							<form action="/admin/pedidos" method="get">
								<input type="text" name="t" value="<?= (!empty($this->request->query('t'))) ? $this->request->query('t') : '';?>" style="width:800px;" > <input type="submit" name="buscar" value="buscar" class="btn btn-secondary"> 
							</form>
						</div>
						<div >
							<strong>Total de pedidos listados: <?= $this->Paginator->params()['count'] ?> em <?= $this->Paginator->params()['pageCount'] ?> página(s)</strong>
						</div>
						<table class="table table-striped table-bordered bootstrap-datatable">
						  <thead>
							  <tr>
								  <th>Nome</th>
								  <th>Agente</th>
								  <th>Criação</th>
								  <th>Ações</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php foreach($pedidos as $pedido): ?>
							<tr>
								<td><?=$pedido->Titulo ?></td>
								<td><?=$pedido->Agente->Nome ?></td>
								<td class="center"><?=$pedido->Criacao->i18nFormat('dd/MM/Y hh:mm:ss') ?></td>
								<td class="center">
									<a class="btn btn-info" href="<?=$this->Url->build(["controller" => "Pedidos", "action" => "edit", $pedido->Codigo]); ?>" title="Editar">
										<i class="halflings-icon white edit"></i>  
									</a>
									<a class="btn btn-danger btn-excluir" href="<?=$this->Url->build(["controller" => "Pedidos", "action" => "delete", $pedido->Codigo]); ?>" title="Excluir">
										<i class="halflings-icon white trash"></i> 
									</a>
								</td>
							</tr>
							<?php endforeach; ?>
						  </tbody>
					  </table>
					  <div class="pagination">            
					  	<?= $this->Paginator->numbers(array('first' => 'First page')); ?>
					  </div>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->