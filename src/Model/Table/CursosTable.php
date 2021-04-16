<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CursosTable extends Table
{
	public function initialize(array $config)
    {
		$this->belongsTo('TipoCursos', [
	            'foreignKey' => 'CodigoTipoCurso', 
	            'className' => 'TipoCurso',
	            'propertyName' => 'Tipo']);

		//2017-01-18 Paulo Campos: Adicionado belongsTo Cidades e UF para listar nos cursos no site
		$this->belongsTo('Cidades', [
	            'foreignKey' => 'CodigoCidade', 
	            'className' => 'Cidade',
	            'propertyName' => 'Cidade']);

		$this->belongsTo('UF', [
	            'foreignKey' => 'CodigoUF', 
	            'className' => 'uf',
	            'propertyName' => 'UF']);

	    $this->table('cursos');
	    $this->primaryKey('Codigo');


	}

	public function validationDefault(Validator $validator)
    {
        $validator = new Validator();
        $validator->notEmpty('Nome')->notEmpty('Descricao')->notEmpty('Titulo')->notEmpty('Link');
        return $validator;
    }
}