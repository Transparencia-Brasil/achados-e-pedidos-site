<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\DestaqueHome;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class DestaquesHomeController extends AppController
{

	public $PASTA_UPLOAD = WWW_ROOT . 'uploads' . DS . 'banners' . DS;

	public function initialize()
	{
		parent::initialize();
		$this->layout = 'admin';
		$this->loadComponent('Flash');
        $this->loadComponent('UData');
	}

	public function index($id = null)
	{
		$destaques = $this->DestaquesHome->find('all')->where(['ativo' => true])->contain(['TipoDestaquesHome'])->order(['DestaquesHome.Criacao' => 'DESC']);
		$this->set('destaques', $destaques);
	}

	public function edit($id = null)
	{
		$destaque = isset($id) ? $this->DestaquesHome->find('all')->where(['codigo' => $id])->first() : new DestaqueHome();
		
        $tipos = TableRegistry::get('TipoDestaquesHome')->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);
		$targets = TableRegistry::get('TipoTarget')->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);

		if ($this->request->is(['post', 'put'])) {
            $arquivoAtual = $destaque->Imagem;
            $this->DestaquesHome->patchEntity($destaque, $this->request->data);
			
            $arquivo = $this->request->data['DestaquesHome']['Imagem'];
            $possuiArquivo = strlen($arquivo['name']) == 0 ? false : true;
            $boolArquivoOk = false;

            if($possuiArquivo){
                $destaque->Imagem = $arquivo['name'];
                $boolArquivoOk = move_uploaded_file($arquivo['tmp_name'], $this->PASTA_UPLOAD . $arquivo['name']);
            }else{
                $destaque->Imagem = $arquivoAtual;
                $destaque->unsetProperty('Imagem');
            }
            
            $destaque->Inicio = $this->UData->ConverterMySQL($destaque->Inicio);
            $destaque->Termino = $this->UData->ConverterMySQL($destaque->Termino);
            // se der erro ao mover o arquivo, retornar mensagem de erro
            if(!$boolArquivoOk && $possuiArquivo)
            {
                $this->Flash->error('Erro ao salvar o arquivo!');
            }else{
                if($destaque->errors())
                    $this->Flash->success('Erro ao salvar destaque. Verifique os campos obrigatórios.');
                else{
                	
                    $destaque->Ativo = 1;
                    if($this->DestaquesHome->save($destaque)){

                        $this->Flash->success('Destaque salvo com sucesso!');
                        $this->redirect(array('action' => 'index'));
                    }else
                    {
                        $this->Flash->error('Erro ao salvar destaque!');
                    }
                }
            }
        }

        if(isset($id) && !$destaque->isNew())
        {
            $destaque->Inicio = !is_null($destaque->Inicio) ? $this->UData->ConverterDataBrasil($destaque->Inicio) : null;
            $destaque->Termino = !is_null($destaque->Termino) ? $this->UData->ConverterDataBrasil($destaque->Termino) : null;
        }

		$this->set('destaque', $destaque);
		$this->set('tipos', $tipos);
		$this->set('targets', $targets);
		
	}

	public function delete($id)
	{
		$destaque = null;
        if(isset($id)){
            $destaque = $this->DestaquesHome->find()->where(['codigo' => $id, 'ativo' => true])->first();
            if($destaque != null){
                $destaque->Ativo = false;
                $this->DestaquesHome->save($destaque);
                $this->Flash->success('Destaque excluído com sucesso.');
            }else{
                $this->Flash->error('Destaque não encontrado.');
            }
        }
        else{
            $this->Flash->error('Id inválido.');
        }

        $this->redirect(array('action' => 'index'));
	}
}

?>