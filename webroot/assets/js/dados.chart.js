//Grafico classificações de atendimento por ano
(function () {
    
    var margin = {top: 40, right: 30, bottom: 10, left: 50},
        width = 960 - margin.left - margin.right,
        height = 470 - margin.top - margin.bottom;   

    var svg = d3.select("#chart-atendimento")
        .append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", (height + margin.top + margin.bottom) + 20)
        .append("g")
            .attr("transform",
                "translate(" + margin.left + "," + margin.top + ")");

    // - 
    var subgroups = ["Respondidos","NaoRespondidos"];

    // - Legenda              
    svg.append("g")
    .attr("class", "legendLinear")
    .attr("transform", "translate(2,-40)");

    
    svg.select(".legendLinear")
    .append('rect')          
    .attr("width",24)
    .attr("height",24)
    .attr('stroke', 'black')
    .attr('fill', '#fbc064');
    
    svg.select(".legendLinear")
    .append('text')       
    .attr("y",20)
    .attr("x",30)
    .attr('stroke', 'black')
    .text('Não Respondidos');

    svg.select(".legendLinear")
    .append('rect')  
    .attr("x",160)       
    .attr("width",24)
    .attr("height",24)
    .attr('stroke', 'black')
    .attr('fill', '#e45d88');

    svg.select(".legendLinear")
    .append('text')     
    .attr("y",20)
    .attr("x",190)  
    .attr('stroke', 'black')
    .text('Respondidos');

    // - 
    function draw(error, data) {
        if (error) throw error;

        // Consolida os Anos e Unicos Registros
        var anosDataq = data.map(el => el.Ano)
            .filter((value, index, self) => self.indexOf(value) === index); // Distinct 

        var dataC = [];
        anosDataq.forEach(function(el, i, arr) {
            var anoNovoItem = {
                Respondido: 0,
                NaoRespondido: 0,
                Total: 0,
                PercRespondidos: 0,
                Ano: el
            };

            // -
            data.filter(el2 => el2.Ano == el).forEach(function(itemAno, iItemAno) {
                var valor = parseInt(itemAno.Qtd);
                
                if(itemAno.StatusResposta == "Respondido") {
                    anoNovoItem.Respondido += valor;
                } else {
                    anoNovoItem.NaoRespondido += valor;
                }
            });

            // -
            dataC[i] = anoNovoItem;
        });

        data = dataC;

        // Calcula a Porcentagem
        data.forEach(function(el, i, arr) {
            var respondidos = el.Respondido;
            var naoRespondidos = el.NaoRespondido;
            
            // - Calcula Porcentagem
            el.Total = naoRespondidos +  respondidos;
            if(respondidos > 0) {  el.PercRespondidos = ((respondidos/el.Total)); }
            else if(respondidos == 0 && naoRespondidos > 0) { el.PercRespondidos = 0; }
            else if(respondidos == 0 && naoRespondidos == 0) { el.PercRespondidos = 1; }

            el.PercNaoRespondidos = 1.00 - el.PercRespondidos;
        });

         // Add X axis
      var x = d3.scaleBand()
        .domain(anosDataq)
        .range([0, width])
        .padding([0.2])
        svg.append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x).tickSizeOuter(0));

        // Add Y axis
        var y = d3.scaleLinear()
        .domain([0.0,1.0])
        .range([ height, 0 ]);
        svg.append("g")
        .call(d3.axisLeft(y).tickFormat(d3.format(".0%")));

        var color = d3.scaleOrdinal()
            .domain(subgroups)
            .range(['#e45d88','#fbc064'])

        //stack the data? --> stack per subgroup
        var stackedData = d3.stack()
                .keys(subgroups)
                .value(function(obj, key) {
                    if(key == "Respondidos") {
                        return obj.PercRespondidos;
                    }
                    else if(key == "NaoRespondidos") {
                        return obj.PercNaoRespondidos;
                    }
                })
                (data)

        // Barra do Gráfico
        svg.append("g")
        .selectAll("g")
        .data(stackedData)
        .enter().append("g")
            .attr("fill", function(d) {
                 return color(d.key); 
            })
            .selectAll("rect")
            .data(function(d) { 
                return d; 
            })
            .enter().append("rect") // Cria a Barra 
            .attr("x", function(d) { 
                return x(d.data.Ano); 
            })
            .attr("y", function(d) { 
                return y(d[1]);
             })
            .attr("height", function(d) {
                 return y(d[0]) - y(d[1]);
             })
            .attr("width",x.bandwidth());

        // Legendas dos Respondidos
        var legendaBarrasResp = svg.append("g")
        .selectAll("g")
        .data(data)
        .enter().append("g");

        legendaBarrasResp.append("text")
            .text(function(d) { 
                return (d.PercRespondidos * 100).toFixed(0) + "%";
            })
            .attr("x", function(d){
                return x(d.Ano) + x.bandwidth()/2;
            })
            .attr("y", function(d){
                return  y(0) - ((y(0) - y(d.PercRespondidos)) / 2);
            })
            .attr("font-family" , "sans-serif")
            .attr("font-size" , "14px")
            .attr("fill" , "black")
            .attr("text-anchor", "middle");

        // Legendas dos Não Respondidos
        var legendaBarrasNaoResp = svg.append("g")
        .selectAll("g")
        .data(data)
        .enter().append("g");

        legendaBarrasNaoResp.append("text")
            .text(function(d) { 
                return (d.PercNaoRespondidos * 100).toFixed(0) + "%";
            })
            .attr("x", function(d){
                return x(d.Ano) + x.bandwidth()/2;
            })
            .attr("y", function(d){
                return  ((y(0) - y(d.PercNaoRespondidos)) / 2);
            })
            .attr("font-family" , "sans-serif")
            .attr("font-size" , "14px")
            .attr("fill" , "black")
            .attr("text-anchor", "middle");
    }

    d3.json("/api/PedidosAtendimentoPorAno", draw);
})();
//FIM Grafico classificações de atendimento por ano
(function () {
    var _lodash = _.noConflict();
    var pedidosPorUFPoderENivelCache = [];

    d3.json("/api/pedidosPorUFPoderENivel", function drawMapData(error, data) {
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
            widthB = viewBoxB.width - marginB.left - marginB.right,
            heightB = viewBoxB.height - marginB.top - marginB.bottom,
            dotB = { minRadius: 3, maxRadius: 30 },
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

        let mouseOver = function(d) {
            d3.selectAll(".chart-uf")
                .transition()
                .duration(200)
                .style("opacity", .85)
                .style("stroke", "transparent")
            d3.select(this)
                .transition()
                .duration(200)
                .style("opacity", 1)
                .style("stroke", "black")
            }
        
        let mouseLeave = function(d) {
            d3.selectAll(".chart-uf")
                .transition()
                .duration(200)
                .style("opacity", .85)
            d3.select(this)
                .transition()
                .duration(200)
                .style("stroke", "transparent")
            }           

        // Range de Cores
        var color_range = ["#969696","#940131","#cd134f","#ec7340","#fab94f","#f6e197"];
        var colorScale = d3.scaleLinear()
        .domain([0.0, 0.20, 0.40, 0.60, 0.80, 1.0])
        .range(color_range);

        var legend = d3.legendColor()
            .scale(colorScale)
            .cells([1.0,0.80, 0.60, 0.40, 0.20,0.0])
            .labelFormat(d3.format(".0%"))
            .title("% Respondidos");
            svgB.append("g")
            .attr("transform", "translate(60,360)")
            .call(legend);  

        // -
        var tooltipB = svgB.append("foreignObject")
            .attr("class", "chart-tooltip")
            .attr("x", 0)
            .attr("y", heightB - 100)
            .attr("width", 150)
            .attr("height", 100)
            .style("display", "none");
        var tooltipContentB = tooltipB.append('xhtml:div')
            .attr("class", "chart-tooltip-content");
        var tooltipTitleB = tooltipContentB.append('div')
            .attr("class", 'chart-tooltip-title');
        var tooltipBodyB = tooltipContentB.append('div')
            .attr('class', 'chart-tooltip-body');

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


        function drawBarras(data) {
            // 
            var orderByPerc = $("#order-by-perc").is(":checked");
            var orderByUf = $("#order-by-uf").is(":checked");

            // Ordena os Dados
            if(orderByPerc) {
                data = data.sort(function(a,b) {
                    return a.PercRespondidos - b.PercRespondidos;                    
                });
            } else if(orderByUf) {
                data = data.sort(function(a,b) {
                    return a.SiglaUf.localeCompare(b.SiglaUf, 'pt-BR', { sensitivity: 'base' });
                });                
            }

            // Consolida os Dados por Estado
            var ufsData = data.map(el => el.SiglaUf)
                .filter((value, index, self) => self.indexOf(value) === index); // Distinct 

            // Add X axis
            var x = d3.scaleLinear()
            .domain([0.0, 1.0])
            .range([ 0, widthC]);
            svgC.append("g")
            .attr("transform", "translate(0," + heightC + ")")
            .call(d3.axisBottom(x).tickFormat(d3.format(".0%")))
            .selectAll("text")
                .attr("transform", "translate(-10,0)rotate(-45)")
                .style("text-anchor", "end");

              // Y axis
            var y = d3.scaleBand()
            .range([ 0, heightC ])
            .domain(data.map(function(d) { return d.SiglaUf; }))
            .padding(.1);
            svgC.append("g")
            .call(d3.axisLeft(y))


            //Bars
            svgC.selectAll("myRect")
            .data(data)
            .enter()
            .append("rect")
            .attr("x", x(0) )
            .attr("y", function(d) { return y(d.SiglaUf); })
            .attr("width", function(d) { return x(d.PercRespondidos); })
            .attr("height", y.bandwidth() )
            .attr("fill", "#fe9301")
            .style("opacity", 0.5)
            .on("mouseover", function(d) {
                d3.select(this).style("opacity", 1);
                d3.select("#bartext-" + d.SiglaUf).style("opacity", 1);
            })
            .on("mouseout", function(d) {
                d3.select(this).style("opacity", 0.5);
                d3.select("#bartext-" + d.SiglaUf).style("opacity", 0);
            });

            // Texto da Quantidades de Pedidos
            svgC.selectAll("myText")
            .data(data)
            .enter()
            .append("text")
            .attr("x", function(d) {
                return x(d.PercRespondidos) + 5; 
            })
            .attr("y", function(d) { return y(d.SiglaUf) + 10; })
            .attr("width", 100)
            .attr("height", y.bandwidth() )
            .attr("fill", "#000")
            .attr("id", function(d) {
                return "bartext-" + d.SiglaUf;
            })
            .style("opacity", 0)
            .style("z-index", 1000)
            .text(function(d) {
                return d.Respondido + " pedidos";
            });
        }

        function drawMap(error, br) {
            if (error) throw error;
            var ufs = topojson.feature(br, br.objects.br);
            data = pedidosPorUFPoderENivelCache;

            // Filtra os Resultados
            var nivelFederativo = $("#filter-nivel").val();
            var esferaPoder = $("#filter-poder").val();

            if(nivelFederativo !== "--") {
                data = data.filter(function(el) {
                    return el.NomeNivelFederativo == nivelFederativo;
                });
            }

            if(esferaPoder !== "--") {
                    data = data.filter(function(el) {
                        return el.NomePoder == esferaPoder;
                    });        
            }

            // Consolida os Dados por Estado
            var ufsData = data.map(el => el.SiglaUf)
                .filter((value, index, self) => self.indexOf(value) === index); // Distinct 

            // Recria o Dados Consolidados
            var dataC = [];
            ufsData.forEach(function(el, i, arr) {
                var ufNovoItem = {
                    Respondido: 0,
                    NaoRespondido: 0,
                    Total: 0,
                    PercRespondidos: 0,
                    SiglaUf: el 
                };

                // -
                data.filter(el2 => el2.SiglaUf == el).forEach(function(itemUf, iItemUf) {
                    var respondidos = itemUf.Respondido;
                    var naoRespondidos = itemUf.NaoRespondido;
                    
                    // -
                    if(respondidos == null) { respondidos = 0 } else { respondidos = parseInt(respondidos) };
                    if(naoRespondidos == null) { naoRespondidos = 0 } else { naoRespondidos = parseInt(naoRespondidos) };
                    
                    ufNovoItem.Respondido += respondidos;
                    ufNovoItem.NaoRespondido += naoRespondidos;
                });

                // -
                dataC[i] = ufNovoItem;
            });

            data = dataC;

            // Calcula a Porcentagem
            data.forEach(function(el, i, arr) {
                var respondidos = el.Respondido;
                var naoRespondidos = el.NaoRespondido;
                
                // - Calcula Porcentagem
                el.Total = naoRespondidos +  respondidos;
                if(respondidos > 0) {  el.PercRespondidos = ((respondidos/el.Total)); }
                else if(respondidos == 0 && naoRespondidos > 0) { el.PercRespondidos = 0; }
                else if(respondidos == 0 && naoRespondidos == 0) { el.PercRespondidos = 1; }
            });

            // Altera a Cor dos Estados de Acordo com a Porcentagem 
            gB.selectAll(".chart-uf")
                    .data(ufs.features)
                    .enter().append("path")
                    .attr("class", "chart-uf")
                    .attr("d", map)
                    .attr("fill", function (d) { 
                        var sigla = d.id;
                        var procura = data.filter(el => el.SiglaUf == sigla);                    

                        return colorScale(procura[0].PercRespondidos);
                    })                    
                    // Efeito Hover
                    .style("opacity", .85)
                    .style("stroke", "transparent")
                    .on("mouseover", mouseOver )
                    .on("mouseleave", mouseLeave )
                    // Tooltip do Estado + Porcentagem 
                    .append("title")
                    .text(function (d) {  
                        var sigla = d.id;
                        var procura = data.filter(el => el.SiglaUf == sigla);                    

                        return d.properties.nome + ", " + (procura[0].PercRespondidos * 100).toFixed(1) + "%" +
                        "\r\n Respondidos: " + procura[0].Respondido + 
                        "\r\n Não Respondidos: " + procura[0].NaoRespondido;
                    });

                drawBarras(data);
        }
        d3.json("/assets/data/br.json", drawMap);
    }  

    $("#filter-nivel").change(function() {
        doDrawMap();
    });
    
    $("#filter-poder").change(function() {
        doDrawMap();
    });

    $("#order-by-perc").change(function() {
        doDrawMap();
    });

    $("#order-by-uf").change(function() {
        doDrawMap();
    });
})();

(function () {
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

        data.forEach(function (d) {
            d.DataEnvio = new Date(d.DataEnvio);
            d.DataResposta = new Date(d.DataResposta);
            d.Grupo = z(d.DiasCorridos);
        });

        d3.select("#filter-tipo-tempo").on("change", function () {
            filter_tipo = this.value;
            filter();
        });

        d3.select("#filter-tempo-esfera").on("change", function () {
            filter_esfera = this.value;
            filter();
        });

        function filter() {
            var entries = _.filter(data, function (d) { return (filter_tipo !== "--") ? d.NomeEsferaPoder == filter_tipo : true });
            entries = _.filter(entries, function (d) { return (filter_esfera !== "--") ? d.NomeNivelFederativo == filter_esfera : true });
            var series = d3.nest()
                .key(function (d) { return d.Grupo; })
                .rollup(function (leaves) { return leaves.length; })
                .entries(entries);
            series.sort(function (a, b) { return d3.ascending(a.value, b.value); });

            var total = d3.nest()
                .rollup(function (leaves) { return leaves.length; })
                .entries(entries);
            console.log("total")
            console.log(total)
            y.domain([0, Math.ceil(d3.max(series, function (d) { return d.value / total; }) * 10) / 10]);
            yAxis.call(d3.axisLeft(y).tickFormat(d3.format(".1%")).ticks(4));

            g.selectAll(".chart-bar").remove();
            var bars = g.selectAll(".chart-bar")
                .data(series)
                .enter().append("rect")
                .attr("class", "chart-bar")
                .attr("x", function (d) { return x(d.key); })
                .attr("y", height)
                .attr("width", x.bandwidth())
                .attr("height", 0)
                .on("mouseover", function (d) {
                    tooltip.attr("transform", "translate(" + x(d.key) + ", " + (y(d.value / total) + 10) + ")")
                    if (d.key == "mais de 40") {
                        tooltipTitle.html(d.key + " dias")
                    } else {
                        tooltipTitle.html("De " + d.key + " dias")
                    }
                    tooltipBody.html("<p class='chart-tip'>" + d.value + " pedidos</p><p>" + d3.format(".0%")(d.value / total) + " do total</p>");
                    tooltip.style("display", null);
                })
                .on("mouseout", function (d) {
                    tooltip.style("display", "none");
                });
            g.selectAll(".chart-bar")
                .transition()
                .duration(function (d, i) { return i * 100; })
                .attr("y", function (d) { return y(d.value / total); })
                .attr("height", function (d) { return height - y(d.value / total); });
        }
        filter();
    }

    //d3.json("/api/pedidosTempoMedioDeTramitacao", draw);
})();

(function () {
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
        var dividend = _.filter(data, function (d) {
            return d.Interacao == "5" || d.Interacao == "7" || d.Interacao == "9" || d.Interacao == "11";
        });
        var divisor = _.filter(data, function (d) {
            return d.Interacao == "4" || d.Interacao == "6" || d.Interacao == "8" || d.Interacao == "10";
        });
        dividend = d3.nest()
            .key(function (d) { return d.Interacao; })
            .rollup(function (leaves) { return { "sum": d3.sum(leaves, function (l) { return +l.Qtd; }) } })
            .entries(dividend);
        divisor = d3.nest()
            .key(function (d) { return d.Interacao; })
            .rollup(function (leaves) { return { "sum": d3.sum(leaves, function (l) { return +l.Qtd; }) } })
            .entries(divisor);
        var series = [
            { instancia: "1ª instância", dividend: +dividend[0].value.sum, divisor: divisor[0].value.sum },
            { instancia: "2ª instância", dividend: +dividend[1].value.sum, divisor: divisor[1].value.sum },
            { instancia: "3ª instância", dividend: +dividend[2].value.sum, divisor: divisor[2].value.sum },
            { instancia: "4ª instância", dividend: +dividend[3].value.sum, divisor: divisor[3].value.sum },
        ];
        x.domain(series.map(function (d) { return d.instancia; }));

        var paths = clip.selectAll("circle")
            .data(series)
            .enter().append("circle")
            .attr("cx", function (d) { return x(d.instancia) + dot.radius; })
            .attr("cy", height * 0.5)
            .attr("r", dot.radius);

        var gCircles = g.selectAll(".chart-circle")
            .data(series)
            .enter().append("g")
            .attr("class", "chart-circle");
        gCircles.append("text")
            .attr("x", function (d) { return x(d.instancia) + dot.radius; })
            .attr("y", (height * 0.5) - dot.radius - text.padding)
            .attr("fill", "#000000")
            .attr("font-size", "8px")
            .attr("text-anchor", "middle")
            .text(function (d) { return d.instancia; });
        gCircles.append("text")
            .attr("x", function (d) { return x(d.instancia) + dot.radius; })
            .attr("y", (height * 0.5) + dot.radius + text.padding)
            .attr("fill", "#000000")
            .attr("font-size", "8px")
            .attr("text-anchor", "middle")
            .attr("alignment-baseline", "hanging")
            .text(function (d) { return d.dividend + " pedidos"; });
        gCircles.append("circle")
            .attr("cx", function (d) { return x(d.instancia) + dot.radius; })
            .attr("cy", height * 0.5)
            .attr("r", dot.radius)
            .attr("fill", "#edf0f5")
            .attr("stroke", "#e1e1e1")
            .attr("stroke-width", 2);
        gCircles.append("rect")
            .attr("x", function (d) { return x(d.instancia); })
            .attr("y", function (d) {
                if (d.divisor > 0) {
                    return (height * 0.5 + dot.radius) - y(d.dividend / d.divisor);
                }
            })
            .attr("width", dot.radius * 2)
            .attr("height", function (d) {
                if (d.divisor > 0) {
                    return y(d.dividend / d.divisor);
                }
                return y(0);
            })
            .attr("fill", "#FFA401")
            .attr("clip-path", "url(#circles-clip-path)");
        gCircles.append("text")
            .attr("x", function (d) { return x(d.instancia) + dot.radius; })
            .attr("y", function (d) {
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
            .text(function (d) {
                if (d.divisor > 0) {
                    return d3.format(".1f")((d.dividend / d.divisor) * 100) + "%";
                }
                return "0%";
            });

    }
    //d3.json("/api/taxaDeReversao", draw);
})();
