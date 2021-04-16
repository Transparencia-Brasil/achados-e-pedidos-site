<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Model\Entity\NaMidia;

class NaMidiaController extends AppController
{
	public function initialize()
    {
        parent::initialize();

        $this->set('slug_pai', "na-midia");
        $this->loadComponent['Flash'];
        $this->loadComponent("UNumero");
        $this->loadComponent("UString");
        $this->loadComponent['Auth'];
    }

	public function index()
    {
        $pagina = 1;
        $namidiaBU = new NaMidia();

        if ($this->request->is('post')) {
            $data = $this->request->data;

            $pagina = $this->UNumero->ValidarNumeroEmArray($data, "pagina");
            $pagina = $pagina <= 0 ? 1 : $pagina;
        }

        $total = $namidiaBU->Total();
        $dados = $namidiaBU->FiltrarGeral($pagina, 5);

        $this->set('title', 'Notícias');
        $this->set('total', $total);
        $this->set('pagina', $pagina);
        $this->set('dados', $dados);
    }

    public function detalhe($slug)
    {
        $slug = $this->UString->AntiXSSComLimite($slug, 100);

        if(strlen($slug) == 0){
            $this->set("url", "/na-midia/$slug");
            $this->set("message", "404");
            $this->render('/Error/error400');
            return;
        }

        $namidiaBU = new NaMidia();
        $namidiaBU->Slug = $slug;
        $midia = $namidiaBU->ListarPorSlug();

        if($midia == null)
        {
            $this->set("url", "/na-midia/$slug");
            $this->set("message", "404");
            $this->render('/Error/error400');
            return;
        }

        $relacionados = $namidiaBU->ListarRelacionados();

        $this->set("midia", $midia);
        $this->set('title', $midia["Titulo"]);
        $this->set("relacionados", $relacionados);
    }
}

?>