<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class DocumentosTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('TipoDocumento', [
            'foreignKey' => 'CodigoTipoDocumento', 
            'propertyName' => 'TipoDocumento']);

         $this->belongsToMany('Usuarios', [
             'alias' => 'Usuarios',
             'foreignKey' => 'CodigoDocumento',
             'targetForeignKey' => 'CodigoUsuario',
             'joinTable' => 'usuarios_documentos'
         ]);

        $this->table('documentos');
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
        $validator->notEmpty('Nome')
                   ->notEmpty('CodigoTipoDocumento');

        return $validator;
    }
}
?>