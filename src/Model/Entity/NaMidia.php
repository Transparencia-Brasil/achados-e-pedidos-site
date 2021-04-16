<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use App\Controller\Component\UNumeroComponent;
use Cake\Datasource\ConnectionManager;

class NaMidia extends Entity{

	//2017-01-22 Paulo Campos: Constantes criadas para redimensionar as imagens
	// utilizado pelos controllers e views
    const PREFIX_THUMB0 = ""; //769 x 260
    //const PREFIX_THUMB2 = "th2_"; //360 x 199
    //const PREFIX_THUMB3 = "th3_"; //68 x 67

    // const WIDTH_THUMB0 = 772;
    // const HEIGHT_THUMB0 = 508;
		//
    // const WIDTH_THUMB1 = 769;
    // const HEIGHT_THUMB1 = 260;
		//
    // const WIDTH_THUMB2 = 360;
    // const HEIGHT_THUMB2 = 199;
		//
    // const WIDTH_THUMB3 = 68;
    // const HEIGHT_THUMB3 = 68;

	public function Total(){
		$connection = ConnectionManager::get('default');

		$query = 'select count(Codigo) Total from na_midia
			where Ativo = 1 and (InicioExibicao <= current_timestamp and (TerminoExibicao is null or TerminoExibicao >= current_timestamp))';
        //debug($query);die();
		$results = $connection->execute($query)->fetchAll('assoc');

		return $results[0]["Total"];
	}

	public function FiltrarGeral($pagina, $qtd, $slug = "")
	{
		$limite = $qtd > 0 ? " limit " . ($qtd * ($pagina - 1)) . "," . $qtd : "";
		$condicao = strlen($slug) > 0 ? " and (namidia.Slug = '" . $slug . "')" : "";
		$connection = ConnectionManager::get('default');

		$query = 'select namidia.Codigo, namidia.Slug, namidia.NomeInterno, namidia.Titulo, namidia.SubTitulo,
			namidia.HTML, namidia.Link, namidia.Autor, namidia.ImagemResumo,namidia.ImagemThumb,namidia.Publicacao
			from na_midia namidia
			where Ativo = 1 and (InicioExibicao <= current_timestamp and (TerminoExibicao is null or TerminoExibicao >= current_timestamp))' . $condicao . '
		 order by namidia.Publicacao desc ' . $limite;
        //debug($query);die();
		$results = $connection->execute($query)->fetchAll('assoc');

    	return $results;
	}

	public function ListarPorSlug()
	{
		$elemento = $this->FiltrarGeral(1, 1, $this->Slug);

		if(count($elemento) == 0) return null;

		return $elemento[0];
	}

	public function ListarRelacionados()
	{
		$connection = ConnectionManager::get('default');

		$query = 'select namidia.Codigo, namidia.Slug, namidia.NomeInterno, namidia.Titulo, namidia.SubTitulo,
			namidia.HTML, namidia.Link, namidia.Autor, namidia.ImagemResumo, namidia.ImagemThumb, namidia.Publicacao
			from na_midia namidia
			where Ativo = 1 and (InicioExibicao <= current_timestamp and (TerminoExibicao is null or TerminoExibicao >= current_timestamp)) and (slug <> "'. $this->Slug .'")
		 order by namidia.Publicacao desc limit 0, 5';
        //debug($query);die();
		$results = $connection->execute($query)->fetchAll('assoc');

    	return $results;
	}

}

?>
