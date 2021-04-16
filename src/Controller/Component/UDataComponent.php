<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\I18n\Time;

class UDataComponent extends Component
{
    public static function ConverterDataBrasil($data, $hora = false)
    {
    	if($data != null)
    	{

            // 21/02/2018. Mota - comentado pois estava dando o erro:
            // "Error: DateTime::__construct(): Failed to parse time string (15/02/18 00:00) at position 0 (1): Unexpected character"
            // $data = new Time(trim($data));

            $data = new Time($data);
    		$padrao = $hora ? 'dd/MM/yyyy HH:mm:ss' : 'dd/MM/yyyy';
            return $data->i18nFormat($padrao);
    	}
    }

    public static function ConverterMySQL($data)
    {
    	if($data != null)
    	{
    		Time::$defaultLocale = 'pt-BR';
            $data = Time::parseDate(stripslashes($data));
            return $data->i18nFormat('Y-MM-dd HH:mm:ss');
    	}
    }

    public function validateDate($date)
    {
        if(!preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/',$date)){
            return false;
        }

        $data_convertida = UDataComponent::ConverterMySQL($date);
        $d = date_create($data_convertida);

        return $d !== false;
    }
}

?>
