<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ModeracoesTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('TipoObjeto', [
            'foreignKey' => 'CodigoTipoObjeto', 
            'propertyName' => 'Tipo']);
        $this->belongsTo('StatusModeracao', [
            'foreignKey' => 'CodigoStatusModeracao', 
            'propertyName' => 'Status']);

        $this->table('moderacoes');
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