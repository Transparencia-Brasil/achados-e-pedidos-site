<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Core\App;
use App\Controller\Component\UStringComponent;
use App\Controller\Component\UNumeroComponent;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;

class UsuarioRelacionamento extends Entity{

	public function ListarPorTipo(){
		$arrayErros = [];

		$elementos = null;
		switch($this->CodigoTipoObjeto)
		{
			case 1:
				$elementos = ListarUsuariosSeguindo($this->CodigoUsuario); break;
			case 2:
				$elementos = ListarAgentesSeguindo($this->CodigoUsuario); break;
			case 3:
				$elementos = ListarPedidosSeguindo($this->CodigoUsuario); break;
		}


		return $elementos;
	}

	public function TotalSeguindo()
	{
		$connection = ConnectionManager::get('default');

		$results = $connection
    		->execute("
				select distinct count(Nome) Total from(
				select a.Nome Nome, a.Descricao Texto, a.Slug Slug, b.CodigoObjeto, 1 CodigoTipoObjeto, b.Criacao Criacao, 'Órgão Público' NomeTipo, '/agentes/' Url
				from agentes a join 
				usuarios_relacionamentos b on a.Codigo = b.CodigoObjeto and b.CodigoTipoObjeto = 2
				where CodigoUsuario = :codigoUsuario

				union 

				select a.Titulo Nome, a.Descricao Texto, a.Slug Slug, b.CodigoObjeto, 2 CodigoTipoObjeto, b.Criacao Criacao, 'Pedido' NomeTipo, '/pedidos/' Url
				from pedidos  a join 
				usuarios_relacionamentos b on a.Codigo = b.CodigoObjeto and b.CodigoTipoObjeto = 1
				where b.CodigoUsuario = :codigoUsuario

				union 

				select a.Nome Nome, '' Texto, a.Slug Slug, b.CodigoObjeto, 3 CodigoTipoObjeto, b.Criacao Criacao, 'Usuário' NomeTipo, '/usuarios/' Url
				from usuarios  a join 
				usuarios_relacionamentos b on a.Codigo = b.CodigoObjeto and b.CodigoTipoObjeto = 3
				where b.CodigoUsuario = :codigoUsuario
				) tb
				order by Criacao desc", 
				['codigoUsuario' => $this->CodigoUsuario])->fetchAll('assoc');

    	return $results[0]["Total"];
	}

	public function Listar($start, $qtd = 5){
		$connection = ConnectionManager::get('default');

		$limite  = " limit " . $start . "," . $qtd;

		$query = "select distinct * from(
				select a.Codigo, a.Nome Nome, a.Descricao Texto, a.Slug Slug, b.CodigoObjeto, b.CodigoTipoObjeto, b.Criacao Criacao, 'Órgão Público' NomeTipo, '/agentes/' Url
				from agentes a join 
				usuarios_relacionamentos b on a.Codigo = b.CodigoObjeto and b.CodigoTipoObjeto = 2
				where CodigoUsuario = :codigoUsuario

				union 

				select a.Codigo, a.Titulo Nome, a.Descricao Texto, a.Slug Slug, b.CodigoObjeto, b.CodigoTipoObjeto, b.Criacao Criacao, 'Pedido' NomeTipo, '/pedidos/' Url
				from pedidos  a join 
				usuarios_relacionamentos b on a.Codigo = b.CodigoObjeto and b.CodigoTipoObjeto = 1
				where b.CodigoUsuario = :codigoUsuario

				union 

				select a.Codigo, a.Nome Nome, '' Texto, a.Slug Slug, b.CodigoObjeto, b.CodigoTipoObjeto, b.Criacao Criacao, 'Usuário' NomeTipo, '/usuarios/' Url
				from usuarios  a join 
				usuarios_relacionamentos b on a.Codigo = b.CodigoObjeto and b.CodigoTipoObjeto = 3
				where b.CodigoUsuario = :codigoUsuario
				) tb
				order by Criacao desc" . $limite;
		
		$results = $connection
    		->execute($query, 
				['codigoUsuario' => $this->CodigoUsuario])->fetchAll('assoc');

    	return $results;
	}

	public function ListarQuemSegue($start, $qtd = 5){
		$connection = ConnectionManager::get('default');

		$limite  = " limit " . $start . "," . $qtd;

		$results = $connection
    		->execute("
				select 
					distinct a.Codigo, a.Nome Nome, '' Texto, a.Slug Slug, b.CodigoObjeto, b.CodigoTipoObjeto, b.Criacao Criacao, 'Usuário' NomeTipo, '/usuarios/' Url
				from usuarios  a join 
					usuarios_relacionamentos b on a.Codigo = b.CodigoUsuario
				where 
					CodigoObjeto = :codigoUsuario and CodigoTipoObjeto = 3
				order by a.Criacao desc" . $limite, 
				['codigoUsuario' => $this->CodigoUsuario])->fetchAll('assoc');

    	return $results;
	}

	public function TotalQuemSegue(){
		$connection = ConnectionManager::get('default');
		$results = $connection
    		->execute("
				select 
					count(a.Codigo) Total
				from usuarios  a join 
					usuarios_relacionamentos b on a.Codigo = b.CodigoUsuario
				where 
					CodigoObjeto = :codigoUsuario and CodigoTipoObjeto = 3
				order by a.Criacao desc", 
				['codigoUsuario' => $this->CodigoUsuario])->fetchAll('assoc');
    	
    	return $results[0]["Total"];
	}

	/*
	Gera array de elementos genéricos que o usuário segue que são dos tipos
	Usuário, agente ou pedido.
	*/
	public function ListarTodos()
	{
		$lista = null;
		for($x = 1; $x < 4; $x++){
			$this->CodigoTipoObjeto = $x;
			$elementos = $this->ListarPorTipo();

			foreach ($elementos as $elemento) {
				array_push($lista, ["CodigoObjeto" => $elemento->CodigoObjeto, "Nome" => $elemento->Nome, "CodigoTipoObjeto" => $elemento->CodigoTipoObjeto, "Link" => ""]);
			}
		}

		return $lista;
	}

	public function ListarSeguindo($codigoUsuario)
	{
		$connection = ConnectionManager::get('default');
		$results = $connection
    		->execute('select * from usuarios_relacionamentos where CodigoObjeto = :codigoUsuario and CodigoTipoObjeto = 3', ['codigoUsuario' => $codigoUsuario])
    		->fetchAll('assoc');

    	return $results;
	}

	public function ListarSeguidores($codigoUsuario)
	{
		$connection = ConnectionManager::get('default');
		$results = $connection
    		->execute('select * from usuarios_relacionamentos where CodigoObjeto = :codigoUsuario and CodigoTipoObjeto = 3', ['codigoUsuario' => $codigoUsuario])
    		->fetchAll('assoc');

    	return $results;
	}

	public function ListarUsuariosSeguindo($codigoUsuario)
	{
		$connection = ConnectionManager::get('default');
		$results = $connection
    		->execute('SELECT distinct a.* FROM usuarios a WHERE codigo in(select codigoObjeto from usuarios_relacionamentos where CodigoUsuario = :codigoUsuario and CodigoTipoObjeto = 3)', ['codigoUsuario' => $codigoUsuario])
    		->fetchAll('assoc');

    	return $results;
	}

	public function ListarAgentesSeguindo($codigoUsuario)
	{
		$connection = ConnectionManager::get('default');
		$results = $connection
    		->execute('SELECT distinct a.* FROM agentes a WHERE codigo in(select codigoObjeto from usuarios_relacionamentos where CodigoUsuario = :codigoUsuario and CodigoTipoObjeto = 2)', ['codigoUsuario' => $codigoUsuario])
    		->fetchAll('assoc');

    	return $results;
	}

	public function ListarPedidosSeguindo($codigoUsuario)
	{
		$connection = ConnectionManager::get('default');
		$results = $connection
    		->execute('SELECT distinct a.* FROM pedidos a WHERE codigo in(select codigoObjeto from usuarios_relacionamentos where CodigoUsuario = :codigoUsuario and CodigoTipoObjeto = 1)', ['codigoUsuario' => $codigoUsuario])
    		->fetchAll('assoc');

    	return $results;
	}

	// se já estiver seguindo, deixa de seguir,do contrário, começa a seguir.
	public function ToggleSeguir()
	{
		$conn_usuario_relacionamento = TableRegistry::get("UsuariosRelacionamentos");

		$elemento = $conn_usuario_relacionamento->find()->where(["CodigoObjeto" => $this->CodigoObjeto, "CodigoTipoObjeto" => $this->CodigoTipoObjeto, "CodigoUsuario" => $this->CodigoUsuario])->first();

		if($elemento == null){
			return $conn_usuario_relacionamento->save($this);
		}else{
			return $conn_usuario_relacionamento->delete($elemento);
		}
	}

	public function Salvar(){

		$elemento = Listar();
		$conn_usuario_relacionamento = TableRegistry::get("UsuariosRelacionamentos");

		if($elemento != null)
		{
			return $conn_usuario_relacionamento->save($this);
		}

		return false;
	}

	public function Remover(){
		
		$elementos = Listar();
		$conn_usuario_relacionamento = TableRegistry::get("UsuariosRelacionamentos");

		$elemento = $elementos->find()->where(["CodigoObjeto" => $this->CodigoObjeto])->first();
		if($elemento != null){
			return $conn_usuario_relacionamento->delete($this);
		}

		return false;
	}

	public function TotalSeguindoPedido(){
		$connection = ConnectionManager::get('default');
		$results = $connection
    		->execute('select
					count(1) Total
				from
					usuarios_relacionamentos
				where
					CodigoTipoObjeto = 1 and CodigoObjeto = :CodigoObjeto', ['CodigoObjeto' => $this->CodigoObjeto])
    		->fetchAll('assoc');

    	return $results[0]["Total"];
	}

	public function EstaSeguindoObjeto()
	{
		$conn = TableRegistry::get("UsuariosRelacionamentos");

		$elemento = $conn->find('all')->where(["CodigoUsuario" => $this->CodigoUsuario, "CodigoObjeto" => $this->CodigoObjeto, "CodigoTipoObjeto" => $this->CodigoTipoObjeto])->first();
		
		return $elemento != null;
	}

	public function TotalMeuFeed()
	{
		$connection = ConnectionManager::get('default');
		$query = "select count(*) Total From (

			-- Usuário que sigo seguiu um pedido
			select distinct
				user.Codigo, user.Nome, user.Slug,
			    1 TipoFeed,
			    ur2.Criacao
			from
			    usuarios_relacionamentos ur join
			    usuarios_relacionamentos ur2 on ur.CodigoObjeto = ur2.CodigoUsuario and ur2.CodigoTipoObjeto = 1 join
			    usuarios user on user.Codigo = ur2.CodigoUsuario
			where
				ur.CodigoUsuario = :CodigoUsuario and ur.CodigoTipoObjeto = 3 	

			union 

			-- Usuário que sigo atualizou um pedido
			select distinct
				user.Codigo, user.Nome, user.Slug,
			    2 TipoFeed,
			    pi.Criacao
			from
			    usuarios_relacionamentos ur join
			    usuarios_relacionamentos ur2 on ur.CodigoObjeto = ur2.CodigoUsuario and ur2.CodigoTipoObjeto = 1 join
			    pedidos pedido on ur2.CodigoUsuario = pedido.CodigoUsuario join
			    pedidos_interacoes pi on pedido.Codigo = pi.CodigoPedido join
			    usuarios user on user.Codigo = ur2.CodigoUsuario
			where
				ur.CodigoUsuario = :CodigoUsuario and ur.CodigoTipoObjeto = 3
			    
			union

			-- Usuário que sigo inseriu um pedido
			select distinct
				user.Codigo, user.Nome, user.Slug,
			    3 TipoFeed,
			    pedido.Criacao
			from
			    usuarios_relacionamentos ur join
			    usuarios_relacionamentos ur2 on ur.CodigoObjeto = ur2.CodigoUsuario and ur2.CodigoTipoObjeto = 1 join
			    pedidos pedido on ur2.CodigoUsuario = pedido.CodigoUsuario join
			    usuarios user on user.Codigo = ur2.CodigoUsuario
			where
				ur.CodigoUsuario = :CodigoUsuario and ur.CodigoTipoObjeto = 3
			    
			) tb
			order by Criacao desc";
		$results = $connection
    		->execute($query, ['CodigoUsuario' => $this->CodigoUsuario])
    		->fetchAll('assoc');

    	return $results[0]["Total"];
	}

	public function MeuFeed($start, $qtd)
	{
		$connection = ConnectionManager::get('default');
		$limite = "";
		if($qtd > 0)
			$limite = " limit " . $start . "," . $qtd;
		$query = "select distinct Codigo, NomeUsuario, SlugUsuario, NomePedido, SlugPedido, TipoFeed, Criacao From (

			-- Usuário que sigo seguiu um pedido
			select distinct
				user.Codigo, user.Nome NomeUsuario, user.Slug SlugUsuario,
			    1 TipoFeed,
			    pedido.Titulo NomePedido, pedido.Slug SlugPedido,
			    ur2.Criacao
			from
			    usuarios_relacionamentos ur join
			    usuarios_relacionamentos ur2 on ur.CodigoObjeto = ur2.CodigoUsuario and ur2.CodigoTipoObjeto = 1 join
			    usuarios user on user.Codigo = ur2.CodigoUsuario join 
			    pedidos pedido on ur2.CodigoObjeto = pedido.Codigo
			where
				ur.CodigoUsuario = 1 and ur.CodigoTipoObjeto = 3 	

			union 

			-- Usuário que sigo atualizou um pedido
			select distinct
				user.Codigo, user.Nome NomeUsuario, user.Slug SlugUsuario,
			    2 TipoFeed,
			    pedido.Titulo NomePedido, pedido.Slug SlugPedido,
			    pi.Criacao
			from
			    usuarios_relacionamentos ur join
			    usuarios_relacionamentos ur2 on ur.CodigoObjeto = ur2.CodigoUsuario and ur2.CodigoTipoObjeto = 1 join
			    pedidos pedido on ur2.CodigoUsuario = pedido.CodigoUsuario join
			    pedidos_interacoes pi on pedido.Codigo = pi.CodigoPedido join
			    usuarios user on user.Codigo = ur2.CodigoUsuario
			where
				ur.CodigoUsuario = 1 and ur.CodigoTipoObjeto = 3
			    
			union

			-- Usuário que sigo inseriu um pedido
			select distinct
				user.Codigo, user.Nome NomeUsuario, user.Slug SlugUsuario,
			    3 TipoFeed,
			    pedido.Titulo NomePedido, pedido.Slug SlugPedido,
			    pedido.Criacao
			from
			    usuarios_relacionamentos ur join
			    usuarios_relacionamentos ur2 on ur.CodigoObjeto = ur2.CodigoUsuario and ur2.CodigoTipoObjeto = 1 join
			    pedidos pedido on ur2.CodigoUsuario = pedido.CodigoUsuario join
			    usuarios user on user.Codigo = ur2.CodigoUsuario
			where
				ur.CodigoUsuario = 1 and ur.CodigoTipoObjeto = 3
			    
			) tb
			order by Criacao desc" . $limite;
		$results = $connection
    		->execute($query, ['CodigoUsuario' => $this->CodigoUsuario])
    		->fetchAll('assoc');

    	return $results;
	}
}

?>