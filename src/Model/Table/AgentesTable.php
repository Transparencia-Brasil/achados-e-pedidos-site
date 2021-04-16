<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AgentesTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('TipoPoder', [
            'foreignKey' => 'CodigoPoder', 
            'propertyName' => 'TipoPoder']);

        $this->belongsTo('TipoNivelFederativo', 
            ['foreignKey' => 'CodigoNivelFederativo', 
            'propertyName' => 'TipoNivelFederativo']);

        $this->belongsTo('Uf', 
            ['foreignKey' => 'CodigoUf', 
            'propertyName' => 'Uf']);

        $this->table('agentes');
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
        $validator->notEmpty('Nome')
                   ->notEmpty('Descricao')
                   ->notEmpty('CodigoPoder')
                   ->notEmpty('CodigoNivelFederativo');

        return $validator;
    }
}
?>