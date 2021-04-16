<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Agente;
use App\Model\Entity\Cidade;
use App\Model\Entity\UF;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class AgenteController extends AppController{

	public function initialize()
	{
		parent::initialize();
		$this->layout = 'admin';
		$this->loadComponent('Flash');
        $this->loadComponent('UData');
	}

	public function index($id = null)
	{
		$agenteBU = new Agente();

		$agentes = $agenteBU->Listar();

		$this->set('agentes', $agentes);
	}

	public function edit($id = null)
	{
		$conn = TableRegistry::get("Agentes");

		$agenteBU = new Agente();
		$agente = isset($id) ? $agenteBU->Listar()->find('all')->where(['Codigo' => $id])->first() : new Agente();

		$poderes = TableRegistry::get('TipoPoder')->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);
		$niveis = TableRegistry::get('TipoNivelFederativo')->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);
		$pais = TableRegistry::get('Agentes')->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome'])->where(['CodigoPai is null']);
		$paises = TableRegistry::get("Pais")->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);
		$siglaUF = '';
		$codigoPais = 0;

		if($agente->CodigoUF > 0)
		{
			//$codigoUF = Cidade::GetCodigoUF($agente->CodigoCidade);
			$uf = TableRegistry::get("uf")->find()->where(['Codigo' => $agente->CodigoUF])->first();

			if($uf != null){
				$siglaUF = $uf->Sigla;

				$codigoPais = UF::GetCodigoPais($uf->Codigo)->Codigo;
			}
		}

		if($this->request->isPost() || $this->request->isPut())
		{
			$conn->patchEntity($agente, $this->request->data);

			if($agente->CodigoUF != null){
				$agente->CodigoUF = UF::CodigoUFPorSigla($agente->CodigoUF);
			}
			//die(debug($agente));
			if($conn->save($agente)){

                $this->Flash->success('Agente salvo com sucesso!');
                $this->redirect(array('action' => 'index'));
            }else
            {
                $this->Flash->error('Erro ao salvar agente!');
            }
		}

		$this->set('agente', $agente);
		$this->set('paises', $paises);
		$this->set('poderes', $poderes);
		$this->set('niveis', $niveis);
		$this->set('siglaUF', $siglaUF);
		$this->set('codigoPais', $codigoPais);
		$this->set('pais', $pais);
	}
}