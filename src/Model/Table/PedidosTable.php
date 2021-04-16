<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PedidosTable extends Table
{
	public function initialize(array $config)
    {

        $this->hasOne('PedidosInteracoes', [
            'foreignKey' => 'CodigoPedido', 
            'propertyName' => 'PedidosInteracoes']);

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'CodigoUsuario', 
            'propertyName' => 'Usuario']);

        $this->belongsTo('Agentes', 
            ['foreignKey' => 'CodigoAgente', 
            'propertyName' => 'Agente']);
        
        $this->belongsTo('StatusPedido', 
            ['foreignKey' => 'CodigoStatusPedido', 
            'propertyName' => 'StatusPedido']);

        $this->table('pedidos');
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
        $validator->notEmpty('CodigoUsuario')
                   ->notEmpty('CodigoAgente')
                   ->notEmpty('CodigoTipoOrigem')
                   ->notEmpty('Titulo')
                   ->notEmpty('Descricao')
                   ->notEmpty('DataEnvio')
                   ->notEmpty('CodigoStatusPedido');
        return $validator;
    }
}
?>