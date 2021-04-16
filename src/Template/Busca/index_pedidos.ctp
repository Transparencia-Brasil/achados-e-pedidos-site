

<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="active"><a href="#">Busca</a></li>
    </ul>
  </div>
</div>

<div class="busca">

  <!--Pedidos-->
  <div class="container">
      <section class="buscaForm">
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-4">
             <form role="search" action="<?=BASE_URL?>busca" method="get">
                <div id="custom-search-input">
                    <div class="input-group col-md-12">

                      <input list="fieldList" name="termo" id="fieldValue" class="form-control input-lg" placeholder="Digite aqui sua busca" autocomplete="off">
                      <datalist id="fieldList"></datalist>
                        <span class="input-group-btn">
                            <button id="btnsearch2" class="btn btn-info btn-lg" type="submit" attr="busca_geral">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
          </div>
          <div class="col-md-4"></div>
        </div>
          <div class="row bnts show">
            <div class="col-md-1"></div>
            <div class="col-md-2">
              <div class="btnPadrao buscaFiltroAcao <?=$tipo == "pedidos" ? "selected" : ""?>" repo="pedidos">
                <a href="<?=BASE_URL?>busca/pedidos/?termo=<?=$termo?>">Pedidos</a>
              </div>
            </div>
             <div class="col-md-2">
              <div class="btnPadrao buscaFiltroAcao <?=$tipo == "agentes" ? "selected" : ""?>" repo="orgaospublicos">
                <a href="<?=BASE_URL?>busca/agentes/?termo=<?=$termo?>">Órgãos Públicos</a>
              </div>
            </div>
             <div class="col-md-2">
              <div class="btnPadrao buscaFiltroAcao <?=$tipo == "usuarios" ? "selected" : ""?>" repo="usuarios">
                <a href="<?=BASE_URL?>busca/usuarios/?termo=<?=$termo?>">Usuários</a>
              </div>
            </div>
            <div class="col-md-4"></div>
          </div>
      </section>
  </div>

  <!--Pedidos-->
  <div class="container-fluid bgColor show" session="pedidos">
    <div class="container pedidos pedidosOrgaos">
      <section>
         <h3>Pedidos</h3>
         <h5><a href="/pedidos/busca-avancada">Busca avançada</a></h5>
         <h4>Resultado para: "<span class="termo-display"></span>"</h4>
         <h5>Foram encontrados <span class="hits-total-display"></span> registros - Mostrando <span class="paginacao-de"></span> de <span class="paginacao-ate"></span>.</h5>
         <div class="row" id="boxes-resultados">
            <!-- Card pedido -->

            <!-- // Card pedido -->
         </div>
      </section>
    </div>
  </div>
   <div class="row">
      <div class="text-center">
        <ul class="pagination pagination-large" id="ulPagination"> 
      </ul>
      </div>
  </div>
</div>

<script type="text/javascript" src="<?=BASE_URL?>assets/js/busca.js" ></script>
