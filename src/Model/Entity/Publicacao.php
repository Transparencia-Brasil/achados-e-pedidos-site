<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use App\Controller\Component\UStringComponent;
use App\Controller\Component\UNumeroComponent;
use Cake\Datasource\ConnectionManager;

class Publicacao extends Entity{

	public function TotalPublicacao(){
		$connection = ConnectionManager::get('default');

		$query = 'select count(Codigo) Total from publicacoes
			where Ativo = 1';
        //debug($query);die();
		$results = $connection->execute($query)->fetchAll('assoc');

		return $results[0]["Total"];
	}

	public function ListarAnosParaSelect(){
		$conn_Publicacoes = TableRegistry::get('Publicacoes');
        // separa anos para drop-down
        $year = $conn_Publicacoes->find()->func()->year(['DataPublicacao' => 'literal']);
        $query = $conn_Publicacoes->find()->select(['anoData' => $year])->distinct(['anoData'])->where(['ativo' => true]);
        $anos = $query->find('list', ['keyField' => 'anoData', 'valueField' => 'anoData'])->order(['DataPublicacao' => 'Desc']);

        return $anos;
	}

	public function Filtrar($data, $pagina, $qtd = 30)
	{

		$limite = $qtd > 0 ? " limit " . ($qtd * ($pagina - 1)) . "," . $qtd : "";

		if($data == null || count($data) == 0){
			$busca = "";
			$categoria = 0;
			$ano = 0;
		}else{
			$busca = UStringComponent::AntiXSSEmArrayComLimite($data, "busca", 100);
			$categoria = UNumeroComponent::ValidarNumeroEmArray($data,"CodigoCategoria");
			$ano = UNumeroComponent::ValidarNumeroEmArray($data,"Ano");
		}

		return $this->FiltrarGeral($busca, $categoria, $ano, $limite);
	}

	public function FiltrarGeral($busca, $categoria, $ano, $limite)
	{
		$connection = ConnectionManager::get('default');

		$condicao = strlen($busca) > 0 ? " and (publicacao.Nome like '%" . $busca . "%' or publicacao.Descricao like '%" . $busca . "%' or publicacao.PalavrasChave like '%" . $busca . "%')" : "";
		$condicao .= $categoria > 0 ? " and (publicacao.CodigoCategoria = ".$categoria.")" : "";
		$condicao .= $ano > 0 ? " and (year(publicacao.DataPublicacao) = ".$ano.")" : "";

		$query = 'select publicacao.Codigo,
			publicacao.Nome, publicacao.Descricao, publicacao.DataPublicacao, publicacao.Arquivo,
			publicacao.PalavrasChave,publicacao.Ativo, publicacao.Link, categoria.Nome NomeCategoria
			from publicacoes publicacao join
			publicacoes_categoria categoria on publicacao.CodigoCategoria = categoria.Codigo
			where Ativo = 1
		' . $condicao . ' order by publicacao.DataPublicacao desc' . $limite;
        //debug($query);die();
		$results = $connection->execute($query)->fetchAll('assoc');

    	return $results;
	}


	public function FiltrarPorBusca($busca)
	{
		if(strlen($busca) == 0 || !isset($busca) || empty($busca))
    	{
    		return null;
    	}else{
    		$conn_Publicacoes = TableRegistry::get('Publicacoes');
    		$retorno = $conn_Publicacoes->find('all')
    					->orWhere(['Descricao LIKE' => '%'.$busca.'%'])->orWhere(['Nome LIKE' => '%'.$busca.'%'])
                        ->orWhere(['PalavrasChave LIKE' => '%'.$busca.'%'])
                        ->andwhere(['ativo' => 1]);

            return $retorno;
    	}
	}

	public function FiltrarPorAnoOuCategoria($categoria, $ano)
	{
        $retorno = "";
        if($ano <= 0)
        {
            return null;
        }else{
            $conn_Publicacoes = TableRegistry::get('Publicacoes');
            $retorno = $conn_Publicacoes->find('all')
                        ->where(['ativo' => true, "year(DataPublicacao)" => $ano]);
            
            if($categoria > 0)
                $retorno = $retorno->where(["CodigoCategoria" => $categoria]);
        }
	}
}

?>
