<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TipoAgenteCategoriaTable extends Table
{
	public function initialize(array $config)
    {
        $this->table('tipo_agente_categoria');
        $this->primaryKey('Codigo');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'Alteracao' => 'always'
                ]
            ]
        ]);
    }
}
?>