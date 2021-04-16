<?php
namespace App\Controller\Minhaconta;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Usuario;
use App\Model\Entity\Avaliacao;
use App\Model\Entity\Pedido;
use App\Model\Entity\UsuarioRelacionamento;


class HomeController extends AppController {

    public function initialize()
    {
        parent::initialize();

        $this->set('slug_pai', "minha-conta");

        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth');
        $this->loadComponent('UString');
        $this->loadComponent('USessao');
        $this->loadComponent('UNumero');
    }

   	public function index($abaPedidos = 0){

        $usuarioLogado = $this->USessao->GetUsuarioFront($this->request);
        $filtro = "";
        if (isset($this->request->query["filtro"]))
            $filtro = $this->request->query["filtro"]; //Mostra pedidos em moderação, aprovados e todos.

        switch ($filtro) {
            case 'total':
                $moderacao = false;
                $tituloPedidos = "Total de pedidos cadastrados: ";
                $CodigoStatusModeracao = 0; //Não aplicavel quando moderacao = false
                break;
            case 'aprovados':
                $moderacao = true;
                $tituloPedidos = "Pedidos aprovados: ";
                $CodigoStatusModeracao = 2;
                break;
            case 'moderacao':
                $moderacao = true;
                $tituloPedidos = "Pedidos em moderação: ";
                $CodigoStatusModeracao = 1;
                break;
            case 'reprovados':
                $moderacao = true;
                $tituloPedidos = "Pedidos reprovados pela moderação: ";
                $CodigoStatusModeracao = 3;
                break;
            default:
                $moderacao = false;
                $tituloPedidos = "Total de pedidos cadastrados: ";
                $CodigoStatusModeracao = 0; //Não aplicavel quando moderacao = false
                break;
        }

        $abaPedidos = isset($abaPedidos) ? (bool)$abaPedidos : false;

        $pedido = new Pedido();
        $usuario = new Usuario();
        $avaliacao = new Avaliacao();
        $usuarioRelacionamentoBU = new UsuarioRelacionamento();
        $feed = [];
        $pedidos = [];
        $pagina = 1;
        $start = 0;
        $totalItens = 0;

        if($this->request->isPost())
        {
            $pagina = $this->UNumero->ValidarNumero($this->request->data["pagina"]);
            $pagina = $pagina <= 0 ? 1 : $pagina;

            $start = ($pagina - 1) * 5;
        }

        $usuario->Codigo = $usuarioLogado->Codigo;

        $seguindo = $usuario->TotalSeguindo($usuario->Codigo);
        $seguidores = $usuario->TotalSeguidores($usuario->Codigo);

        $pedido->CodigoUsuario = $usuario->Codigo;
        $totalPedidosPaginacao = $pedido->TotalPorUsuario($moderacao,$CodigoStatusModeracao);
        $totalPedidos = $pedido->TotalPorUsuario(false);
        $totalPedidosAprovados = $pedido->TotalPorUsuario(true);
        $totalPedidosEmModeracao = $pedido->TotalPorUsuario(true,1);
        $totalPedidosReprovados = $pedido->TotalPorUsuario(true,3);

        $avaliacao->CodigoObjeto = $usuario->Codigo;
        $nota = $avaliacao->ListarParaUsuario();

        $totalAvaliacao = $avaliacao->TotalParaUsuario();

        if($abaPedidos){
            $pedido->CodigoUsuario = $usuario->Codigo;
            $pedidos = $pedido->ListarPorUsuario($pagina, 5, $moderacao,$CodigoStatusModeracao);
            $totalItens = $totalPedidosPaginacao;
        }else{

            $usuarioRelacionamentoBU->CodigoUsuario = $usuarioLogado->Codigo;
            $feed = $usuarioRelacionamentoBU->MeuFeed($start, 5);

            $totalItens = $usuarioRelacionamentoBU->TotalMeuFeed();
        }

        $this->set("usuarioLogado", $usuarioLogado);
        $this->set("tituloPedidos", $tituloPedidos);
        $this->set("totalPedidosReprovados", $totalPedidosReprovados);
        $this->set("totalPedidosPaginacao", $totalPedidosPaginacao);
        $this->set("totalPedidos", $totalPedidos);
        $this->set("totalPedidosAprovados", $totalPedidosAprovados);
        $this->set("totalPedidosEmModeracao", $totalPedidosEmModeracao);
        $this->set("totalItens", $totalItens);
        $this->set("nota", $nota);
        $this->set("pagina", $pagina);
        $this->set("totalAvaliacao", $totalAvaliacao);
        $this->set("seguindo", $seguindo);
        $this->set("seguidores", $seguidores);
        $this->set("feed", $feed);
        $this->set("pedidos", $pedidos);
        $this->set("abaPedidos", $abaPedidos);
   	}
}
?>
