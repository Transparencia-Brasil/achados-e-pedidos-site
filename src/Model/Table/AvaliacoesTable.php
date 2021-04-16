<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AvaliacoesTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('TipoObjeto', [
            'foreignKey' => 'CodigoTipoObjeto', 
            'propertyName' => 'TipoObjeto']);

        $this->belongsTo('Usuario', 
            ['foreignKey' => 'CodigoUsuario', 
            'propertyName' => 'Usuario']);

        $this->table('avaliacoes');
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
        $validator->notEmpty('Nota')
                   ->notEmpty('CodigoTipoObjeto')
                   ->notEmpty('CodigoUsuario');

        return $validator;
    }
}
?>