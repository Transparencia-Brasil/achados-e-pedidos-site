<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsuarioDocumentosTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('Documentos', [
            'foreignKey' => 'CodigoTipoDocumento', 
            'propertyName' => 'TipoDocumento']);

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'CodigoUsuario', 
            'propertyName' => 'Usuario']);

        $this->table('usuarios_documentos');
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
                   ->notEmpty('CodigoDocumento');

        return $validator;
    }
}
?>