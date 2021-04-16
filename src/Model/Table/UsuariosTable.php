<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsuariosTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('TipoUsuario', [
            'foreignKey' => 'CodigoTipoUsuario', 
            'propertyName' => 'Tipo']);

        //2017-01-27 Paulo Campos: Criado relacionamento (tabela usuarios_perfis)
        $this->belongsTo('UsuariosPerfis', [
            'foreignKey' => 'CodigoUsuario',
            'propertyName' => 'UsuarioPerfil']);

        //2017-01-27 Paulo Campos: Criado relacionamento
         $this->belongsToMany('Documentos', [
             'alias' => 'Documentos',
             'foreignKey' => 'CodigoUsuario',
             'targetForeignKey' => 'CodigoDocumento',
             'joinTable' => 'usuarios_documentos'
         ]);

        $this->table('usuarios');
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
        $validator->notEmpty('CodigoTipoUsuario')
                   ->notEmpty('Nome')
                   ->notEmpty('Email')
                   ->notEmpty('Senha');

        return $validator;
    }
}
?>