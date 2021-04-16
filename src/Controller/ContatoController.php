<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Model\Entity\Contato;
use App\Model\Entity\Newsletter;
use App\Controller\Component\UEmailComponent;


class ContatoController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Contato');
        $this->loadModel('Newsletter');
        $this->set('slug_pai', "contato");

        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth');
        $this->loadComponent('UString');
        $this->loadComponent('UNumero');
    }

	public function index()
    {
        $contato = new Contato();
        $mensagem = '';
        $guid = $this->UString->guid();

        $this->set('sucesso', null);
        $this->set('erros', []);
        $this->set('guid', $guid);
        $this->set('contato', $contato);
        $this->set('mensagem', $mensagem);
    }

    public function novoContato(){

        /*$token = $this->request->param('_csrfToken');

        if(!isset($token))
            $this->Security->requireSecure();*/
        $sucesso = null;

    	if ($this->request->is(['post', 'put'])) {

            $dados = $this->request->data;
            $contato = new Contato();

            $guid_anterior = $this->request->session()->read('guidContatoEnviado');
            $guid = $this->UString->AntiXSSComLimite($dados["guid"], 100);

            $arrayErros = [];
            // tentativa de reenvio de formulário
            if($guid == null || ($guid_anterior != null && $guid == $guid_anterior)){
                $erro = true;
                $arrayErros["Mensagem"] = 'Erro ao enviar contato.[3]';
                $this->request->data = [];
            }else{
                $dados = $this->request->data;

                $contato->Nome = $this->UString->AntiXSSComLimite($dados["Nome"], 100);
                $contato->Email = $this->UString->AntiXSSComLimite($dados["Email"], 100);
                $contato->Assunto = $this->UString->AntiXSSComLimite($dados["Assunto"], 100);
                $contato->Mensagem = $this->UString->AntiXSSComLimite($dados["Mensagem"], 3000);

                $novidades = !isset($dados["Novidades"]) ? 0 : $this->UNumero->ValidarNumero($dados["Novidades"]) > 0 ? 1 : 0;

                $contato->AceitouNovidades = $novidades;
                $arrayErros = $contato->Validar();

        		if($contato != null)
        		{
        			if(count($arrayErros) == 0){
        				$contato->Respondido = 0;
        				if($contato->Salvar($contato))
        				{
                            // insere um novo usuário de newsletter
                            if($novidades)
                            {
                                try{
                                    $newsletterBU = new Newsletter();
                                    $newsletterBU->Salvar($contato->Nome, $contato->Email);
                                }catch(Exception $ex){}
                            }

                            // enviar e-mail
                            UEmailComponent::EmailContato($contato->Nome, $contato->Email, $contato->Assunto, $contato->Mensagem);


                            // evita reenvio de dados
                            $this->request->session()->write('guidContatoEnviado', $guid);
                            $contato = new Contato();
                            $this->request->data = [];
                            $sucesso = true;
        				}
        			}
        		}else{
                    $arrayErros["Mensagem"] = 'Erro ao enviar contato.[2]';
        		}
            }
    	}else{
            $this->redirect(['action' => 'index']);
            return;
        }

        $this->set('guid', $guid);
        $this->set('contato', $contato);
        $this->set('erros', $arrayErros);
        $this->set('sucesso', $sucesso);
        $this->render('index');
    }
}

?>
