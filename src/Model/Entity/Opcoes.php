<?php


namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;
use App\Controller\Component\UStringComponent;
use App\Controller\Component\UNumeroComponent;
use App\Model\Table\OpcoesTable;

class Opcoes extends Entity
{
    public static function Mudar($chave, $valor)
    {
        $conn_opcoes = TableRegistry::get("Opcoes");
        $opcao = $conn_opcoes->find()->where(['Chave' => $chave])->first();

        if ($opcao == null) {
            $opcao = new Opcoes();
        }

        $opcao->Chave = $chave;
        $opcao->Valor = $valor;
        $table = new OpcoesTable();
        return $table->save($opcao);
    }

    public static function Ler($chave, $padrao = null)
    {
        $conn_opcoes = TableRegistry::get("Opcoes");
        $opcao = $conn_opcoes->find()->where(['Chave' => $chave])->first();

        if ($opcao !== null) {
            return $opcao->Valor;
        }

        return $padrao;
    }
}
