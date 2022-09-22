function toFixed(num, fixed) {
    var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (fixed || -1) + '})?');
    return num.toString().match(re)[0];
}
//Grafico classificações de atendimento por ano
(function() {

    var margin = { top: 40, right: 30, bottom: 10, left: 50 },
        width = 960 - margin.left - margin.right,
        height = 470 - margin.top - margin.bottom,
        tooltip, tooltipBody, tooltipContent, tooltipTitle;

    var lineStroke = 4;

    var svg = d3.select("#taxa-resposta-ano")
        .append("svg")
        .attr("width", width + margin.left + margin.right + 200)
        .attr("height", (height + margin.top + margin.bottom) + 20)
        .append("g")
        .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")");

    // -
    var subgroups = ["Respondidos", "NaoRespondidos"];

    // - Legenda
    svg.append("g")
        .attr("class", "legendLinear")
        .attr("transform", "translate(900,145)");

    svg.select(".legendLinear")
        .append('rect')
        .attr("width", 24)
        .attr("height", 24)
        .attr('stroke', 'black')
        .attr('fill', '#fbc064');

    svg.select(".legendLinear")
        .append('text')
        .attr("y", 20)
        .attr("x", 30)
        .attr('stroke', 'black')
        .text('Atendidos');

    svg.select(".legendLinear")
        .append('rect')
        .attr("x", 0)
        .attr("y", 44)
        .attr("width", 24)
        .attr("height", 24)
        .attr('stroke', 'black')
        .attr('fill', '#e45d88');

    svg.select(".legendLinear")
        .append('text')
        .attr("y", 64)
        .attr("x", 30)
        .attr('stroke', 'black')
        .text('Não Atendidos');

    svg.select(".legendLinear")
        .append('rect')
        .attr("x", 0)
        .attr("y", 84)
        .attr("width", 24)
        .attr("height", 24)
        .attr('stroke', 'black')
        .attr('fill', '#87570b');

    svg.select(".legendLinear")
        .append('text')
        .attr("y", 104)
        .attr("x", 30)
        .attr('stroke', 'black')
        .text('Parcialmente Atendidos');


    function tooltipShow(data, x, y) {
        tooltip.attr("transform", "translate(" + x + ", " + y + ")")
        tooltipTitle.html(data.Ano);

        tooltipBody.html("<p class='chart-tip'>" + data.Total + " pedidos</p><p>" +
            data.Respondido + " pedidos respondidos</p><p>" +
            data.NaoRespondido + " pedidos não respondidos</p>");

        tooltip.style("display", null);
    }

    // -
    function draw(error, data) {
        if (error) throw error;

        // Consolida os Anos e Unicos Registros
        var anosDataq = data.map(el => el.AnoEnvio)
            .filter((value, index, self) => self.indexOf(value) === index);

        var x = d3.scaleBand()
            .domain(anosDataq)
            .range([0, width])
            .padding([0.2])
        svg.append("g")
            .attr("class", "xaxis")
            .attr("transform", "translate(0," + height + ")")
            .call(d3.axisBottom(x).tickSizeOuter(0))
            .style("font-size", "15px");

        // Add Y axis
        var y = d3.scaleLinear()
            .domain([0, 100])
            .range([height, 0]);

        var y_axis = d3.axisLeft(y).tickFormat(d => d + "%");

        svg.append("g")
            .attr("class", "yaxis")
            .call(y_axis)

        svg.select(".yaxis")
            .selectAll("text")
            .style("font-size", "15px");

        // Add the "Atendido" line
        var dataAtendido = data.filter((value, index, self) => value.StatusNome == 'Atendido');

        svg.append("path")
            .datum(dataAtendido)
            .attr("fill", "none")
            .attr("stroke", "#fbc064")
            .attr("stroke-width", lineStroke)
            .attr("d", d3.line()
                .x(function(d) { return x(d.AnoEnvio) })
                .y(function(d) { return y(d.PercStatus) })
            )

        // Add the "Não Atendido" line
        var dataNaoAtendido = data.filter((value, index, self) => value.StatusNome == 'Não Atendido');

        svg.append("path")
            .datum(dataNaoAtendido)
            .attr("fill", "none")
            .attr("stroke", "#e45d88")
            .attr("stroke-width", lineStroke)
            .attr("d", d3.line()
                .x(function(d) { return x(d.AnoEnvio) })
                .y(function(d) { return y(d.PercStatus) })
            )

        // Add the "Parcial Atendido" line
        var dataParcialAtendido = data.filter((value, index, self) => value.StatusNome == 'Parcialmente Atendido');

        svg.append("path")
            .datum(dataParcialAtendido)
            .attr("fill", "none")
            .attr("stroke", "#87570b")
            .attr("stroke-width", lineStroke)
            .attr("d", d3.line()
                .x(function(d) { return x(d.AnoEnvio) })
                .y(function(d) { return y(d.PercStatus) })
            )
    }

    d3.json("/api/v2/PedidosAtendimentoPorAno", draw);
})();
//FIM Grafico classificações de atendimento por ano
(function() {
    var _lodash = _.noConflict();
    var unidadesFederativas = [{ "ID": "0", "Sigla": "ÓrgãosFederais", "Nome": "Órgãos Federais" }, { "ID": "1", "Sigla": "AC", "Nome": "Acre" }, { "ID": "2", "Sigla": "AL", "Nome": "Alagoas" }, { "ID": "3", "Sigla": "AM", "Nome": "Amazonas" }, { "ID": "4", "Sigla": "AP", "Nome": "Amapá" }, { "ID": "5", "Sigla": "BA", "Nome": "Bahia" }, { "ID": "6", "Sigla": "CE", "Nome": "Ceará" }, { "ID": "7", "Sigla": "DF", "Nome": "Distrito Federal" }, { "ID": "8", "Sigla": "ES", "Nome": "Espírito Santo" }, { "ID": "9", "Sigla": "GO", "Nome": "Goiás" }, { "ID": "10", "Sigla": "MA", "Nome": "Maranhão" }, { "ID": "11", "Sigla": "MG", "Nome": "Minas Gerais" }, { "ID": "12", "Sigla": "MS", "Nome": "Mato Grosso do Sul" }, { "ID": "13", "Sigla": "MT", "Nome": "Mato Grosso" }, { "ID": "14", "Sigla": "PA", "Nome": "Pará" }, { "ID": "15", "Sigla": "PB", "Nome": "Paraíba" }, { "ID": "16", "Sigla": "PE", "Nome": "Pernambuco" }, { "ID": "17", "Sigla": "PI", "Nome": "Piauí" }, { "ID": "18", "Sigla": "PR", "Nome": "Paraná" }, { "ID": "19", "Sigla": "RJ", "Nome": "Rio de Janeiro" }, { "ID": "20", "Sigla": "RN", "Nome": "Rio Grande do Norte" }, { "ID": "21", "Sigla": "RO", "Nome": "Rondônia" }, { "ID": "22", "Sigla": "RR", "Nome": "Roraima" }, { "ID": "23", "Sigla": "RS", "Nome": "Rio Grande do Sul" }, { "ID": "24", "Sigla": "SC", "Nome": "Santa Catarina" }, { "ID": "25", "Sigla": "SE", "Nome": "Sergipe" }, { "ID": "26", "Sigla": "SP", "Nome": "São Paulo" }, { "ID": "27", "Sigla": "TO", "Nome": "Tocantins" }];
    var pedidosPorUFPoderENivelCache = [];
    var dataFilteredWithoutStatus = [];


    var namesPlural = []
    namesPlural["Atendido"] = "atendidos"
    namesPlural["Não Atendido"] = "não atendidos"
    namesPlural["Parcialmente Atendido"] = "parcialmente atendidos"

    var statusAtendido =  $('#filter-status').val(); //default filter selected

    d3.json("/api/pedidosPorUFPoderENivelEStatus", function drawMapData(error, data) {
        if (error) throw error;

        pedidosPorUFPoderENivelCache = data;
        doDrawMap();
    });

    function doDrawMap() {
        $("#chart-pedidos-uf-mapa").empty();
        $("#chart-pedidos-uf-barras").empty();
        var
            marginB = { top: 0, right: 0, bottom: 0, left: 0 },
            viewBoxB = { width: 600, height: 460 },
            heightB = viewBoxB.height - marginB.top - marginB.bottom,
            svgB = d3.select("#chart-pedidos-uf-mapa").append('svg')
            .attr("version", "1.1")
            .attr("viewBox", "0 0 " + viewBoxB.width + " " + viewBoxB.height)
            .attr("width", "100%"),
            gB = svgB.append("g").attr("transform", "translate(" + marginB.left + "," + marginB.top + ")"),
            projection = d3.geoAlbers()
            .center([-44, -15])
            .rotate([0, 0])
            .parallels([0, 0])
            .scale(700),
            map = d3.geoPath().projection(projection);

        // Range de Cores
        var color_range = ["#969696","#969696","#f6e197","#f6e197","#fab94f","#fab94f" ,"#ec7340","#ec7340","#cd134f","#cd134f","#940131"];
        var colorScale = d3.scaleLinear()
            .domain([0.0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1.0])
            .range(color_range);
        
        statusAtendido =  $('#filter-status').val()
        var legend = d3.legendColor()
            .scale(colorScale)
            .cells([1.0, 0.8, 0.6, 0.4, 0.2, 0.0])
            .labelFormat(d3.format(".0%"))
            .title("% " + statusAtendido);
        svgB.append("g")
            .attr("transform", "translate(60,20)")
            .call(legend);

        // -
        var tooltipB = svgB.append("foreignObject")
            .attr("class", "chart-tooltip")
            .attr("x", 0)
            .attr("y", heightB - 100)
            .attr("width", 150)
            .attr("height", 100)
            .style("display", "none");

        var
            marginC = { top: 20, right: 60, bottom: 20, left: 90 },
            viewBoxC = { width: 450, height: 500 },
            widthC = viewBoxC.width - marginC.left - marginC.right,
            heightC = viewBoxC.height - marginC.top - marginC.bottom,
            svgC = d3.select("#chart-pedidos-uf-barras").append("svg")
            .attr("width", widthC + marginC.left + marginC.right + 230)
            .attr("height", heightC + marginC.top + marginC.bottom + 20)
            .append("g")
            .attr("transform",
                "translate(" + marginC.left + "," + marginC.top + ")");


        function drawBarras(data,_totalQtdeByUF) {
            //
            var orderByPerc = $("#order-by-perc").is(":checked");
            var orderByUf = $("#order-by-uf").is(":checked");

           var groupBy = _lodash(data).groupBy('SiglaUF').value();   
           var totalQtdeByUFConsolidate = _lodash.map(groupBy, (obj, key) => {
                var getTotalObj = _totalQtdeByUF.filter(el => el.SiglaUF == key)
                if (key != 'null') {
                    var totalQtde = _lodash.sumBy(getTotalObj,item => 
                        {
                            return parseInt(item.QuantidadePedido)
                        })                
                    return {
                            'SiglaUF': key,
                            'QuantidadePedido': _lodash.sumBy(obj, item => parseInt(item.QuantidadePedido)),
                            'ProrcentagemPedido':_lodash.sumBy(obj, item => parseInt(item.QuantidadePedido))/totalQtde
                        }
                }

           })
           //remove undefined values
           totalQtdeByUFConsolidate = totalQtdeByUFConsolidate.filter(n => n)
            // Ordena os Dados
            if (orderByPerc) {
                totalQtdeByUFConsolidate = totalQtdeByUFConsolidate.sort(function(a, b) {
                    return (parseFloat(a.ProrcentagemPedido) * 100).toFixed(0) - (parseFloat(b.ProrcentagemPedido) * 100).toFixed(0)
                    //return parseFloat(a.ProrcentagemPedido) - parseFloat(b.ProrcentagemPedido)
                });
            } else if (orderByUf) {
                totalQtdeByUFConsolidate = totalQtdeByUFConsolidate.sort(function(a, b) {
                    return a.SiglaUF.localeCompare(b.SiglaUF, 'pt-BR', { sensitivity: 'base' });
                });
            }
            // Add X axis
            var x = d3.scaleLinear()
                .domain([0.0, 1.0])
                .range([0, widthC]);
            svgC.append("g")
                .attr("transform", "translate(0," + heightC + ")")
                .call(d3.axisBottom(x).tickFormat(d3.format(".0%")))
                .selectAll("text")
                .attr("transform", "translate(-10,0)rotate(-45)")
                .style("text-anchor", "end");

            // Y axis
            var y = d3.scaleBand()
                .range([0, heightC])
                .domain(totalQtdeByUFConsolidate.map(function(d) { return d.SiglaUF; }))
                .padding(.1);
            svgC.append("g")
                .call(d3.axisLeft(y))


            //Bars
            svgC.selectAll("myRect")
                .data(totalQtdeByUFConsolidate)
                .enter()
                .append("rect")
                .attr("x", x(0))
                .attr("y", function(d) { return y(d.SiglaUF); })
                .attr("width", function(d) { 
                    return x(d.ProrcentagemPedido);
                })
                .attr("height", y.bandwidth())
                .attr("fill", "#fe9301")
                .style("opacity", 0.5)
                .on("mouseover", function(d) {
                    d3.select(this).style("opacity", 1);
                    d3.select("#bartext-" + d.SiglaUF).style("opacity", 1);
                })
                .on("mouseout", function(d) {
                    d3.select(this).style("opacity", 0.5);
                    d3.select("#bartext-" + d.SiglaUF).style("opacity", 0);
                });

            // Texto da Quantidades de Pedidos
            svgC.selectAll("myText")
                .data(totalQtdeByUFConsolidate)
                .enter()
                .append("text")
                .attr("x", function(d) {
                    return x(d.ProrcentagemPedido) + 5;
                })
                .attr("y", function(d) { return y(d.SiglaUF) + 10; })
                .attr("width", 100)
                .attr("height", y.bandwidth())
                .attr("fill", "#000")
                .attr("id", function(d) {
                    return "bartext-" + d.SiglaUF;
                })
                .style("opacity", 0)
                .style("z-index", 1000)
                .text(function(d) {
                    return d.QuantidadePedido + " pedidos";
                });
        }

        function drawBarrasBrasil(percentBrasil,totalQtdeByBrasilAndStatus) {
            //
            var orderByPerc = $("#order-by-perc").is(":checked");
            var orderByUf = $("#order-by-uf").is(":checked");
           var totalQtdeByUFConsolidate = [{
                'SiglaUF': 'BR',
                'QuantidadePedido': totalQtdeByBrasilAndStatus,
                'ProrcentagemPedido': percentBrasil
            }]
                
           //remove undefined values
           totalQtdeByUFConsolidate = totalQtdeByUFConsolidate.filter(n => n)
            // Ordena os Dados
            if (orderByPerc) {
                totalQtdeByUFConsolidate = totalQtdeByUFConsolidate.sort(function(a, b) {
                    return (parseFloat(a.ProrcentagemPedido) * 100).toFixed(0) - (parseFloat(b.ProrcentagemPedido) * 100).toFixed(0)
                    //return parseFloat(a.ProrcentagemPedido) - parseFloat(b.ProrcentagemPedido)
                });
            } else if (orderByUf) {
                totalQtdeByUFConsolidate = totalQtdeByUFConsolidate.sort(function(a, b) {
                    return a.SiglaUF.localeCompare(b.SiglaUF, 'pt-BR', { sensitivity: 'base' });
                });
            }
            // Add X axis
            var x = d3.scaleLinear()
                .domain([0.0, 1.0])
                .range([0, widthC]);
            svgC.append("g")
                .attr("transform", "translate(0," + heightC + ")")
                .call(d3.axisBottom(x).tickFormat(d3.format(".0%")))
                .selectAll("text")
                .attr("transform", "translate(-10,0)rotate(-45)")
                .style("text-anchor", "end");

            // Y axis
            var y = d3.scaleBand()
                .range([0, heightC])
                .domain(totalQtdeByUFConsolidate.map(function(d) { return d.SiglaUF; }))
                .padding(.1);
            svgC.append("g")
                .call(d3.axisLeft(y))


            //Bars
            svgC.selectAll("myRect")
                .data(totalQtdeByUFConsolidate)
                .enter()
                .append("rect")
                .attr("x", x(0))
                .attr("y", function(d) { return y(d.SiglaUF); })
                .attr("width", function(d) { 
                    return x(d.ProrcentagemPedido);
                })
                .attr("height", y.bandwidth())
                .attr("fill", "#fe9301")
                .style("opacity", 0.5)
                .on("mouseover", function(d) {
                    d3.select(this).style("opacity", 1);
                    d3.select("#bartext-" + d.SiglaUF).style("opacity", 1);
                })
                .on("mouseout", function(d) {
                    d3.select(this).style("opacity", 0.5);
                    d3.select("#bartext-" + d.SiglaUF).style("opacity", 0);
                });

            // Texto da Quantidades de Pedidos
            svgC.selectAll("myText")
                .data(totalQtdeByUFConsolidate)
                .enter()
                .append("text")
                .attr("x", function(d) {
                    return x(d.ProrcentagemPedido) + 5;
                })
                .attr("y", function(d) { return y(d.SiglaUF) + 10; })
                .attr("width", 100)
                .attr("height", y.bandwidth())
                .attr("fill", "#000")
                .attr("id", function(d) {
                    return "bartext-" + d.SiglaUF;
                })
                .style("opacity", 0)
                .style("z-index", 1000)
                .text(function(d) {
                    return d.QuantidadePedido + " pedidos";
                });
        }        

        function drawMap(error, br) {
            if (error) throw error;
            var ufs = topojson.feature(br, br.objects.br);
            // Filtra os Resultados
            var nivelFederativo = $("#filter-nivel").val();
            var esferaPoder = $("#filter-poder").val();
            statusAtendido = $('#filter-status').val();

            data = pedidosPorUFPoderENivelCache
                .map(function(el) {
                    var el2 = Object.assign({}, el);

                    // - Se o Nivel federativo for Federal, Considera tudo como BR

                    if (nivelFederativo == "Federal") {
                        el2.SiglaUf = "BR";
                    }

                    return el2;
                });;

            if (nivelFederativo !== "--") {
                data = data.filter(function(el) {
                    return el.NomeNivelFederativo == nivelFederativo;
                })
            }

            if (esferaPoder !== "--") {
                data = data.filter(function(el) {
                    return el.NomePoder == esferaPoder;
                });
            }

           dataFilteredWithoutStatus = data
           var groupBy = _lodash(data).groupBy('SiglaUF').value();   
           var totalQtdeByUF = _lodash.map(groupBy, (obj, key) => {
            return {
                    'SiglaUF': key,
                    'QuantidadePedido': _lodash.sumBy(obj, item => parseInt(item.QuantidadePedido)) 
                }

           })

           var totalQtdeByBrasil = _lodash.sumBy(data, item => parseInt(item.QuantidadePedido)) 
            data = data.filter(function(el) {
                return el.NomeStatusPedido == statusAtendido;
            });
            var totalQtdeByBrasilAndStatus = _lodash.sumBy(data, item => parseInt(item.QuantidadePedido)) 
            var percentBrasil = totalQtdeByBrasilAndStatus/totalQtdeByBrasil
            setMapInfo("Brasil", percentBrasil, totalQtdeByBrasilAndStatus,totalQtdeByBrasil);
            // Altera a Cor dos Estados de Acordo com a Porcentagem
            //COMENTADO PAULO
            if (nivelFederativo == "Federal") {
                gB.selectAll(".chart-uf")
                    .data(ufs.features)
                    .enter().append("path")
                    .attr("class", "chart-uf")
                    .attr("d", map)
                    .attr("fill", "#edf0f5")
                    .attr("stroke", "#e1e1e1")
                drawBarrasBrasil(percentBrasil,totalQtdeByBrasilAndStatus);
                $("#chart-pedidos-uf-info").fadeIn();
            } else {
                gB.selectAll(".chart-uf")
                    .data(ufs.features)
                    .enter().append("path")
                    .attr("class", "chart-uf")
                    .attr("d", map)
                    .attr("fill", function(d) {
                        var sigla = d.id;
                        var procura = data.filter(el => el.SiglaUF == sigla);
                        var totalQtde = _lodash.sumBy(procura,item => 
                            {
                                return parseInt(item.QuantidadePedido)
                            })
                        var getTotalObj = totalQtdeByUF.filter(el => el.SiglaUF == sigla)
                        var percent = 0
                        if (getTotalObj.length > 0) {
                            percent = totalQtde/getTotalObj[0].QuantidadePedido
                        }
                        return procura.length == 0 ? colorScale(0) : colorScale(toFixed(percent,1));
                    })
                    // Efeito Hover
                    .style("opacity", .85)
                    .style("stroke", "transparent")
                    //Legenda Geral do Filtro
                    .on("mouseover", function(d) {
                        $("#chart-pedidos-uf-info").fadeIn();
                        d3.selectAll(".chart-uf")
                            .transition()
                            .duration(200)
                            .style("opacity", .85)
                            .style("stroke", "transparent");

                        d3.select(this)
                            .transition()
                            .duration(200)
                            .style("opacity", 1)
                            .style("stroke", "#999999");

                        var sigla = d.id;

                        var procuraWithoutStatus = dataFilteredWithoutStatus.filter(el => el.SiglaUF == sigla);
                        var totalQtdeWithoutStatus = _lodash.sumBy(procuraWithoutStatus,item => 
                        {
                            return parseInt(item.QuantidadePedido)
                        })

                        var procura = data.filter(el => el.SiglaUF == sigla);
                        var totalQtde = _lodash.sumBy(procura,item => 
                            {
                                return parseInt(item.QuantidadePedido)
                            })
                        var getTotalObj = totalQtdeByUF.filter(el => el.SiglaUF == sigla)
                        var percent = 0
                        if (getTotalObj.length > 0) {
                            percent = totalQtde/getTotalObj[0].QuantidadePedido
                        }

                        setMapInfo(_lodash.find(unidadesFederativas, { Sigla: sigla }).Nome,
                        percent, totalQtde,totalQtdeWithoutStatus);
                    })
                    .on("mouseout", function(d) {
                        $("#chart-pedidos-uf-info").hide();
                        d3.selectAll(".chart-uf")
                            .transition()
                            .duration(200)
                            .style("opacity", .85);

                        d3.select(this)
                            .transition()
                            .duration(200)
                            .style("stroke", "transparent");

                        setMapInfo("Brasil", percentBrasil, totalQtdeByBrasilAndStatus);
                    });

                drawBarras(data,totalQtdeByUF);

                if (nivelFederativo == 'Federal') {
                    $("#chart-pedidos-uf-info").fadeIn();
                } else {
                    $("#chart-pedidos-uf-info").hide();
                }
            }
        }


        function setMapInfo(title, perc, totalStatus, total = 0) {
            var statusAtendidoPlural = namesPlural[statusAtendido]
            $("#chart-info-uf").html(title);
            $("#chart-info-qtd-total").html(total);
            $("#chart-info-qtd-status").html(totalStatus);
            $("#chart-info-tipo").html(statusAtendidoPlural)
            $("#chart-info-perc").html((perc * 100).toFixed(1) + "%");
        }

        d3.json("/assets/data/br.json", drawMap);
    }

    $("#filter-nivel").change(function() {
        doDrawMap();
    });

    $("#filter-poder").change(function() {
        doDrawMap();
    });

    $("#filter-status").change(function() {
        doDrawMap();
    });

    $("#order-by-perc").change(function() {
        doDrawMap();
    });

    $("#order-by-uf").change(function() {
        doDrawMap();
    });
})();

(function() {
    var
        margin = { top: 80, right: 50, bottom: 30, left: 50 },
        viewBox = { width: 860, height: 420 },
        width = viewBox.width - margin.left - margin.right,
        height = viewBox.height - margin.top - margin.bottom,
        dot = { radius: 3 },
        svg = d3.select("#chart-tempo-resposta").append('svg')
        .attr("version", "1.1")
        .attr("viewBox", "0 0 " + viewBox.width + " " + viewBox.height)
        .attr("width", "100%"),
        g = svg.append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    var filter_tipo = "--";
    var filter_esfera = "--";

    var x = d3.scaleBand().rangeRound([0, width]).padding(0.01).paddingOuter(0.5),
        y = d3.scaleLinear().range([height, 0]),
        z = d3.scaleThreshold()
        .domain([6, 11, 16, 21, 26, 31, 36, 41])
        .range(["1 a 5", "6 a 10", "11 a 15", "16 a 20", "21 a 25", "26 a 30", "31 a 35", "36 a 40", "mais de 40"]);
    x.domain(z.range());

    g.append("g")
        .attr("class", "chart-axis chart-axis--x")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x));

    var yAxis = g.append("g")
        .attr("class", "chart-axis chart-axis--y");

    var tooltip = svg.append("foreignObject")
        .attr("class", "chart-tooltip")
        .attr("x", 12)
        .attr("y", -10)
        .attr("width", 150)
        .attr("height", 100)
        .style("display", "none");
    var tooltipContent = tooltip.append('xhtml:div')
        .attr("class", "chart-tooltip-content");
    var tooltipTitle = tooltipContent.append('div')
        .attr('class', 'chart-tooltip-title');
    var tooltipBody = tooltipContent.append('div')
        .attr('class', 'chart-tooltip-body');

    function draw(error, data) {
        if (error) throw error;

        data.forEach(function(d) {
            d.DataEnvio = new Date(d.DataEnvio);
            d.DataResposta = new Date(d.DataResposta);
            d.Grupo = z(d.DiasCorridos);
        });

        d3.select("#filter-tipo-tempo").on("change", function() {
            filter_tipo = this.value;
            filter();
        });

        d3.select("#filter-tempo-esfera").on("change", function() {
            filter_esfera = this.value;
            filter();
        });

        function filter() {
            var entries = _.filter(data, function(d) { return (filter_tipo !== "--") ? d.NomeEsferaPoder == filter_tipo : true });
            entries = _.filter(entries, function(d) { return (filter_esfera !== "--") ? d.NomeNivelFederativo == filter_esfera : true });
            var series = d3.nest()
                .key(function(d) { return d.Grupo; })
                .rollup(function(leaves) { return leaves.length; })
                .entries(entries);
            series.sort(function(a, b) { return d3.ascending(a.value, b.value); });

            var total = d3.nest()
                .rollup(function(leaves) { return leaves.length; })
                .entries(entries);
            y.domain([0, Math.ceil(d3.max(series, function(d) { return d.value / total; }) * 10) / 10]);
            yAxis.call(d3.axisLeft(y).tickFormat(d3.format(".1%")).ticks(4));

            g.selectAll(".chart-bar").remove();
            var bars = g.selectAll(".chart-bar")
                .data(series)
                .enter().append("rect")
                .attr("class", "chart-bar")
                .attr("x", function(d) { return x(d.key); })
                .attr("y", height)
                .attr("width", x.bandwidth())
                .attr("height", 0)
                .on("mouseover", function(d) {
                    tooltip.attr("transform", "translate(" + x(d.key) + ", " + (y(d.value / total) + 10) + ")")
                    if (d.key == "mais de 40") {
                        tooltipTitle.html(d.key + " dias")
                    } else {
                        tooltipTitle.html("De " + d.key + " dias")
                    }
                    tooltipBody.html("<p class='chart-tip'>" + d.value + " pedidos</p><p>" + d3.format(".0%")(d.value / total) + " do total</p>");
                    tooltip.style("display", null);
                })
                .on("mouseout", function(d) {
                    tooltip.style("display", "none");
                });
            g.selectAll(".chart-bar")
                .transition()
                .duration(function(d, i) { return i * 100; })
                .attr("y", function(d) { return y(d.value / total); })
                .attr("height", function(d) { return height - y(d.value / total); });
        }
        filter();
    }

    d3.json("/api/pedidosTempoMedioDeTramitacao", draw);
})();

(function() {
    var
        margin = { top: 0, right: 0, bottom: 0, left: 0 },
        viewBox = { width: 520, height: 160 },
        width = viewBox.width - margin.left - margin.right,
        height = viewBox.height - margin.top - margin.bottom,
        dot = { radius: 40 },
        text = { padding: 10 },
        svg = d3.select("#chart-taxa-reversao").append('svg')
        .attr("version", "1.1")
        .attr("viewBox", "0 0 " + viewBox.width + " " + viewBox.height)
        .attr("width", "100%"),
        clip = svg.append("defs").append("clipPath").attr("id", "circles-clip-path"),
        g = svg.append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");
    var
        x = d3.scaleBand().rangeRound([0, width]).paddingOuter(0.5),
        y = d3.scaleLinear().range([0, dot.radius * 2]);

    function draw(error, data) {
        if (error) throw error;
        var nulldata = [
            { Interacao: "4", Status: "Nenhum", Qtd: 0 },
            { Interacao: "5", Status: "Nenhum", Qtd: 0 },
            { Interacao: "6", Status: "Nenhum", Qtd: 0 },
            { Interacao: "7", Status: "Nenhum", Qtd: 0 },
            { Interacao: "8", Status: "Nenhum", Qtd: 0 },
            { Interacao: "9", Status: "Nenhum", Qtd: 0 },
            { Interacao: "10", Status: "Nenhum", Qtd: 0 },
            { Interacao: "11", Status: "Nenhum", Qtd: 0 }
        ];
        data = data.concat(nulldata);
        var dividend = _.filter(data, function(d) {
            return d.Interacao == "5" || d.Interacao == "7" || d.Interacao == "9" || d.Interacao == "11";
        });
        var divisor = _.filter(data, function(d) {
            return d.Interacao == "4" || d.Interacao == "6" || d.Interacao == "8" || d.Interacao == "10";
        });
        dividend = d3.nest()
            .key(function(d) { return d.Interacao; })
            .rollup(function(leaves) { return { "sum": d3.sum(leaves, function(l) { return +l.Qtd; }) } })
            .entries(dividend);
        divisor = d3.nest()
            .key(function(d) { return d.Interacao; })
            .rollup(function(leaves) { return { "sum": d3.sum(leaves, function(l) { return +l.Qtd; }) } })
            .entries(divisor);
        var series = [
            { instancia: "1ª instância", dividend: +dividend[0].value.sum, divisor: divisor[0].value.sum },
            { instancia: "2ª instância", dividend: +dividend[1].value.sum, divisor: divisor[1].value.sum },
            { instancia: "3ª instância", dividend: +dividend[2].value.sum, divisor: divisor[2].value.sum },
            { instancia: "4ª instância", dividend: +dividend[3].value.sum, divisor: divisor[3].value.sum },
        ];
        x.domain(series.map(function(d) { return d.instancia; }));

        var paths = clip.selectAll("circle")
            .data(series)
            .enter().append("circle")
            .attr("cx", function(d) { return x(d.instancia) + dot.radius; })
            .attr("cy", height * 0.5)
            .attr("r", dot.radius);

        var gCircles = g.selectAll(".chart-circle")
            .data(series)
            .enter().append("g")
            .attr("class", "chart-circle");
        gCircles.append("text")
            .attr("x", function(d) { return x(d.instancia) + dot.radius; })
            .attr("y", (height * 0.5) - dot.radius - text.padding)
            .attr("fill", "#000000")
            .attr("font-size", "8px")
            .attr("text-anchor", "middle")
            .text(function(d) { return d.instancia; });
        gCircles.append("text")
            .attr("x", function(d) { return x(d.instancia) + dot.radius; })
            .attr("y", (height * 0.5) + dot.radius + text.padding)
            .attr("fill", "#000000")
            .attr("font-size", "8px")
            .attr("text-anchor", "middle")
            .attr("alignment-baseline", "hanging")
            .text(function(d) { return d.dividend + " pedidos"; });
        gCircles.append("circle")
            .attr("cx", function(d) { return x(d.instancia) + dot.radius; })
            .attr("cy", height * 0.5)
            .attr("r", dot.radius)
            .attr("fill", "#edf0f5")
            .attr("stroke", "#e1e1e1")
            .attr("stroke-width", 2);
        gCircles.append("rect")
            .attr("x", function(d) { return x(d.instancia); })
            .attr("y", function(d) {
                if (d.divisor > 0) {
                    return (height * 0.5 + dot.radius) - y(d.dividend / d.divisor);
                }
            })
            .attr("width", dot.radius * 2)
            .attr("height", function(d) {
                if (d.divisor > 0) {
                    return y(d.dividend / d.divisor);
                }
                return y(0);
            })
            .attr("fill", "#FFA401")
            .attr("clip-path", "url(#circles-clip-path)");
        gCircles.append("text")
            .attr("x", function(d) { return x(d.instancia) + dot.radius; })
            .attr("y", function(d) {
                if (d.divisor > 0) {
                    if (d.dividend / d.divisor > 0.2 || d.dividend / d.divisor < 0.8) {
                        return (height * 0.5 + dot.radius) - y(d.dividend / d.divisor) - (text.padding * 0.4);
                    }
                }
                return height * 0.5;
            })
            .attr("fill", "#000000")
            .attr("font-size", "8px")
            .attr("text-anchor", "middle")
            .attr("alignment-baseline", "middle")
            .text(function(d) {
                if (d.divisor > 0) {
                    return d3.format(".1f")((d.dividend / d.divisor) * 100) + "%";
                }
                return "0%";
            });

    }
    d3.json("/api/taxaDeReversao", draw);
})();