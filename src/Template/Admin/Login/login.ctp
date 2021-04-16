<h1>Painel de Controle</h1>
<div class="alert-error"><?php echo $this->Flash->render();?></div>
<?= $this->Form->create('User', ['url' => ['prefix' => 'admin', 'controller'=>'Login', 'action'=>'logar']]) ?>
	<div style="margin:0 auto;">
		<fieldset>
			<div>
				<?php 
				echo $this->Form->input('login', ['tabindex' => 1]);
				echo $this->Form->input('senha', ['type' => 'password', 'tabindex' => 1]);
				?>
			</div>
			<div>
				<?= $this->Form->button(__('Login')); ?>
			</div>

		</fieldset>
	</div>

<?= $this->Form->end() ?>