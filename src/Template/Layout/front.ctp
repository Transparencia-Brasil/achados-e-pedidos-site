<?php
use Cake\Core\Configure;
use Phinx\Config\Config;

$cakeDescription = 'Achados e Pedidos';
$slug = isset($slug) ? $slug : isset($slug_pai) ? $slug_pai : "";

$titulo = isset($title) ? " - " . $title : "";

$linkChat = Configure::read("BlipChat.AppLink");
$blipchat_key = Configure::read("BlipChat.Key");
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
      <!-- Google Tag Manager -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-MN3TZMR');</script>
      <!-- End Google Tag Manager -->

        <?= $this->Html->charset() ?>
        <title>
            <?= $cakeDescription ?>
            <?= $titulo ?>
        </title>
        <meta name="description" content="Portal LAI - Achados e Pedidos">
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Pathway+Gothic+One" type="text/css" />
        <!-- Favicon -->
        <link rel="icon" href="<?=BASE_URL?>assets/images/favicon.png" sizes="16x16">
        <?= $this->fetch('meta');
        //echo $this->Html->script('/admin/js/jquery-1.9.1.min.js');
        echo $this->Html->css('/assets/css/public.css', ['rel' => 'stylesheet', 'media' => 'all']);
        echo $this->Html->css('/assets/css/crop_images.css', ['rel' => 'stylesheet', 'media' => 'all']);
        echo $this->Html->css('/assets/css/adjustments.css', ['rel' => 'stylesheet', 'media' => 'all']);
        echo $this->Html->css('/assets/css/charts.css', ['rel' => 'stylesheet', 'media' => 'all']);
        echo $this->Html->css('/assets/css/chat.css', ['rel' => 'stylesheet', 'media' => 'all']);
        echo $this->Html->script('/assets/js/jquery-3.1.1.min.js');
        ?>
        <script src="<?=BASE_URL?>assets/js/jquery.mask.min.js"></script>
        <script src="<?=BASE_URL?>assets/js/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA==" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?=BASE_URL?>assets/css/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?=BASE_URL?>assets/css/jquery-ui/jquery-ui.structure.min.css">
        <link rel="stylesheet" href="<?=BASE_URL?>assets/css/jquery-ui/jquery-ui.theme.min.css">


        <script type="text/javascript">
            var base_url = '<?=BASE_URL?>';
            var es_url = '<?=ES_URL?>';
            var logado = <?=$this->FrontEnd->UsuarioLogadoEcho()?>

        </script>
        <style type="text/css">
          .error{
            color:red;
          }
        </style>
    </head>
<body>
      <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MN3TZMR"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
      <div class="wrapper">
        <header>
          <div class="container">
            <div class="row">
              <div class="col-md-8 col-sm-12 col-xs-12 logosHeader">
                <div>
                <a href="http://www.abraji.org.br/" target="_blank">
                  <img src="<?=BASE_URL?>assets/images/home/logo-abraji.png" alt="Abraji" class="img-first">
                </a>
                <img src="<?=BASE_URL?>assets/images/home/logo-tranparencia-divisao.png" alt="Tranparência Brasil" class="img-div hidden-xs">
                <a href="http://www.transparencia.org.br/" target="_blank">
                  <img src="<?=BASE_URL?>assets/images/home/tb-logo-cinza.png" alt="Tranparência Brasil" class="img-last">
                </a>
              </div>
              </div>
                <?php
                  $this->Header->login();
                ?>
            </div>
          </div>
          <nav class="navbar navbar-default">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="<?=$this->Url->build(["controller" => "Home","action" => "index", "prefix" => false]); ?>">
                    <img src="<?=BASE_URL?>assets/images/home/logo-projeto.png" alt="logo">
                  </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                  <ul class="nav navbar-nav">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sobre <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="<?=$this->Url->build(["controller" => "Institucional","action" => "index", "prefix" => false]); ?>">Institucional</a></li>
                        <li><a href="<?=$this->Url->build(["controller" => "Faq","action" => "index", "prefix" => false]); ?>">Dúvidas</a></li>
                        <li><a href="<?=$this->Url->build(["controller" => "NaMidia","action" => "index", "prefix" => false]); ?>">Notícias</a></li>
                        <li><a href="<?=$this->Url->build(["controller" => "Contato","action" => "index", "prefix" => false]); ?>">Contato</a></li>
                      </ul>
                    </li>
                    <li><a href="<?=$this->Url->build(["controller" => "Pedidos","action" => "index", "prefix" => false]); ?>">Pedidos</a></li>
                    <li><a href="<?=$this->Url->build(["controller" => "Publicacoes","action" => "index", "prefix" => false]); ?>">Publicações</a></li>
                    <li><a href="<?=$this->Url->build(["controller" => "Dados","action" => "index", "prefix" => false])?>">Dados</a></li>
                    <li><a href="#" class="menuLast toogle-chat">Quer ajuda?</a></li>
                    <li class="loginMobile"><a href="<?=$this->Url->build('/minhaconta/pedidos/novopedido'); ?>">Inserir Pedido</a></li>
                    <li class="loginMobile"><a href="#" class="toogle-chat">Quer ajuda?</a></li>
                    <?php
                    if($this->FrontEnd->UsuarioLogado()){
                      ?>
                      <li class="loginMobile"><a href="<?=$this->Url->build('/minha-conta/meus-pedidos'); ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Meu Perfil</a></li>
                      <li class="loginMobile"><a href="<?=$this->Url->build('/minha-conta/logout'); ?>">Sair <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></a></li>
                    <?php
                    }else{
                      ?>
                      <li class="loginMobile"><a href="<?=$this->Url->build('/minhaconta'); ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Entrar</a></li>
                    <?php
                    }
                    ?>
                    <!-- /change-view-search -->
                    <form class="navbar-form navbar-right" role="search" id="frmBusca" action="<?=BASE_URL?>pedidos" method="get">
                      <div id="custom-search-input">
                          <div class="input-group col-md-12 col-xs-12">
                              <input type="text" list="fieldList" name="buscaFixa" id="buscaFixa" class="form-control input-lg" placeholder="Digite aqui sua busca">
                              <span class="input-group-btn">
                                  <button class="btn btn-info btn-lg" type="button" onclick="$('#frmBusca').submit()" attr="busca_pedido">
                                      <i class="glyphicon glyphicon-search"></i>
                                  </button>
                              </span>
                          </div>
                      </div>
                    </form>
                  </ul>
                </div>
              </div>
              <!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </nav>
        </header>
        <!--Cards-->
        <div class="wr wr-content">
            <?= $this->fetch('content') ?>
        </div>
    <footer>
      <div class="container-fluid bgFooter">
        <div class="container">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <img src="<?=BASE_URL?>assets/images/footer/logo-projeto.png" alt="Logo"/>
            </div>
            <div class="col-md-5 col-sm-6 col-xs-12">
              <h2>Sobre</h2>
              <ul>
                <div class="col-md-4 col-sm-6 col-xs-6">
                  <li><a href="<?=$this->Url->build(["controller" => "Institucional","action" => "index", "prefix" => false])?>">Institucional</a></li>
                  <li><a href="<?=$this->Url->build(["controller" => "Faq","action" => "index", "prefix" => false])?>">Dúvidas</a></li>
                  <li><a href="<?=$this->Url->build(["controller" => "NaMidia","action" => "index", "prefix" => false])?>">Notícias</a></li>
                  <li><a href="<?=$this->Url->build(["controller" => "Contato","action" => "index", "prefix" => false])?>">Contato</a></li>
                </div>
                <div class="col-md-5 col-sm-6 col-xs-6">
                  <li><a href="<?=$this->Url->build(["controller" => "Publicacoes","action" => "index", "prefix" => false])?>">Publicações</a></li>
                  <li><a href="<?=$this->Url->build(["controller" => "Pedidos","action" => "index", "prefix" => false])?>">Pedidos</a></li>
                  <li><a href="<?=$this->Url->build(["controller" => "Dados","action" => "index", "prefix" => false])?>">Dados</a></li>
                  <li><a href="<?=$this->Url->build(["controller" => "Cursos","action" => "index", "prefix" => false])?>">Cursos</a></li>
                  <li><a href="#" class="toogle-chat">Quer ajuda?</a></li>
                </div>
              </ul>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 pull-right">
              <div class="redesSociais">
                <a href="https://twitter.com/trbrasil/" target="_blank"><img src="<?=BASE_URL?>assets/images/footer/twitter.jpg" alt="Twitter"/></a>
                <a href="https://www.facebook.com/brasil.transparencia/" target="_blank">
                  <img src="<?=BASE_URL?>assets/images/footer/facebook.jpg" alt="Facebook"/>
                  </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container">

        <div class="row last">
          <div class="col-md-1 col-sm-12 col-xs-12 no-gutter-left">
            <img src="<?=BASE_URL?>assets/images/footer/logo-creative.jpg" alt="creative" class="ImgCreative"/>
          </div>
          <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="politica">
            <p>
              Todo o nosso conteúdo pode ser publicado ou reutilizado de forma gratuita, exceto a maioria das fotografias, ilustrações e vídeos.</p>
              <a href="<?=$this->Url->build("/termos-de-uso"); ?>"><strong>Termos de Uso</strong></a><span>e</span><a href="<?=$this->Url->build("/politica-de-privacidade"); ?>"><strong>&nbsp;Política de Privacidade</strong></a>
            </div>
          </div>
          <div class="col-md-2 col-sm-12 col-xs-12 copyright no-gutter-right">
            <p>2017 © Achados e Pedidos.</p>
          </div>
        </div>
      </div>
    </footer>
    <a href="javascript:void(0);" data-toggle="modal" data-target="#modalnaologado" id="modalLogin" style="display:none" ></a>
    <!-- line modal -->
    <div class="modal-warning modal fade" id="modalnaologado" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">
              <img src="<?=BASE_URL?>assets/images/cursos/fechar.png" alt="Fechar"></span>
              <span class="sr-only">Fechar</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- content goes here -->
            <div class="box">
              <img src="<?=BASE_URL?>assets/images/geral/warning.png" alt="Espere!">
              <p class="warning-title">Esta ação requer login</p>
              <p>Você precisa se logar no site para fazer essa ação.</p>
              <div class="col-sm-12">
                <div class="bntVerMais"><a href="<?=$this->Url->build('/login/')?>">Fazer login</a></div>
              </div>
              <a href="<?=$this->Url->build('/cadastro/')?>">Não tenho login, quero me cadastrar.</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container text-center" style="background-color: #cccccc; position:fixed; bottom: 0; width:100%; display:none" id="divDisclaimer">
      <div class="row" style="padding: 10px;">
        <div class="col-8 col-sm-10">
          <p>Utilizamos cookies conforme descrito em nossa <a href="/politica-de-privacidade" style="color: #3d3d3c"><u>Política de Privacidade</u></a> e, ao seguir navegando, você concorda com essas condições.</p>
        </div>
        <div class="col-2 col-sm-2">
            <button type="button" class="close btnClosedivDisclaimer" aria-label="Close" id="btnDisclaimer" style="opacity:0.7;font-size:25px; float:none; margin-left:20px">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      </div>
    </div>

    <div class="message-bubble">
        <p>Quer ajuda com um pedido ou recurso?</p>
        <span class="close-button" id="bubble-msg" onclick="this.parentElement.style.display='none'"></span>
    </div>

    <script type="text/javascript">

      $(document).ready(function() {

        <?php
        if (strpos($_SERVER['REQUEST_URI'], 'politica-de-privacidade') === false) {
        ?>
          if ($.cookie('closedDisclaimer') != 'true') {
            $('#divDisclaimer').show();
          };
        <?php
        };
        ?>

        $('#divDisclaimer').on('click', function(e) {
          $('#divDisclaimer').hide();
          $.cookie('closedDisclaimer', 'true', {
            expires: (1 / 24)
          });
        });
      });
    </script>

    <!--// line modal -->
    <script type="text/javascript" src="assets/js/busca_avancada.js" ></script>

    <!-- Deferred JavaScript -->
    <script type="text/javascript" src="<?=BASE_URL?>assets/js/wow/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="<?=BASE_URL?>assets/js/bootstrap-filestyle.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/bootstrap.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/chart.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/slick.min.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="<?=BASE_URL?>assets/js/functions.js"></script>




    <script src="https://unpkg.com/blip-chat-widget@1.6.*" type="text/javascript"></script>
    <script>
        (function () {
            window.onload = function () {
                var blipClient = new BlipChat();
                blipClient.withAppKey('<?= $blipchat_key ?>')
                blipClient.withButton({"color":"#f9a521","icon":""})
                blipClient.withEventHandler(BlipChat.LOAD_EVENT, function () {
                    document.getElementById('bubble-msg').click() 
                })
                blipClient.withCustomCommonUrl('https://chat.blip.ai/')
                blipClient.build();
                $(".toogle-chat").on('click', () => {
                  blipClient.toogleChat();
                });
            }
        })();
    </script>
  </body>
</html>
