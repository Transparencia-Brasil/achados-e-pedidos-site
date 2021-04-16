<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class NaMidiaTable extends Table{

    public function initialize(array $config)
    {
        $this->table('na_midia');
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
        $validator->notEmpty('NomeInterno')->notEmpty('Titulo')->notEmpty('Subtitulo')->notEmpty('Publicacao')->notEmpty('InicioExibicao');
        return $validator;
    }
}

?>
