<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class DestaquesHomeTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('TipoDestaquesHome', [
            'foreignKey' => 'CodigoTipoDestaqueHome', 
            'propertyName' => 'Tipo']);

        $this->belongsTo('TipoTarget', 
            ['foreignKey' => 'CodigoTargetTipo', 
            'propertyName' => 'Target']);

        $this->table('destaques_home');
        $this->primaryKey('Codigo');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'Alteracao' => 'always'
                ]
            ]
        ]);

        $this->entityClass('App\Model\Entity\DestaqueHome');
    }

    
    public function validationDefault(Validator $validator)
    {
        $validator = new Validator();
        $validator->notEmpty('Nome')
                   ->notEmpty('CodigoTipoDestaqueHome')
                   ->notEmpty('CodigoTargetTipo')
                   ->notEmpty('Resumo')
                   ->notEmpty('Link')
                   ->notEmpty('Imagem');

        return $validator;
    }
}
?>