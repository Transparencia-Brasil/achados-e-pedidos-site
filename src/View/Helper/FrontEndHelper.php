<?php
namespace App\View\Helper;

use Cake\View\Helper;
use App\Model\Entity\UsuarioRelacionamento;
use App\Controller\Component\USessaoComponent;

class FrontEndHelper extends Helper
{

    public function interacao($codigoObjeto, $codigoTipoObjeto)
    {
        if(!USessaoComponent::EstaLogadoFront($this->request))
            echo "Seguir";
        else{
            $codigoUsuario = USessaoComponent::GetUsuarioFrontID($this->request);

            $usuarioRelBU = new UsuarioRelacionamento();
            
            $usuarioRelBU->CodigoUsuario = $codigoUsuario;
            $usuarioRelBU->CodigoObjeto = $codigoObjeto;
            $usuarioRelBU->CodigoTipoObjeto = $codigoTipoObjeto;

            $boolSeguindo = $usuarioRelBU->EstaSeguindoObjeto();

            if($boolSeguindo){
                echo "Deixar de seguir";
            }
            else{
                echo "Seguir";
            }
        }

    }

    public function elementoChecked($codigo, $valor)
    {
    	if($valor == null || empty($valor))
    		return "";

        if($valor == $codigo){
        	echo "checked='checked'";
        }
    }

    public function paging($paginaAtual, $total, $qtdPorPagina)
    {
        if($total <= $qtdPorPagina)
            return;

    	$qtdPorPagina = $qtdPorPagina <= 0 ? 10 : $qtdPorPagina;
        $total = $total <= 0 ? 0 : $total;
    	$paginas = ceil($total / $qtdPorPagina);

    	$html = "";

        if($paginaAtual == 1)
        {
            //2017-3-09 Paulo Campos: Adicionado style="pointer-events:none para tirar o evento de clique
            $html = '<li class="disabled" style="pointer-events:none;"><span>«</span></li>';
        }else{
            $html = '<li data-val="1"><a href="javascript:void(0);"><span>«</span></a></li>';
        }
        //2017-3-09 Paulo Campos: Implementação de paginação por range. Os números vão aparecendo conforme a navegação
        //decresce ou cresce. Antes todas as 32 páginas apareciam na paginacao e quebrava o layout
        $range1 = $paginaAtual-3;
        $range2 = $paginaAtual+3;
        //debug($range1 . " # " . $range2 . " pa " . $paginaAtual . " pags " . $paginas);
        if ($range2 > $paginas && $range1>0) {
            $range2 = $paginas;
            $range1 = $paginas-6;
        } elseif ($range2 > $paginas && $range1<=0) {
            $range1 = 1;
            $range2 = $paginas;
        } elseif ($range2 < $paginas && $range1<0) {
            $range1 = 1;
            $range2 = 4;
        } elseif ($range2 < $paginas && $range1>=0) {
            $range1 = $range1 + 1;
            //$range2 = 4;
        }
        //Fim implementacao de paginacao por range
    	for($count = $range1; $count <= $range2; $count++){
    		if($count == $paginaAtual)
    			$html .= "<li data-val='" . $count . "' class='active'><span>" . $count . "</span></li>";
    		else
    			$html .= "<li data-val='" . $count . "'><a href='javascript:void(0);'>" . $count . "</a></li>";
    	}

        if($paginaAtual != $paginas && $paginas > 1)
        {
            $html .= '<li data-val="'.$paginas.'"><a href="javascript:void(0);"><span>»</span></a></li>';
        }else{
            //2017-3-09 Paulo Campos: Adicionado style="pointer-events:none para tirar o evento de clique
            $html .= '<li class="disabled" style="pointer-events:none;"><span>»</span></li>';
        }

    	echo $html;
    }

    public function EhUsuarioLogado($codigoUsuario)
    {
        if(USessaoComponent::GetUsuarioFrontID($this->request) == $codigoUsuario){
            return true;
        }

        return false;
    }

    public function UsuarioLogado()
    {
        if(USessaoComponent::GetUsuarioFrontID($this->request) != 0){
            return true;
        }

        return false;
    }

    public function UsuarioLogadoEcho()
    {
        if(USessaoComponent::GetUsuarioFrontID($this->request) != 0){
            echo 'true';
        }else {
            echo 'false'; 
        }        
    }

    public function calcularAvaliacao($nota)
    {
        $html = '';


        for($count = 1; $count <= 5; $count++){
            $checked = $count == ceil($nota) ? "checked='checked'" : "";
            if($count == 1)
                $html .= '<input type="radio" id="cm_star-empty" name="fb" value="" checked="" >';
            $html .= '<label for="cm_star-'.$count.'"><i class="fa"></i></label>
            <input type="radio" id="cm_star-'.$count.'" name="fb" value="'.$count.'" '.$checked.'>';
        }

        echo $html;
    }
    //2016-01-16 Paulo Camopos: Adiciono parametro para saber se pega status checado pela tb ou não
    public function statusPedido($codigoStatus,$codigoStatusInterno=4)
    {
        if ($codigoStatusInterno == 4) {
            //pega da tabela pedidos.CodigoStatusPedido
            switch($codigoStatus)
            {
                case 1:
                    $statusPedido["imagem"] = '<img src="'.BASE_URL.'assets/images/pedidos/icon-atendido.png" class="img-responsive" alt="Atendido (Não verificado)">';
                    $statusPedido["texto"]  = '<strong>Atendido</strong><br>(Não verificado)'; break;
                case 2:
                    $statusPedido["imagem"] = '<img src="'.BASE_URL.'assets/images/pedidos/icon-nao-atendido.png" class="img-responsive" alt="Não Atendido (Não verificado)">';
                    $statusPedido["texto"]  = '<strong>Não Atendido</strong><br>(Não verificado)'; break;
                case 3:
                    $statusPedido["imagem"] = '<img src="'.BASE_URL.'assets/images/pedidos/icon-parcialmente-atendido.png" class="img-responsive" alt="Parcialmente Atendido (Não verificado)">';
                    $statusPedido["texto"]  = '<strong>Parcialmente Atendido</strong><br>(Não verificado)'; break;
                case 4:
                    $statusPedido["imagem"] = '<img src="'.BASE_URL.'assets/images/pedidos/icon-naoclassificado.png" class="img-responsive" alt="Não Classificado">';
                    $statusPedido["texto"]  = '<strong>Não Classificado</strong><br>(Não verificado)'; break;
            }
        } else {
            //pega da tabela pedidos.CodigoStatusPedidoInterno
            switch($codigoStatusInterno)
            {
                case 1:
                    $statusPedido["imagem"] = '<img src="'.BASE_URL.'assets/images/pedidos/icon-atendido-verificado.png" class="img-responsive" alt="Atendido (Status verificado)">';
                    $statusPedido["texto"]  = '<strong>Atendido</strong><br>(Status verificado)'; break;
                case 2:
                    $statusPedido["imagem"] = '<img src="'.BASE_URL.'assets/images/pedidos/icon-nao-atendido-verificado.png" class="img-responsive" alt="Não Atendido (Status verificado)">';
                    $statusPedido["texto"] = '<strong>Não Atendido</strong><br>(Status verificado)'; break;
                case 3:
                    $statusPedido["imagem"] = '<img src="'.BASE_URL.'assets/images/pedidos/icon-parcialmente-atendido-verificado.png" class="img-responsive" alt="Parcialmente Atendido (Status verificado)">';
                    $statusPedido["texto"]  = '<strong>Parcialmente Atendido</strong><br>(Status verificado)'; break;
                case 4:
                    $statusPedido["imagem"] = '<img src="'.BASE_URL.'assets/images/pedidos/icon-naoclassificado.png" class="img-responsive" alt="Não Classificado">';
                    $statusPedido["texto"]  = '<strong>Não Classificado</strong><br>(Status verificado)'; break;
            }
        }

        return $statusPedido;
    }

    public function statusPedidoInterno($codigoStatus)
    {
        if($codigoStatus == 1)
        {
            echo '<img src="'.BASE_URL.'assets/images/pedidos/icon-checado-TB.jpg" alt="Checado pela TB">
                <p>Verificado: <br/><strong>Checado pela TB</strong></p>';
        }else{
            echo '<img src="'.BASE_URL.'assets/images/pedidos/icon-em-tramitacao.png" alt="Tramitação">
                <p>Verificado: <br/><strong>Ainda não verificado</strong></p>';
        }
    }

    public function situacaoPedido($codigoSituacao)
    {
        switch($codigoSituacao)
        {
            case 1:
                echo '<img src="'.BASE_URL.'assets/images/pedidos/icon-em-tramitacao.png" alt="Em Tramitação">
                <p>Situação:<br/><strong>Em tramitação</strong></p>'; break;
            case 2:
                echo '<img src="'.BASE_URL.'assets/images/pedidos/icon-finalizado.png" alt="Finalizado">
                <p>Situação:<br><strong>Finalizado</strong></p>'; break;
            case 3:
                echo '<img src="'.BASE_URL.'assets/images/pedidos/icon-finalizado.png" alt="Finalizado: não obteve resposta.">
                <p>Situação:<br><strong>Finalizado: não obteve resposta.</strong></p>'; break;
        }
    }


}
?>
