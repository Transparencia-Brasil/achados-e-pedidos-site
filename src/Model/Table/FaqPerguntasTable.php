<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FaqPerguntasTable extends Table
{

	public function initialize(array $config)
    {
        $this->table('faq_pergunta');
        $this->primaryKey('Codigo');
        $this->belongsTo('FaqCategorias', [
            'foreignKey' => 'CodigoFaqCategoria', 
            'propertyName' => 'FaqCategoria']);

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
        $validator->notEmpty('Pergunta')->notEmpty('CodigoFaqCategoria');
        return $validator;
    }
}


?>