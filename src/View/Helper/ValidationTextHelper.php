<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;

class ValidationTextHelper extends Helper
{
    public function exibirErro($arrayErro, $nome)
    {
        if(count($arrayErro) > 0)
        {
        	if(array_key_exists($nome, $arrayErro))
        		return "<span class='error'>" . $arrayErro[$nome] . "</span>";
        }

        return "";
    }
}
?>