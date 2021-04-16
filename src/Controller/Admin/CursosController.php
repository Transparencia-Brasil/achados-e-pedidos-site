<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Curso;
//2017-01-18 Paulo Campos: Tirando Chamada para não dar erro de dupla declaração. Agora a Tabela UF vem do BelongsTo no CursosTable.php
use App\Model\Entity\UF;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class CursosController extends AppController{

	public function initialize()
	{
		parent::initialize();
		$this->layout = 'admin';
		$this->loadComponent('Flash');
        $this->loadComponent('UData');
        $this->loadComponent('UString');
	}

	public function index()
	{
		$conn = TableRegistry::get("Cursos");

		$cursos = $conn->find('all', ['contain' => ['TipoCursos']])->where(['Cursos.ativo' => 1])->order(['Cursos.Criacao' => 'DESC']);
		
		$this->set('cursos', $cursos);
		
	}

	public function edit($idCurso = null)
	{
		$conn = TableRegistry::get('Cursos');
		$estados = $this->UString->SelectEstados();
		
		$tipos = TableRegistry::get("TipoCursos")->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome'])->where(['ativo' => 1]);
		//2017-01-18 Paulo Campos: alterando relacionamento. Agora a Tabela UF vem do BelongsTo no CursosTable.php
		//$curso = isset($idCurso) ? $conn->find()->where(['codigo' => $idCurso])->first() : new Curso();
		$curso = isset($idCurso) ? $conn->find('all',['contain' => ['UF']])->where(['Cursos.codigo' => $idCurso])->first() : new Curso();
        $siglaUF = '';



		if($curso->CodigoUF > 0)
		{
			//$codigoUF = Cidade::GetCodigoUF($agente->CodigoCidade);
			//2017-01-18 Paulo Campos: Comentado
			// $uf = TableRegistry::get("uf")->find()->where(['Codigo' => $curso->CodigoUF])->first();

			// if($uf != null){
			// 	$siglaUF = $uf->Sigla;
			// }
			$siglaUF = $curso->UF->Sigla;
		}

        if ($this->request->is(['post', 'put'])) {

            $this->Cursos->patchEntity($curso, $this->request->data);

            $curso->CodigoUF = UF::CodigoUFPorSigla($curso->CodigoUF);

            //2017-01-15 Paulo campos: campo uf e cidade na tablea cursos são nulls agora. Eles não sao mais obrigatorios quando o curso é online
            if ($curso->CodigoUF == 0)
            	$curso->CodigoUF = null;

            //debug($curso); die();
            if($this->Cursos->save($curso)){

                $this->Flash->success('Curso salvo com sucesso!');
                $this->redirect(array('action' => 'index'));
            }else
            {
                $this->Flash->error('Erro ao salvar curso!');
            }
        }

        $this->set('siglaUF', $siglaUF);
        $this->set('curso', $curso);
        $this->set('estados', $estados);
        $this->set('tipos', $tipos);
	}

	public function delete($idCurso = null)
	{
		$conn = TableRegistry::get("Cursos");
		$curso = $conn->find('all')->where(['codigo' => $idCurso])->first();
		//debug($curso);die();
		if($curso == null)
		{
			$this->Flash->success('Id de curso inválido!');
			$this->redirect(array('action' => 'index'));
		}else{
			$curso->Ativo = false;
            $conn->save($curso);
            $this->Flash->success('Curso excluído com sucesso.');
		}

		$this->redirect(array('action' => 'index'));
	}

}