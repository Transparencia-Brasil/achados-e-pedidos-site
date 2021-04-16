<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FaqRespostasTable extends Table{
    
    public function initialize(array $config)
    {
        $this->table('faq_resposta');
        $this->primaryKey('Codigo');
        $this->belongsTo('FaqRespostas', [
            'foreignKey' => 'CodigoFaqResposta',
            'propertyName' => 'FaqResposta']);
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