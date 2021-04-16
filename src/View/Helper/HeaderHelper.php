<?php
namespace App\View\Helper;

use Cake\View\Helper;
use App\Controller\Component\USessaoComponent;

class HeaderHelper extends Helper
{
	public function login()
    {
    	$urlNovoPedido = BASE_URL . "minhaconta/pedidos/novopedido";
        if(!USessaoComponent::EstaLogadoFront($this->request)){
        	echo '<div class="col-md-4 col-sm-12 col-xs-12">
	                <ul class="nav navbar-nav navbar-letf loginDesk">
	                	<li class="btnLogin"><a href="' . BASE_URL . "login/" .'">Entrar</a></li>
	                  	<li class="btnInserirPedido"><a href="'.$urlNovoPedido.'">Inserir Pedido</a></li>
	                </ul>
	              </div>';
        }else{
            echo '<div class="col-md-4 col-sm-12 col-xs-12">
                <ul class="nav navbar-nav navbar-letf loginDesk">
                  <li class="btnInserirPedido"><a href="'.$urlNovoPedido.'">Inserir Pedido</a></li>
                  <li class="btnPerfil">
                    <div class="col-md-1">
                      <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6">
                      <a href="'.BASE_URL . "minha-conta/meus-pedidos" .'">Meu Perfil</a>  
                    </div>
                    <div class="col-md-3 sair">
                      <a href="'.BASE_URL . "minha-conta/logout" .'">
                        <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
                      </a>
                    </div>
                  </li>
                </ul>
              </div>';
        }
    }
}
?>
