<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PedidosInteracoesTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('Pedidos', [
            'foreignKey' => 'CodigoPedido', 
            'propertyName' => 'Pedido']);

        $this->hasMany('PedidosAnexos', [
            'foreignKey' => 'CodigoPedidoIntercao', 
            'propertyName' => 'Pedido']);

        $this->belongsTo('TipoPedidoResposta', [
            'foreignKey' => 'CodigoTipoPedidoResposta', 
            'propertyName' => 'TipoResposta']);

        $this->table('pedidos_interacoes');
        $this->primaryKey('Codigo');

        $this->entityClass('App\Model\Entity\PedidoInteracao');
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
        $validator->notEmpty('CodigoPedido')
                   ->notEmpty('DataResposta')
                   ->notEmpty('Descricao');
    //     $validator->add('Descricao', [
    //         'required' => [
    //             'rule' => 'notEmpty',
    //             'message' => 'sadsadssad adsdassa'
    //         ]
    //    ]);

        return $validator;
    }
}
?>