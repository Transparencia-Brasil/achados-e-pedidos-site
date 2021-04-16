<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class NoticiasTable extends Table
{

	public function initialize(array $config)
    {
        $this->belongsTo('StatusConteudo', [
            'foreignKey' => 'CodigoStatusConteudo', 
            'propertyName' => 'Status']);

        $this->table('noticias');
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
        $validator->notEmpty('Nome')->notEmpty('CodigoStatusConteudo')->notEmpty('Slug')
                    ->notEmpty('NomeInterno')->notEmpty('Titulo')
                    ->notEmpty('HTML')->notEmpty('InicioExibicao');
        return $validator;
    }
}
?>