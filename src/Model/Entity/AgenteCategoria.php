<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\Time;

class AgenteCategoria extends Entity{
	
	public function Listar($codigoAgente){

		$connection = ConnectionManager::get('default');

		$results = $connection
    		->execute("SELECT distinct a.* FROM tipo_agente_categoria a inner join agentes_categorias b on a.Codigo = b.CodigoAgenteCategoria WHERE b.CodigoAgente = :codigoAgente", ['codigoAgente' => $codigoAgente])
    		->fetchAll('assoc');

    	return $results;
	}
}

?>