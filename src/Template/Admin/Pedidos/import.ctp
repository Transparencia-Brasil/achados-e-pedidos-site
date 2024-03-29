			<div class="row-fluid sortable">
				<div class="box">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Pastas importadas na base</h2>
						<div class="box-icon">
							<a href="javascript:void(0);" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table width="40%">
							<tr>
								<td><h2>Total de pastas cadastradas:</h2></td>
								<td><h2><?=$TotalPendentesAnexosPastasES;?></h2></td>
							</tr>
						</table>
						<form action="/admin/pedidos/limparpastas" class="form-horizontal" method="post">
						<div>
						  	<button type="submit" class="btn btn-primary">Limpar pastas</button>
						</div>
						</form>
					</div>
				</div><!--/span-->
				<div class="box">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Pedido</h2>
						<div class="box-icon">
							<a href="javascript:void(0);" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table width="40%">
							<tr>
								<td><h2>Pedidos pendentes de sincronização com o Elastic Search:</h2></td>
								<td><h2><?=$TotalPendentesES;?></h2></td>
							</tr>
							<tr>
								<td><h2>Interações pendentes de sincronização com o Elastic Search:</h2></td>
								<td><h2><?=$TotalPendentesInteracoesES;?></h2></td>
							</tr>
							<tr>
								<td><h2>Anexos pendentes de sincronização com o Elastic Search:</h2></td>
								<td><h2><?=$TotalPendentesAnexosES;?></h2></td>
							</tr>
						</table>

<?php
	if ($estadoIndexacao == "OKAY") {
?>
						<div class="messagesList">
							<span class='title'>
								<span class="label label-success">Pedidos sincronizados com sucesso</span>
							</span>
						</div>
<?php
	}
?>

<?php
	if ( ($estadoIndexacao == "NEW" || $estadoIndexacao == "RUNNING") && $executandoIndexacao) {
?>
						<div class="messagesList">
							<span class='title'>
								<span class="label label-alert"><?php echo $progressoMsg ?></span>
							</span>
						</div>
						<div class="progress progress-striped active">
							<div class="bar" style="width:<?php echo $progressoPerc ?>%"></div>
						</div>
<?php
	}
?>
<?php
	if (!$executandoIndexacao) {
?>
						<?=$this->Form->create($pedidoBU, ['class' => 'form-horizontal']) ?>



						<div>
						  	<button type="submit" class="btn btn-primary">Importar pedidos para o elastic search</button>
						</div>
						<?=$this->Form->end();?>
<?php
	}
    else
    {
?>
<div>
    <button type="button" class="btn btn-primary" onclick="document.location.reload(true);">Atualizar</button>
</div>
<?php
	}
?>

					</div>
				</div><!--/span-->
			</div><!--/row-->
