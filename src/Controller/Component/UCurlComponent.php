<?php

namespace App\Controller\Component;

use Cake\Network\Email\Email;
use Cake\Controller\Component;
use Cake\I18n\Time;
use Cake\Filesystem\File;
use Cake\Log\Log;

class UCurlComponent extends Component
{

	public static function get($url) {
		$ch = curl_init($url);

		$headers = array('Accept: application/json');

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	  	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	  	curl_setopt($ch, CURLOPT_VERBOSE, true);

        if( ! $result = curl_exec($ch))
        {
            Log::info("CURL ERROR: " . print_r(curl_error($ch), true));
        }

		curl_close($ch);

	  	return $result;
	}

	/*
	http://stackoverflow.com/questions/18647611/posting-json-data-to-api-using-curl
	*/
	public static function enviarDadosJson($url, $dados, $method)
	{
		$ch = curl_init($url);

		$headers = array('Accept: application/json','Content-Type: application/json');

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	  	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  	curl_setopt($ch, CURLOPT_POSTFIELDS,$dados);
	  	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	  	curl_setopt($ch, CURLOPT_VERBOSE, true);

        if( ! $result = curl_exec($ch))
        {
            Log::info("CURL ERROR: " . print_r(curl_error($ch), true));
        }

		curl_close($ch);

	  	return $result;
	}
}

?>
