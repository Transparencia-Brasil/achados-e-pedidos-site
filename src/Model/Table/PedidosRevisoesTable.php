<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PedidosRevisoesTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'CodigoUsuario', 
            'propertyName' => 'Usuario']);

        $this->belongsTo('Pedidos', 
            ['foreignKey' => 'CodigoPedido', 
            'propertyName' => 'Pedido']);

        $this->table('pedidos_revisoes');
        $this->primaryKey('Codigo');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'Alteracao' => 'always'
                ]
            ]
        ]);

        $this->entityClass('App\Model\Entity\PedidoRevisao');
    }
}
?>