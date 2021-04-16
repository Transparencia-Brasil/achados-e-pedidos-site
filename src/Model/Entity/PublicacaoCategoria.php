<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class PublicacaoCategoria extends Entity{

	public function ListarParaSelect(){
		$conn_categorias = TableRegistry::get('PublicacoesCategoria');
        $categorias = $conn_categorias->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome'])->order(['Nome' => 'Asc']);

        return $categorias;
	}
}

?>