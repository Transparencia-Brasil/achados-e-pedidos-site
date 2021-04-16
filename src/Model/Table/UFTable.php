<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
////2017-01-18 Paulo Campos: Alterado nome da Classe
//class UFSTable extends Table
class UFTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('Pais', [
            'foreignKey' => 'CodigoPais', 
            'propertyName' => 'Pais']);

        $this->table('uf');
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