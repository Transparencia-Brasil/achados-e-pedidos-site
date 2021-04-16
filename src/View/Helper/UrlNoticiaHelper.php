<?php
namespace App\View\Helper;

use Cake\View\Helper;


class UrlNoticiaHelper extends Helper
{

	public function getLink($url,$slug){

		if(empty($url)){

			return '<a href="'.$slug.'" target="_self" class="btnVerPage pull-right">Ver <i class="fa fa-chevron-right" aria-hidden="true"></i></a>';
		}else{
			return '<a href="'.$url.'" target="_blank" class="btnVerPage pull-right">Ver <i class="fa fa-chevron-right" aria-hidden="true"></i></a>';
		}

	}

}
?>
