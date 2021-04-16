<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Model\Entity\Agente;
use App\Model\Entity\Pedido;
use App\Model\Entity\PedidoRevisao;
use App\Model\Entity\Comentario;
use App\Model\Entity\Avaliacao;
use App\Model\Entity\UsuarioRelacionamento;

class JsonController extends AppController{

	public function initialize()
	{
		parent::initialize();
		$this->layout = 'admin';
		$this->loadComponent('Flash');
        $this->loadComponent('UData');
        $this->loadComponent('UNumero');
        $this->loadComponent('UString');
        $this->loadComponent('USessao');
        $this->loadComponent('RequestHandler');
	}

    public function ufs($codigo)
    {
        $this->autoRender = false;
        $this->response->type('application/json');
        
        $retorno = [];
        try{
            if($codigo == 33)
                $retorno = $this->UString->SelectUF($codigo);
            else{
                $retorno = ["status" => 3];
            }
        }catch(Exception $ex){
            $retorno = ["erro" => true, "msg" => "Erro ao buscar estados."];
        }

        echo json_encode($retorno);
    }

	public function cidades($sigla)
	{
		$this->autoRender = false;
        $this->response->type('application/json');
        
        try{
        	$retorno = $this->UString->SelectCidades($sigla);
        }catch(Exception $ex){
            $retorno = ["erro" => true, "msg" => "Erro ao buscar as cidades."];
        }
        //debug($retorno);die();
        echo json_encode($retorno);
	}

    public function agentes($tipo = 1){
        $this->autoRender = false;
        $this->response->type('application/json');

        $texto = $this->UString->AntiXSSComLimite($this->request->query["term"], 200);
      
        $agente = new Agente();

        if($tipo == 1){
            $agentes = $agente->ListarModerados($texto, 0, 0, false, 0, "", "", 0, 5);
        }
        else if($tipo == 2){
            $agentes = $agente->ListarModerados($texto, 0, 0, true, 0, "", "", 0, 5);
        }

        $retorno = [];
        $obj = [];
        // pega apenas as propriedades essenciais
        foreach ($agentes as $agente) {
            $obj["value"] = $agente["Codigo"];
            $obj["label"] = $agente["Nome"];
            $obj["desc"] = strlen($agente["Descricao"]) > 100 ? substr($agente["Descricao"],0, 100) : $agente["Descricao"];
            $obj["desc"] .= "<br/>Poder: " . $agente["NomePoder"] . "<br/>Nível Federativo: " . $agente["NomeNivelFederativo"];

            if($agente["CodigoCidade"] == null && $agente["CodigoUF"] != null){
                $obj["label"] .= " - " . $agente["SiglaUF"];
                $obj["desc"] .= "<br/>" . " - " . $agente["SiglaUF"];
            }            

            if($agente["CodigoCidade"] != null){
                $obj["label"] .= " - " . $agente["NomeCidade"] . " - " . $agente["SiglaUF"];
                $obj["desc"] .= "<br/>" . $agente["NomeCidade"] . " - " . $agente["SiglaUF"];
            }
            array_push($retorno, $obj);
        }

        echo json_encode($retorno);
    }

    public function novoAgente($agenteSuperior, $nome)
    {
        $this->autoRender = false;
        $this->response->type('application/json');

        $agente = new Agente();

        $agente->CodigoPai = $this->UNumero->ValidarNumero($agenteSuperior);
        $agente->Nome = $this->UString->AntiXSSComLimite($nome, 350);

        $erros = $agente->Validar();

        $elemento = $agente->JaExiste();

        if($elemento != null)
        {
            echo json_encode($elemento);
            return;
        }
        else if(count($erros) == 0){
            if($agente->Salvar())
            {
                echo json_encode($agente);
                return;
            }
        }else{
            $retorno["erro"] = true;
            $retorno["msg"] = "Erro ao cadastrar novo Órgão Público. Por favor, tente novamente mais tarde.";

            echo json_encode($retorno); 
        }
    }

    public function toggleSeguir($ct, $co)
    {
        $this->autoRender = false;
        $this->response->type('application/json');

        if(!$this->USessao->EstaLogadoFront($this->request)){
            $retorno = ["erro" => true, "msg" => "Efetue o login para seguir / deixar de seguir."];
        }else{

            $usuarioRelacionamentoBU = new UsuarioRelacionamento();

            $ct = $this->UNumero->ValidarNumero($ct);
            $co = $this->UNumero->ValidarNumero($co);

            if($ct <= 0 || $co <= 0){
                $retorno = ["erro" => true, "msg" => "Erro interno. Por favor, tente novamente mais tarde."];
            }else{
                $codigoUsuario = $this->USessao->GetUsuarioFrontID($this->request);

                $usuarioRelacionamentoBU->CodigoObjeto = $co;
                $usuarioRelacionamentoBU->CodigoTipoObjeto = $ct;
                $usuarioRelacionamentoBU->CodigoUsuario = $codigoUsuario;

                $status = $usuarioRelacionamentoBU->ToggleSeguir();

                if($status)
                    $retorno = ["status" => 1];
                else
                    $retorno = ["erro" => true, "msg" => "Erro ao processar pedido."];
            }
        }

        echo json_encode($retorno);
    }

    public function pedidoRevisao($cp)
    {
        $this->autoRender = false;
        $this->response->type('application/json');

        if(!$this->USessao->EstaLogadoFront($this->request)){
            $retorno = ["erro" => true, "msg" => "Efetue o login para pedir a revisão do pedido."];
        }else{

            $pedidoRevisaoBU = new PedidoRevisao();

            $cp = $this->UNumero->ValidarNumero($cp);
            $texto = $this->UString->AntiXSSEmArrayComLimite($this->request->data, "texto", 1000);

            if($cp <= 0 || strlen($texto) <= 10)
            {
                $retorno = ["erro" => true, "msg" => "Erro interno. Por favor, tente novamente mais tarde."];
            }else{
                $codigoUsuario = $this->USessao->GetUsuarioFrontID($this->request);

                $pedidoRevisaoBU->CodigoUsuario = $codigoUsuario;
                $pedidoRevisaoBU->CodigoPedido = $cp;
                $pedidoRevisaoBU->Texto = $texto;

                $status = $pedidoRevisaoBU->Salvar();

                if($status)
                    $retorno = ["status" => 1];
                else
                    $retorno = ["erro" => true, "msg" => "Erro ao processar pedido."];
            }
        }

        echo json_encode($retorno);
    } 

    public function avaliar($ct, $co, $nota)
    {
        $this->autoRender = false;
        $this->response->type('application/json');

        if(!$this->USessao->EstaLogadoFront($this->request)){
            $retorno = ["erro" => true, "msg" => "Efetue o login para avaliar."];
        }else{
            $ct = $this->UNumero->ValidarNumero($ct);
            $co = $this->UNumero->ValidarNumero($co);
            $nota = $this->UNumero->ValidarNumero($nota);

            if($ct <= 0 || $co <= 0 || ($nota <= 0 || $nota > 5)){
                $retorno = ["erro" => true, "msg" => "Erro interno. Por favor, tente novamente mais tarde."];
            }else{
                $codigoUsuario = $this->USessao->GetUsuarioFrontID($this->request);

                $avaliacao = new Avaliacao();

                $avaliacao->CodigoUsuario = $codigoUsuario;
                $avaliacao->CodigoTipoObjeto = $ct;
                $avaliacao->CodigoObjeto = $co;
                $avaliacao->Nota = $nota;

                $status = $avaliacao->Salvar();

                if($status)
                    $retorno = ["status" => 1];
                else
                    $retorno = ["erro" => true, "msg" => "Erro ao processar pedido."];
            }
        }
        echo json_encode($retorno);
    }

    public function comentar($ct, $co)
    {
        $this->autoRender = false;
        $this->response->type('application/json');

        if(!$this->USessao->EstaLogadoFront($this->request)){
            $retorno = ["erro" => true, "msg" => "Efetue o login para comentar."];
        }else{
            $ct = $this->UNumero->ValidarNumero($ct);
            $co = $this->UNumero->ValidarNumero($co);
            $texto = $this->UString->AntiXSSEmArrayComLimite($this->request->data, "texto", 1000);

            if($ct <= 0 || $co <= 0 || strlen($texto) < 10){
                $retorno = ["erro" => true, "msg" => "Erro interno. Por favor, tente novamente mais tarde."];
            }else{
                $codigoUsuario = $this->USessao->GetUsuarioFrontID($this->request);

                $comentario = new Comentario();

                $comentario->CodigoUsuario = $codigoUsuario;
                $comentario->CodigoTipoObjeto = $ct;
                $comentario->CodigoObjeto = $co;
                $comentario->Texto = $texto;

                $status = $comentario->Salvar();

                if($status)
                    $retorno = ["status" => 1];
                else
                    $retorno = ["erro" => true, "msg" => "Erro ao processar pedido."];
            }
        }
        echo json_encode($retorno);
    }
}