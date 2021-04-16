<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PedidosAnexosTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('PedidosInteracoes', [
            'foreignKey' => 'CodigoPedidoInteracao', 
            'propertyName' => 'PedidoInteracao']);

        $this->table('pedidos_anexos');
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
        $validator->notEmpty('CodigoPedidoInteracao')->notEmpty('Arquivo');

        return $validator;
    }
}
?>