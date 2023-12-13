

<div class="container-fluid breadcrumbLinha">
  <div class="container">
    <div class="row">
      <ul class="breadcrumb">
        <li class="completed">Home</li>
        <li class="completed"><a href="/newsletter">Newsletter</a></li>
        <li class="active"><a href="#">Arquivo</a></li>
      </ul>
    </div>
  </div>
</div>

<section class="contato">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <h1>Arquivo Newsletter</h1>
        <img src="<?=BASE_URL?>assets/images/home/linhas.png" alt="Como Funciona">
        <div style="width:50%;margin: 0 auto;">
          <p style="text-align:left!important;margin-bottom:20px;margin-left:0px;">
            <a class="btn" href="<?=$this->Url->build(["controller" => "Newsletter", "action" => "index", $agente->Codigo]); ?>" title="Editar" style="width:auto;background-color:#f9a521!important;color:white;border-radius:4px;">junte-se a nossa lista de emails</a>
          </p>
        </div>
        
        <div style="width:50%;margin: 0 auto 50px auto;">
          <style type="text/css">
          <!--
          .display_archive {font-family: arial,verdana; font-size: 12px;}
          .campaign {line-height: 125%; margin: 5px;}
          //-->
          </style>
          <script language="javascript" src="//abraji.us8.list-manage.com/generate-js/?u=3a2d727753f3d085d23587074&fid=7&show=10000" type="text/javascript"></script>
        </div>        
      </div>
    </div>
  </div>
</section>
