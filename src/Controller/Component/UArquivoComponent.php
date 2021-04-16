<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\I18n\Time;

class UArquivoComponent extends Component
{
	function reArrayFiles(&$file_post) {

	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);

	    for ($i=0; $i<$file_count; $i++) {
	    	if(strlen($file_post['name'][$i]) == 0)
	    		continue;
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }

	    return $file_ary;
	}
}
?>