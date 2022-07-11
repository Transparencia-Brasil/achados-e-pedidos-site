<!--Cards-->
  <section class="cards">
    <div class="container">
      <div class="row">
        <div class="">
          <?php
          /* Destaques da home. exibe item padrão caso não existam */
          $destaquePrincipal = $destaques->where(["CodigoTipoDestaqueHome" => 1])->first();
          $destaqueSecundarioUm = $destaques2->where(["CodigoTipoDestaqueHome" => 2])->first();
          $destaqueSecundarioDois = $destaques3->where(["CodigoTipoDestaqueHome" => 3])->first();

          //echo ($destaquePrincipal);

          if($destaquePrincipal != null){
            ?>
            <div class="col-md-6 col-sm-6 col-xs-12 primeiroCard">
              <a href="<?=$destaquePrincipal->Link?>">
                <img src="uploads/banners/<?=$destaquePrincipal->Imagem?>" alt="<?=$destaquePrincipal->Nome?>" class="img-responsive">
                <h1><?=$destaquePrincipal->Nome?></h1>
                <p><?=$destaquePrincipal->Resumo?></p>
              </a>
            </div>
            <?php
          }else{
          ?>
          <div class="col-md-6 col-sm-6 col-xs-12 primeiroCard">
            <a href="<?=$this->Url->build('/institucional/')?>">
              <img src="assets/images/home/img-na-midia-1.jpg" alt="Institucional" class="img-responsive">
              <h1>Institucional</h1>
              <p>Conheça mais sobre o trabalho da Transparência Brasil junto a Abraji.</p>
            </a>
          </div>
          <?php
          }

          if($destaqueSecundarioUm != null){
            ?>
            <div class="col-md-6 col-sm-6 col-xs-12 pull-right segundoCard">
              <a href="<?=$destaqueSecundarioUm->Link?>"><img src="uploads/banners/<?=$destaqueSecundarioUm->Imagem?>" alt="<?=$destaqueSecundarioUm->Nome?>" class="img-responsive">
              <h1><?=$destaqueSecundarioUm->Nome?></h1>
              <p><?=$destaqueSecundarioUm->Resumo?></p></a>
            </div>
          <?php
          }else{
          ?>
          <div class="col-md-6 col-sm-6 col-xs-12 pull-right segundoCard">
            <a href="<?=$this->Url->build('/na-midia/')?>">
              <img src="assets/images/home/img-na-midia-2.jpg" alt="Institucional" class="img-responsive">
              <h1>Na Mídia</h1>
              <p>Veja os destaques que sairam na mídia sobre o projeto!</p>
            </a>
          </div>
          <?php
          }

          if($destaqueSecundarioDois != null){
            ?>
            <div class="col-md-6 col-sm-6 col-xs-12 pull-right ultimoCard">
              <a href="<?=$destaqueSecundarioDois->Link?>">
                <h1><?=$destaqueSecundarioDois->Nome?></h1>
                <p><?=$destaqueSecundarioDois->Resumo?></p>
              </a>
            </div>
          <?php
          }else{
          ?>
            <div class="col-md-6 col-sm-6 col-xs-12 pull-right ultimoCard">
              <a href="<?=$this->Url->build('/cursos/')?>">
                <h1>Cursos</h1>
                <p>Confira os cursos oferecidos pela Abraji.</p>
              </a>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </section>

  <!--Como Funciona-->
  <section class="comoFunciona" id="parallaxBar" data-speed="25" data-type="background">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <h1>COMO FUNCIONA</h1>
          <img src="assets/images/home/linhas.png" alt="Como Funciona">
          <p>
          O Achados e Pedidos reúne solicitações de cidadãos e respostas da administração
          pública feitas via Lei de Acesso à Informação (LAI).
            <br><br>
            Todo cidadão tem direito de obter informações públicas a<br> respeito de qualquer assunto, por exemplo: quanto se gasta<br> com funcionários em determinado órgão público? Ou quanto<br> de água é desperdiçado por problemas de encanamento da<br> própria empresa pública? <br><br>
            <strong>O que você quer saber? Busque uma resposta ou<br> base de dados disponibilizada pelo governo no<br> nosso site.</strong>
          </p>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 lupa">
          <img src="assets/images/home/img-como-funciona.png" alt="Como Funciona" class="img-responsive">
        </div>
      </div>
    </div>
  </section>

  <!--Dados-->
  <section class="dados">
    <div class="container">
      <div class="row">
        <h1>CONFIRA OS DADOS</h1>
        <img src="assets/images/home/linhas.png" alt="Como Funciona">
        <p>
          Achados e Pedidos reúne solicitações de cidadãos e respostas da administração <br>pública feita via Lei de Acesso à Informação ( LAI ).
        </p>
        <?php
        $relatorioTotal = $viewModel["RelatorioTotal"];

        $totalPedidos = $relatorioTotal["Total"];
        $totalAtendidos = $relatorioTotal["TotalAtendidos"];
        $totalNaoAtendidos = $relatorioTotal["TotalNaoAtendidos"];
        $pcAtendidos = $totalAtendidos == 0 ? 0 : $totalAtendidos / $totalPedidos;
        $pcNaoAtendidos = $totalAtendidos == 0 ? 0 : $totalNaoAtendidos / $totalPedidos;




        ?>
        <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInLeft animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInLeft;">
          <img src="assets/images/home/icon-pedidos-base.jpg" alt="Pedidos na Base"/>
          <h2>Pedidos<br> na Base</h2>
          <h3 class="qnt"><?=$totalPedidos?></h3>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12 box wow fadeInDown animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: fadeInDown;">
          <img src="assets/images/home/icon-pedidos-atendidos.jpg" alt="Pedidos Atendidos"/>
          <h2>Pedidos<br> Atendidos</h2>
          <h3 class="qnt"><?=number_format($pcAtendidos *100, 0)?>%</h3>
          <h4 class="numbers"><?=$totalAtendidos?></h4>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12 box wow slideInRight animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: slideInRight;">
          <img src="assets/images/home/icon-pedidos-nao-atendidos.jpg" alt="Pedidos Atendidos"/>
          <h2>Pedidos<br> Não atendidos</h2>
          <h3 class="qnt"><?=number_format($pcNaoAtendidos *100, 0)?>%</h3>
          <h4 class="numbers"><?=$totalNaoAtendidos?></h4>
        </div>
      </div>

      <div class="boxTotal">
       <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12 mapaBrasil">
            <div id="mapa" class="ajax show-resource row mapaBrasil" data-resource="mapa" data-show-template="#project-show-template">
              <h2>• Total de pedidos por estado</h2>
              <hr>
              <div id="mapa_relatorio">
                  <svg version="1.1" id="svg-map" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="450px" height="460px" viewBox="0 0 450 460" enable-background="new 0 0 450 460" xml:space="preserve">
                      <g>
                        <a xlink:href="#tocantins" data-id="27" data-uf="TO" style="pointer-events: none;cursor: default;">
                          <path id="t_to" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M289.558,235.641
                          c16.104,0.575,44.973-31.647,44.835-45.259c-0.136-13.612-17.227-58.446-22.349-66.088c-5.122-7.628-37.905,2.506-37.905,2.506
                          S234.852,233.695,289.558,235.641z"></path>
                          <text id="t_to" x="293" y="192" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">TO</text>
                        </a>
                        <a xlink:href="#bahia" data-id="5" data-uf="BA" style="pointer-events: none;cursor: default;">
                          <path id="t_ba" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M313.276,197.775
                          c2.084-2.739,3.506-7.012,6.464-8.764c1.641-0.973,3.232-4.684,4.271-5.163c2.304-1.014,12.161-25.143,20.706-22.513
                          c1.095,0.342,29.881,3.478,32.153,7.532c2.246-0.506,17.582-8.804,25.829-4.999c9.172,4.246,11.225,20.679,11.2,20.843
                          c0.107,0.328-0.823,5.765-0.985,5.929c-1.15,1-5.258-0.807-4.22,2.138c1.317,3.751,5.094,10.583,9.97,6.613
                          c-3.669,6.574-6.846,16.022-13.966,17.747c-5.808,1.411-4.605,13.421-5.178,18.037c-0.465,3.75,0.192,8.448,1.014,12.117
                          c1.148,4.959-0.821,8.6-1.808,13.42c-0.822,4.162-0.219,8.299-0.987,12.297c-0.271,1.286-4.407,5.723-5.559,7.148
                          c-1.616-1.426-63.952-37.248-73.1-36.265c1.149-3.738,2.438-9.559-0.741-12.723c-8.625-8.572-0.135-19.335-0.162-19.432
                          c-0.546-1.725-5.396-6.079-0.026-7.175c-3.175,0.959-1.944-4.027,0.875-3.012C316.726,200.733,314.044,200.527,313.276,197.775z"></path>
                          <text id="t_ba" x="367" y="213" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">BA</text>
                        </a>
                        <a xlink:href="#sergipe" data-id="25" data-uf="SE" style="pointer-events: none;cursor: default;">
                          <path id="sergipe" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M408.561,191.735
                          c0.521-1.505,2.465-0.725,3.533-0.794c2.273-0.164,0.494-2.738,1.095-3.778c2.026-3.793-2.738-5.999-1.998-10.408
                          c4.024,1.931,9.448,3.397,12.408,6.89c1.343,1.533,5.504,2.656,5.832,4.847c-6.822,0.384-6.901,8.819-11.942,11.572
                          C413.545,202.212,407.055,193.721,408.561,191.735z"></path>
                          <path class="circle" d="M417.324,182.854c6.214,0,11.266,5.035,11.266,11.262c0,6.208-5.052,11.261-11.266,11.261
                          c-6.238,0-11.258-5.053-11.258-11.261C406.063,187.89,411.084,182.854,417.324,182.854z"></path>
                          <text id="sergipe" x="417" y="199" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">SE</text>
                        </a>
                        <a xlink:href="#pernambuco" data-id="16" data-uf="PE" style="pointer-events: none;cursor: default;" >
                          <path id="pernambuco" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M373.011,167.238
                          c2.709-0.795,6.218-14.106,8.325-15.106c4.136-1.986,17.255-1.437,17.8,4.903c-0.437-0.068,8.189-2.273,7.479-1.466
                          c1.7-0.711,10.518-4.723,12.599-4.82c0.274-0.013,4.603,0.905,3.068,2.315c-0.464,0.439,4.219,3.698,10.789,3.45
                          c4.66-0.176,5.179-3.436,8.627-4.409c5.89-1.67,4.737,3.698,5.589,6.943c-1.182,2.684-1.646,5.586-2.74,8.285
                          c-1.533,3.792-9.804,9.791-13.39,12.119c-7.287,4.778-21.802-4.067-22.762-5.67c-0.602-0.985-2.55-5.121-3.178-5.107
                          c-0.629,0.356-1.04,0.861-1.287,1.519c-0.904-0.013-7.256-3.533-7.502-4.655c-4.769-1.151-5.425,6.108-8.957,6.19
                          c0.219,0.108-8.244,6.681-7.506,3.314C383.556,170.4,374.241,168.566,373.011,167.238z"></path>
                          <text id="pernambuco" x="408" y="167" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">PE</text>>
                        </a>
                        <a xlink:href="#alagoas" data-id="2" data-uf="AL" style="pointer-events: none;cursor: default;">
                          <path id="alagoas" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M413.953,169.018
                          c3.78,3.313,9.424,5.505,12.547,5.491c3.229-0.013,5.009-3.328,7.421-4.794c1.177-0.712,10.297-1.93,9.174,1.042
                          c-1.807,4.848-7.122,8.585-10.024,12.789c-2.792,2-3.423,7.093-6.354,1.864c-3.259,0.424-3.722-4.424-6.957-4.477
                          c-3.668-2.261-7.998-3.769-11.201-6.342C410.615,172.646,412.751,171.359,413.953,169.018z"></path>
                          <path class="circle" d="M436.423,168.763c6.236,0,11.258,5.054,11.258,11.278c0,6.207-5.02,11.259-11.258,11.259
                          c-6.241,0-11.263-5.052-11.263-11.259C425.16,173.816,430.182,168.763,436.423,168.763z"></path>
                          <text id="alagoas" x="437" y="184" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">AL</text>
                        </a>
                        <a xlink:href="#riograndedonorte" data-id="20" data-uf="RN" style="pointer-events: none;cursor: default;">
                          <path id="rioGrandeN" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M404.698,138.795
                          c2.383-4.027,6.574-6.123,8.49-11.149c1.973-5.107,3.834-5.818,8.764-4.642c5.041,1.207,9.339,0.837,14.57,1.671
                          c7.534,1.193,6.848,10.968,9.206,16.516c-1.919,1.096-13.972,0.521-15.064-1.657c-1.041-2.067-2.904,7.107-5.094,7.3
                          c1.532-5.847-12.654,1.78-5.424-8.683c2.545-3.67-6.302-0.808-6.711,0.725C410.121,144.013,407.217,139.151,404.698,138.795z"></path>
                          <path class="circle" d="M430.827,107.798c6.241,0,11.261,5.039,11.261,11.261c0,6.224-5.02,11.261-11.261,11.261
                          c-6.209,0-11.26-5.037-11.26-11.261C419.567,112.837,424.618,107.798,430.827,107.798z"></path>
                          <text id="rioGrandeN" x="431" y="124" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">RN</text>
                        </a>
                        <a xlink:href="#ceara" data-id="6" data-uf="CE" style="pointer-events: none;cursor: default;">
                          <path id="ceara" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M372.379,104.409
                          c0.437-1.368,2.961-3.627,1.043-5.025c12.106-1.328,17.581-0.849,27.66,6.723c4.026,3.054,6.822,5.574,10.571,9.147
                          c1.317,1.273,7.614,4.313,7.914,6.164c-0.054-0.316-5.396,3.696-5.997,5.217c-1.066,2.684-2.659,6.093-4.3,8.298
                          c0.025-0.055-6.903,3.957-3.532,4.217c-4.41,3.821-1.015,8.135-0.797,11.517c0.196,2.767-4.38,7.587-6.765,5.422
                          c-2.244-1.999-3.998-5.711-7.779-5.094c-1.998,0.329-5.476,2.189-7.612,0.479c-2.52-2.054,3.669-5.162-0.545-7.354
                          c-6.987-3.615-1.264-15.393-6.684-20.239c-3.504-3.136,1.753-7.313,0.109-10.749C374.952,111.68,373.694,105.244,372.379,104.409
                          C373.035,102.314,374.815,105.971,372.379,104.409z"></path>
                          <text id="ceara" x="395" y="128" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">CE</text>
                        </a>
                        <a xlink:href="#piaui" data-id="17" data-uf="PI" style="pointer-events: none;cursor: default;">
                          <path id="piaui" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M320.781,185.478
                          c2.465-5.149-7.505-20.801-7.505-20.801s47.354-65.868,54.285-66.841c0.299-0.042,6.243,1.768,6.463,2.219
                          c0.438,0.863-0.821,5.244-0.685,6.587c0.275,2.629,2.879,6.587,2.328,8.684c-1.15,4.736-1.863,6.134,1.369,9.901
                          c2.794,3.245,0.325,10.16,2.544,14.269c-1.778,4.23,4.768,3.656,3.943,7.613c-0.655,3.163-5.424,7.655-1.176,10.312
                          c0.274,4.642-4.685,4.983-6.79,7.818c-2.631,2.835-5.535,5.013-7.999,7.888c-0.55,0.671-8.821,4.096-9.998,4.082
                          c0.302-0.301-17.665-6.449-11.967,2.354c2.463,3.808-1.505,5.56-3.177,8.778c-0.633,2.164-5.836,0.958-7.836,3.205
                          C328.176,198.748,327.409,180.727,320.781,185.478z"></path>
                          <text id="piaui" x="358" y="161" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">PI</text>
                        </a>
                        <a xlink:href="#maranhao" data-id="10" data-uf="MA" style="pointer-events: none;cursor: default;">
                          <path id="maranhao" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M288.845,127.827
                          c4.108-2.726,31.195-48.985,31.386-50.395c1.235,0.397,6.084,7.435,7.562,5.025c0.493,0.013-0.328,2.15-0.547,2.396
                          c-0.054-0.135,2.189-2.286,2.52-2.436c0.521-0.233,1.948,1.903,3.451-0.726c5.642,1.575,1.314,14.31,9.121,11.694
                          c-1.147,0.384,1.452,0.74,0.848,1.905c5.095-6.587,8.488-0.027,15.337,1.491c2.025,0.466,6.243,0.575,8.162,0.207
                          c3.808-0.823-2.082,6.847-2.082,6.887c-1.369,2.986-5.041,1.713-6.818,5.683c-0.684,1.549-3.506,4.327-3.042,6.148
                          c0.494,1.781,2.081,2.863,0.274,4.629c0.603,2.793,3.066,7.109-0.385,9.12c-4.601,4.383,2.304,7.52,1.316,11.598
                          c-0.9,3.726-6.244,5.725-9.147,2.78c-4.847-0.11-6.872,3.821-10.406,6.45c-2.74,2.041-8.793,2.493-10.327,5.642
                          c-1.918,3.929-3.699,8.763-5.341,12.79c-1.699,4.204,6.383,18.762-4.328,15.611c-0.932-0.273-3.396-4.725-3.396-5.738
                          c-0.081-3.739-2.738-4.176-4.821-7.477c0.356-3.025,2.466-6.929,4.766-8.052c3.342-1.63,1.919-6.629-2.466-4.465
                          c-3.505,1.726-4.709-2.794-6.958-5.287c0.548,0.59-3.064-4.696-3.146-3.697c0.19-1.89,2.876-5.833,3.341-8.448
                          c0.575-3.259,0.52-6.764-0.521-10.105c-0.63-2.068-4.656-4.521-6.518-4.437c-1.289,0.287-2.443,0-3.427-0.878
                          C290.983,125.675,290.983,128.044,288.845,127.827z"></path>
                          <text id="maranhao" x="329" y="127" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">MA</text>
                        </a>
                        <a xlink:href="#amapa" data-id="4" data-uf="AP" style="pointer-events: none;cursor: default;">
                          <path id="amapa" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M225.198,39.089
                          c3.274,1.165,3.985-1.315,6.572-1.74c3.616-0.603,5.683,2.725,9.037,2.067c4.055-0.78,7.093-8.025,7.314-11.598
                          c4.492-3.534,5.503-11.258,9.42-14.68c6.055,4.258,6.11,15.788,7.589,22.485c-0.164,0.083,6.57,7.998,7.944,8.682
                          c3.396,1.657,3.366,6.203,0.078,9.34c-3.777,3.587-7.449,34.275-7.449,34.275h-46.489c0,0,0.932-50.366,0-51.449
                          C221.814,36.458,223.334,38.417,225.198,39.089z"></path>
                          <text id="amapa" x="254" y="55" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">AP</text>>
                        </a>
                        <a xlink:href="#para" data-id="14"  data-uf="PA" style="pointer-events: none;cursor: default;">
                          <path id="para" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M173.378,50.619
                          c2.259,2.63,5.629-4.478,7.901-3.82c3.19,0.918,1.478-1.108,5.026-1.752c1.931,0.806,3.096,0.273,3.519-1.631
                          c0.535-1.26,1.453-1.726,2.725-1.384c1.768-1.684,13.558,3.603,14.68,0.384c0.629-1.821-4.287-5.709-0.302-6.997
                          c1.643-0.533,6.012,0.808,8.75-0.068c3.986-1.288,4.876,2.684,4.382,6.066c0.631,3.587,13.145,5.766,12.982,7.97
                          c3.589-1.518,5.354,12.763,7.105,14.447c0.357,4.26,6.304,8.585,7.07,12.544c0.628,3.396,7.065,3.616,8.213,0.095
                          c2.578-8.133,9.696-10.022,13.475-16.651c4.603-8.038,3.725,3.752,8.955,1.067c2.11,0.411,2.876,3.629,4.574,4.724
                          c3.18,2.027,7.779,0.974,10.572,3.013c-4.192,4.382,8.188,3.752,9.231,3.875c4.682,0.575,8.104,2.383,11.855,3.629
                          c-0.164-0.069,4.792,0.52,5.178,1.245c2.026,3.767-4.904,19.214-6.382,21.486c-1.121,1.713-2.932,4.985-3.727,6.834
                          c-0.902,2.026-4.764,7.313-4.655,9.229c-1.888,0.972-2.248,4.835-5.012,4.328c-3.096,3.026-8.187,4.999-10.27,8.956
                          c2.057,0.781,8.325,1.041,5.311,4.272c-0.821,0.877-1.094,5.533-1.615,6.833c-0.575,1.384-4.464,4.779-6.108,5.34
                          c-4.107,1.426-2.736,4.135-4.271,7.655c-0.933,2.054-0.546,3.491,1.756,4.339c-0.083,2.835-0.988,5.575-2.385,7.998
                          c-3.041,5.245-9.009,9.818-10.079,16.27c-3.261,3.408-87.066-1.22-87.464-2.644c-1.423-5.012,1.508-24.006-2.808-27.88
                          c-0.19-2.082-29.893-6.299-30.714-8.081C150.016,140.479,173.173,58.561,173.378,50.619z M319.139,77.664
                          C319.302,76.912,319.74,78.76,319.139,77.664z"></path>
                          <text id="para" x="243" y="127" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">PA</text>
                        </a>
                        <a xlink:href="#roraima" data-id="23" data-uf="RR" style="pointer-events: none;cursor: default;">
                          <path id="roraima" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M113.18,24.107
                          c-0.972-2.753-7.861-5.889-6.999-8.984c0.068-0.232,13.229,6.053,12.79,2.808c0.398,1.329,1.219,1.889,2.439,1.685
                          c1.889-1.301,7.148,4.204,8.216,1.889c0.438-0.959-1.657-3.753,0.74-3.848c1.026,0.438,1.534,0.164,1.52-0.822
                          c0.835-1.752,3.575,0.219,4.793,0.083c0.767-1.056,10.625-3.026,9.037-5.094c1.37,0.438,4.574,0.808,4.63-1.547
                          c4.546-2.054,1.15-4.409,2.644-6.354c2.177-2.82,9.791,0.809,7.327,5.738c-1.972,3.93,7.121,4.027,5.724,9.366
                          c-0.452,1.686-2.479,2.724-3.423,3.971c-1.179,1.546-1.836,9.243-1.356,11.53c1.041,4.889,3.231,8.695,6.134,12.16
                          c1.712,2.027,5.614,2.261,5.724,4.369c0.164,2.945,1.165,6.177,0.329,9.092c-1.547,5.424-36.618,30.471-36.618,30.471
                          s-12.517-52.736-20.335-54.063C115.261,36.417,111.523,25.682,113.18,24.107z"></path>
                          <text id="roraima" x="146" y="45" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">RR</text>
                        </a>
                        <a xlink:href="#amazonas" data-id="3" data-uf="AM" style="pointer-events: none;cursor: default;">
                          <path id="amazonas" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M10.078,136.412
                          c1.15-4.972,4.258-10.394,8.215-13.105c4.41-3.027,7.656-5.71,13.105-6.082c2.165-0.149,10.216-5.75,11.983-2.984
                          c3.711,5.765,4.998-3.739,5.574-7.025c1.726-9.667,3.697-19.322,4.86-29.086c-0.342-1.356-2.013-6.231-2.833-7.163
                          c-1.453-1.616-4.287-2.122-4.768-4.544c-0.272-1.452-0.574-7.258,1.109-8.121c3.494-1.768,6.547-0.042,9.737-0.89
                          c-2.561-4.053,0.302-4.327-5.532-5.135c-3.438-0.466-3.971-2.466-2.738-6.368c1.053-3.3,15.898-1,19.088-1.396
                          c-1.534,0.178-1.11-2.479-0.042-2.616c1.274-0.165,1.576,2.684,3.165,0.998c1.286-1.395,3.189-2.915,4.6-3.751
                          c2.438-1.45,4.533,8.217,4.465,9.833c-0.041,0.78-0.137,2.438,1.177,2.246c3.012-0.466,4.219,2.849,7.273,4.231
                          c3.778,1.713,3.929-1.355,7.023-2.068c4.301-0.985,0.711,3.396,2.383,3.793c1.589,0.385,3.806-4.969,4.821-5.572
                          c0.93-0.533,3.725-0.753,4.846-1.602c3.013-2.245,1.933-1.686,3.492-1.206c3.478,1.041,2.233-8.367,6.491-7.066
                          c1.822-0.466,3.643-2.34,5.533-2.423c1.041-0.043,6.066,2.287,6.544,3.147c0.589,1.465,0.316,2.795-0.793,3.986
                          c1.575,1.425,2.698,3.149,3.355,5.162c0.904,2.862-1.286,6.807,0.588,9.299c-0.22,6.655,4.808,7.887-0.396,12.597
                          c0.192-0.178,6.711,7.067,7.121,8.039c0.971-0.711,4.066,0.849,4.381,1.535c-1.658-3.629,0.547-17.09,6.628-10.915
                          c7.203,7.327,5.491-3.615,9.148-8.627c2.834-3.875,14.597-3.136,14.077,3.246c-1.082,3.273,6.271,14.256,9.667,11.436
                          c2.26,5.737,6.889,4.285,10.407,8.051c5.094,5.464,4.37,3.396,11.313,2.848c-2.259,3.602-3.425,4.808-5.272,8.86
                          c-3.149,6.862-6.15,13.776-9.204,20.678c-2.437,5.505-14.843,23.471-11.105,28.442c4.806,6.395,9.339,30.183,11.324,29.934
                          c-6.162-0.26-48.079-10.625-51.652-8.105c-1.453,1.013-53.626,10.503-55.9,10.819c-6.369,0.875-18.09-7.272-23.719-10.136
                          c-8.601-4.381-16.61-8.981-26.088-11.05c-10.282-2.259-20.635-4.793-29.878-10.011C4.121,145.766,12.433,144.779,10.078,136.412z"></path>
                          <text id="amazonas" x="115" y="127" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">AM</text>
                        </a>
                        <a xlink:href="#acre" data-id="1" data-uf="AC" style="pointer-events: none;cursor: default;">
                          <path id="acre" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M3.656,148.545
                          c12.557,7.544,27.524,8.367,41.082,13.2c12.802,8.065,27.278,12.845,40.616,19.872c-2.834,1.205-7.587,4.382-9.983,6.395
                          c-2.93,2.45-1.3,2.04-4.628,1.957c-2.93-0.069-3.957,4.615-7.203,5.259c-2.999,0.603-7.161-1.958-10.995-1.697
                          c-1.905,0.136-11.969-0.056-12.64,0.603c0.313-3.642-0.385-7.299-0.165-10.941c0.096-1.439,1.998-6.533,1.245-7.451
                          c-6.82,3.149-8.339,7.19-16.733,7.013c-2.136-0.042-2.562-2.492-3.081-4.001c-1.247-3.572-7.218-3.422-10.559-3.778
                          c6.299-3.41-3.107-11.9-5.216-15.679c-0.52-0.918-3.588-4.655-3.629-5.957C1.642,150.174,6.612,151.968,3.656,148.545z"></path>
                          <text id="acre" x="57" y="187" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">AC</text>
                        </a>
                        <a xlink:href="#rondonia" data-id="21"  data-uf="RO" style="pointer-events: none;cursor: default;">
                          <path id="rondonia" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M83.34,180.232
                          c0.931-1.574,5.341-4.668,6.312-4.656c1.355-0.067,2.671,0.138,3.958,0.603c3.012,1.44,2.039-1.135,5.341-0.123
                          c-1.274-2.287,3.793-2.943,2.86-0.315c3.068,0.247,2.725-4.683,6.668-5.12c4.438-0.508,5.054-0.646,7.122-4.534
                          c0.135-0.246,2.628-5.519,2.752-5.025c2.191-6.491,14.585-0.878,15.638,3.355c0.397,1.615,1.834,3.137,3.642,4.369
                          c1.246,0.862,6.327-3.999,6.134,1.314c-0.78,1.274,26.663,7.656,30.005,19.282c3.82,13.338-16.421,32.167-18.173,34.043
                          c-4.464,1.191-2.039,1.726-6.6,0.15c-2.574-0.875-6.422,0.986-9.08,0.289c-2.409-0.645-3.041-3.957-5.86-4.683
                          c-3.055-0.78-5.423-1.795-7.654-3.93c-4.041-3.876-8.983-2.645-14.475-3.808c-1.835-0.083-6.053-6.779-7.874-5.327
                          c-1.821-0.438-5.381-9.094-3.397-11.204c0.124-1.67-0.26-3.204-1.163-4.627c-0.986-2.644,1.041-5.026,0.863-7.806
                          c-0.384-6.081-1.028-1.986-3.382-1.903C94.336,180.686,85.957,181.671,83.34,180.232z"></path>
                          <text id="rondonia" x="129" y="202" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">RO</text>
                        </a>
                        <a xlink:href="#matogrosso" data-id="11"  data-uf="MT" style="pointer-events: none;cursor: default;">
                          <path id="t_mato" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M142.237,173.962
                          c4-0.316-1.888-6.452,5-5.738c7.914,0.808,16.295,0.328,24.279,0.218c1.629-0.013,8.902,1.288,7.395-1.833
                          c-1.192-2.453,1.821-6.425,0.425-9.725c2.027-0.864,1.289-3.807,2.629-5.107c1.151-1.123,4.176,7.244,4.436,7.819
                          c1.097,2.451,0.398,5.478,1.932,7.654c1.41,1.987,4.574,2.136,5.889,4.259c3.136,5.136,10.845,4.137,17.13,4.657
                          c20.159,1.656,40.356,2.669,60.486,4.752c-3.48,7.763-3.999,14.912-5.122,22.552c-0.437,2.972,1.863,7.163-0.056,10.065
                          c1.945,1.287,1.346,2.753,1.424,4.409c1.151,25.129-20.429,60.186-33.548,58.569c-10.914-1.369-45.3,0.058-46.928-3.396
                          c-1.165-3.944-6.136-2.658-8.395-6.603c-2.301-4.051,0.684-6.299,0.737-10.242c-6.997,0.603-14.09-0.384-21.102-0.324
                          c0.793-5.016-3.725-9.288-2.929-13.809c0.519-3.025,2.726-2.916,0.932-6.79c-1.206-2.589-0.261-4.247-0.699-6.382
                          c-0.289-1.385-1.042-1.876-2.124-2.424c-2.931-1.493,1.246-2.48,2.056-3.644c1.726-2.465,3.299-11.394,6.545-11.612
                          c1.219-1.999-1.781-3.643-1.465-5.56c-3.902-3.588,0.506-4.643,0.369-7.984c-0.151-3.627-9.654-3.944-12.256-3.751
                          c-1.821,0.137-4.109,0.562-5.888-0.094c0.493-3.521-0.521-6.054-0.535-9.217c-0.014-2.286,1.288-5.177,0.835-7.45
                          C143.581,176.618,141.937,174.714,142.237,173.962z"></path>
                          <text id="t_mato" x="212" y="230" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">MT</text>>
                        </a>
                        <a xlink:href="#matogrossodosul" data-id="12"  data-uf="MS" style="pointer-events: none;cursor: default;">
                          <path id="t_mtsul" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M183.198,294.536
                          c2.136-4.464,3.177-9.394,5.312-13.61c1.712-3.344-4.067-7.587-2.423-9.807c0.027-0.026,2.738,3.641,3.917,3.725
                          c3.204-1.534,4.807-2.272,6.984-5.228c2.615-3.59,10.832-3.014,14.051-0.305c1.259,1.041,3.068,2.107,4.668,2.574
                          c3.163,0.934,5.889-3.013,8.559-0.873c3.724,2.982,4.626-1.862,7.86-3.509c1.945-1.012-1.768,8.465-2.244,7.781
                          c2.463,0.959,4.285,0.901,6.82,0.959c3.504,0.081,1.805,1.205,2.436,3.339c0.466,1.564,28.948-5.997,29.416,0.578
                          c0.302,3.837-0.987,61.813-0.987,61.813s-39.532,5.533-41.602,5.286c-3.889-0.492-3.587-3.231-8.063-0.933
                          c-2.028,0.329-6.012,1.205-5.177-2.409c-2.013-4.354-0.111-14.625-4.849-17.088c-1.206-0.659-7.092-2.36-7.504-1.945
                          c-1.699,1.777-3.739,1.562-6.121,1.121c-2.904,0.027-5.629-1.614-8.243-1.203c-4.178,0.656-0.603-2.986-1.645-3.535
                          c0.932-2.847,1.411-9.912,0.453-11.856c-0.165-0.331-3.52-7.232-2.547-8.108C186.306,297.688,182.334,299.415,183.198,294.536z"></path>
                          <text id="t_mtsul" x="222" y="308" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">MS</text>ct>
                        </a>
                        <a xlink:href="#goias" data-id="9"  data-uf="GO" style="pointer-events: none;cursor: default;">
                          <path id="t_goias" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M237.768,270.519
                          c0.628-2.904,1.835-7.396,4.709-8.766c1.015-1.644,1.754-5.147,2.275-5.586c2.408-2.247,3.889-3.783,6.63-4.656
                          c3.723-1.205,3.338-5.342,4.846-8.165c1.504-2.845,4.736-1.15,5.942-3.382c1.479-2.834,0.741-6.161,2.189-8.874
                          c2.902-5.531,1.862-17.363,8.656-20.567c-4.878,7.641,3.698,4.971,7.201,9.449c2.273,1.738,2.164-1.822,2.71-3.055
                          c1.618-3.533,2.878,2.247,4.52-1.533c0.413,0.37,4.136,5.765,3.427,5.601c-0.029-0.931,0.326-1.408,1.037-1.438
                          c0.108,0.534,0.274,1.013,0.602,1.452c-0.602-0.261,9.697-0.095,8.82,1.534c0.36-0.657-0.602-3.11,0.221-3.438
                          c1.039-0.411,3.971,1.368,6.351,0.438c1.045-0.397,7.889-2.807,7.671-3.683c0.767,0.905,1.262,2.67,2.85,1.286
                          c-2.632,2.274-2.576,4.466,1.258,3.821c-1.861,1.438-2.846,4.341-2.382,6.547c0.357,1.643,3.752,5.973,3.478,6.751
                          c-1.78,0.315,0.602,5.438-2.325,6.078c-3.181,0.701-3.973-5.53-4.3,0.688c-0.164,1.48-1.097,1.67-2.768,0.576
                          c-3.288,0.327-0.549,2.19-1.121,3.888c-0.988,2.902,2.792,6.437-2.411,6.764c-3.586,0.219-2.682,1.341-2.682-2.739
                          c-0.028-4.573-12.054-3.643-10.218,0.521c-4.901,6.355,12.05-0.326,9.668,6.355c-1.313,3.752,15.83,28.211,10.406,25.416
                          c-1.944-0.986-50.804,10.271-49.982,12.105c-5.012-2.136-11.804-7.941-17.391-8.162c-0.438-2.189-3.618-1.284-5.095-1.533
                          c-3.724-0.604,1.04-3.231,0.22-4.109c-1.89-1.916-4.382,1.756-3.588-3.012C239.602,274.627,237.055,273.038,237.768,270.519z"></path>
                          <text id="t_goias" x="278" y="254" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">GO</text>
                        </a>
                        <a xlink:href="#parana" data-id="18"  data-uf="PR" style="pointer-events: none;cursor: default;">
                          <path id="t_parana" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M222.225,363.694
                          c1.807-2.138,1.889-4.881,2.424-7.479c0.301-1.453,0.465-7.86,1.369-8.736c2.3-0.684,2.3-3.315,2.726-5.204
                          c0.616-2.738,2.821-2.958,3.984-5.616c4.369-9.91,38.947-9.529,46.476-9.227c4.658,0.193,15.775,34.563,17.916,33.794
                          c-1.728,2.19-5.754,8.929-8.41,8.984c-4.054,0.057-14.215,14.68-14.215,14.68s-37.329-12.05-40.287-11.285
                          c-3.875-1.449-2.698-6.491-6.054-8.216C226.663,364.623,222.498,367.8,222.225,363.694z"></path>
                          <text id="t_parana" x="257" y="358" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">PR</text>
                        </a>
                        <a xlink:href="#santacatarina" data-id="24"  data-uf="SC" style="pointer-events: none;cursor: default;">
                          <path id="t_textSanta" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M231.029,383.959
                          c1.669-3.338-0.284-10.516,4.573-10.569c6.631-0.109,13.639,3.559,20.402,3.888c1.317,0.055,5.231,2.163,4.357-1.15
                          c-1.095-4.164,3.945-1.863,5.67-3.179c2.274-1.724,8.187-4.106,11.311-1.367c1.423,1.809,20.05-5.395,13.284,3.946
                          c-1.368,1.395,0.713,10.789,0.466,10.734c-3.449,4.438,1.726,11.666-5.096,15.334c-2.901,1.536-7.284,7.779-9.64,9.995
                          C276.085,411.866,233.534,382.918,231.029,383.959z"></path>
                          <text id="t_textSanta" x="273" y="390" text-anchor="middle" font-size="18" font-family="Arial" fill="white">SC</text>
                        </a>
                        <a xlink:href="#riograndedosul" data-id="22"  data-uf="RN" style="pointer-events: none;cursor: default;">
                          <path id="t_textRioGrande" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M191.236,416.881
                          c0.52-2.684,7.38-8.409,9.477-10.351c0.37-0.359,8.599-10.08,9.174-8.329c-1.301-3.89,2.781-1.589,3.917-4.819
                          c0.26-0.521,7.04-4.821,7.109-4.795c1.436-0.191,6.721-3.695,7.421-3.257c1.204-2.028,8.927-1.479,8.653-0.824
                          c1.165-0.38,2.284-0.877,3.326-1.479c0.221-0.821,22.459,7.533,24.319,11.531c2.523,5.34,12.217,2.822,13.15,5.563
                          c0.106,0.275-5.809,9.339-3.89,9.173c-0.985,0.08,3.204-2.875,3.834,0.409c-2.793,3.619-4.6,7.834-6.571,11.944
                          c-3.696,7.614-8.872,12.765-15.886,17.42c-7.394,4.902-7.339,11.941-13.257,17.693c-8.091,7.942-10.159-0.574-4.08-5.752
                          c3.806-3.231-22.527-19.746-25.578-22.732c-1.918-1.862-2.384,0.274-4.219,1.15c-2.547,1.205-1.917-2.822-3.588-4.273
                          c-2.3-1.999-4.793-5.479-7.737-6.68c-3.478-1.367-5.615,5.145-9.052,0.821C189.168,418.854,190.332,418.032,191.236,416.881z"></path>
                          <text id="t_textRioGrande" x="240" y="420" text-anchor="middle" font-size="18" font-family="Arial" fill="white">RS</text>
                        </a>
                        <a xlink:href="#saopaulo" data-id="26"  data-uf="SP" style="pointer-events: none;cursor: default;">
                          <path id="t_sampa" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M239.3,330.554
                          c3.26-4.356,9.56-5.039,11.531-10.792c1.369-3.942,3.889-8.818,6.135-13.036c1.561-2.957,7.749-7.121,10.517-8.65
                          c0.383-0.196,32.974-6.138,42.234-1.701c20.265,9.724,26.017,33.879,27.854,33.304c4.408-1.425,5.34,3.778,2.106,4.49
                          c-1.754,0.413-6.519,1.479-6.49,3.399c0.027,3.448,0.521,1.615-2.931,3.639c-2.189-1.42-3.34,4.111-4.763,3.426
                          c-4.271-2.244-6.958,2.96-9.258,1.918c-4.271-1.918-16.98,13.092-19.638,15.336c0.245-0.218-1.148-1.479-1.587-2.685
                          c-0.466-1.369-2.658,0.385-4.025,0.082c-0.986-0.192,1.751-4.079-2.303-4.52c-1.369-0.164-3.753,0.303-4.929,0.084
                          c-2.903-0.547,0.108-2.41-0.439-3.862c-1.067-2.986-3.013-4.931-3.751-7.779c-0.52-1.945,0.165-7.531-3.615-7.395
                          c-0.848-2.956-6.628-1.451-9.066-1.862c-0.162,0.163-8.846-2.684-10.079-2.684c-1.616-0.029-6.791-3.396-7.121-0.274
                          C247.982,330.386,239.876,331.21,239.3,330.554z"></path>
                          <text id="t_sampa" x="288" y="330" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">SP</text>
                        </a>
                        <a xlink:href="#minasgerais" data-id="13"  data-uf="MG" style="pointer-events: none;cursor: default;">
                          <path id="t_textMinas" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M262.881,297.305
                          c-1.696-5.094,15.531-19.882,18.844-13.421c5.531-7.367,15.886,1.588,19.773-3.944c0.988-1.367,3.015-1.453,3.725-2.957
                          c0.326-0.711-0.493-2.793-0.056-3.888c1.369-3.398-4.873-2.355-0.109-6.603c4.547-4.053-1.917-4.739-1.204-8.186
                          c0.957-4.604,1.807-4.713,5.613-6.027c1.943-0.688,0.906-8.272,0.083-8.52c-0.108-2.699,1.974-2.546,3.782-1.617
                          c2.188-0.135-0.276-3.695,0.957-4.243c-0.357,0.151,5.559,1.999,5.724,2.055c0.986,0.358-0.52,3.534-0.931,3.943
                          c8.217-2.355,14.514-11.789,23.279-11.242c4.983,0.316-0.327,4.339,5.367,5.544c0.684,1.234,3.34-1.054,4.054-1.189
                          c2.876-0.536,5.53,3.284,8.106,3.886c2.301,3.578,7.503,0.537,10.298,3.001c1.755,1.589,2.188,3.397,3.396,5.313
                          c1.314,2.052,3.86-0.465,5.726-0.109c3.257,0.656,6.326,2.026,9.338,3.723c2.19,1.205,0.768,3.179-0.548,4.573
                          c-0.765,0.796-3.259,6.165-2.627,5.643c-2.138,1.781-2.628-1.669-3.397,2.764c-0.628,3.674,0.164,4.714,3.149,7.015
                          c4.901,3.229-6.765,3.12-6.71,3.504c0.22,0.601-2.846,41.96-3.835,42.179c-6.737,1.562-14.513,5.311-21.744,7.012
                          c-12.736,2.985-24.295,3.778-29.471,4.656c0,1.452-5.367,6.872-8.518,1.259c0,0-3.041-7.285-2.821-7.229
                          c0.105-0.027,2.138-5.506,2.244-6.137c0.768-3.504-5.042-0.765-5.749-2.188c-0.878-1.81-2.358-4.576-2.166-6.628
                          c1.699-1.205,1.672-2.383-0.08-3.562c-1.04-1.095-1.205-2.303-0.521-3.672c-2.329-1.424-3.065-2.683-5.698-2.462
                          c-1.479,0.138-4.055,3.668-5.506,0.629c0.878,2.108-4.188,0.769-5.094,1.56c-2.354-1.202-1.779,2.028-2.384,3.069
                          c-0.137,0.22-1.014-2.904-1.065-2.961c-1.149-1.175-2.767,4.165-3.505-0.055c0.766-4.105-4.657-2.709-7.67-2.93
                          c-4.708-0.353-5.53-1.613-9.858,0.631C262.993,300.562,262.336,299.274,262.881,297.305z"></path>
                          <text id="t_textMinas" x="340" y="288" text-anchor="middle" font-size="18" font-family="Arial" fill="white">MG</text>
                        </a>
                        <a xlink:href="#riodejaneiro" data-id="19"  data-uf="RJ" style="pointer-events: none;cursor: default;">
                          <path id="t_rj" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M332.886,337.429
                          c-1.26-2.768,8.409-4.795,7.89-6.71c-3.177-1.864-4.602,1.148-6.63-2.959c4.274-0.686,9.533-4.49,13.831-3.562
                          c0.548-0.219,4.902-1.753,4.96,0.167c2.546-1.566,5.479-2.412,8.105-3.837c2.246-1.206,0.932-8.218,3.725-9.643
                          c6.054-3.123,1.398,1.836,7.066,2.959c5.888,1.205,5.395,1.48,5.641,7.067c0.247,5.642-8.763,4.381-11.063,8.764
                          c-1.039,1.999,1.698,5.368-3.368,4.903c-4.188-0.413-10.628,2.355-9.285-3.18c-1.039-0.08-1.861,0.301-2.464,1.124
                          c0,0,0.105,2.767-0.74,2.741c-0.766-0.056-7.643,1.094-7.449,0.463c1.398-0.359,2.708-0.684,4.135-0.794
                          c-1.667-0.713-2.957-1.839-4.901-0.142c0.465,0.195-4.227-0.086-3.379-0.113c-0.521,1.727-3.814,0.699-3.879,3.045
                          C336.717,337.908,333.927,342.41,332.886,337.429z"></path>
                          <path class="circle" d="M355.094,318.613c6.209,0,11.263,5.021,11.263,11.259c0,6.208-5.056,11.264-11.263,11.264
                          c-6.211,0-11.263-5.054-11.263-11.264C343.831,323.634,348.883,318.613,355.094,318.613z"></path>
                          <text id="t_rj" x="355" y="335" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">RJ</text>
                        </a>
                        <a xlink:href="#espiritosanto" data-id="8"  data-uf="ES" style="pointer-events: none;cursor: default;">
                          <path id="t_espirito" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M367.119,308.834
                          c1.044-1.999-0.298-5.451,1.841-6.326c3.697-1.453,3.858-0.467,5.941-4.49c0.767-1.563,3.999-5.807,2.848-7.835
                          c-0.439-0.765-3.204-3.613-3.286-4.05c1.04-0.249,2.079-0.219,3.123,0.054c1.366-0.654-6.465-10.519,2.137-8.054
                          c-1.204-0.655-1.535-1.365-0.932-2.135c4.358-0.138,13.856,0.027,12.845,6.738c-0.577,3.835,0.933,8.079-0.577,11.804
                          c-0.218,0.576-5.861,8.954-5.831,8.954c0.985,3.289-5.18,5.808-6.054,8.165c-1.313,3.56-2.135,3.013-5.614,2.573
                          c-1.64-0.274-3.202-0.768-4.736-1.451C368.819,311.297,369.424,309.055,367.119,308.834z"></path>
                          <path class="circle" d="M381.917,284.723c6.21,0,11.261,5.055,11.261,11.262c0,6.212-5.051,11.261-11.261,11.261
                          c-6.212,0-11.263-5.049-11.263-11.261C370.654,289.777,375.705,284.723,381.917,284.723z"></path>
                          <text id="t_espirito" x="383" y="300" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">ES</text>
                        </a>
                        <a xlink:href="#distritofederal" data-id="7"  data-uf="DF" style="pointer-events: none;cursor: default;">
                          <path id="t_df" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M292.461,246.197
                          c0,0,12.929-2.903,14.188,0c1.233,2.903,0.659,10.683-1.424,11.504c-2.08,0.849-14.296-1.806-14.023-3.313
                          C291.503,252.853,292.461,246.197,292.461,246.197z"></path>
                          <path class="circle" d="M300.735,238.34c6.212,0,11.26,5.035,11.26,11.258c0,6.21-5.048,11.263-11.26,11.263
                          c-6.209,0-11.261-5.053-11.261-11.263C289.475,243.377,294.523,238.34,300.735,238.34z"></path>
                          <text id="t_df" x="301" y="254" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">DF</text>
                        </a>
                        <a xlink:href="#paraiba" data-id="15"  data-uf="PB" style="pointer-events: none;cursor: default;">
                          <path id="paraiba" stroke="#FFFFFF" stroke-width="1.0404" stroke-linecap="round" stroke-linejoin="round" d="M401.575,141.096
                          c2.081-3.081,16.791-6.82,19.117-4.616c0,1.918,7.259,1.686,10.133,2.712c-0.492,3.038,12.652,1.533,14.408,2.259
                          c1.421,0.589,3.833,11.983,1.421,12.202c-0.874-1.124-2.083-1.739-3.586-1.835c-2.957-0.027-2.546,1.863-4.383,3.108
                          c-2.626,1.767-6.571,1.917-9.558,2.109c-0.162,1.232-3.943,4.438-5.259,4.916c-3.122,1.149-2.657-2.727-5.095-3.602
                          c0.713-1.124,4.082-5.203,3.725-6.205c-1.423-3.846-12.051,5.52-14.981,3.506c-1.396-0.973-6.218,1.493-3.476-2.588
                          C405.574,150.776,400.398,142.889,401.575,141.096z"></path>
                          <path class="circle" d="M433.797,133.597c6.237,0,11.26,5.051,11.26,11.261c0,6.226-5.022,11.262-11.26,11.262
                          c-6.208,0-11.257-5.036-11.257-11.262C422.54,138.647,427.589,133.597,433.797,133.597z"></path>
                          <text id="paraiba" x="431" y="150" text-anchor="middle" font-size="18" font-family="Arial" fill="white" style="line-height: 25px;">PB</text>
                        </a>
                      </g>
                  </svg>
              </div>
              <div class="legenda">
                <h4>Quantidade por estado</h4>
                <ul>
                  <li class="cor1">0 - 100 pedidos</li>
                  <li class="cor2">101 - 500 pedidos</li>
                  <li class="cor3">501 - 10000 pedidos</li>
                  <li class="cor4">mais de 10000 pedidos</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="slider-Graficos">
<?php

                $relatorioPorEstado = $viewModel["RelatorioPorEstado"];
                foreach($relatorioPorEstado as $estado){
?>
                    <div>
                      <h2>• Estado: <?=$estado["Nome"]?></h2>
                      <hr>
                      <h3>Total de pedidos: <?=$estado["Total"]?></h3>
                      <canvas id="myChart<?=$estado["Codigo"]?>" width="400" height="300%"></canvas>
                    </div>
<?php
                }
?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--Respostas-->
  <section class="respostas">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <h1>• Órgãos com mais pedidos atendidos e negados</h1>
          <hr/>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <h2>Pedidos Atendidos</h2>
          <ul class="list-group">
            <?php
            $relatorioPorAgenteP = $viewModel["RelatorioPorAgentePositivas"];
            $contador = 1;
            foreach($relatorioPorAgenteP as $rp){
              $uf = "";
              if (!empty($rp["uf"]))
                $uf = " / " . $rp["uf"];

              $cidade = "";
              if (!empty( $rp["cidade"]))
                $cidade = " / " . $rp["cidade"];

              echo '<li class="list-group-item"><span class="badge">'.number_format($rp['PorcentagemAtendido']*100,0).'%'.'</span>'.$contador.'. '.$rp["Nome"] . $uf  . $cidade .'</li>';
              $contador++;

            }

            ?>
          </ul>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <h2>Pedidos Negados</h2>
          <ul class="list-group">
            <?php
            $relatorioPorAgenteN = $viewModel["RelatorioPorAgenteNegativas"];
            $contador = 1;
            foreach($relatorioPorAgenteN as $rn){
              $uf = "";
              if (!empty($rn["uf"]))
                $uf = " / " . $rn["uf"];

              $cidade = "";
              if (!empty( $rn["cidade"]))
                $cidade = " / " . $rn["cidade"];

              echo '<li class="list-group-item"><span class="badge">'.number_format($rn['PorcentagemNaoAtendido']*100,0).'%'.'</span>'.$contador.'. '.$rn["Nome"] . $uf . $cidade .'</li>';
              $contador++;
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </section>

   <!--Pedidos Recentes-->
  <section class="pedidosRecentes">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
          <h1>PEDIDOS RECENTES</h1>
          <img src="<?=BASE_URL?>assets/images/home/linhas.png" alt="Como Funciona">
        </div>
        <?php
        $ultimosPedidos = $viewModel["UltimosPedidos"];
        $contador = 0;

        foreach ($ultimosPedidos as $pedido) {
          $nomeUsuario = $pedido["Anonimo"] == 1 ? "Anônimo" : $pedido["NomeUsuario"];
          $slugUsuario = $pedido["Anonimo"] == 1 ? "javascript:void(0);" : "/usuarios/" . $pedido["SlugUsuario"];

          $slide = $contador % 2 == 0 ? "slideInLeft" : "slideInRight";
          ?>
          <div class="col-md-6 col-sm-6 col-xs-12 box wow <?=$slide?> animated animated" data-wow-delay="300ms" data-wow-duration="2s" style="min-height:340px;visibility: visible; animation-duration: 2s; animation-delay: 300ms; animation-name: <?=$slide?>;">
            <p>
              <?=truncate($pedido["Titulo"],200)?>
            </p>
            <div class="enviado">Pedido enviado para: <a href="<?=$this->Url->build('/agentes/' . $pedido["SlugAgente"])?>"><?=$pedido["NomeAgente"]?></a></div>
            <div class="porr">Pedido disponibilizado por: <a href="<?=$this->Url->build($slugUsuario)?>"><?=$nomeUsuario?></a></div>
            <div class="em">Em: <?=$pedido["DataEnvio"]?></div>
            <div class="btnVerMais btn-size-small pull-right">
              <a href="<?=$this->Url->build('/pedidos/' . $pedido["Slug"])?>">Ver
                <div class="seta seta-direita"></div>
              </a>
            </div>
          </div>
        <?php
          $contador++;
        }
        ?>
      </div>
        <div class="col-md-12 col-sm-6 col-xs-12 text-center">
          <div class="bntVer"><a href="<?=$this->Url->build('/pedidos')?>">Ver mais</a></div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  cor1 = "#fe9301";cor2 = "#cccc00";cor3 = "#00ccff";cor4 = "#3366ff";

  function pickColor(total)
  {
      if(total == 0 || total < 100){
        return cor1;
      }else if(total > 100 && total < 500)
      {
        return cor2;
      }else if(total > 500 && total < 10000)
      {
        return cor3;
      }else{
        return cor4;
      }
  }

  $(document).ready(function(){


<?php
  //2017-03-09 Paulo Campos -> Não era para estar aqui, mas... Função para "cropar" os títulos dos pedidos nos cards da seção Pedidos Recentes
  function truncate($text, $chars = 50) {
      $text = $text." ";
      $text = substr($text,0,$chars);
      $text = substr($text,0,strrpos($text,' '));
      $text = $text."...";
      return $text;
  }

  /* GERA O SCRIPT DAS BARRAS DE DADOS PARA CADA ESTADO.
    O SCRIPT NÃO FOI ADICIONADO DENTRO DO LOOP DOS GRÁFICOS PORQUE O SCRIPT
    DO SLICK IDENTIFICA OS VALORES ABAIXO COMO OUTRO GRÁFICO (BUG!)
  */
  $relatorioPorEstado = $viewModel["RelatorioPorEstado"];
  foreach($relatorioPorEstado as $estado){
  ?>

      var ctx = document.getElementById("myChart<?=$estado["Codigo"]?>");
      var myChart<?=$estado["Codigo"]?> = new Chart(ctx, {
          type: 'bar',
          responsive: true,
          height:960,
          data: {
              labels: ["Respostas atendidas", "Respostas negativas"],
              datasets: [{
                  data: [<?=$estado["TotalAtendidos"]?>, <?=$estado["TotalNaoAtendidos"]?>],
                  backgroundColor: [
                      'rgba(255, 243, 224, 0.8)',
                      'rgba(251, 215, 218, 0.8)'
                  ],
                  borderColor: [
                      'rgba(255,181,157,2)',
                      'rgba(189, 131, 158, 1)'
                  ],
                  borderWidth: 1
              }]
          },
           options: {
              legend: {display: false,},
              scales: {xAxes: [{stacked: true,ticks: {min: 0,max: 100,stepWidth: 2}}],
                  yAxes: [{stacked: true,ticks: {min: 0,max: <?=$estado["Total"]?> + 5,stepWidth: 2}}]}
                }
      });

      elementoMapa = $("a[data-uf='<?=$estado["Sigla"]?>']");

      cor = pickColor(<?=$estado["Total"]?>)
      elementoMapa.find('path').css('fill', cor);
      // mudar a cor do elemento do mapa
  <?php
  }
?>
  });
</script>
