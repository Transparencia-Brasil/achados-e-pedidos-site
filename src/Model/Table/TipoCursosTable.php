<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TipoCursosTable extends Table
{
	public function initialize(array $config)
    {
	    $this->table('tipo_curso');
	    $this->primaryKey('Codigo');

	}

	public function validationDefault(Validator $validator)
    {
        $validator = new Validator();
        $validator->notEmpty('Nome');
        return $validator;
    }
}