<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\NaMidia;
use Cake\ORM\TableRegistry;

class NaMidiaController extends AppController
{
    public $PASTA_UPLOAD = WWW_ROOT . 'uploads' . DS . 'na-midia' . DS;

	public function initialize()
	{
        parent::initialize();
		    $this->layout = 'admin';
		    $this->loadComponent('Flash');
        $this->loadComponent('UString');
        $this->loadComponent('UData');
	}

	public function index($id = null)
	{
    $conn = TableRegistry::get("NaMidia");
		$lista = $conn->find('all')->where(['ativo' => true])->order(['NaMidia.Criacao' => 'DESC']);

		$this->set('lista', $lista);
	}

	public function edit($id = null)
	{
    $conn = TableRegistry::get("NaMidia");
		$namidia = isset($id) ? $conn->find('all')->where(['codigo' => $id, 'ativo' => true])->first() : new NaMidia();


		if ($this->request->is(['post', 'put'])) {
            $imagemAtual = $namidia->ImagemResumo;
            $conn->patchEntity($namidia, $this->request->data);
            $arquivo = $this->request->data['NaMidia']['ImagemResumo'];
            $datapublic =  $this->request->data['NaMidia']['Publicacao'];
            $dataexibition =  $this->request->data['NaMidia']['InicioExibicao'];

            $possuiArquivo = $arquivo == null || strlen($arquivo['name']) == 0 ? false : true;

            if(!$possuiArquivo && $id == null)
            {
                $this->Flash->error('Você deve publicar uma imagem');
                if ($datapublic == null){
                  $this->Flash->error('Você deve escolher uma data de publicação');
                }
            }else{

                if ($datapublic == null){
                  $this->Flash->error('Você deve escolher uma data de publicação');
                }else{
                  $namidia->Publicacao = $this->UData->ConverterMySQL($namidia->Publicacao);
                }
                if ($dataexibition == null){
                  $this->Flash->error('Você deve escolher uma data de exibição');
                }else{
                  $namidia->InicioExibicao = $this->UData->ConverterMySQL($namidia->InicioExibicao);
                }

                $namidia->TerminoExibicao = $this->UData->ConverterMySQL($namidia->TerminoExibicao);


                if($namidia->errors())
                    $this->Flash->error('Erro ao salvar clipping. Verifique os campos obrigatórios.');

                    if ($namidia->NomeInterno == null){
                      $this->Flash->error('Você deve escolher um Nome Interno');
                    }
                    if ($namidia->Subtitulo == null){
                      $this->Flash->error('Você deve escolher um Subtítulo');
                    }
                    if ($namidia->Titulo == null){
                      $this->Flash->error('Você deve escolher um Título');
                    }
                else{

                    if($namidia->isNew() || strlen($namidia->Slug) == 0)
                    {
                        $namidia->Slug = $this->UString->Slugfy($namidia->Titulo);
                    }

                    if (empty($arquivo['name']))
                        $namidia->ImagemResumo = $imagemAtual;
                    else
                        $namidia->ImagemResumo = $arquivo['name'];

                    if($id = $conn->save($namidia)){
                        //2017-01-22 Paulo Campos: Pega ID do registro (Codigo primary key)
                        $caminhoUnico = $id->Codigo."/";
                            //2017-01-22 Paulo Campos: movi o upload do arquivo para depois da criacao do registro
                            //(deve pegar o ID do registro e criar uma pasta para uma imagem do mesmo nome em registros diferentes não serem sobrescritas)
                            if($possuiArquivo){
                                //2017-01-22 Paulo Campos: Gera pasta com o Codigo primary key
                                if (!is_dir($this->PASTA_UPLOAD .$caminhoUnico)) {
                                    //echo "entrou no dir " . $caminhoUnico;
                                    //echo "deusbom".$this->PASTA_UPLOAD .$caminhoUnico;
                                    mkdir($this->PASTA_UPLOAD .$caminhoUnico, 0777);
                                } else {
                                    //remove os arquivos para repor os novos;
                                    array_map('unlink', glob($this->PASTA_UPLOAD .$caminhoUnico."*"));
                                }
                                $boolArquivoOk = move_uploaded_file($arquivo['tmp_name'], $this->PASTA_UPLOAD .$caminhoUnico. $arquivo['name']);

                                //2017-01-22 Paulo Campos: Gera Thumbnails

                                //$boolArquivoOk =
                                //$this->geraThumb($arquivo['tmp_name'],
                                  //$this->PASTA_UPLOAD .$caminhoUnico.  NaMidia::PREFIX_THUMB0 . $arquivo['name'],
                                  //NaMidia::WIDTH_THUMB0,
                                  //NaMidia::HEIGHT_THUMB0);

                                //Gera thumb grande (destaque na lista de notícias)
                                //$this->geraThumb($this->PASTA_UPLOAD .$caminhoUnico. NaMidia::PREFIX_THUMB0 . $arquivo['name'],
                                  //$this->PASTA_UPLOAD .$caminhoUnico.  NaMidia::PREFIX_THUMB1 . $arquivo['name'],
                                  //NaMidia::WIDTH_THUMB1,
                                  //NaMidia::HEIGHT_THUMB1);

                                //Gera thumb medio (thumb normal na lista de notícias)
                                //$this->geraThumb($this->PASTA_UPLOAD .$caminhoUnico. NaMidia::PREFIX_THUMB0 . $arquivo['name'], $this->PASTA_UPLOAD .$caminhoUnico.  NaMidia::PREFIX_THUMB2 . $arquivo['name'],NaMidia::WIDTH_THUMB2,NaMidia::HEIGHT_THUMB2);

                                //Gera thumb pequeno (thumb pequeno dentro do detalhe da notícia - lista "Matérias Recentes")
                                //$this->geraThumb($this->PASTA_UPLOAD .$caminhoUnico. NaMidia::PREFIX_THUMB0 . $arquivo['name'], $this->PASTA_UPLOAD .$caminhoUnico.  NaMidia::PREFIX_THUMB3 . $arquivo['name'],NaMidia::WIDTH_THUMB3,NaMidia::HEIGHT_THUMB3);

                                if (!$boolArquivoOk) {
                                    $this->Flash->error('O sistema deu um erro ao salvar a imagem, mas sua notícia foi criado. Tente salvar ela novamente modificando este conteúdo ou verifique se sua extenção é JPG, GIF ou PNG.');
                                }
                            }else{
                                $namidia->ImagemResumo = $imagemAtual;
                                $namidia->unsetProperty('ImagemResumo');
                            }

                        $this->Flash->success('Clipping salvo com sucesso!');
                        $this->redirect(array('action' => 'index'));
                    }else
                    {
                        $this->Flash->error('Erro ao salvar mídia!');
                    }
                }
            }
        }
        if($namidia != null){
            if($namidia->Publicacao != null)
                $namidia->Publicacao = $this->UData->ConverterDataBrasil($namidia->Publicacao);
            else
                $this->request->data['NaMidia']['Publicacao'] = $this->UData->ConverterDataBrasil(date('Y-m-d'));

            if($namidia->InicioExibicao != null)
                $namidia->InicioExibicao = $this->UData->ConverterDataBrasil($namidia->InicioExibicao);
            else
                $this->request->data['NaMidia']['InicioExibicao'] = $this->UData->ConverterDataBrasil(date('Y-m-d'));

            if($namidia->TerminoExibicao != null)
                $namidia->TerminoExibicao = $this->UData->ConverterDataBrasil($namidia->TerminoExibicao);
        }

		$this->set('namidia', $namidia);
	}

    //2017-01-22 Paulo Campos: Pega ID do registro (Codigo primary key)
     private function geraThumb($src, $dest, $desired_width,$desired_height) {

         //echo "src " . $src . " - " . $dest . " " ;

         $mimetype = exif_imagetype($src);
         $validacao = true;

         //echo $mimetype . " " . $src . " " . $dest;

          /* Le a imagem source de acordo com o mimetype*/
          switch ($mimetype) {
            case 1: //GIF
              $source_image = imagecreatefromgif($src);
              break;
            case 2: //JPG
              $source_image = imagecreatefromjpeg($src);
              break;
            case 3://PNG
              $source_image = imagecreatefrompng($src);
              break;
          default:
              $validacao = false;
          }
          $width = imagesx($source_image);
          $height = imagesy($source_image);

          if($desired_width > $desired_height){
                 $y = 0;
                 $x =($width - $height) / 2.5;
                 $menorLadoLado = $height +100;
                 $height = $desired_height;
          }else if($desired_width == NaMidia::WIDTH_THUMB2){
                 $y = 0;
                 $x =($width - $height) / 2;
                 $menorLadoLado = $height +150;
                 $height = $desired_height -10;
          }
          else{
                 $x = 0;
                 $y = 0;
                 $menorLadoLado = $height;

          }

          /* Cria uma imagem virtual */
          $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

          /* Copia a imagem e faz o resize */
          imagecopyresampled($virtual_image, $source_image, 0, 0, $x, $y,
            $desired_width, $desired_height,
            $menorLadoLado, $height);

          /* cria o arquivo fisico de acordo com o mimetype*/
          switch ($mimetype) {
            case 1: //GIF
              imagegif($virtual_image, $dest);
              break;
            case 2: //JPG
              imagejpeg($virtual_image, $dest);
              break;
            case 3://PNG
              imagepng($virtual_image, $dest);
              break;
          default:
              $validacao = false;
          }

        //echo " - - - " . $validacao;
        //die();
          if (!$validacao)
            return false;
          else
            return true;
     }


	public function delete($id)
	{
		if(isset($id)){
            $conn = TableRegistry::get("NaMidia");
            $namidia = $conn->find('all')->where(['codigo' => $id, 'ativo' => true])->first();
            if($namidia != null){
                $namidia->Ativo = false;
                if($conn->save($namidia)){
                    $this->Flash->success('Clipping excluído com sucesso.');
                }else{
                    $this->Flash->error('Erro ao salvar clipping.');
                }
            }else{
                $this->Flash->error('Clipping não encontrado.');
            }
        }
        else{
            $this->Flash->error('Id inválido.');
        }

        $this->redirect(array('action' => 'index'));
	}

}

?>
