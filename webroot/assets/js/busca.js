$(function() {

    $("input[type=reset]").click(function() {
        $("input#enviadoPara").prop("value", "");
        $("input#por").prop("value", "");
    });



    $(document).ready(function() {

        //verifica URL. lista default de pedidos so entra na pagina de pedidos
        if (location.href.indexOf("/busca") <= -1) {
            listar_pedidos(1);
        } else {
            if (location.href.indexOf("?termo") > -1) {
                querystring = location.href.split("?");
                value = querystring[1].split("=");
                if (value[1].length > 0) {
                    var valordabusca = decodeURIComponent(value[1]).replace(/\+/g, ' ')
                    search_geral(valordabusca, 1);
                }
            }
        }
        autocomplete();

        $("#cabecalho-resultados").hide();
        $("#sem-resultados").hide();

        $("#btnsearch").click(function() {
            if ($(this).attr('attr') == "busca_pedido") {
                search_pedidos($('#fieldValue').val(), 1);
            } else {
                search_geral($('#fieldValue').val(), 1);
            }
        });

        $("input[type=reset]").click(function() {
            $(".filtro").find(":checkbox").each(function() {
                $(this).prop("checked", false);
            });
            $("#data-de").prop("value", "");
            $("#data-ate").prop("value", "");
            if ($(".termo-display").text().length > 0) {
                search_pedidos($(".termo-display").text(), 1);
            } else {
                listar_pedidos(1);
            }
        });

        $(document).keypress(function(e) {
            if (e.which == 13) {
                if ($("#btnsearch").attr('attr') == "busca_pedido") {
                    search_pedidos($('#fieldValue').val(), 1);
                } else {
                    search_geral($('#fieldValue').val(), 1);
                }
                return false;
            }
        });

        $(".filtro").find(":checkbox").click(function() {
            if ($(".termo-display").text().length > 0) {
                search_pedidos($(".termo-display").text(), 1);
            } else {
                listar_pedidos(1);
            }
        });

        $(".filtro").find(":text").change(function() {
            if ($(".termo-display").text().length > 0) {
                search_pedidos($(".termo-display").text(), 1);
            } else {
                listar_pedidos(1);
            }
        });

    });

    function pagination(pagination) {

        $("#ulPagination").empty();

        var result = '';

        if (pagination.first == null) {
            $("#ulPagination").append('<li class="disabled"><span>«</span></li>');
        } else {
            $("#ulPagination").append('<li><span><a href="#" class="paginacao" id="' + pagination.first + '">«</a></span></li>');
        }

        _.each(pagination.range, function(item) {
            if (item == pagination.current) {
                $("#ulPagination").append('<li class="disabled active"><a href="#">' + item + '</a></li>');
            } else {
                $("#ulPagination").append('<li><a href="#" class="paginacao" id="' + item + '">' + item + '</a></li>');
            }
        });

        if (pagination.last == null) {
            $("#ulPagination").append('<li class="disabled"><span>»</span></li>');
        } else {
            $("#ulPagination").append('<li><span><a href="#" class="paginacao" id="' + pagination.last + '">»</a></span></li>');
        }

        $(".paginacao").click(function() {
            if ($(".termo-display").text().length > 0) {
                if ($("#btnsearch").attr('attr') == "busca_pedido") {
                    search_pedidos($(".termo-display").text(), $(this).attr("id"));
                } else {
                    search_geral($(".termo-display").text(), $(this).attr("id"));
                }
            } else {
                listar_pedidos($(this).attr("id"));
            }
        });

    }

    function listar_pedidos(page) {

        var newData_de = undefined;
        if ($("#data-de").val().length > 0) {
            var data_de = $("#data-de").val();
            newData_de = data_de.split("/").reverse().join("-");
        }

        var newData_ate = undefined;
        if ($("#data-ate").val().length > 0) {
            var data_ate = $("#data-ate").val();
            newData_ate = data_ate.split("/").reverse().join("-");
        }

        var data = {
            "currentPage": page,
            "dataDe": newData_de,
            "dataAte": newData_ate,
            "chkEmTramitacao": $('#chkEmTramitacao').is(':checked'),
            "chkFinalizada": $('#chkFinalizada').is(':checked'),
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
            "chkMinisterio": $('#chkMinisterio').is(':checked')
        };

        $.ajax(es_url + 'pedidos/listar', {
            method: "POST",
            data: data,
            contentType: 'application/x-www-form-urlencoded',
            dataType: "json",
            success: function(result) {
                pagination(result.pagination);

                if (result.hits.hits.total > 0) {
                    $("#primeira-tela").show();
                    $("#boxes-resultados").show();
                    $("#sem-resultados-filtros").hide();
                } else {
                    $("#sem-resultados-filtros").show();
                    $("#primeira-tela").hide();
                    $("#boxes-resultados").hide();
                    return;
                }
                $(".hits-total-display").text(result.hits.hits.total);

                $(".paginacao-de").text(result.pagination.fromResult);
                $(".paginacao-ate").text(result.pagination.toResult);

                $("#fieldValue").val('');
                $("#boxes-resultados").empty();

                _.each(result.hits.hits.hits, function(item) {
                    montaBoxPedido(item);
                });

            },
            error: function(err) {
                console.log(err);

            }
        });

    }

    function search_geral(fieldValue, page) {

        if (!fieldValue) {
            $("#boxes-resultados").empty();
            $("#boxes-resultados").html('Você deve digitar algum valor na caixa de pesquisa');
            $("#cabecalho-resultados").css("display", "none");
            return;
        }
        console.log(fieldValue + " ," + page);
        var data = {
            "value": fieldValue,
            "currentPage": page
        };

        $.ajax(es_url + 'consulta-simples', {
            method: "POST",
            data: data,
            contentType: 'application/x-www-form-urlencoded',
            // headers: { "x-csrf-token": ns.localStorage.get('token') },
            dataType: "json",
            success: function(result) {

                pagination(result.pagination);

                if (result.hits.hits.total > 0) {
                    $("#cabecalho-resultados").show();
                } else {
                    $("#cabecalho-resultados").css("display", "none");
                    $("#boxes-resultados").empty();
                    return;
                }


                $(".termo-display").text(fieldValue);
                $(".hits-total-display").text(result.hits.hits.total);

                $(".paginacao-de").text(result.pagination.fromResult);
                $(".paginacao-ate").text(result.pagination.toResult);

                $("#fieldValue").val('');
                $("#boxes-resultados").empty();
                $("#cabecalho-resultados").css("display", "none");


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

    }

    function search_pedidos(fieldValue, page) {

        if (!fieldValue) {
            $("#boxes-resultados").empty();
            $("#cabecalho-resultados").css("display", "none");
            $("#boxes-resultados").html('Você deve digitar algum valor na caixa de pesquisa');
            return
        }

        var newData_de = undefined;
        if ($("#data-de").val().length > 0) {
            var data_de = $("#data-de").val();
            newData_de = data_de.split("/").reverse().join("-");
        }

        var newData_ate = undefined;
        if ($("#data-ate").val().length > 0) {
            var data_ate = $("#data-ate").val();
            newData_ate = data_ate.split("/").reverse().join("-");
        }

        var data = {
            "value": fieldValue,
            "currentPage": page,
            "dataDe": newData_de,
            "dataAte": newData_ate,
            "chkEmTramitacao": $('#chkEmTramitacao').is(':checked'),
            "chkFinalizada": $('#chkFinalizada').is(':checked'),
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
            "chkMinisterio": $('#chkMinisterio').is(':checked')
        };
        //console.log(data);
        $.ajax(es_url + 'consultar', {
            method: "POST",
            data: data,
            contentType: 'application/x-www-form-urlencoded',
            // headers: { "x-csrf-token": ns.localStorage.get('token') },
            dataType: "json",
            success: function(result) {

                pagination(result.pagination);

                if (result.hits.hits.total > 0) {
                    $("#cabecalho-resultados").show();
                    $("#sem-resultados").hide();
                    $("#sem-resultados").hide();
                    $("#primeira-tela").hide();
                } else {
                    $("#boxes-resultados").empty();
                    $("#cabecalho-resultados").hide();
                    $("#sem-resultados").show();
                    $("termo-display-noresult").text(fieldValue)
                    $("#primeira-tela").hide();
                    //return;
                }

                $(".termo-display").text(fieldValue);
                //console.log(result);
                $(".hits-total-display").text(result.hits.hits.total);

                $(".paginacao-de").text(result.pagination.fromResult);
                $(".paginacao-ate").text(result.pagination.toResult);

                $("#fieldValue").val('');
                $("#boxes-resultados").empty();

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

    }

    function retornaIconSituacao(value) {
        switch (value) {
            case "1":
                return '<img src="' + base_url + 'assets/images/pedidos/icon-em-tramitacao.png">';
            default:
                return '<img src="' + base_url + 'assets/images/pedidos/icon-finalizado.png">';
        }
    }

    function retornaIconStatusPedido(value, value_interno) {

        var icon = '';

        //console.log(value + " , " + value_interno)

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

        if (value_interno == "1" && icon != 'icon-naoclassificado') {
            icon += '-verificado';
        }
        //console.log('<img src="assets/images/pedidos/' + icon + '.png">');
        return '<img src="' + base_url + 'assets/images/pedidos/' + icon + '.png">';
    }

    function ajustaData(data) {
        if (data != null)
            return data.substring(8, 10) + '/' + data.substring(5, 7) + '/' + data.substring(0, 4);

        return null
    }

    function montaBoxPedido(item) {

        var obj = item._source;
        console.log(obj);
        var iconSituacao = retornaIconSituacao(obj.tipo_pedido_situacao_codigo_local);
        var iconStatusPedido = retornaIconStatusPedido(obj.status_pedido_codigo_local, obj.status_pedido_interno_codigo_local);
        var titulo = obj.pedidos_titulo_local;
        var descricao = obj.pedidos_titulo_local;

        if (_.has(item.highlight, 'pedidos_titulo_local')) {
            titulo = item.highlight.pedidos_titulo_local[0];
        }

        if (_.has(item.highlight, 'pedidos_descricao_local')) {
            descricao = item.highlight.pedidos_descricao_local[0];
        }


        var box = '<div class="col-md-12 col-sm-12 col-xs-12 box">';
        box += '  <div class="col-md-8 col-sm-8 col-xs-12">';
        box += '    <h4 style="margin-bottom:5%">' + titulo + '</h4>';
        box += '    <div class="enviado">Pedido enviado para: <a href="agentes/' + obj.agentes_slug_local + '">' + obj.agentes_nome_local + '</a></div>';
        box += '    <div class="por">Pedido disponibilizado por: <a href="usuarios/' + obj.usuarios_slug_local + '">' + obj.usuarios_nome_local + '</a></div>';
        box += '    <div class="em">Em: ' + ajustaData(obj.pedidos_data_envio_local) + '</div>';
        box += '    <div class="situacao">';
        box += '      <div class="col-md-6 col-sm-6 col-xs-12">';
        box += iconSituacao;
        box += '        <p>Situação:<br> <strong>' + obj.tipo_pedido_situacao_nome_local + '</strong></p>';
        box += '      </div>';
        box += '      <div class="col-md-6 col-sm-6 col-xs-12">';
        box += iconStatusPedido;
        box += '        <p>Resposta:<br> <strong>' + obj.status_pedido_nome_local + '</strong></p>';
        box += '        <p>' + retornaStatusVerificado(obj.status_pedido_interno_codigo_local) + '</p>';
        box += '      </div>';
        box += '    </div>';
        box += '  </div>';
        box += '  <div class="col-md-4 col-sm-4 col-xs-12 highlight-box">';
        box += '   <p class="highlight-session bgcolor1">Pedido</p>';
        box += '    <p class="highlight-text">';
        box += descricao;
        box += '    </p>';
        box += '  </div>';
        box += '  <div class="col-md-4 col-sm-4 col-xs-12 bt-margin">';
        box += '    <div class="btnVerMais pull-right">';
        box += '      <a href="' + base_url + 'pedidos/' + obj.pedidos_slug_local + '">Ver <div class="seta seta-direita"></div></a>';
        box += '    </div>';
        box += '  </div>';
        box += '</div>';

        // var box = '<div class="col-md-12 col-sm-12 col-xs-12 box"><div class="col-md-8 col-sm-8 col-xs-12">';
        // box += '<p class="title">' + titulo + '</p>';
        // box += '<div class="enviado">Enviado para: <a href="#">' + obj.agentes_nome_local + '</a></div>';
        // box += '<div class="por">Por: <a href="#">' + obj.usuarios_nome_local + '</a></div>';
        // box += '<div class="em">Em: ' + ajustaData(obj.pedidos_data_envio_local) + '</div>';
        // box += '<div class="situacao"><div class="col-md-6 col-sm-6 col-xs-12">' + iconSituacao;
        // box += '<p>Situação:<br> <strong>' + obj.tipo_pedido_situacao_nome_local + '</strong></p></div>';
        // box += '<div class="col-md-6 col-sm-6 col-xs-12">' + iconStatusPedido;
        // box += '<p>Resposta:<br> <strong>' + obj.status_pedido_nome_local + '</strong></p>';
        // box += retornaStatusVerificado(obj.status_pedido_interno_codigo_local) + '</div></div></div>';
        // box += '<div class="col-md-4 col-sm-4 col-xs-12 highlight-box"><p class="highlight-session bgcolor1">';
        // box += 'Pedido</p><p class="highlight-text">' + descricao;
        // box += '</p></div><div class="col-md-3 col-sm-3 col-xs-12"><div class="btnVerMais pull-right"><a href="#">Ver <div class="seta seta-direita"></div></a></div></div></div>';

        $("#boxes-resultados").append(box);

    }

    function retornaStatusVerificado(status) {
        return '';
    }

    function retornaTipoPedidoResposta(value) {
        switch (value) {
            case "1":
                return '<p class="highlight-session bgcolor1">Resposta do órgão público</p>';
            case "2":
                return '<p class="highlight-session bgcolor2">Reclamação</p>';
            case "3":
                return '<p class="highlight-session bgcolor2">Resposta da Reclamação</p>';
            case "4":
                return '<p class="highlight-session bgcolor3">Recurso - 1º Instância</p>';
            case "5":
                return '<p class="highlight-session bgcolor3">Resposta do recurso - 1º Instância</p>';
            case "6":
                return '<p class="highlight-session bgcolor4">Recurso - 2º Instância</p>';
            case "7":
                return '<p class="highlight-session bgcolor4">Resposta do recurso - 2º Instância</p>';
            case "8":
                return '<p class="highlight-session bgcolor5">Recurso - 3º Instância</p>';
            case "9":
                return '<p class="highlight-session bgcolor5">Resposta do recurso - 3º Instância</p>';
            case "10":
                return '<p class="highlight-session bgcolor6">Recurso - 4º Judicial</p>';
            case "11":
                return '<p class="highlight-session bgcolor6">Resposta do recurso - 4º Judicial</p>';
            default:
                return '<p class="highlight-session bgcolor1">Fora do RANGE</p>';
        }
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
        box += '    <div class="em">Em: ' + ajustaData(obj.pedidos_data_envio) + '</div>';
        box += '    <div class="situacao">';
        box += '      <div class="col-md-6 col-sm-6 col-xs-12">';
        box += iconSituacao;
        box += '        <p>Situação:<br> <strong>' + obj.tipo_pedido_situacao_nome + '</strong></p>';
        box += '      </div>';
        box += '      <div class="col-md-6 col-sm-6 col-xs-12">';
        box += iconStatusPedido;
        box += '        <p>Resposta:<br> <strong>' + obj.status_pedido_nome + '</strong></p>';
        box += '        <p>' + retornaStatusVerificado(obj.status_pedido_interno_codigo) + '</p>';
        box += '      </div>';
        box += '    </div>';
        box += '  </div>';
        box += '  <div class="col-md-4 col-sm-4 col-xs-12 highlight-box">';
        box += retornaTipoPedidoResposta(obj.tipo_pedidos_resposta_codigo_local);
        box += '    <p class="highlight-text">';
        box += descricao;
        box += '    </p>';
        box += '  </div>';
        box += '  <div class="col-md-4 col-sm-4 col-xs-12 bt-margin">';
        box += '    <div class="btnVerMais pull-right">';
        box += '      <a href="' + base_url + 'pedidos/' + obj.pedidos_slug + '">Ver <div class="seta seta-direita"></div></a>';
        box += '    </div>';
        box += '  </div>';
        box += '</div>';

        // var box = '<div class="col-md-12 col-sm-12 col-xs-12 box"><div class="col-md-8 col-sm-8 col-xs-12">';
        // box += '<p class="title">' + titulo + '</p>';
        // box += '<div class="enviado">Enviado para: <a href="#">' + obj.agentes_nome + '</a></div>';
        // box += '<div class="por">Por: <a href="#">' + obj.usuarios_nome + '</a></div>';
        // box += '<div class="em">Em: ' + ajustaData(obj.pedidos_data_envio) + '</div>';
        // box += '<div class="situacao"><div class="col-md-6 col-sm-6 col-xs-12">' + iconSituacao;
        // box += '<p>Situação:<br> <strong>' + obj.tipo_pedido_situacao_nome + '</strong></p></div>';
        // box += '<div class="col-md-6 col-sm-6 col-xs-12">' + iconStatusPedido;
        // box += '<p>Resposta:<br> <strong>' + obj.status_pedido_nome + '</strong></p>';
        // box += retornaStatusVerificado(obj.status_pedido_interno_codigo) + '</div></div></div>';
        // box += '<div class="col-md-4 col-sm-4 col-xs-12 highlight-box">';
        // box += retornaTipoPedidoResposta(obj.tipo_pedidos_resposta_codigo_local);
        // box += '<p class="highlight-text">' + descricao + '</p></div>';
        // box += '<div class="col-md-3 col-sm-3 col-xs-12"><div class="bntVerMais pull-right"><a href="#">Ver <div class="seta seta-direita"></div></a></div></div></div>';

        $("#boxes-resultados").append(box);

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
        box += '    <div class="em">Em: ' + ajustaData(obj.pedidos_data_envio) + '</div>';
        box += '    <div class="situacao">';
        box += '      <div class="col-md-6 col-sm-6 col-xs-12">';
        box += iconSituacao;
        box += '        <p>Situação:<br> <strong>' + obj.tipo_pedido_situacao_nome + '</strong></p>';
        box += '      </div>';
        box += '      <div class="col-md-6 col-sm-6 col-xs-12">';
        box += iconStatusPedido;
        box += '        <p>Resposta:<br> <strong>' + obj.status_pedido_nome + '</strong></p>';
        box += '        <p>' + retornaStatusVerificado(obj.status_pedido_interno_codigo) + '</p>';
        box += '      </div>';
        box += '    </div>';
        box += '  </div>';
        box += '  <div class="col-md-4 col-sm-4 col-xs-12 highlight-box">';
        box += retornaTipoPedidoResposta(obj.tipo_pedidos_resposta_codigo);
        box += '    <p class="highlight-session"><a href="' + base_url + "uploads/pedidos/" + obj.anexos_arquivo + '" target="_blank"><img src="' + base_url + 'assets/images/pedidos/icon-arquivo.png" style="margin-right:3px;"> arquivo anexo</a></p>';
        box += '    <p class="highlight-text">';
        box += descricao;
        box += '    </p>';
        box += '  </div>';
        box += '  <div class="col-md-4 col-sm-4 col-xs-12 bt-margin">';
        box += '    <div class="btnVerMais pull-right">';
        box += '      <a href="' + base_url + 'pedidos/' + obj.pedidos_slug + '">Ver <div class="seta seta-direita"></div></a>';
        box += '    </div>';
        box += '  </div>';
        box += '</div>';

        // var box = '<div class="col-md-12 col-sm-12 col-xs-12 box"><div class="col-md-8 col-sm-8 col-xs-12">';
        // box += '<p class="title">' + titulo + '</p>';
        // box += '<div class="enviado">Enviado para: <a href="#">' + obj.agentes_nome + '</a></div>';
        // box += '<div class="por">Por: <a href="#">' + obj.usuarios_nome + '</a></div>';
        // box += '<div class="em">Em: ' + ajustaData(obj.pedidos_data_envio) + '</div>';
        // box += '<div class="situacao"><div class="col-md-6 col-sm-6 col-xs-12">' + iconSituacao;
        // box += '<p>Situação:<br> <strong>' + obj.tipo_pedido_situacao_nome + '</strong></p></div>';
        // box += '<div class="col-md-6 col-sm-6 col-xs-12">' + iconStatusPedido;
        // box += '<p>Resposta:<br> <strong>' + obj.status_pedido_nome + '</strong></p>';
        // box += retornaStatusVerificado(obj.status_pedido_interno_codigo) + '</div></div></div>';
        // box += '<div class="col-md-4 col-sm-4 col-xs-12 highlight-box">';
        // box += retornaTipoPedidoResposta(obj.tipo_pedidos_resposta_codigo);
        // box += '<p class="highlight-session"><a href="' + obj.anexos_arquivo + '"><img src="assets/images/pedidos/icon-arquivo.png" style="margin-right:3px;"> arquivo anexo</a></p>';
        // box += '<p class="highlight-text">' + descricao + '</p></div>';
        // box += '<div class="col-md-3 col-sm-3 col-xs-12"><div class="bntVerMais pull-right"><a href="#">Ver <div class="seta seta-direita"></div></a></div></div></div>';

        $("#boxes-resultados").append(box);

    }

    function slugify(text) {

        if (text != null) {
            return text.toString().toLowerCase()
                .replace(/[àáâãä]/g, "a")
                .replace(/[éê]/g, "e")
                .replace(/[í]/g, "i")
                .replace(/[óôõ]/g, "o")
                .replace(/[úü]/g, "u")
                .replace(/[ç]/g, "c")
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, ''); // Trim - from end of text
        } else {
            return null
        }

    }

    function slugifyUser(text) {

        if (text != null) {
            var text = text.split("@");
            return text[0].toString().toLowerCase()
                .replace(/[àáâãä]/g, "a")
                .replace(/[éê]/g, "e")
                .replace(/[í]/g, "i")
                .replace(/[óôõ]/g, "o")
                .replace(/[úü]/g, "u")
                .replace(/[ç]/g, "c")
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, ''); // Trim - from end of text
        } else {
            return null
        }


    }

    // function slugify(text) {
    //     return text.toString().toLowerCase()
    //         .replace("-", " ")
    //         .replace(/\-\-+/g, " ")
    //         .replace(/\\+/g, "-")
    //         //.replace(/\s+/g, "-")
    //         .replace(/[àáâãä]/g,"a")
    //         .replace(/[éê]/g,"e")
    //         .replace(/[í]/g,"i")
    //         .replace(/[óôõ]/g,"o")
    //         .replace(/[úü]/g,"u")
    //         .replace(/[ç]/g,"c")
    //         //.replace("/[^A-Za-z0-9\-]/","")
    //         // .replace("--", "-");
    //         // .replace(/^-+/, '')
    //         // .replace(/-+$/, '');
    // }

    function autocomplete() {

        $("#fieldValue").keyup(function(e) {

            if (e.which != 13 && e.which != 38 && e.which != 40) {
                var data = {
                    "data": $('#fieldValue').val()
                };

                $.ajax(es_url + 'pedidos/searchasyoutype', {
                    method: "POST",
                    data: data,
                    contentType: 'application/x-www-form-urlencoded',
                    // headers: { "x-csrf-token": ns.localStorage.get('token') },
                    dataType: "json",
                    success: function(result) {

                        console.log(result);
                        // $( "#fieldList" ).val();
                        $("#fieldList").empty();

                        _.each(result, function(item) {

                            $("#fieldList").append("<option value='" + item + "'>");

                        });

                    },
                    error: function(err) {
                        console.log(err);
                    }


                });
            }

            if (e.which == 13) {
                if ($("#btnsearch").attr('attr') == "busca_pedido") {
                    search_pedidos($('#fieldValue').val(), 1);
                } else {
                    search_geral($('#fieldValue').val(), 1);
                }
                return false;
            }

        });

    }
});