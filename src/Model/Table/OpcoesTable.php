<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OpcoesTable extends Table
{
	public function initialize(array $config)
    {
        $this->table('opcoes');
        $this->primaryKey('Codigo');
    }

    
    public function validationDefault(Validator $validator)
    {
        $validator = new Validator();
        $validator->notEmpty('Chave')
                   ->notEmpty('Valor');

        return $validator;
    }
}
?>