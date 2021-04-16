<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\Newsletter;

class NewslettersTable extends Table
{
	public function initialize(array $config)
    {
        $this->table('newsletters');
        $this->primaryKey('Codigo');
        $this->entityClass('App\Model\Entity\Newsletter');

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
        $validator->notEmpty('Nome')->notEmpty('Email');
        return $validator;
    }

}
?>