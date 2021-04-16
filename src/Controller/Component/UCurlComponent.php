<?php

namespace App\Controller\Component;

use Cake\Network\Email\Email;
use Cake\Controller\Component;
use Cake\I18n\Time;
use Cake\Filesystem\File;

class UCurlComponent extends Component
{
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
	  	
	  	$result = curl_exec($ch);
	  	
		curl_close($ch);
	  
	  	return $result;
	}	
}

?>