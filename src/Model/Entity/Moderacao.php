<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;

class Moderacao extends Entity{
	
	 
	public function Salvar(){

		$conn_moderacao = TableRegistry::get("Moderacoes");

		return $conn_moderacao->save($this);
	}

	public function FoiModerado(){
		$conn_moderacao = TableRegistry::get("Moderacoes");		

		$elemento = $conn_moderacao->find('all')->where(["CodigoTipoObjeto" => $this->CodigoTipoObjeto, "CodigoObjeto" => $this->CodigoObjeto, "CodigoStatusModeracao" => 2])->first();

		return $elemento != null;
	}

	/* insere todos os elementos perdidos na tabela de moderação */
	public function InserirNaoModerados()
	{
		$connection = ConnectionManager::get('default');

		//2017-02-05 Paulo Campos: Inlcusão de IF CodigoTipoOrigem = 3 (Importador de excel). Qualquer pedido que vem de um importador deve ser liberado da moderação automaticamente
		$query = "
			insert into moderacoes (CodigoTipoObjeto, CodigoStatusModeracao, CodigoObjeto)
			select 1 CodigoTipoObjeto, IF(CodigoTipoOrigem = 3, 2, 1) as CodigoStatusModeracao, a.Codigo CodigoObjeto
			from pedidos a
			where
			 a.codigo not in(select CodigoObjeto from moderacoes where CodigoTipoObjeto = 1);

			insert into moderacoes (CodigoTipoObjeto, CodigoStatusModeracao, CodigoObjeto)
			select 2 CodigoTipoObjeto, 1 CodigoStatusModeracao, a.Codigo CodigoObjeto
			from agentes a
			where
			 a.codigo not in(select CodigoObjeto from moderacoes where CodigoTipoObjeto = 2)
			;

			insert into moderacoes (CodigoTipoObjeto, CodigoStatusModeracao, CodigoObjeto)
			select 3 CodigoTipoObjeto, 1 CodigoStatusModeracao, a.Codigo CodigoObjeto
			from usuarios a
			where
			 a.codigo not in(select CodigoObjeto from moderacoes where CodigoTipoObjeto = 3)
			 ;

			insert into moderacoes (CodigoTipoObjeto, CodigoStatusModeracao, CodigoObjeto)
			select 4 CodigoTipoObjeto, 1 CodigoStatusModeracao, a.Codigo CodigoObjeto
			from comentarios a
			where
			 a.codigo not in(select CodigoObjeto from moderacoes where CodigoTipoObjeto = 4)
			 ;
		";

		$results = $connection->execute($query);

    	return $results;
	}

	public function InserirPedidosNaoModerados($CodigoPedido=0)
	{
		$connection = ConnectionManager::get('default');
		$where = "";
		if (!empty($CodigoPedido)) {
			$where = "AND a.Codigo = " . $CodigoPedido;
		}

		//2017-02-05 Paulo Campos: Inlcusão de IF CodigoTipoOrigem = 3 (Importador de excel). Qualquer pedido que vem de um importador deve ser liberado da moderação automaticamente
		$query = "
			insert into moderacoes (CodigoTipoObjeto, CodigoStatusModeracao, CodigoObjeto)
			select 1 CodigoTipoObjeto, IF(CodigoTipoOrigem = 3, 2, 1) as CodigoStatusModeracao, a.Codigo CodigoObjeto
			from pedidos a
			where
			 a.codigo not in(select CodigoObjeto from moderacoes where CodigoTipoObjeto = 1)" . $where .";";

		$results = $connection->execute($query);

    	return $results;
	}

	public function ListarNaoModerados()
	{
		$this->InserirNaoModerados();
		
		$connection = ConnectionManager::get('default');

		$query = "select * from
				(
	
			    select b.Codigo, a.Nome Nome, a.Descricao Texto, a.Slug Slug, b.CodigoObjeto, 1 CodigoTipoObjeto, b.Criacao Criacao, 'Órgão Público' NomeTipo, '/agentes/' Url, a.Nome NomeUsuario
				from agentes a join 
				moderacoes b on a.Codigo = b.CodigoObjeto and b.CodigoStatusModeracao = 1 and CodigoTipoObjeto = 2

				union 

				select b.Codigo, a.Titulo Nome, a.Descricao Texto, a.Slug Slug, b.CodigoObjeto, 2 CodigoTipoObjeto, b.Criacao Criacao, 'Pedido' NomeTipo, '/pedidos/' Url, c.Nome NomeUsuario
				from pedidos  a join 
				moderacoes b on a.Codigo = b.CodigoObjeto and b.CodigoStatusModeracao = 1 and CodigoTipoObjeto = 1
				join usuarios c on a.CodigoUsuario = c.Codigo

				union 

				select b.Codigo, a.Nome Nome, concat(a.Email) Texto, a.Slug Slug, b.CodigoObjeto, 3 CodigoTipoObjeto, b.Criacao Criacao, 'Usuário' NomeTipo, '/usuarios/' Url, a.Nome NomeUsuario
				from usuarios  a join 
				moderacoes b on a.Codigo = b.CodigoObjeto and b.CodigoStatusModeracao = 1 and CodigoTipoObjeto = 3 

				union

				select c.Codigo, concat('Pedido - ', a.Titulo) as Nome, b.Texto, a.Slug Slug, b.CodigoObjeto, 4 CodigoTipoObjeto, b.Criacao Criacao, 'Comentário' NomeTipo, '/pedidos/' Url, d.Nome NomeUsuario
				from pedidos  a join comentarios b on a.Codigo = b.CodigoObjeto join    
				moderacoes c on b.Codigo = c.CodigoObjeto and 		c.CodigoStatusModeracao <> 2 and c.CodigoTipoObjeto = 4
				join usuarios d on a.CodigoUsuario = d.Codigo
			    
			) tb
			order by Criacao desc
			";
		$results = $connection->execute($query)->fetchAll('assoc');

    	return $results;
	}

	public function ListarUsuarioObjetoModeracao($codigoObjeto=0){
		$connection = ConnectionManager::get('default');

		$where = "";
		if (!empty($codigoObjeto)) {
			$where = "AND m.CodigoObjeto = " . $codigoObjeto;
		}

		$query = "select distinct u.codigo as CodigoUsuario,u.Nome as NomeUsuario,u.Email,
						 u.AceiteComunicacao, m.codigoTipoObjeto,
						 m.CodigoStatusModeracao,m.CodigoObjeto,
						 p.codigo,p.slug,p.titulo as TituloPedido FROM moderacoes m 
						 INNER JOIN pedidos p on p.Codigo = m.CodigoObjeto and m.CodigoTipoObjeto = 1
						 INNER JOIN usuarios u on u.Codigo = p.CodigoUsuario
						 WHERE u.AceiteComunicacao = 1
		" . $where ." ORDER BY m.codigoTipoObjeto;";

		$results = $connection->execute($query)->fetch('assoc');

		//var_dump($results);
    	return $results;
	}
}

?>
