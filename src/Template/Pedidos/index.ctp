<div class="container"><div class="row">
    <ul class="breadcrumb">
      <li class="completed">Home</li>
      <li class="active"><a href="/pedidos">Pedidos</a> / Busca</li>
    </ul>
  </div>
</div>

<div class="container pedidosOrgaos">
    <div class="row">
      <div class="col-md-10 busca">
        <form>
          <h2>Pedidos | <a href="" data-toggle="modal" data-target="#myModal">Dicas de pesquisa</a></h2>
          <div id="custom-search-input">
              <div class="input-group col-md-12">
                  <input list="fieldList" name="buscaAvancada" id="buscaAvancada" class="form-control input-lg" placeholder="Digite aqui sua busca" autocomplete="off" >
                  <datalist id="fieldList">
                  </datalist>
                  <span class="input-group-btn">
                      <button class="btn btn-info btn-lg" type="button" id="btnBuscaAvancada" attr="busca_pedido">
                          <i class="glyphicon glyphicon-search"></i>
                      </button>
                  </span>
              </div>
          </div>
        </form>
      </div>


      <!--TODO: AJUSTAR BOTAO DE AJUDA

      <div class="col-md-2 ">
          <button type="button" style="margin-top:54px;" data-toggle="modal" data-target="#myModal">
            Dicas de pesquisa
          </button>
      </div>
-->


      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"><center>Como fazer pesquisas mais assertivas</center></h4>
            </div>
            <div class="modal-body">
              <div>
                <p>Para encontrar resultados relevantes mais rapidamente, use as dicas a seguir:</p>
              </div>
              <div>
                <h3>Expressão ou frase exata (“ ”)</h3>
                <p>Utilize aspas duplas (“ ”) para pesquisar por expressões ou frases específicas. A busca retornará pedidos com a sequência exata de palavras digitadas.</p>
                <p>Exemplo: a busca <b>“Programa de Aceleração do Crescimento”</b> retornará apenas os resultados em que estes termos aparecerem exatamente nesta ordem. Não aparecerão, por exemplo, pedidos com a expressão “Programa de Aceleração de Crescimento”</p>
              </div>

              <div>
                <h3>Todos os termos em qualquer ordem (AND)</h3>
                <p>Para pedidos com mais de uma palavra, independente da ordem em que elas aparecem, utilize AND em caixa alta entre cada uma das palavras ou expressões.</p>
                <p>Ex: a busca <b>inflação</b> AND <b>“crescimento do PIB”</b> retornará os pedidos que contenham necessariamente a palavra inflação e a expressão crescimento do PIB. Pedidos que contenham apenas um dos termos não retornarão.</p>
              </div>

              <div>
                <h3>Qualquer um dos termos (OR)</h3>
                <p>Para os pedidos que contenham qualquer um dos termos digitados na pesquisa, digite OR em caixa alta entre tais termos.</p>
                <p>Ex: a busca <b>“Programa de Aceleração do Crescimento” OR “Programa de Aceleração de Crescimento” OR PAC</b> retornará os resultados que contenham qualquer uma das três expressões.</p>
              </div>

              <div>
                <h3>Exclusão de termo irrelevante (-)</h3>
                <p>Para excluir da sua pesquisa uma palavra ou expressão específica que possa estar poluindo os resultados, basta digitar um sinal de menos (-) antes da palavra.</p>
                <p>Ex: A pesquisa <b>oficial -justiça</b> mostrará todos os pedidos em que a palavra <b>oficial</b> aparece, com exceção daqueles que contenham a palavra <b>justiça</b>.</p>
                <p>A busca Universidade -”de São Paulo” mostrará todos os pedidos em que a palavra <b>Universidade</b> aparece, com exceção daqueles que contenham a expressão <b>de São Paulo</b>.</p>
              </div>

              <div>
                <h3>Variações de uma palavra (*)</h3>
                <p>Para resultados relacionados a um termo que pode aparecer de formas variadas, omita a parte variável da palavra e substitua por um asterisco (*). Assim, o motor de busca completa a palavra buscando por todas suas variações.</p>
                <p>Ex: a busca <b>desenvolv*</b> retornará resultados que contenham os termos <b>desenvolvimento, desenvolver, desenvolvido, desenvolvida, desenvolvidas, desenvolverem</b>, etc.</p>
              </div>

              <div>
                <h3>Variações de um caractere (?)</h3>
                <p>Caso apenas um caractere específico da palavra for variável, substitua-o por um ponto de interrogação (?). Assim, o motor de busca mostrará apenas as variações deste único caractere no termo buscado.</p>
                <p>Ex: a busca <b>ro?alties</b> retornará resultados que contenham os termos <b>royalties, roialties</b>, etc.</p>
              </div>

              <div>
                <h3>Grafias semelhantes (~)</h3>
                <p>Para termos com grafia que costumam variar, utilize o sinal til (~) após a palavra. Isso é útil para palavras que costumam ser escrita de formas variadas, para incluir resultados em que a palavra desejada foi escrita incorretamente ou quando você não tiver certeza da grafia da palavra.</p>
                <p>Ex: A busca <b>Rousseff~</b> retornará pedidos que contenham palavras como <b>Rousef, Roussef, Rouseff</b>, mas também <b>Youssef</b> e outras possíveis variações.</p>
              </div>

              <div>
                <h3>Maior relevância a certos termos da pesquisa (termo^n)</h3>
                <p>Por padrão, todos os termos buscados em uma mesma busca têm a mesma relevância entre si. Para aumentar a relevância de algum termo da pesquisa e retornar primeiro os pedidos que o contenham, basta digitar ^ e um algarismo após o termo. Quanto maior o número, maior a relevância.</p>
                <p>Ex: a pesquisa <b>tribunal^2 contas^3 justiça</b> retornará todos os resultados em que esses três termos aparecem, porém primeiro serão mostrados os pedidos em que a palavra contas aparecer mais vezes, em segundo lugar a palavra tribunal e em terceiro justiça.</p>
              </div>

              <div>
                <h3>Distância entre duas palavras (“palavra_x palavra_y”~n)</h3>
                <p>Para buscar pedidos que contenham duas palavras que não estejam em uma ordem exata, mas que estejam próximas no pedido. Basta colocar ambas entre aspas e seguidas de ~ e o número máximo de palavras entre elas.</p>
                <p>Ex: a busca <b>“financiamento educação”~2</b> retornaria resultados como:<br /> ... <b>financiamento</b> para a <b>educação</b>...<br /> ...<b>financiamento</b> estadual na <b>educação</b>...<br /> ...<b>financiamento</b> da <b>educação</b>...</p>
              </div>



            </div>
            <div class="modal-footer">
              <button type="button" data-dismiss="modal">Entendi</button>

            </div>
          </div>
        </div>
      </div>

      <!-- FIM TODO -->


    </div>
    <div class="row">
      <div class="col-md-3 filtro">
        <h1>Filtrar por:</h1>
         <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

         <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingSix">
                    <h4 class="panel-title" data-toggle="tooltip" data-placement="right" title="Apenas pedidos com anexos.">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            <i class="more-less glyphicon glyphicon-chevron-down"></i>
                            Pedidos com anexos:
                        </a>
                    </h4>
                </div>
                <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                    <div class="panel-body">
                        <form action="" method="post" data-parsley-validate data-parsley-errors-messages-disabled>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="chkPedidoAnexo" class="regular-checkbox">
                            <label for="chkPedidoAnexo">Selecionar apenas pedidos com anexos</label>
                          </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading data" role="tab" id="headingA">
                    <h4 class="panel-title" data-toggle="tooltip" data-placement="right" title="Órgão para o qual o pedido foi enviado.">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseA" aria-expanded="true" aria-controls="collapseA">
                            <i class="more-less glyphicon glyphicon-chevron-down"></i>
                            Pedido enviado para:
                        </a>
                    </h4>
                </div>
                <div id="collapseA" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingA">
                    <div class="panel-body">

                       <div class="col-md-12 group-f">
                          <div class="form-group" id="env-para">
                            <p class="env-container">
                                <a style="display:block;" class='removerCampo' onclick="removeCampo(event)" href="javascript:void(0);">- Remover este filtro:</a>
                                <input type="text" class="form-control enviado-para" id="enviadoPara" list="fieldListEnviadoPara" onkeyup="autocompleteEnviadoPara(event)">
                                <datalist id="fieldListEnviadoPara">
                                  <select style="display: none;">
                                  </select>
                                </datalist>
                            </p>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                              <input type="button" class="form-control" value="selecionar" id="selectedSAYTEP">
                          </div>
                        </div>
                        <div class="center">
                          <a class='more-field center' id='novoCampo' href="javascript:void(0);">+ Filtrar por mais um órgão</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading data" role="tab" id="headingB">
                    <h4 class="panel-title" data-toggle="tooltip" data-placement="right" title="Usuário ou órgão que compartilhou o pedido.">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseB" aria-expanded="true" aria-controls="collapseB">
                            <i class="more-less glyphicon glyphicon-chevron-down"></i>
                            Pedido disponibilizado por:
                        </a>
                    </h4>
                </div>
                <div id="collapseB" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingB">
                    <div class="panel-body">

                       <div class="col-md-12">
                          <div class="form-group">
                              <input type="text" class="form-control" id="por" list="fieldListPor">
                              <datalist id="fieldListPor">
                              </datalist>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                              <input type="button" class="form-control" value="selecionar" id="selectedSAYTP">
                          </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading data" role="tab" id="headingOne">
                    <h4 class="panel-title" data-toggle="tooltip" data-placement="right" title="Data em que o pedido foi feito.">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="more-less glyphicon glyphicon-chevron-down"></i>
                            Data:
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                      <form action="" method="post" data-parsley-validate data-parsley-errors-messages-disabled>
                       <div class="col-md-6">
                          <div class="form-group">
                              <input type="text" name="data-de" class="form-control datePicker" id="data-de" placeholder="Data inicial" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <input type="text" class="form-control datePicker" id="data-ate" placeholder="Data final" required>
                          </div>
                        </div>
<!--                         <div class="col-md-12">
                          <div class="form-group">
                              <input type="submit" class="form-control" value="selecionar">
                          </div>
                        </div> -->
                      </form>
                    </div>
                </div>
              </div>

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFour">
                    <h4 class="panel-title" data-toggle="tooltip" data-placement="right" title="Atendimento ou não atendimento do pedido.">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <i class="more-less glyphicon glyphicon-chevron-down"></i>
                            Respostas do órgão público:
                        </a>
                    </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                    <div class="panel-body">
                        <form action="" method="post" data-parsley-validate data-parsley-errors-messages-disabled>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="chkAtendido" class="regular-checkbox">
                            <label for="chkAtendido">Atendido</label>
                          </div>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="chkNaoAtendido" class="regular-checkbox">
                            <label for="chkNaoAtendido">Não atendido</label>
                          </div>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="chkParcAtendido" class="regular-checkbox">
                            <label for="chkParcAtendido">Parcialmente atendido</label>
                          </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFive">
                    <h4 class="panel-title" data-toggle="tooltip" data-placement="right" title="Nível federativo e esfera de poder dos órgãos públicos.">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            <i class="more-less glyphicon glyphicon-chevron-down"></i>
                            Órgãos públicos
                        </a>
                    </h4>
                </div>
                <div id="collapseFive" class="panel-collapse collapsse" role="tabpanel" aria-labelledby="headingFive">
                    <div class="panel-body">
                      <form action="" method="post" data-parsley-validate data-parsley-errors-messages-disabled>
                         <h5>Nível:</h5>
                         <div class="form-group bgCheckbox">
                            <input type="checkbox" id="chkFederal" class="regular-checkbox">
                            <label for="chkFederal">Federal</label>
                          </div>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="chkEstadual" class="regular-checkbox">
                            <label for="chkEstadual">Estadual</label>
                          </div>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="chkMunicipal" class="regular-checkbox">
                            <label for="chkMunicipal">Municipal</label>
                          </div>
                          <h5>Poder:</h5>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="chkLegislativo" class="regular-checkbox">
                            <label for="chkLegislativo">Legislativo</label>
                          </div>
                          <!-- <div class="form-group bgCheckbox">
                            <input type="checkbox" id="chkTribunal" class="regular-checkbox">
                            <label for="chkTribunal">Tribunais de Contas</label>
                          </div> -->
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="chkExecutivo" class="regular-checkbox">
                            <label for="chkExecutivo">Executivo</label>
                          </div>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="chkJudiciario" class="regular-checkbox">
                            <label for="chkJudiciario">Judiciário</label>
                          </div>
                          <div class="form-group bgCheckbox">
                            <input type="checkbox" id="chkMinisterio" class="regular-checkbox">
                            <label for="chkMinisterio">Ministério Público e Tribunais de Contas</label>
                          </div>
                        </form>
                    </div>
                </div>
                
                <div class="col-md-12">
                  <div class="form-group">
                      <input type="reset" class="form-control" value="Limpar Filtros">
                  </div>
                </div>
            </div>

        </div><!-- panel-group -->
      </div>

      <div>
        <div class="col-md-9">
      <!-- Visualização 1 -->
          <div id="primeira-tela">
            <h3>Total de pedidos: <span class="hits-total-display"></span></h3>
            <h5>Mostrando <span class="paginacao-de"></span> de <span class="paginacao-ate"></span>.</h5>
          </div>
          <!-- // Visualização 1 -->
          <!-- Visualização 3 -->
          <div id="sem-resultados" style="display:none">
            <h3>Nada foi encontrado para o termo: <span class="termo-display"></span></h3>
          </div>
          <!-- // Visualização 3 -->
          <!-- Visualização 4 -->
          <div id="sem-resultados-filtros" style="display:none">
            <h4>Resultado para: <span class="termo-display"></span></h4>
            <h3>O filtro elaborado não possui resultados.</h3>
          </div>
          <!-- // Visualização 4 -->
          <!-- Visualização 5 -->
          <div id="sem-resultados-em-branco" style="display:none">
            <h3>Favor digitar uma palavra chave na busca.</h3>
          </div>
          <!-- // Visualização 4 -->
          <!-- Visualização 2 -->
          <div id="cabecalho-resultados" style="display:none">
          <h4>Encontramos <span class="hits-total-display"></span> pedidos contendo o(s) termo(s): <i><span class="termo-display"></span></i></h4>
            <h5>Mostrando <span class="paginacao-de"></span> de <span class="paginacao-ate"></span>, ordenados por data do pedido LAI mais recente.</h5>
            
            <h5 id="erro-resultado" style="color:red;"></h5>
          </div>
          <div class="row" id="boxes-resultados">
          </div>
          <div class="text-center">
            <ul class="pagination pagination-large" id="ulPagination"></ul>
          </div>
          <!-- // Visualização 2 -->
        </div>
      </div>
    </div>
</div>

<script>
//AO clicar adiciona mais um campo de busca enviado para.
var total = 0;
$("#novoCampo").click(function(){
  adicionaCampo();
});

function adicionaCampo() {
  total = $("#env-para").children('p').length;

  if(total >= 1){
      $('.removerCampo').css("display", "block");
  }
  if(total > 9){
    $("#env-para").append("<span class='error'>É permitido apenas 10 órgãos por interação</span>");
    return;
  }
  $("#env-para").append('<p class="env-container"><a class="removerCampo'+(total + 1)+'" style="display:block;" onclick="removeCampo(event)" href="javascript:void(0);">- Remover este filtro:</a><input type="text" onkeyup="autocompleteEnviadoPara(event)" list="fieldListEnviadoPara'+(total + 1)+'" class="form-control enviado-para" id="enviadoPara'+(total + 1)+'"><datalist id="fieldListEnviadoPara'+(total + 1)+'"></p>');
  
  //bindNovoAutocomplete(total + 1)
}

function removeCampo(event) {
  
  var scopeSearch = ['pedidos', 'interacoes', 'anexos'];
  var scopeSearchOnlyPedidos = ['pedidos'];
  var elementoClasse = $(event.target);

  total = $("#env-para").children('p').length;

  var primeiro_campo_com_valor = false;
  $('.enviado-para').map(function () {
    if ($(this).val().trim().length > 0 && total == 1) {  
      $(this).val(''); 
      primeiro_campo_com_valor = true;
    }
  })

  if (total > 1 && !primeiro_campo_com_valor) {
     $(elementoClasse).parent().remove();
  }

    if (total <= 1 && primeiro_campo_com_valor) {
      $(elementoClasse).css("display", "block");
    }

    var possui_conteudo = false
    $('.enviado-para').map(function () {
        if ($(this).val().trim().length > 0) {
          possui_conteudo = true;
        }
    })
    
    search_pedidos(1);
};


// function bindNovoAutocomplete(num) {

//   var envPara = "#enviadoPara"+num
//   var fieldlist = "#fieldListEnviadoPara"+num

//       $( envPara ).keyup(function(e) {
//         var data = { "data" :  $(envPara).val() };

//         $.ajax(es_url+'pedidos/searchasyoutype-enviadopara', {
//             method: "POST",
//             data: data,
//             contentType: 'application/x-www-form-urlencoded',
//             dataType: "json",
//             success: function (result) {
//                 $().empty();
//                 _.each(result, function(item) {
//                     $( fieldlist ).append("<option value='"+ item +"'>");
//                 });
//             },
//             error: function (err) {
//                 console.log(err);
//             }
//         });
//     });

// }
</script>

<script type="text/javascript" src="<?=BASE_URL?>assets/js/tooltip-ajuda.js" ></script>