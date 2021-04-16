<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsuariosPerfisTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('usuarios', [
            'foreignKey' => 'CodigoUsuario', 
            'propertyName' => 'Usuario']);

        $this->belongsTo('tipo_genero', 
            ['foreignKey' => 'CodigoTipoGenero', 
            'propertyName' => 'Genero']);

        $this->belongsTo('cidade', 
            ['foreignKey' => 'CodigoCidade', 
            'propertyName' => 'Cidade']);

        $this->belongsTo('tipo_ocupacao', 
            ['foreignKey' => 'CodigoTipoOcupacao', 
            'propertyName' => 'TipoOcupacao']);

        $this->table('usuarios_perfis');
        $this->primaryKey('Codigo');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'Alteracao' => 'always'
                ]
            ]
        ]);

        $this->entityClass('App\Model\Entity\UsuarioPerfil');
    }

    
    public function validationDefault(Validator $validator)
    {
        $validator = new Validator();

        return $validator;
    }
}
?>