<?php
namespace App\Controller;

use Model\Entity\Projeto;
use Cake\ORM\TableRegistry;

class ProjetosController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->set('slug_pai', "projetos");

        $this->loadComponent['Auth'];
    }

	public function index()
    {
    	$tabela = TableRegistry::get('Projetos');
        $projetos = [];
        $ano = -1;

        // separa anos para drop-down
        $year = $tabela->find()->func()->year(['Data' => 'literal']);
        $query = $tabela->find()->select(['anoData' => $year])->distinct(['anoData'])->where(['ativo' => true]);
        $anos = $query->find('list', ['keyField' => 'anoData', 'valueField' => 'anoData'])->order(['Data' => 'Desc']);
        $ano = !isset($this->request->data['ano']) ? 0 : $this->request->data['ano'];

        if ($this->request->is(['post']) && $ano > 0) {
            // faz filtro por ano
        	if($ano != null){
        		$projetos = $tabela->find('all')->contain(['ProjetosArquivo'])->where(['ativo' => true, 'year(Data)' => $ano]);
                $projetos = $projetos->order(['Data' => 'Desc']);
        	}
        }else{
            $projetos = $tabela->find('all')->contain(['ProjetosArquivo'])->where(['ativo' => true]);
        }
        $this->set('ano', $ano);
        $this->set('anos', $anos);
    	$this->set('projetos', $projetos);
    }
}

?>