<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class Newsletter extends Entity{

	public function Salvar($nome, $email){
		$conn_newsletter = TableRegistry::get('Newsletters');

		$elemento = $conn_newsletter->find()->where(["Email" => $email])->first();

		if($elemento == null){
			$novoItem = new Newsletter();
			$novoItem->Nome = $nome;
			$novoItem->Email = $email;
			$novoItem->Ativo = 1;

			return $conn_newsletter->save($novoItem);
		}else{
			if($elemento->Ativo == 0){
				$elemento->Ativo = 1;

				return $conn_newsletter->save($elemento);
			}
		}

		return true;
	}
}

?>