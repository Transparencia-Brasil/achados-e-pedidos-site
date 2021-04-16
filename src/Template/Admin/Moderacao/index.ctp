			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Moderação</h2>
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
						<?php
						if(count($lista) == 0)
						{
							echo "<p>Não há elementos para moderar.</p>";
						}

						foreach($lista as $elemento):

							$descricao = $elemento["Texto"];
							$descricao = strlen($descricao) > 400 ? substr($descricao, 0, 400) . "..." : $descricao;
						?>
						<div style="width:400px;border:solid 1px black;padding:20px;margin:5px;float:left;min-height: 350px;" data-val="<?=$elemento["Codigo"]?>">
							<div class="elementoModeracao">
								<p><strong>Tipo</strong>: <?=$elemento["NomeTipo"]?></p>
								<p><strong>Nome</strong>: <?=$elemento["Nome"]?></p>
								<p><strong>Código de identificação</strong>: <?=$elemento["Codigo"]?></p>
								<?php if($elemento["NomeTipo"] =="Pedido" ){	?>
									<p><strong>Nome do Usuário</strong>: <?=$elemento["NomeUsuario"]?></p>
								<?php }?>
								<p><strong>Descrição</strong>:</p>
								<div>
									<p><?=$elemento["Texto"]?></p>
								</div>
								<p><strong>Criação</strong>: <?=date("d/m/Y H:i:s", strtotime($elemento["Criacao"]))?></p>
								<div>
									<?php 
									// não exibe botão editar para comentário
									if($elemento["CodigoTipoObjeto"] != 4):
									?>
										<a href="<?=BASE_URL . 'admin' . $elemento["Url"] . 'edit/' . $elemento["CodigoObjeto"]?>" target="_blank"><input type="button" value="Editar" /></a>
									<?php endif;?>
									<input type="button" value="Aprovar" onclick="moderar(<?=$elemento["Codigo"]?>, 2)" />
									<input type="button" value="Reprovar" onclick="moderar(<?=$elemento["Codigo"]?>, 3)" />
									<?php 
									// exibe botão apenas para pedidos
									if($elemento["CodigoTipoObjeto"] == 1):
									?>
										<input type="button" value="Aprovar todos para este usuário" name="aprovarTudo" onclick="moderar(<?=$elemento["Codigo"]?>, 1)" /><br/><br/>
									<?php endif;?>
								</div>
								<span class="retorno" style="color:red;font-weight: bold;"></span>
							</div>
						</div>
						<?php
						endforeach;
						?>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

<script type="text/javascript" src="<?=BASE_URL?>admin/js/moderacao.js"></script>