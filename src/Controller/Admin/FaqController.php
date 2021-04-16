<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\FaqCategoria;
use App\Model\Entity\FaqPergunta;
use App\Model\Entity\FaqResposta;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class FaqController extends AppController{

	public function initialize()
	{
		parent::initialize();
		$this->layout = 'admin';
		$this->loadComponent('Flash');
        $this->loadComponent('UData');
	}

	public function index($id = null)
	{
		$conn_faqs = TableRegistry::get('FaqCategorias');

		$faqs = $conn_faqs->find('all')->where(['ativo' => 1])->order(['Criacao' => 'DESC']);
        $this->set('faqs', $faqs);
	}

	public function edit($id = null)
	{
		$conn_faqs = TableRegistry::get('FaqCategorias');

		$faq_categoria = isset($id) ? $conn_faqs->find()->where(['codigo' => $id])->first() : new FaqCategoria();
        
        if ($this->request->is(['post', 'put'])) {
            $conn_faqs->patchEntity($faq_categoria, $this->request->data);

            if($conn_faqs->save($faq_categoria)){
                $this->Flash->success('Categoria salva com sucesso!');
                $this->redirect(array('action' => 'index'));
            }else
            {
                $this->Flash->error('Erro ao salvar usuário!');
            }
        }
        $this->set('faq', $faq_categoria);
	}

	/* Lista as perguntas de uma determinada categoria */
	public function perguntas($idCategoria)
	{
		$conn_faqs = TableRegistry::get('FaqPergunta');
		$faq_perguntas = null;

		if(isset($idCategoria)){

			$faq_perguntas = $conn_faqs->find('all')->where(['CodigoFaqCategoria' => $idCategoria, 'Ativo' => 1])->order(['Criacao' => 'DESC']);;
			$categoria = TableRegistry::get('FaqCategorias')->find()->where(["Codigo" => $idCategoria])->first();
		}else{
			$this->Flash->success('Categoria de FAQ inválida!');
            $this->redirect(array('controller' => 'FaqCategoria', 'action' => 'index'));
            return;
		}

		$this->set('faq_perguntas', $faq_perguntas);
		$this->set('categoria', $categoria);
	}

	/* Lista as respostas de uma determinada pergunta */
	public function respostas($idPergunta)
	{
		$conn_faqs = TableRegistry::get('FaqResposta');
		$faq_respostas = new FaqResposta();

		$pergunta = TableRegistry::get('FaqPergunta')->find()->where(["Codigo" => $idPergunta])->first();

		if(isset($idPergunta)){

			$faq_respostas = $conn_faqs->find('all')->where(['CodigoFaqPergunta' => $idPergunta, 'Ativo' => 1])->order(['Criacao' => 'DESC']);;
			
		}else{
			$this->Flash->success('Pergunta de FAQ inválida!');
            $this->redirect(array('controller' => 'Faq', 'action' => 'perguntas', $idPergunta));
            return;
		}

		$this->set('faq_respostas', $faq_respostas);
		$this->set('pergunta', $pergunta);
	}

	/* edita um elemento do tipo faq_pergunta */
	public function editPergunta($idCategoria, $idPergunta = null)
	{
		$conn_pergunta = TableRegistry::get('FaqPergunta');
		$categorias = TableRegistry::get('FaqCategorias')->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);

		$pergunta = isset($idPergunta) ? $conn_pergunta->find()->where(['codigo' => $idPergunta, 'ativo' => 1])->first() : $conn_pergunta->newEntity();
		
		if ($this->request->is(['post', 'put'])) {
            
            $conn_pergunta->patchEntity($pergunta, $this->request->data);

			if($conn_pergunta->save($pergunta)){
                $this->Flash->success('Pergunta salva com sucesso!');
                $this->redirect(array('action' => 'index', $idCategoria));
            }else
            {
                $this->Flash->error('Erro ao salvar pergunta!');
            }
        }

        $this->set('codigoCategoria', $idCategoria);
		$this->set('categorias', $categorias);
		$this->set('pergunta', $pergunta);
	}

	/* edi um elemento do tipo faq_resposta */
	public function editResposta($idPergunta, $idResposta = null)
	{
		$conn_resposta = TableRegistry::get('FaqResposta');
		$pergunta = TableRegistry::get('FaqPergunta')->find()->where(['codigo' => $idPergunta, 'ativo' => 1])->first();

		$resposta = isset($idResposta) ? $conn_resposta->find()->where(['codigo' => $idResposta])->first() : new FaqResposta();
		
		if ($this->request->is(['post', 'put'])) {
            
            $conn_resposta->patchEntity($resposta, $this->request->data);
            $resposta->Ativo = 1;

            //debug($resposta); die();
            if($conn_resposta->save($resposta)){
                    $this->Flash->success('Resposta salva com sucesso!');
                    $this->redirect(array('action' => 'respostas', $idPergunta));
            }else
            {
                $this->Flash->error('Erro ao salvar resposta!');
            }
        }

		$this->set('pergunta', $pergunta);
		$this->set('resposta', $resposta);
	}

	public function excluir($idCategoria)
	{
		$conn_categoria = TableRegistry::get('FaqCategorias');
		$categoria = null;
        if(isset($idCategoria)){
            $categoria = $conn_categoria->find()->where(['Codigo' => $idCategoria, 'Ativo' => true])->first();
            if($categoria != null){
                $categoria->Ativo = false;
                $conn_categoria->save($categoria);
                $this->Flash->success('Categoria excluída com sucesso.');
            }else{
                $this->Flash->error('Categoria não encontrada.');
            }
        }
        else{
            $this->Flash->error('Id inválido.');
        }

        $this->redirect(array('action' => 'index'));
	}

	public function excluirPergunta($idPergunta)
	{
		$conn = TableRegistry::get('FaqPerguntas');
		$pergunta = null;
        if(isset($idPergunta)){
            $pergunta = $conn->find()->where(['Codigo' => $idPergunta, 'Ativo' => true])->first();
            if($pergunta != null){
                $pergunta->Ativo = false;
                $conn->save($pergunta);
                $this->Flash->success('Pergunta excluída com sucesso.');
            }else{
                $this->Flash->error('Pergunta não encontrada.');
            }
        }
        else{
            $this->Flash->error('Id inválido.');
        }

        $this->redirect(array('action' => 'index'));
	}

	public function excluirResposta($idResposta)
	{
		$conn = TableRegistry::get('FaqRespostas');
		$resposta = null;
        if(isset($idResposta)){
            $resposta = $conn->find()->where(['Codigo' => $idResposta, 'Ativo' => true])->first();
            if($resposta != null){
                $resposta->Ativo = false;
                $conn->save($resposta);
                $this->Flash->success('Resposta excluída com sucesso.');
            }else{
                $this->Flash->error('Resposta não encontrada.');
            }
        }
        else{
            $this->Flash->error('Id inválido.');
        }

        $this->redirect(array('action' => 'index'));
	}
}