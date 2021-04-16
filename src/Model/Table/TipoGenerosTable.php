<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TipoGenerosTable extends Table
{

	public function initialize(array $config)
    {
        $this->table('tipo_genero');
        $this->primaryKey('Codigo');
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'Alteracao' => 'always'
                ]
            ]
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator = new Validator();
        $validator->notEmpty('Nome');
        return $validator;
    }
}
?>