<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CidadesTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('UF', [
            'foreignKey' => 'CodigoUF', 
            'propertyName' => 'UF']);

        $this->table('cidade');
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