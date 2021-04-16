<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Usuario;
use App\Model\Entity\Documento;
use App\Model\Entity\Cidade;
use App\Model\Entity\UF;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
//2017-01-27 Paulo Campos Classes adicionada
use App\Model\Entity\UsuarioPerfil;
use Cake\Auth\DefaultPasswordHasher;

class UsuariosController extends AppController{

	public function initialize()
	{
		parent::initialize();
		$this->layout = 'admin';
		$this->loadComponent('Flash');
        $this->loadComponent('UData');
	}

	public function index($id = null)
	{
		$usuarios = TableRegistry::get("Usuarios")->find('all')->where(['Ativo' => 1]);

		$this->set('usuarios', $usuarios);
	}

	public function edit($id = null)
	{
		$erros = [];
		$ocupacao = "";
		$nascimento =  "";
		$documento = "";
		$CodigoPais = 33; //Selecao Default Brasil
		$CodigoUF = "";
		$CodigoCidade = "";
		$CodigoTipoGenero = "";

		//$usuario = isset($id) ? $this->Usuarios->find('all')->where(['Codigo' => $id])->first() : new Usuario();
		//debug($this->Usuarios->find()->where(["Codigo"=>$id])->contain('Documentos')->first());
		$usuario = isset($id) ? $this->Usuarios->find('all')->contain('Documentos')->where(["Usuarios.Codigo"=>$id])->first() : new Usuario();
		$paises = TableRegistry::get("Pais")->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);
		$siglaUF = '';

		if($usuario->Codigo > 0)
		{
			$perfil = TableRegistry::get("UsuariosPerfis")->find('all')->where(["CodigoUsuario" => $usuario->Codigo])->contain(['tipo_ocupacao'])->first();

			if($perfil != null && !is_null($perfil->CodigoCidade)){

				$codigoUF = Cidade::GetCodigoUF($perfil->CodigoCidade);
				$uf = TableRegistry::get("uf")->find()->where(['Codigo' => $codigoUF])->first();

				if($uf != null){
					$siglaUF = $uf->Sigla;

					$CodigoPais = UF::GetCodigoPais($uf->Codigo)->Codigo;
				}
			}

			$usuario->Perfil = $perfil;
		}

		if($this->request->isPost() || $this->request->isPut())
		{

			$usuario_post = new Usuario();
			$this->Usuarios->patchEntity($usuario_post, $this->request->data);

			$documento_post = new Documento();
			$this->Usuarios->Documentos->patchEntity($documento_post, $this->request->data);

			$DocValor = (!empty($usuario["documentos"][0]->Valor)) ? $usuario["documentos"][0]->Valor : "";
			$EmailAtual = (!empty($usuario->Email)) ? $usuario->Email : "";
			$erros = $usuario->ValidarCadastroViaAdmin($this->request->data,$usuario->Codigo,$EmailAtual,$DocValor);

			$data = $this->request->data;
			$perfil_post = new UsuarioPerfil();
			$this->Usuarios->usuariosperfis->patchEntity($perfil_post, $data);

            if(count($erros) == 0)
            {
            	if (!empty($usuario->Codigo))
            		$usuario_post->Codigo = $usuario->Codigo;

				$usuario_post->CodigoTipoUsuario = 1; // usuário padrão
				$documento = new Documento();
				$usuario_post->Slug = $usuario->GerarSlug($usuario_post["Email"]);
				$usuario_post->Senha = (new DefaultPasswordHasher)->hash($usuario_post["Senha"]);

				if($returnUsuario = $this->Usuarios->save($usuario_post)){
					//2017-01-27 Paulo Campos: Inclusão/atualização de documento (CPF ou CNPJ)
					if (empty($usuario->Codigo)) {
						$codigoDocumento = $documento->InserirNovoDocumento($documento_post->Valor, $usuario->CodigoTipoDocumento);
						if($codigoDocumento > 0) {
	            			$codigoUsuarioDocumento = $documento->InserirUsuarioDocumento($codigoDocumento, $returnUsuario->Codigo);
	            		}
	            	} else {
	            		$codigoDocumento = $documento->AtualizaDocumento($usuario["documentos"][0]->Codigo,$documento_post->Valor,$usuario->CodigoTipoDocumento);
	            	}

					//2017-01-27 Paulo Campos: Inclusão/atualização de dados do perfil
		            $usuarioPerfil = new UsuarioPerfil();
		            $usuarioPerfil->CodigoUsuario = $usuario->Codigo;

		            $errosPerfil = $usuarioPerfil->ValidarPerfilMinhaConta($data);
		            if(count($errosPerfil) == 0){
		             	$usuarioPerfil->AtualizarPerfilPeloAdmin($perfil_post,$returnUsuario->Codigo);
		            }

	                $this->Flash->success('Usuário salvo com sucesso!');
	                $this->redirect(array('action' => 'index'));
	            }else
	            {
	                $this->Flash->error('Erro ao salvar usuário!');
	            }
	        }
			if (isset($perfil_post["UsuarioPerfil"]["CodigoUF"]))
				$CodigoUF = $perfil_post["UsuarioPerfil"]["CodigoUF"];

			if (isset($perfil_post["UsuarioPerfil"]["CodigoCidade"]));
				$CodigoCidade = $perfil_post["UsuarioPerfil"]["CodigoCidade"];
		}

		$generos = TableRegistry::get("TipoGeneros")->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);
		$ocupacaoNome =  isset($usuario->Perfil->TipoOcupacao->Nome) ? $usuario->Perfil->TipoOcupacao->Nome : "";
		$perfilNascimento =  isset($usuario->Perfil->Nascimento) ? date('d/m/Y', strtotime($usuario->Perfil->Nascimento)) : "";
		$documentoValor =  isset($usuario->documentos[0]->Valor) ? $usuario->documentos[0]->Valor : "";
		$perfilGenero =  isset($usuario->Perfil->CodigoTipoGenero) ? $usuario->Perfil->CodigoTipoGenero : "";

		$ocupacao = isset($perfil_post["UsuarioPerfil"]["Ocupacao"]) ? $perfil_post["UsuarioPerfil"]["Ocupacao"] : $ocupacaoNome;
		$nascimento = isset($perfil_post["UsuarioPerfil"]["Nascimento"]) ? $perfil_post["UsuarioPerfil"]["Nascimento"] : $perfilNascimento;
		$documento = isset($documento_post->Valor) ? $documento_post->Valor : $documentoValor;
		$CodigoPais = isset($perfil_post["UsuarioPerfil"]["CodigoPais"]) ? $perfil_post["UsuarioPerfil"]["CodigoPais"] : $CodigoPais;
		$CodigoTipoGenero = isset($perfil_post["UsuarioPerfil"]["CodigoTipoGenero"]) ? $perfil_post["UsuarioPerfil"]["CodigoTipoGenero"] : $perfilGenero;

		$this->set('usuario', $usuario);
		$this->set('generos', $generos);
		$this->set('CodigoTipoGenero', $CodigoTipoGenero);
		$this->set('nascimento', $nascimento);
		$this->set('ocupacao', $ocupacao);
		$this->set('documento', $documento);
		$this->set('paises', $paises);
		$this->set('siglaUF', $siglaUF);
		$this->set('CodigoPais', $CodigoPais);
		$this->set('CodigoUF', $CodigoUF);
		$this->set('CodigoCidade', $CodigoCidade);
		$this->set("erros", $erros);
	}

    // desabilita um usuário no banco
    public function delete($id = null)
    {
    	// debug($id);
    	// die();
        $usuario = null;
        if(isset($id)){
            $usuario = $this->Usuarios->find()->where(['Codigo' => $id, 'Ativo' => true])->first();
            if($usuario != null){
                $usuario->Ativo = false;
                $this->Usuarios->save($usuario);
                $this->Flash->success('Usuário excluído com sucesso.');
            }else{
                $this->Flash->error('Usuário não encontrado.');
            }
        }
        else{
            $this->Flash->error('Id de usuário inválido.');
        }

        $this->redirect(array('action' => 'index'));
    }

}