<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class DestaquesHomeTipoTable extends Table
{

	public function initialize(array $config)
    {
        $this->table('tipo_destaques_home');
        $this->primaryKey('codigo');
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