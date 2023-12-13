<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Model\Entity\NaMidia;

class NewsletterController extends AppController
{

	public function index()
    {

        $this->set('title', 'Newsletter');
    }
}

?>