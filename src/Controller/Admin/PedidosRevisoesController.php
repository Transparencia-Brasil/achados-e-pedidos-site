<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Pedido;
use App\Model\Entity\PedidoInteracao;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class PedidosRevisoesController extends AppController{

	public function initialize()
	{
		parent::initialize();
		$this->layout = 'admin';
		$this->loadComponent('Flash');
        $this->loadComponent('UData');
	}

	public function index($id = null)
	{
		$lista = $this->PedidosRevisoes->find('all')->where(['PedidosRevisoes.Respondido' => 0])->contain(['Pedidos', 'Usuarios'])->order(['PedidosRevisoes.Criacao' => 'DESC']);
		$this->set('lista', $lista);

		if($id != null){
			$elemento = $this->PedidosRevisoes->find()->where(['Codigo' => $id])->first();

			if($elemento != null)
			{
				$elemento->Respondido = 1;

				if($this->PedidosRevisoes->save($elemento)){
					$this->Flash->success('Revisão atualizada!');
				}else
				{
					$this->Flash->error('Erro ao salvar revisão');
				}
			}else{
				$this->Flash->error('Revisão não encontrada.');
			}
		}
		
	}

}