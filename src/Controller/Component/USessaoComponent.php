<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\I18n\Time;
use App\Model\Entity\Usuario;

class USessaoComponent extends Component
{
	public static function GetUsuarioFront($request){

		$sessao = $request->session();

		if(isset($sessao) && !empty($sessao)){

			$usuario_array = $sessao->read('Auth.MinhaContaFront');

			if($usuario_array != null){
				$usuario = new Usuario();
				$usuario->Codigo = $usuario_array["id"];

				$usuario_encontrado = $usuario->GetByCodigo();

				return $usuario_encontrado;
			}
		}

		return null;
	}

	public static function GetUsuarioFrontID($request){
		$usuario = USessaoComponent::GetUsuarioFront($request);

		if($usuario != null){
			return $usuario->Codigo;
		}

		return 0;
	}

	public static function EstaLogadoFront($request){
		$sessao = $request->session();

		$usuario_array = $sessao->read('Auth.MinhaContaFront');
		if($usuario_array != null){
			return true;
		}	

		return false;
	}

	public static function LogoutFront($request)
	{
		$request->Auth->sessionKey = 'Auth.MinhaContaFront';
		$request->Auth->user(null);
		$request->Auth->logout();
	}
}

?>