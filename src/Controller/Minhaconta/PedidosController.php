<?php

namespace App\Controller\Minhaconta;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Pedido;
use App\Model\Entity\Comentario;
use App\Model\Entity\Avaliacao;
use App\Model\Entity\UsuarioRelacionamento;
use App\Model\Entity\Agente;
use App\Model\Entity\Moderacao;
use App\Model\Entity\PedidoInteracao;
use App\Model\Entity\PedidoAnexo;
use App\Model\Entity\TipoPedidoResposta;
use Cake\Log\Log;

class PedidosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->set('slug_pai', "minha-conta");

        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth');
        $this->loadComponent('UString');
        $this->loadComponent('UData');
        $this->loadComponent('UEmail');
        $this->loadComponent('UNumero');
        $this->loadComponent('USessao');
        $this->loadComponent('UArquivo');
    }

    public function index()
    {
    }

    public function novopedido()
    {
        $erros = [];
        $pedido = new Pedido();
        $sucesso = null;

        $codigoAgente = 0;
        $nomeAgente = "";

        if ($this->request->is('post') || $this->request->is('put')) {
            
            Log::debug("[0] Novo Pedido", "pedidos");

            $conn = TableRegistry::get("Pedidos");

            $conn->patchEntity($pedido, $this->request->data);

            $codigoAgente = $this->UNumero->ValidarNumero($pedido->CodigoAgente);

            Log::debug("[1] Agente: $codigoAgente", "pedidos");

            if ($codigoAgente > 0) {
                $agenteBU = new Agente();
                $agenteBU->Codigo = $codigoAgente;
                $agente = $agenteBU->GetByCodigo();

                if ($agente != null) {
                    $nomeAgente = $agente->Nome;
                }
            }

            $erros = $pedido->ValidarNovoPedido();

            Log::debug("[2] Validação do Pedido resulton em: " . count($erros) . " erros", "pedidos");

            if (count($erros) == 0) {

                Log::debug("[3] Preparando o pedido para a base", "pedidos");

                $pedido->CodigoTipoOrigem = 1;
                //$pedido->CodigoStatusPedido= 4; // não classificado
                $pedido->CodigoStatusPedidoInterno = 4; // não classificado
                $pedido->CodigoUsuario = $this->USessao->GetUsuarioFrontID($this->request);

                Log::debug("[4] Salvando o pedido", "pedidos");
                $sucesso = $pedido->Salvar();
                Log::debug("[5] Resultou em: $sucesso", "pedidos");

                if ($sucesso) {
                    //Joga os pedidos em moderação
                    $moderacao = new Moderacao();

                    Log::debug("[6] Abrindo moderação para o pedido", "pedidos");
                    //2017-01-05 Paulo Campos: Coloca todos os pedidos deste fluxo de cadastro em moderação.
                    //TODO - Moderação inteligente: Usuários aprovados não precisam de moderação nos pedidos
                    $moderacao->InserirPedidosNaoModerados($sucesso->Codigo);
                    // atualiza os dados no elastic search
                    Log::debug("[7] Moderação aberta para o pedido", "pedidos");

                    //2017-01-05 Paulo Campos: Nessa primeira fase, todos os pedidos inseridos pelo fluxo de cadastro vão cair em moderação.
                    //A moderação irá inserir o pedido no ES.
                    //$pedidoBU = new Pedido();
                    //$pedidoBU->ES_InserirAtualizarPedidos($pedido->CodigoObjeto);
                    //die();

                    // envia e-mail de pedido cadastrado
                    Log::debug("[8] Preparando o e-mail de pedido cadastrado para o usuário", "pedidos");
                    $usuario = $this->USessao->GetUsuarioFront($this->request);
                    Log::debug("[9] Envia o e-mail de pedido cadastrado para o usuário", "pedidos");
                    $this->UEmail->EnviarEmailPedidoCadastrado($usuario->Email, $usuario->Nome, $pedido->Titulo, BASE_URL . 'minhaconta/pedidos/editar/' . $pedido->Slug);
                    Log::debug("[10] E-mail de pedido cadastrado para o usuário enviado", "pedidos");

                    // encaminhar para interação de pedido
                    if ($this->request->data['CodigoStatusPedido'] == 4) {
                        Log::debug("[11] Redirecionando", "pedidos");
                        $this->redirect('/minhaconta/pedidos/sucesso/' . $pedido->Slug);
                    } else {
                        Log::debug("[11] Redirecionando para os pedidos", "pedidos");
                        $this->redirect(array('controller' => 'Pedidos', 'action' => 'pedidointeracao', 'prefix' => 'minhaconta', $pedido->Slug));
                    }
                    return;
                } else {
                    Log::debug("[11] Erro ao salvar o pedido", "pedidos");
                    $erros["ErroInterno"] = "Não foi possível salvar seu pedido. Por favor, tente novamente mais tarde.";
                }
            }
        }

        $this->set("erros", $erros);
        $this->set("sucesso", $sucesso);
        $this->set("pedido", $pedido);
        $this->set("codigoAgente", $codigoAgente);
        $this->set("nomeAgente", $nomeAgente);
    }

    public function pedidoInteracao($slug = "")
    {
        $pedidoInteracao = TableRegistry::get("PedidosInteracoes")->newEntity();

        $erros = [];
        $sucesso = null;
        $primeiraVez = true;
        //2017-01-13 Paulo Campos. Troca variaval $pedidoAtrasado por $pedidoDataEnvio
        $pedidoDataEnvio = "";
        $arquivos = [];
        $slug = $this->UString->AntiXSSComLimite($slug, 300);
        $pedidoPesquisa = new Pedido();
        $pedidoPesquisa->Slug = $slug;
        $errosArquivo = [];
        $codigoPedido = $pedidoPesquisa->GetCodigoBySlug();

        if (!isset($codigoPedido) || $codigoPedido <= 0) {
            $this->redirect(array('controller' => 'Pedidos', 'action' => 'index', 'prefix' => 'minhaconta'));
            return;
        }

        $pedidoPesquisa->Codigo = $codigoPedido;

        $pedidoPesquisa->CodigoUsuario = $this->USessao->GetUsuarioFrontID($this->request);
        $pedidoValido = $pedidoPesquisa->PedidoPertenceACliente();

        // navegação inválida
        if (!$pedidoValido) {
            $this->redirect(array('controller' => 'Home', 'action' => 'index', 'prefix' => 'minhaconta'));
            return;
        }

        //$pedidoAtrasado = $pedidoPesquisa->PedidoAtrasado();
        $pedidoDataEnvio = $pedidoPesquisa->PedidoDataEnvio();

        if ($this->request->is('post')) {
            $primeiraVez = false;

            $conn = TableRegistry::get("PedidosInteracoes");

            $conn->patchEntity($pedidoInteracao, $this->request->data);

            $possuiArquivo = false;

            if (array_key_exists('arquivos', $_FILES)) {
                $possuiArquivo = true;
                $arquivos = $this->UArquivo->reArrayFiles($_FILES['arquivos']);
            }
            // if(array_key_exists('arquivos_hidden',$_POST)){
            //     $possuiArquivo = true;
            //     $arquivos = $this->UArquivo->reArrayFiles($_POST['arquivos_hidden']);
            // }

            // verifica se veio arquivo e só grava depois de validar a interação
            $erros = $pedidoInteracao->Validar();

            $pedidoAnexo = new PedidoAnexo();
            if ($possuiArquivo) {
                // valida se os arquivos tem o formato e tamanho corretos
                $errosArquivo = $pedidoAnexo->ValidarArquivos($arquivos);
                $erros = array_merge($erros, $errosArquivo);
            }

            if (count($erros) == 0 && count($errosArquivo) == 0) {

                if (array_key_exists("FoiProrrogado", $this->request->data)) {
                    $foiProrrogado = $this->UNumero->ValidarNumero($pedidoInteracao->FoiProrrogado);

                    if ($foiProrrogado == 1) {
                        // atualiza o pedido
                        $pedidoPesquisa->PedidoProrrogado();
                    }
                }

                if ($pedidoInteracao->Salvar()) {
                    $pedidoInteracaoEdicaoBU = new PedidoInteracao();
                    // atualiza interação no Elastic Search
                    $pedidoInteracaoEdicaoBU->ES_AtualizarInserirInteracoes($pedidoInteracao->Codigo);

                    if ($possuiArquivo) {
                        $erros = "";
                        $sucesso = $pedidoAnexo->SalvarMultiplos($arquivos, $pedidoInteracao->Codigo, $codigoPedido, $erros);

                        if (!$sucesso) {
                            array_push($errosArquivo, $erros);
                        }
                    } else {
                        $sucesso = true;
                    }
                } else {
                    $sucesso = false;
                }
            }
        }

        $tipoResposta = new TipoPedidoResposta();

        $respostas = $tipoResposta->ListarParaSelect();

        $pedidoInteracao->CodigoPedido = $codigoPedido;
        $this->set("pedidoInteracao", $pedidoInteracao);
        $this->set("erros", $erros);
        $this->set("arquivos", $arquivos);
        $this->set('errosArquivo', $errosArquivo);
        //$this->set("pedidoAtrasado", $pedidoAtrasado);
        $this->set("pedidoDataEnvio", $pedidoDataEnvio);
        $this->set("primeiraVez", $primeiraVez);
        $this->set("respostas", $respostas);
        $this->set("sucesso", $sucesso);
        $this->set("slug", $slug);
    }

    public function editar($slug = "")
    {
        $slug = $this->UString->AntiXSSComLimite($slug, 200);

        $pedidoBU = new Pedido();

        $pedidoBU->Slug = $slug;
        $pedido = $pedidoBU->ListarPorSlug(false);

        // pedido não encontrado
        if ($pedido == null) {
            $this->set("url", "/minha-conta/pedidos/editar/$slug");
            $this->set("message", "404");
            $this->render('/Error/error400');

            return;
        }

        $pedidoValido = new Pedido();
        $pedidoValido->CodigoUsuario = $this->USessao->GetUsuarioFrontID($this->request);
        $pedidoValido->Codigo = $pedido["Codigo"];


        // navegação inválida
        if (!$pedidoValido->PedidoPertenceACliente()) {
            $this->redirect(array('controller' => 'Home', 'action' => 'index', 'prefix' => 'minhaconta'));
            return;
        }


        $pedidoInteracaoEdicao = new PedidoInteracao();
        $pedidoInteracaoEdicaoBU = null;

        $errosPedidoInteracao = [];
        $errosPedido = [];
        $sucessoAtualizadoPedido = null;
        $sucessoAtualizadoInteracao = null;
        $arquivos = [];
        $possuiArquivo = false;
        $errosArquivo = [];
        $t = $this->UNumero->ValidarNumeroEmArray($this->request->query, "t");

        // verifica se usuário está atualizando um pedido ou interação
        if ($this->request->isPost() || $this->request->isPut()) {

            $t = $this->UNumero->ValidarNumeroEmArray($this->request->data, "t");
            // verifica se é pedido ou interação
            if ($t == 1) {
                // atualiza o pedido.

                $pedidoAtualizacao = $pedidoBU->ListarUnico($pedido["Codigo"]);
                // coleta e valida dados
                $pedidoAtualizacao->CodigoTipoPedidoSituacao = $this->UNumero->ValidarNumeroEmArray($this->request->data, "CodigoTipoPedidoSituacao");
                $pedidoAtualizacao->CodigoStatusPedido = $this->UNumero->ValidarNumeroEmArray($this->request->data, "CodigoStatusPedido");
                $pedidoAtualizacao->CodigoStatusPedido = is_null($pedidoAtualizacao->CodigoStatusPedido) || $pedidoAtualizacao->CodigoStatusPedido == 0 ? 4 : $pedidoAtualizacao->CodigoStatusPedido;

                $pedidoAtualizacao->Titulo = $this->UString->AntiXSSComLimite($this->request->data["Titulo"], 1000); //2017-01-21 Paulo Campos: tirando validação strlen
                //$pedidoAtualizacao->Titulo = $this->UString->LimitarTamanho($this->request->data["Titulo"], 1000); //2017-01-21 Paulo Campos: tirando validação strlen
                //2017-04-27 Paulo Campos: Aumentando o limite de strings de 1.000 para 100.000
                //$pedidoAtualizacao->Descricao = $this->UString->AntiXSSComLimite($this->request->data["Descricao"], 1000);
                //$pedidoAtualizacao->Descricao = $this->UString->AntiXSSComLimite($this->request->data["Descricao"], 100000);
                $pedidoAtualizacao->Descricao = $this->UString->LimitarTamanho($this->request->data["Descricao"], 100000);
                $pedidoAtualizacao->DataEnvio = $this->UString->AntiXSSComLimite($this->request->data["DataEnvio"], 20);

                $errosPedido = $pedidoAtualizacao->ValidarPedidoAtualizacao();

                if (count($errosPedido) == 0) {
                    $sucessoAtualizadoPedido = $pedidoAtualizacao->AtualizarPedido();
                    $pedidoBU->ES_InserirAtualizarPedidos($sucessoAtualizadoPedido->Codigo);
                }
            } else if ($t == 2) {
                // atualiza ou insere uma interação
                $ci = $this->UNumero->ValidarNumeroEmArray($this->request->query, "ci");

                $pedidoAtualizacao = $pedidoBU->ListarUnico($pedido["Codigo"]);
                $pedidoAtualizacao->CodigoStatusPedido = $this->UNumero->ValidarNumeroEmArray($this->request->data, "CodigoStatusPedido");
                $errosPedido = $pedidoAtualizacao->ValidarPedidoAtualizacaoStatus();

                $pedidoInteracaoEdicaoBU = new PedidoInteracao();
                $pedidoInteracaoEdicaoBU->CodigoPedido = $pedido["Codigo"];

                $pedidoInteracaoAtualizacao = $pedidoInteracaoEdicaoBU->Listar()->where(["PedidosInteracoes.Codigo" => $ci])->first();

                if ($pedidoInteracaoAtualizacao == null) {
                    $pedidoInteracaoAtualizacao = new PedidoInteracao();
                    $pedidoInteracaoAtualizacao->CodigoPedido = $pedido["Codigo"];
                }

                if (array_key_exists('arquivos', $_FILES)) {
                    $possuiArquivo = true;
                    $arquivos = $this->UArquivo->reArrayFiles($_FILES['arquivos']);
                }

                // if(array_key_exists('arquivos_hidden',$_POST)){
                //     $possuiArquivo = true;
                //     foreach ($_POST['arquivos_hidden'] as $key=>$value) {
                //         echo $key;
                //         $postUnserialize = [$key => unserialize($value)];

                //     }
                //     $arquivos = $postUnserialize;
                //     //debug(array_push($arquivos,$postUnserialize));
                //     //$arquivos = $this->UArquivo->reArrayFiles($_POST['arquivos_hidden']);
                // }

                //2017-04-27 Paulo Campos: Aumentando o limite de strings de 1.000 para 100.000
                //$pedidoAtualizacao->Descricao = $this->UString->AntiXSSComLimite($this->request->data["Descricao"], 1000);
                //$pedidoInteracaoAtualizacao->Descricao = $this->UString->AntiXSSComLimite($this->request->data["Descricao"], 100000);
                $pedidoInteracaoAtualizacao->Descricao = $this->UString->LimitarTamanho($this->request->data["Descricao"], 100000);
                $pedidoInteracaoAtualizacao->DataResposta = $this->UString->AntiXSSComLimite($this->request->data["DataResposta"], 20);
                $pedidoInteracaoAtualizacao->CodigoTipoPedidoResposta = $this->UNumero->ValidarNumeroEmArray($this->request->data, "CodigoTipoPedidoResposta");

                $errosPedidoInteracao = $pedidoInteracaoAtualizacao->ValidarAtualizacao();

                $pedidoAnexo = new PedidoAnexo();

                if ($possuiArquivo) {
                    // valida se os arquivos tem o formato e tamanho corretos

                    $errosArquivo = $pedidoAnexo->ValidarArquivos($arquivos);
                }

                if (count($errosPedido) == 0 && count($errosPedidoInteracao) == 0 && count($errosArquivo) == 0) {

                    if (array_key_exists("FoiProrrogado", $this->request->data)) {
                        $foiProrrogado = $this->UNumero->ValidarNumeroEmArray($this->request->data, "FoiProrrogado");

                        if ($foiProrrogado == 1) {
                            // atualiza o pedido
                            $pedidoValido->PedidoProrrogado();
                        }
                    }

                    if ($pedidoInteracaoAtualizacao->Salvar()) {
                        $sucessoAtualizadoPedido = $pedidoAtualizacao->AtualizarPedido();
                        $pedidoBU->ES_InserirAtualizarPedidos($sucessoAtualizadoPedido->Codigo);

                        // atualiza interação no Elastic Search
                        $pedidoInteracaoEdicaoBU->ES_AtualizarInserirInteracoes($pedidoInteracaoAtualizacao->Codigo);

                        if ($possuiArquivo) {
                            $erros = "";
                            $sucessoAtualizadoInteracao = $pedidoAnexo->SalvarMultiplos($arquivos, $pedidoInteracaoAtualizacao->Codigo, $pedidoValido->Codigo, $erros);

                            if (!$sucessoAtualizadoInteracao) {
                                array_push($errosArquivo, $erros);
                            }
                        } else {
                            $sucessoAtualizadoInteracao = true;
                        }
                    } else {
                        $sucessoAtualizadoInteracao = false;
                    }
                }
            } else {
                $sucessoAtualizadoInteracao = false;
                $t = 2;
                $errosArquivo["Erro"] = "Falha ao receber os arquivos. Tente substituir o arquivo.";
            }
        }
        // verifica se usuário quer atualizar um pedido ou interação
        else if (count($this->request->query) > 0) {
            if ($t == 2) {
                $pedidoInteracaoEdicaoBU = new PedidoInteracao();
                $pedidoInteracaoEdicaoBU->CodigoPedido = $pedido["Codigo"];
                $codigoPedidoInteracao = $this->UNumero->ValidarNumeroEmArray($this->request->query, "ci");
                $pedidoInteracaoEdicao = $pedidoInteracaoEdicaoBU->Listar()->where(["PedidosInteracoes.Codigo" => $codigoPedidoInteracao])->first();
                $pedidoCodigoStatusPedido = $pedidoBU->ListarUnico($pedido["Codigo"]);
                if (isset($pedidoInteracaoEdicao) && !empty($pedidoInteracaoEdicao)) {
                    $pedidoInteracaoEdicao->CodigoStatusPedido = $pedidoCodigoStatusPedido->CodigoStatusPedido;
                }
                if ($pedidoInteracaoEdicao != null) {
                    $pedidoInteracaoEdicao->DataResposta = $this->UData->ConverterDataBrasil($pedidoInteracaoEdicao->DataResposta);
                }
            }
        }
        // se atualizado, recarregar dados
        if ($sucessoAtualizadoPedido || $sucessoAtualizadoInteracao)
            $pedido = $pedidoBU->ListarPorSlug(false);

        $comentarioBU = new Comentario();
        $comentarioBU->CodigoObjeto = $pedido["Codigo"];
        $comentarios = $comentarioBU->ListarPorPedido();

        $pedidoInteracaoBU = new PedidoInteracao();
        $pedidoInteracaoBU->CodigoPedido = $pedido["Codigo"];

        $interacoes = $pedidoInteracaoBU->Listar();
        $usuarioRelacionamentoBU = new UsuarioRelacionamento();
        $usuarioRelacionamentoBU->CodigoTipoObjeto = 1;
        $usuarioRelacionamentoBU->CodigoObjeto = $pedido["Codigo"];

        $totalSeguidores = $usuarioRelacionamentoBU->TotalSeguindoPedido();

        $avaliacao = new Avaliacao();
        $avaliacao->CodigoObjeto = $pedido["Codigo"];
        $avaliacao->CodigoTipoObjeto = 1;

        $nota = $avaliacao->CalcularMediaAvaliacoes();
        $totalAvaliacoes = $avaliacao->TotalAvaliacoes();


        // dados para edição de elemento
        $pedidoEdicao = $pedidoBU->ListarUnico($pedido["Codigo"]);

        if ($pedidoEdicao != null)
            $pedidoEdicao->DataEnvio = $this->UData->ConverterDataBrasil($pedidoEdicao->DataEnvio);

        $tipoResposta = new TipoPedidoResposta();
        $respostas = $tipoResposta->ListarParaSelect();

        if (empty($pedidoInteracaoEdicao)) {
            $pedidoInteracaoEdicao = new PedidoInteracao(['role' => 'required']);
        }

        $this->set("t", $t);
        $this->set('arquivos', $arquivos);
        $this->set('respostas', $respostas);
        $this->set('pedido', $pedido);
        $this->set('pedidoEdicao', $pedidoEdicao);
        $this->set('pedidoInteracaoEdicao', $pedidoInteracaoEdicao);
        $this->set('sucessoAtualizadoPedido', $sucessoAtualizadoPedido);
        $this->set('sucessoAtualizadoInteracao', $sucessoAtualizadoInteracao);
        $this->set('errosArquivo', $errosArquivo);
        $this->set('errosPedido', $errosPedido);
        $this->set('errosPedidoInteracao', $errosPedidoInteracao);
        $this->set('interacoes', $interacoes);
        $this->set('comentarios', $comentarios);
        $this->set('totalSeguidores', $totalSeguidores);
        $this->set('nota', $nota);
        $this->set('totalAvaliacoes', $totalAvaliacoes);
    }

    public function sucesso($slug = "")
    {
        $this->set("sucesso", true);
        $this->set("slug", $slug);
        $this->render('pedidointeracao');
    }
}
