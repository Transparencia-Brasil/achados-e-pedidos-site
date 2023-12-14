//**********************************************************************************************************
//** COMPONENTES DA BUSCA
//**********************************************************************************************************
//
//** Busca Fixa do header  (Template/Layout/front.ctp)
//
//type="text" | Name=buscaFixa | id="buscaFixa"
//type="button" | id="btnBuscaFixa" | attr="busca_pedido">
//
//** Busca Avançada na página de pedidos (Template/Pedidos/index.ctp)
//
//type="text" | name="buscaAvancada" | id="buscaAvancada"
//type="button" | id="btnBuscaAvancada" | attr="busca_pedido"
//
//**********************************************************************************************************
//** FILTROS (Template/Pedidos/index.ctp)
//**********************************************************************************************************
//
//** Pedidos enviados para
//class="enviado-para" | id="enviadoPara"
//
//+ Filtrar por mais um órgão
//class="more-field" | id='novoCampo'
//
//- Remover filtro
//class="more-field" | id='removerCampo'
//
//** Pedido disponibilizado por:
//id="por"
//
//** Data (Data Inicial)
//name="data-de" | id="data-de"
//
//** Data (Data Final)
//id="data-ate"
//
//** Situação do pedido
//class="regular-checkbox" | id="chkEmTramitacao" | id="chkFinalizada" | id="chkNaoObteveResposta"
//
//** Resposta do órgão público (Nível)
//class="regular-checkbox" | id="chkFederal" | id="chkEstadual" | id="chkMunicipal"
//
//** Resposta do órgão público (Poder)
//class="regular-checkbox" | id="chkLegislativo" | id="chkTribunal" | id="chkExecutivo" | id="chkJudiciario" | id="chkMinisterio"
//
//** Botão Limpar
//type="reset" | value="Limpar"
//
//**********************************************************************************************************
// Visualizações da busca (Template/Pedidos/index.ctp)
//**********************************************************************************************************
//
//** Parametros
//id="total_de_pedidos" -> mostra o total de pedidos contidos na lista (sempre fixo). Não aparece quando não existir resultado
//id="palavra_chave" -> armazena e mostra a palavra chave buscada. (quando não tem a palavra chave, não mostra esse parametro)
//** Paginação 
//id="paginacao-de" | id="paginacao-ate"
//Frase "busca não encontrada para a #palavra_chave digitada"
//
//**********************************************************************************************************
// Eventos
//**********************************************************************************************************
//
//** Busca Fixa do header  (Template/Layout/front.ctp)
//
//Clique na lupa id="btnBuscaFixa" (efetua a busca. pega a palavra chave escrita no campo)
//
//Keypress Enter no campo input="text" id="buscaFixa" (efetua a busca. pega a palavra chave escrita no campo)
//
//** Busca Avançada na página de pedidos (Template/Pedidos/index.ctp)
//
//Clique na lupa id="btnBuscaAvancada" (efetua a busca. pega a palavra chave escrita no campo)
//
//Keypress Enter no campo input="text" id="buscaAvancada" (efetua a busca. pega a palavra chave escrita no campo)
//
//** Botão Limpar (Limpa todos os filtros e reseta a busca)
//
//Clique na lupa id="btnBuscaAvancada"
//
//$('#selectedSAYTEP').click(function ()
//$('#selectedSAYTP').click(function ()
//$(".filtro").find(":checkbox")
//$(".filtro").find(":text").change
//
//** Paginação
//
//**********************************************************************************************************
// Metodos
//**********************************************************************************************************
//
//listar_pedidos(1);
//search_pedidos(valordabusca, 1);
//autocomplete();
//autocompleteEnviadoPara();
//autocompletePor();
//pagination(pagination)
//retornaIconSituacao(value)
//retornaIconStatusPedido(value, value_interno)
//ajustaData(data)
//montaBoxPedido(item)
//retornaStatusVerificado(status)
//retornaTipoPedidoResposta(value)
//montaBoxInteracao(item)
//montaBoxAnexo(item)
//slugify(text)
//slugifyUser(text)
//autocomplete()
//autocompleteEnviadoPara()
//autocompletePor()


//1. Listagem
//2. Paginacao
//3. Busca 
//4. Filtros com toltip

var btnBuscaAvancada = $("#btnBuscaAvancada");
var inputBuscaAvancada = $("#buscaAvancada");

var inputBuscaFixa = $("#buscaFixa");

var visualizacao1 = $("#primeira-tela");
var visualizacao2 = $("#cabecalho-resultados");
var visualizacao3 = $("#sem-resultados");
var visualizacao4 = $("#sem-resultados-filtros");
var visualizacao4H4 = $("#sem-resultados-filtros h4");
var visualizacao5 = $("#sem-resultados-em-branco");

//Caixa onde fica a lista de pedidos
var boxe_dos_resultados = $("#boxes-resultados");

var total_de_pedidos = $(".hits-total-display");
var termo_display = $(".termo-display");

//campos dos filtros
var filtroText = $(".filtro").find(":text");
var filtroCheckbox = $(".filtro").find(":checkbox");
var disponibilizado_por = $('#por');
var enviado_para = $("#enviadoPara");
var data_inicial = $("input[name='data-de']");
var fieldList = $("#fieldList");
var fieldListEnviadoPara = $("#fieldListEnviadoPara");
var fieldListPor = $("#fieldListPor");
var data_de = $("#data-de");
var data_ate = $("#data-ate");
var inputFiltroOrgao = $('#selectedSAYTEP');
var inputFiltroPor = $('#selectedSAYTP');

//Outros componentes
var tooltip = $('[data-toggle="tooltip"]');
var btnLimpar = $("input[type=reset]");
var ulPagination = $("#ulPagination");
var paginacao_de = $(".paginacao-de");
var paginacao_ate = $(".paginacao-ate");
var removerCampo = $('.removerCampo'); //filtro por orgão publico (enviado por)
var primeiroRemoverCampo = $('#primeiroRemoverCampo'); //filtro por orgão publico (enviado por)

var inputPor = $("input#por");

var temfiltro = false;

var scopeSearch = ['pedidos', 'interacoes', 'anexos'];
var scopeSearchOnlyPedidos = ['pedidos'];

//INICIALIZAÇÃO
$(document).ready(function() {

    if (location.href.indexOf("?buscaFixa") > -1) {
        querystring = location.href.split("?");
        value = querystring[1].split("=");
        if (value[1].length > 0) {
            var valordabusca = decodeURIComponent(value[1]).replace(/\+/g, ' ')
            inputBuscaAvancada.val(valordabusca);
        }
    }

    search_pedidos(1);

    tooltip.tooltip({
        trigger: 'hover',
        container: 'body'
    });

    var nativedatalist = !!('list' in document.createElement('input')) &&
        !!(document.createElement('datalist') && window.HTMLDataListElement);

    if (!nativedatalist) {
        // $('input[list]').each(function () {
        //     var availableTags = $('#' + $(this).attr("list")).find('option').map(function () {
        //         return this.value;
        //     }).get();
        //     $(this).autocomplete({ source: availableTags });
        // });
    }

    autocomplete();
    //autocompleteEnviadoPara();
    autocompletePor();
});
//FIM INICIALIZAÇÃO

/***********************************************************************************************************************************/
/*
/** EVENTOS */
/*
/***********************************************************************************************************************************/

btnBuscaAvancada.click(function() {
    search_pedidos(1);
});

btnLimpar.click(function() {
    limparBusca();
});

$(inputBuscaAvancada).keypress(function(e) {
    if (e.which == 13) {
        search_pedidos(1);
        e.preventDefault();
        return false;
    }
});

filtroCheckbox.click(function() {
    temfiltro = true;
    search_pedidos(1);
});

filtroText.change(function() {
    temfiltro = true;
    search_pedidos(1);
});

inputFiltroOrgao.click(function() {
    temfiltro = true;
    var show_remove_link = false;
    var counter = 1;
    $(".enviado-para").map(function() {
        // console.log($(thisBtn).parent.attr("id"));
        if (counter == 1) {
            if ($(this).val().trim().length > 0) {
                $(this).parent().find("a").css("display", "block");
            }
        }
        counter++;
    })
    search_pedidos(1);
});

inputFiltroPor.click(function() {
    temfiltro = true;
    search_pedidos(1);
});

//** FIM EVENTOS */

//** visualizacoes: Mostra as mensagens de feedback da página de busca */
// 1. Visualização inícial do pedido (sem filtros e sem busca)
// 2. Visualização de resultado da busca (com ou sem filtro e com a palavra chave da busca)
// 3. Visualização sem resultado para a palavra chave buscada
// 4. Visualização nenhum resultado encontrado para a filtragem específica (com filtro e com ou sem palavra chave)
// Parametros (com valores exemplo)
// {total_registros: 100, paginacao_de: 0, paginacao_ate: 30, palavra_chave: null}
var parametros_visualizacao = {
    "total_registros": 0,
    "paginacao_de": 0,
    "paginacao_ate": 0,
    "palavra_chave": null,
}

function visualizacoes(_parametros) {
    var param = _parametros;

    var checkboxChecked = $('#accordion input:checked');

    // Zera as visualizações e a listagem de pedidos
    visualizacao1.css("display", "none");
    visualizacao2.css("display", "none");
    visualizacao3.css("display", "none");
    visualizacao4.css("display", "none");
    visualizacao4H4.css("display", "none");
    visualizacao5.css("display", "none");
    boxe_dos_resultados.empty();

    //Verifica se foi feito filtragem
    var filtro_erro = false;
    if (disponibilizado_por.val() != undefined && disponibilizado_por.val().length > 0) {
        filtro_erro = true;
    }
    if (data_inicial.val() != undefined && data_inicial.val().length >= 10 && !filtro_erro) {
        filtro_erro = true;
    }

    if (checkboxChecked.length != undefined && checkboxChecked.length >= 1 && !filtro_erro) {
        filtro_erro = true;
    }

    $('.enviado-para').map(function() {
        if ($(this).val().trim().length > 0) {
            filtro_erro = true;
        }
    })

    // 1. Visualização inícial do pedido (sem filtros e sem busca)
    // Parametros: total de registros, paginacao de, paginacao até,
    if ((param.total_registros > 0) && (param.palavra_chave == null)) {
        visualizacao1.css("display", "block");
        total_de_pedidos.text(param.total_registros);
        paginacao_de.text(param.paginacao_de);
        paginacao_ate.text(param.paginacao_ate);
    }

    // 2. Visualização de resultado da busca (com ou sem filtro e com a palavra chave da busca)
    // Parametros: palavra chave, total de registros, paginacao de, paginacao até, pesquisou em filtro?
    if ((param.total_registros > 0) && (param.palavra_chave != null)) {
        visualizacao2.css("display", "block");
        termo_display.text(param.palavra_chave);
        total_de_pedidos.text(param.total_registros);
        paginacao_de.text(param.paginacao_de);
        paginacao_ate.text(param.paginacao_ate);
    }

    // 3. Visualização sem resultado para a palavra chave buscada
    // Parametros: palavra chave, retornou sem resultado a busca
    if ((param.total_registros <= 0) && (param.palavra_chave != null) && !filtro_erro) {
        visualizacao3.css("display", "block");
        termo_display.text(param.palavra_chave);
    }

    // 4. Visualização nenhum resultado encontrado para a filtragem específica (com filtro e com ou sem palavra chave)
    // Parametros: palavra chave, retornou sem resultado a busca e pesquisou em filtros
    if ((param.total_registros <= 0) && (filtro_erro)) {
        visualizacao4.css("display", "block");

        if (param.palavra_chave != null) {
            visualizacao4H4.css("display", "block");
            termo_display.text(param.palavra_chave);
        }

        total_de_pedidos.text(param.total_registros);
        paginacao_de.text(param.paginacao_de);
        paginacao_ate.text(param.paginacao_ate);
    }

    if (param.total_registros == null) {
        visualizacao5.css("display", "block");
    }
}
//*** getData: PEGA VALORES DOS FILTROS E DO CAMPO DA BUSCA */
function getData(page) {

    temfiltro = false;
    var fieldValue = undefined;
    if (inputBuscaAvancada.val() != undefined && inputBuscaAvancada.val().length > 0) {
        fieldValue = inputBuscaAvancada.val();
        temfiltro = true;
    }

    var enviadoPara = []
    $('.enviado-para').map(function() {
        if ($(this).val().trim()) {
            enviadoPara.push($(this).val().trim());
            temfiltro = true;
        }
    })

    var newData_de = undefined;
    if (data_de.val() != undefined && data_de.val().length > 0) {
        var data_de_val = data_de.val();
        newData_de = data_de_val.split("/").reverse().join("-");
        temfiltro = false;
    }

    var newData_ate = undefined;
    if (data_ate.val() != undefined && data_ate.val().length > 0) {
        var data_ate_val = data_ate.val();
        newData_ate = data_ate_val.split("/").reverse().join("-");
        temfiltro = false;
    }

    if (disponibilizado_por.val() != undefined && disponibilizado_por.val().length > 0) {
        temfiltro = true;
    }

    var data = {
        "value": fieldValue,
        "currentPage": page,
        "dataDe": newData_de,
        "dataAte": newData_ate,
        "enviadoPara": enviadoPara,
        "por": disponibilizado_por.val(),
        "chkEmTramitacao": $('#chkEmTramitacao').is(':checked'),
        "chkFinalizada": $('#chkFinalizada').is(':checked'),
        "chkNaoObteveResposta": $('#chkNaoObteveResposta').is(':checked'),
        "chkPedidosRecursoSim": $('#chkPedidosRecursoSim').is(':checked'),
        "chkPedidosRecursoNao": $('#chkPedidosRecursoNao').is(':checked'),
        "chkAtendido": $('#chkAtendido').is(':checked'),
        "chkNaoAtendido": $('#chkNaoAtendido').is(':checked'),
        "chkParcAtendido": $('#chkParcAtendido').is(':checked'),
        "chkFederal": $('#chkFederal').is(':checked'),
        "chkEstadual": $('#chkEstadual').is(':checked'),
        "chkMunicipal": $('#chkMunicipal').is(':checked'),
        "chkLegislativo": $('#chkLegislativo').is(':checked'),
        "chkExecutivo": $('#chkExecutivo').is(':checked'),
        "chkJudiciario": $('#chkJudiciario').is(':checked'),
        "chkMinisterio": $('#chkMinisterio').is(':checked'),
        "chkPedidoAnexo": $('#chkPedidoAnexo').is(':checked'),
        "scope_search": setAPIScope()
    };

    return data;
}

//** API (listar_pedidos e search_pedidos) E PAGINACAO */
// function listar_pedidos(page,scope) {
//     console.log("listar pedidos");

//     data = getData(page);

//     $.ajax(es_url + 'pedidos/listar', {
//         method: "POST",
//         data: data,
//         contentType: 'application/x-www-form-urlencoded',
//         dataType: "json",
//         success: function (result) {

//             pagination(result.pagination);

//             parametros_visualizacao = {
//                 "total_registros": result.hits.hits.total,
//                 "paginacao_de": result.pagination.fromResult,
//                 "paginacao_ate": result.pagination.toResult,
//                 "palavra_chave": null
//             }
//             visualizacoes(parametros_visualizacao)

//             _.each(result.hits.hits.hits, function (item) {
//                 montaBoxPedido(item);
//             });

//         },
//         error: function (err) {
//             console.log(err);

//         }
//     });
// }

function search_pedidos(page) {

    data = getData(page);

    //if (data.value != undefined || (data.por.length > 0 || data.enviadoPara.length > 0)) {
    //if (data.value != undefined || temfiltro === true) {
    $.ajax(es_url + 'busca-avancada', {
        method: "POST",
        data: data,
        contentType: 'application/x-www-form-urlencoded',
        // headers: { "x-csrf-token": ns.localStorage.get('token') },
        dataType: "json",
        success: function(result) {

            pagination(result.pagination);

            parametros_visualizacao = {
                "total_registros": result.hits.hits.total,
                "paginacao_de": result.pagination.fromResult,
                "paginacao_ate": result.pagination.toResult,
                "palavra_chave": data.value
            }
            visualizacoes(parametros_visualizacao)

            _.each(result.hits.hits.hits, function(item) {
                switch (item._index) {
                    case "pedidos":
                        montaBoxPedido(item);
                        break;
                    case "interacoes":
                        montaBoxInteracao(item);
                        break;
                    case "anexos":
                        montaBoxAnexo(item);
                        break;
                }
            });
        },
        error: function(err) {

            console.log(err);

        }


    });
    //}
}

function pagination(pagination) {

    ulPagination.empty();

    var result = '';

    if (pagination.first == null) {
        ulPagination.append('<li class="disabled"><span>«</span></li>');
    } else {
        ulPagination.append('<li><span><a href="#" class="paginacao" id="' + pagination.first + '">«</a></span></li>');
    }

    _.each(pagination.range, function(item) {
        if (item == pagination.current) {
            ulPagination.append('<li class="disabled active"><a href="#">' + item + '</a></li>');
        } else {
            ulPagination.append('<li><a href="#" class="paginacao" id="' + item + '">' + item + '</a></li>');
        }
    });

    if (pagination.last == null) {
        ulPagination.append('<li class="disabled"><span>»</span></li>');
    } else {
        ulPagination.append('<li><span><a href="#" class="paginacao" id="' + pagination.last + '">»</a></span></li>');
    }

    var paginacaoClass = $(".paginacao");
    paginacaoClass.click(function() {
        search_pedidos($(this).attr("id"));
    });

}

/**** MONTAGEM DOS CARDS DE PEDIDOS, INTERACOES e ANEXOS */
function montaBoxPedido(item) {

    var obj = item._source;
    // console.log(obj);
    var iconSituacao = retornaIconSituacao(obj.tipo_pedido_situacao_codigo_local);
    var iconStatusPedido = retornaIconStatusPedido(obj.status_pedido_codigo_local, obj.status_pedido_interno_codigo_local);
    var titulo = obj.pedidos_titulo_local;
    var descricao = obj.pedidos_titulo_local;

    if (_.has(item.highlight, 'pedidos_titulo_local') && termo_display.text().length > 0) {
        titulo = item.highlight.pedidos_titulo_local[0];
    } else {
        titulo = obj.pedidos_titulo_local;
    }

    if (_.has(item.highlight, 'pedidos_descricao_local') && termo_display.text().length > 0) {
        descricao = item.highlight.pedidos_descricao_local;
    } else {
        descricao = obj.pedidos_descricao_local;
    }


    var box = '<div class="col-md-12 col-sm-12 col-xs-12 box">';
    box += '  <div class="col-md-8 col-sm-8 col-xs-12">';
    box += '    <h4 style="margin-bottom:5%">' + titulo + '</h4>';
    box += '    <div class="enviado">Pedido enviado para: <a href="agentes/' + obj.agentes_slug_local + '">' + obj.agentes_nome_local + '</a></div>';
    box += '    <div class="por">Pedido disponibilizado por: <a href="usuarios/' + obj.usuarios_slug_local + '">' + obj.usuarios_nome_local + '</a></div>';
    box += '    <div class="em">Pedido LAI realizado em: ' + ajustaData(obj.pedidos_data_envio_local) + '</div>';
    box += '    <div class="situacao">';
    box += '      <div class="col-md-6 col-sm-6 col-xs-12">';
    box +=          iconStatusPedido;
    box += '        <div  style="float:left;margin-right:15px;">';
    box += '            <ul style="list-style-type: none;padding:0px;">'
    box += '                <li>Resposta:</li>'
    box += '                <li> <strong>' + obj.status_pedido_nome_local + '</strong></li>'
    box += '            </ul>'
    box += '        </div>'
    box += '      <div>'
    box += '      <img src="' + base_url + 'assets/images/pedidos/pergunta.png" alt="" data-tooltip="tooltip-resposta-pedido" class="img-responsive tooltip-ajuda-action" style="cursor:pointer;">'
    box += '    </div>'
    box += '    <div id="tooltip-resposta-pedido" class="tooltip-ajuda hidden text-right">';
    box += '        <div class="text-right">';
    box += '            <a href="#" class="close-tooltip" data-dismiss="alert" style="color:white;">&times;</a>';
    box += '        </div>';
    box += '        <div class="tooltip-ajuda-inner text-left" style="padding:5px;">';
    box += '            Esta classificação é feita com um modelo de inteligência artificial que ';
    box += '            analisa a estrutura dos textos do pedido e da resposta para determinar se a ';
    box += '            solicitação foi atendida de fato, ou seja, se a informação foi fornecida. ';
    box += '            O código, desenvolvido especialmente para o Achados e Pedidos, classifica corretamente os pedidos em 85% dos casos. ';
    box += '            Caso encontre uma classificação incorreta, por favor nos notifique. Saiba mais <a class="tooltip-ajuda-icon" href="' + base_url + 'na-midia/achados-e-pedidos-usa-inteligencia-artificial-para-classificar-atendimento-a-pedidos">aqui</a>';
    box += '      </div>';
    box += '</div></p>';
    box += '      </div>';
    box += '    </div>';
    box += '  </div>';
    box += '  <div class="col-md-4 col-sm-4 col-xs-12 highlight-box">';
    box += '   <p class="highlight-session bgcolor1">Pedido</p>';
    box += '    <p class="highlight-text">';
    box += truncate.apply(descricao, [300, true]);
    box += '    </p>';
    box += '  </div>';
    box += '  <div class="col-md-4 col-sm-4 col-xs-12 bt-margin">';
    box += '    <div class="btnVerMais pull-right">';
    box += '      <a href="' + base_url + 'pedidos/' + obj.pedidos_slug_local + '">Ver <div class="seta seta-direita"></div></a>';
    box += '    </div>';
    box += '  </div>';
    box += '</div>';


    boxe_dos_resultados.append(box);
    InitTooltipsAjuda();
}

function montaBoxInteracao(item) {

    var obj = item._source;
    var iconSituacao = retornaIconSituacao(obj.tipo_pedido_situacao_codigo);
    var iconStatusPedido = retornaIconStatusPedido(obj.status_pedido_codigo, obj.status_pedido_interno_codigo);
    var titulo = obj.pedidos_titulo;
    var descricao = obj.interacoes_descricao_local;

    if (_.has(item.highlight, 'interacoes_descricao_local')) {
        descricao = item.highlight.interacoes_descricao_local[0];
    }

    var box = '<div class="col-md-12 col-sm-12 col-xs-12 box">';
    box += '  <div class="col-md-8 col-sm-8 col-xs-12">';
    box += '    <h4 style="margin-bottom:5%">' + titulo + '</h4>';
    box += '    <div class="enviado">Pedido enviado para: <a href="agentes/' + obj.agentes_slug + '">' + obj.agentes_nome + '</a></div>';
    box += '    <div class="por">Pedido disponibilizado por: <a href="usuarios/' + obj.usuarios_slug + '">' + obj.usuarios_nome + '</a></div>';
    box += '    <div class="em">Pedido LAI realizado em: ' + ajustaData(obj.pedidos_data_envio) + '</div>';
    box += '    <div class="situacao">';
    box += '      <div class="col-md-6 col-sm-6 col-xs-12">';
    box +=          iconStatusPedido;
    box += '        <div  style="float:left;margin-right:15px;">';
    box += '            <ul style="list-style-type: none;padding:0px;">'
    box += '                <li>Resposta:</li>'
    box += '                <li> <strong>' + obj.status_pedido_nome + '</strong></li>'
    box += '            </ul>'
    box += '        </div>'
    box += '      <div>'
    box += '      <img src="' + base_url + 'assets/images/pedidos/pergunta.png" alt="" data-tooltip="tooltip-resposta-pedido" class="img-responsive tooltip-ajuda-action" style="cursor:pointer;">'
    box += '    </div>'
    box += '    <div id="tooltip-resposta-pedido" class="tooltip-ajuda hidden text-right">';
    box += '        <div class="text-right">';
    box += '            <a href="#" class="close-tooltip" data-dismiss="alert" style="color:white;">&times;</a>';
    box += '        </div>';
    box += '        <div class="tooltip-ajuda-inner text-left" style="padding:5px;">';
    box += '            Esta classificação é feita com um modelo de inteligência artificial que ';
    box += '            analisa a estrutura dos textos do pedido e da resposta para determinar se a ';
    box += '            solicitação foi atendida de fato, ou seja, se a informação foi fornecida. ';
    box += '            O código, desenvolvido especialmente para o Achados e Pedidos, classifica corretamente os pedidos em 85% dos casos. ';
    box += '            Caso encontre uma classificação incorreta, por favor nos notifique. Saiba mais <a class="tooltip-ajuda-icon" href="' + base_url + 'na-midia/achados-e-pedidos-usa-inteligencia-artificial-para-classificar-atendimento-a-pedidos">aqui</a>';
    box += '      </div>';
    box += '</div></p>';
    box += '      </div>';
    box += '    </div>';
    box += '  </div>';
    box += '  <div class="col-md-4 col-sm-4 col-xs-12 highlight-box">';
    box += retornaTipoPedidoResposta(obj.tipo_pedidos_resposta_codigo_local);
    box += '    <p class="highlight-text">';
    box += truncate.apply(descricao, [300, true]);
    box += '    </p>';
    box += '  </div>';
    box += '  <div class="col-md-4 col-sm-4 col-xs-12 bt-margin">';
    box += '    <div class="btnVerMais pull-right">';
    box += '      <a href="' + base_url + 'pedidos/' + obj.pedidos_slug + '">Ver <div class="seta seta-direita"></div></a>';
    box += '    </div>';
    box += '  </div>';
    box += '</div>';

    boxe_dos_resultados.append(box);
    InitTooltipsAjuda();
}

function montaBoxAnexo(item) {

    var obj = item._source;
    var iconSituacao = retornaIconSituacao(obj.tipo_pedido_situacao_codigo);
    var iconStatusPedido = retornaIconStatusPedido(obj.status_pedido_codigo, obj.status_pedido_interno_codigo);
    var titulo = obj.pedidos_titulo;
    var descricao = obj.anexos_conteudo_arquivo;

    if (_.has(item.highlight, 'anexos_conteudo_arquivo')) {
        descricao = item.highlight.anexos_conteudo_arquivo[0];
    }


    var box = '<div class="col-md-12 col-sm-12 col-xs-12 box">';
    box += '  <div class="col-md-8 col-sm-8 col-xs-12">';
    box += '    <h4 style="margin-bottom:5%">' + titulo + '</h4>';
    box += '    <div class="enviado">Pedido enviado para: <a href="agentes/' + obj.agentes_slug + '">' + obj.agentes_nome + '</a></div>';
    box += '    <div class="por">Pedido disponibilizado por: <a href="usuarios/' + obj.usuarios_slug + '">' + obj.usuarios_nome + '</a></div>';
    box += '    <div class="em">Pedido LAI realizado em: ' + ajustaData(obj.pedidos_data_envio) + '</div>';
    box += '    <div class="situacao">';
    box += '      <div class="col-md-6 col-sm-6 col-xs-12">';
    box +=          iconStatusPedido;
    box += '        <div  style="float:left;margin-right:15px;">';
    box += '            <ul style="list-style-type: none;padding:0px;">'
    box += '                <li>Resposta:</li>'
    box += '                <li> <strong>' + obj.status_pedido_nome + '</strong></li>'
    box += '            </ul>'
    box += '        </div>'
    box += '      <div>'
    box += '      <img src="' + base_url + 'assets/images/pedidos/pergunta.png" alt="" data-tooltip="tooltip-resposta-pedido" class="img-responsive tooltip-ajuda-action" style="cursor:pointer;">'
    box += '    </div>'
    box += '    <div id="tooltip-resposta-pedido" class="tooltip-ajuda hidden text-right">';
    box += '        <div class="text-right">';
    box += '            <a href="#" class="close-tooltip" data-dismiss="alert" style="color:white;">&times;</a>';
    box += '        </div>';
    box += '        <div class="tooltip-ajuda-inner text-left" style="padding:5px;">';
    box += '            Esta classificação é feita com um modelo de inteligência artificial que ';
    box += '            analisa a estrutura dos textos do pedido e da resposta para determinar se a ';
    box += '            solicitação foi atendida de fato, ou seja, se a informação foi fornecida. ';
    box += '            O código, desenvolvido especialmente para o Achados e Pedidos, classifica corretamente os pedidos em 85% dos casos. ';
    box += '            Caso encontre uma classificação incorreta, por favor nos notifique. Saiba mais <a class="tooltip-ajuda-icon" href="' + base_url + 'na-midia/achados-e-pedidos-usa-inteligencia-artificial-para-classificar-atendimento-a-pedidos">aqui</a>';
    box += '      </div>';
    box += '</div></p>';
    box += '      </div>';
    box += '    </div>';
    box += '  </div>';
    box += '  <div class="col-md-4 col-sm-4 col-xs-12 highlight-box">';
    box += retornaTipoPedidoResposta(obj.tipo_pedidos_resposta_codigo);
    box += '    <p class="highlight-session"><a href="' + base_url + "uploads/pedidos/" + obj.anexos_arquivo + '" target="_blank"><img src="' + base_url + 'assets/images/pedidos/icon-arquivo.png" style="margin-right:3px;"> arquivo anexo</a></p>';
    box += '    <p class="highlight-text">';
    box += truncate.apply(descricao, [300, true]);
    box += '    </p>';
    box += '  </div>';
    box += '  <div class="col-md-4 col-sm-4 col-xs-12 bt-margin">';
    box += '    <div class="btnVerMais pull-right">';
    box += '      <a href="' + base_url + 'pedidos/' + obj.pedidos_slug + '">Ver <div class="seta seta-direita"></div></a>';
    box += '    </div>';
    box += '  </div>';
    box += '</div>';

    boxe_dos_resultados.append(box);
    InitTooltipsAjuda();
}

function retornaIconSituacao(value) {
    switch (value) {
        case "1":
            return '<img src="' + base_url + 'assets/images/pedidos/icon-em-tramitacao.png">';
        default:
            return '<img src="' + base_url + 'assets/images/pedidos/icon-finalizado.png">';
    }
}

function retornaStatusVerificado(status) {
    return '';
}

function retornaTipoPedidoResposta(value) {
    switch (value) {
        case "1":
            return '<p class="highlight-session bgcolor1">Resposta do Órgão público</p>';
        case "2":
            return '<p class="highlight-session bgcolor2">Reclamação</p>';
        case "3":
            return '<p class="highlight-session bgcolor2">Resposta da Reclamação</p>';
        case "4":
            return '<p class="highlight-session bgcolor3">Recurso - 1ª Instância</p>';
        case "5":
            return '<p class="highlight-session bgcolor3">Resposta do recurso - 1ª Instâncua</p>';
        case "6":
            return '<p class="highlight-session bgcolor4">Recurso - 2ª Instâncua</p>';
        case "7":
            return '<p class="highlight-session bgcolor4">Resposta do recurso - 2ª Instâncua</p>';
        case "8":
            return '<p class="highlight-session bgcolor5">Recurso - 3ª Instâncua</p>';
        case "9":
            return '<p class="highlight-session bgcolor5">Resposta do recurso - 3ª Instâncua</p>';
        case "10":
            return '<p class="highlight-session bgcolor6">Recurso - 4ª Judicial</p>';
        case "11":
            return '<p class="highlight-session bgcolor6">Resposta do recurso - 4ª Judicial</p>';
        default:
            return '<p class="highlight-session bgcolor1">Fora do RANGE</p>';
    }
}

function retornaIconStatusPedido(value, value_interno) {

    var icon = '';

    switch (value) {
        case "1":
            icon = 'icon-atendido';
            break
        case "2":
            icon = 'icon-nao-atendido';
            break
        case "3":
            icon = 'icon-parcialmente-atendido';
            break
        case "4":
            icon = 'icon-naoclassificado';
            break
        default:
            icon = 'icon-naoclassificado';
    }

    // if (value_interno == "1" && icon != 'icon-naoclassificado') {
    //     icon += '-verificado';
    // }
    return '<img src="' + base_url + 'assets/images/pedidos/' + icon + '.png">';
}

function ajustaData(data) {
    if (data != null)
        return data.substring(8, 10) + '/' + data.substring(5, 7) + '/' + data.substring(0, 4);

    return null
}
/**** FIM MONTAGEM DOS CARDS DE PEDIDOS, INTERACOES e ANEXOS */


// FUNCOES DE AUTOCOMPLETE

function autocomplete() {

    inputBuscaAvancada.keyup(function(e) {

        if (e.which != 13 && e.which != 38 && e.which != 40) {
            var data = {
                "data": inputBuscaAvancada.val()
            };

            $.ajax(es_url + 'pedidos/searchasyoutype', {
                method: "POST",
                data: data,
                contentType: 'application/x-www-form-urlencoded',
                // headers: { "x-csrf-token": ns.localStorage.get('token') },
                dataType: "json",
                success: function(result) {

                    // console.log(result);
                    // $( "#fieldList" ).val();
                    // fieldList.empty();

                    // _.each(result, function (item) {

                    //     fieldList.append("<option value='" + item + "'>");

                    // });

                    $("#buscaAvancada").autocomplete({
                        source: result,
                        minLength: 1,
                        delay: 500,
                        autoFocus: true,
                        classes: {
                            "ui-autocomplete": "highlight"
                        }
                    });

                },
                error: function(err) {
                    console.log(err);
                }


            });
        }

        if (e.which == 13) {
            console.log("entrou no autocomplete entere");
            adicionaCampo();
            search_pedidos(1);
            return false;
        }

    });

}

function autocompleteEnviadoPara(event) {

    console.log("autocompleteEnviadoPara")
    var data = { "data": $(event.target).val() };

    $.ajax(es_url + 'pedidos/searchasyoutype-enviadopara', {
        method: "POST",
        data: data,
        contentType: 'application/x-www-form-urlencoded',
        dataType: "json",
        success: function(result) {
            //fieldListEnviadoPara.empty();
            //console.log(result);
            // // _.each(result, function (item) {
            // //    fieldListEnviadoPara.append("<option value='" + item + "'>");
            // // });
            // console.log($(event.target));
            $(event.target).autocomplete({
                source: result,
                minLength: 2,
                delay: 500,
                autoFocus: true,
                classes: {
                    "ui-autocomplete": "highlight"
                }
            });
        },
        error: function(err) {
            console.log(err);
        }
    });
}

function autocompletePor() {

    disponibilizado_por.keyup(function(e) {
        var data = { "data": disponibilizado_por.val() };

        $.ajax(es_url + 'pedidos/searchasyoutype-por', {
            method: "POST",
            data: data,
            contentType: 'application/x-www-form-urlencoded',
            dataType: "json",
            success: function(result) {
                // fieldListPor.empty();
                // _.each(result, function (item) {
                //     fieldListPor.append("<option value='" + item + "'>");
                // });
                $('#por').autocomplete({
                    source: result,
                    minLength: 2,
                    delay: 500,
                    autoFocus: true,
                    classes: {
                        "ui-autocomplete": "highlight"
                    }
                });
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

}

function limparBusca() {

    console.log($(".env-container input"));
    $(".env-container input").val('');
    inputPor.prop("value", "");

    filtroCheckbox.each(function() {
        $(this).prop("checked", false);
    });
    temfiltro = false;
    data_de.prop("value", "");
    data_ate.prop("value", "");

    search_pedidos(1);
}

function setAPIScope() {
    if (inputBuscaAvancada.val() != undefined && inputBuscaAvancada.val().length > 0) {
        return scopeSearch;
    } else {
        return scopeSearchOnlyPedidos;
    }
}

function truncate(n, useWordBoundary) {
    if (this.length <= n) { return this; }
    var subString = this.substr(0, n - 1);
    return (useWordBoundary ?
        subString.substr(0, subString.lastIndexOf(' ')) :
        subString) + "...";
};