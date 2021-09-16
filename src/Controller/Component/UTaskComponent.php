<?php

namespace App\Controller\Component;

use Cake\Network\Email\Email;
use Cake\Controller\Component;
use Cake\I18n\Time;
use Cake\Filesystem\File;
use Cake\Log\Log;

class UTaskComponent extends Component
{
    /**
     * Inicia uma Nova Tarefa em Plano de Fundo
     */
	public static function iniciarTarefa($nome)
	{
        $id = $nome;
        file_put_contents(TMP . "/$id" . ".task", "NEW");

        $cmd = "php ". __DIR__ . "/../../Tasks/$nome.php $id > " . TMP . "/$id.log &";
        exec($cmd);

        return $id;
	}

    /**
     * Verifica se a Tarefa esta rodando
     */
    public static function estaRodando($nome) {
        $pidArq = TMP . "/$nome" . ".pid";

        if(file_exists($pidArq)) {
            $pid = file_get_contents($pidArq);
            if(strlen($pid) > 0)
            {
                return file_exists("/proc/$pid");
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Busca a Situação da Tarefa de Plano de Fundo
     */
    public static function estadoTarefa($nome) {
        $estadoArq = TMP . "/$nome" . ".task";

        if(file_exists($estadoArq)) {
            return file_get_contents($estadoArq);
        } else {
            return "DOWN";
        }
    }
}

?>
