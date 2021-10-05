//Grafico classificações de atendimento por ano
(function () {

    var margin = {top: 40, right: 30, bottom: 10, left: 50},
    width = 960 - margin.left - margin.right,
    height = 470 - margin.top - margin.bottom,
    tooltip , tooltipBody, tooltipContent, tooltipTitle;


    var svg = d3.select("#chart-atendimento")
        .append("svg")
            .attr("width", width + margin.left + margin.right + 200)
            .attr("height", (height + margin.top + margin.bottom) + 20)
        .append("g")
            .attr("transform",
                "translate(" + margin.left + "," + margin.top + ")");

    // -
    var subgroups = ["Respondidos","NaoRespondidos"];

    // - Legenda
    svg.append("g")
    .attr("class", "legendLinear")
    .attr("transform", "translate(900,145)");

    svg.select(".legendLinear")
    .append('rect')
    .attr("width",24)
    .attr("height",24)
    .attr('stroke', 'black')
    .attr('fill', '#e45d88');

    svg.select(".legendLinear")
    .append('text')
    .attr("y",20)
    .attr("x",30)
    .attr('stroke', 'black')
    .text('Respondidos');

    svg.select(".legendLinear")
    .append('rect')
    .attr("x",0)
    .attr("y",44)
    .attr("width",24)
    .attr("height",24)
    .attr('stroke', 'black')
    .attr('fill', '#fbc064');

    svg.select(".legendLinear")
    .append('text')
    .attr("y",64)
    .attr("x",30)
    .attr('stroke', 'black')
    .text('Não Respondidos');

    function tooltipShow(data, x, y) {
        tooltip.attr("transform", "translate(" + x + ", " + y + ")")
        tooltipTitle.html(data.Ano);

        tooltipBody.html("<p class='chart-tip'>" + data.Total + " pedidos</p><p>"
        + data.Respondido + " pedidos respondidos</p><p>"
        + data.NaoRespondido + " pedidos não respondidos</p>");

        tooltip.style("display", null);
    }

    // -
    function draw(error, data) {
        if (error) throw error;
    
        var series = d3.nest().key(function(d) { return d.status; }).sortKeys(d3.ascending).entries(data);
        var series2 = d3.nest().key(function(d) { return d.ano; }).sortValues(function(a, b) { return b.qtd - a.qtd; }).entries(data);
    
        x.domain(data.map(function(d) { return d.ano; }));
        // y.domain([d3.min(data, function(d) { return +d.qtd }), d3.max(data, function(d) { return +d.qtd })]);
        z.domain(series.map(function(d) { return d.key; }));
    
        series2 = _.map(series2, function(item) {
            var sum = d3.sum(item.values, function(d) { return +d.qtd; });
            item.values.forEach(function(v) {
                v.sum = sum;
            });
            return item;
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
        .attr("class","xaxis")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x).tickSizeOuter(0));

        // Add Y axis
        var y = d3.scaleLinear()
        .domain([0.0,1.0])
        .range([ height, 0 ]);

        var y_axis = d3.axisLeft().scale(y)
            .tickValues([0, .25, .5, .75, 1])
            .tickFormat(d3.format(".0%"));

        svg.append("g")
        .attr("class","yaxis")
        .call(y_axis);

        var color = d3.scaleOrdinal()
            .domain(subgroups)
            .range(['#e45d88','#fbc064']);

        svg.select(".yaxis")
            .selectAll("text")
            .style("font-size","15px");

        svg.select(".xaxis")
            .selectAll("text")
            .style("font-size","16px");


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
                d.forEach(function(item, i) {
                    item.key = d.key;
                });

                return d;
            })
            .enter()
            .append("rect") // Cria a Barra
            .attr("x", function(d) {
                return x(d.data.Ano);
            })
            .attr("y", function(d) {
                return y(d[1]);
             })
            .attr("height", function(d) {
                 return y(d[0]) - y(d[1]);
             })
            .attr("width",x.bandwidth())
            .style("cursor", "pointer")
            .on("mouseover", function (d) {
                var tooltipY = d.key == "Respondidos" ? y(0.9) : y(0.5);

                tooltipShow(d.data, x(d.data.Ano) , tooltipY);
            })
            .on("mouseout", function (d) {
                tooltip.style("display", "none");
            });

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
                d.dy =  y(0) - ((y(0) - y(d.PercRespondidos)) / 2);
                return d.dy;
            })
            .attr("font-family" , "sans-serif")
            .attr("font-size" , "14px")
            .attr("fill" , "black")
            .attr("text-anchor", "middle")
            .style("cursor", "pointer")
            .on("mouseover", function (d) {
                tooltipShow(d, x(d.Ano) , y(0.8));
            })
            .on("mouseout", function (d) {
                tooltip.style("display", "none");
            });;

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
                d.dy2 =  ((y(0) - y(d.PercNaoRespondidos)) / 2);
                return d.dy2;
            })
            .attr("font-family" , "sans-serif")
            .attr("font-size" , "14px")
            .attr("fill" , "black")
            .attr("text-anchor", "middle")
            .style("cursor", "pointer")
            .on("mouseover", function (d) {
                tooltipShow(d, x(d.Ano) , y(0.5));
            })
            .on("mouseout", function (d) {
                tooltip.style("display", "none");
            });;


        // - Tooltip
        tooltip = svg.append("foreignObject")
        .attr("class", "chart-tooltip")
        .attr("x", -15)
        .attr("y", 10)
        .attr("width", 150)
        .attr("height", 100)
        .style("display", "none")
        .style("z-index", 10000);
        tooltipContent = tooltip.append('xhtml:div')
            .attr("class", "chart-tooltip-content");
        tooltipTitle = tooltipContent.append('div')
            .attr("class", 'chart-tooltip-title');
        tooltipBody = tooltipContent.append('div')
            .attr('class', 'chart-tooltip-body');
    }

    d3.json("/api/PedidosAtendimentoPorAno", draw);
})();
//FIM Grafico classificações de atendimento por ano
(function () {
    var _lodash = _.noConflict();
    var unidadesFederativas = [{"ID": "0","Sigla": "ÓrgãosFederais","Nome": "Órgãos Federais"},{"ID": "1","Sigla": "AC","Nome": "Acre"}, {"ID": "2","Sigla": "AL","Nome": "Alagoas"}, {"ID": "3","Sigla": "AM","Nome": "Amazonas"}, {"ID": "4","Sigla": "AP","Nome": "Amapá"}, {"ID": "5","Sigla": "BA","Nome": "Bahia"}, {"ID": "6","Sigla": "CE","Nome": "Ceará"}, {"ID": "7","Sigla": "DF","Nome": "Distrito Federal"}, {"ID": "8","Sigla": "ES","Nome": "Espírito Santo"}, {"ID": "9","Sigla": "GO","Nome": "Goiás"}, {"ID": "10","Sigla": "MA","Nome": "Maranhão"}, {"ID": "11","Sigla": "MG","Nome": "Minas Gerais"}, {"ID": "12","Sigla": "MS","Nome": "Mato Grosso do Sul"}, {"ID": "13","Sigla": "MT","Nome": "Mato Grosso"}, {"ID": "14","Sigla": "PA","Nome": "Pará"}, {"ID": "15","Sigla": "PB","Nome": "Paraíba"}, {"ID": "16","Sigla": "PE","Nome": "Pernambuco"}, {"ID": "17","Sigla": "PI","Nome": "Piauí"}, {"ID": "18","Sigla": "PR","Nome": "Paraná"}, {"ID": "19","Sigla": "RJ","Nome": "Rio de Janeiro"}, {"ID": "20","Sigla": "RN","Nome": "Rio Grande do Norte"}, {"ID": "21","Sigla": "RO","Nome": "Rondônia"}, {"ID": "22","Sigla": "RR","Nome": "Roraima"}, {"ID": "23","Sigla": "RS","Nome": "Rio Grande do Sul"}, {"ID": "24","Sigla": "SC","Nome": "Santa Catarina"}, {"ID": "25","Sigla": "SE","Nome": "Sergipe"}, {"ID": "26","Sigla": "SP","Nome": "São Paulo"}, {"ID": "27","Sigla": "TO","Nome": "Tocantins"}];
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
            totais = { Respondidos : 0, NaoRespondidos : 0, Total: 0},
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
            .attr("transform", "translate(60,20)")
            .call(legend);

        // -
        var tooltipB = svgB.append("foreignObject")
            .attr("class", "chart-tooltip")
            .attr("x", 60)
            .attr("y", 0)
            .attr("width", 150)
            .attr("height", 100)
            .style("display", "none");
        var tooltipContent = tooltip.append('xhtml:div')
            .attr("class", "chart-tooltip-content");
        var tooltipTitle = tooltipContent.append('div')
            .attr('class', 'chart-tooltip-title');
        var tooltipBody = tooltipContent.append('div')
            .attr('class', 'chart-tooltip-body');
        var tooltipTips = tooltipBody.selectAll('.chart-tip')
            .data(series2)
            .enter()
            .append('p')
                .attr('class', 'chart-tip');
    
        var tooltipDots = focus2.selectAll('.chart-dot-hover')
            .data(series)
            .enter()
            .append('circle')
                .attr("class", "chart-dot-hover")
                .attr("r", dot.radius*3)
                .style("display", "none")
                .style("opacity", 0.3);
    
        svg.append('rect')
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
            .attr("class", "chart-overlay")
            .attr("width", width)
            .attr("height", height)
            .on("mouseover", mouseover)
            .on("mouseout", mouseout)
            .on("mousemove", mousemove);
    
        var timeScales = d3.map(data, function(d) { return x(d.ano); }).keys();
    
        function mouseover() {
            focus.style("display", null);
            tooltip.style("display", null);
            tooltipDots.style("display", null);
        }
        function mouseout() {
            focus.style("display", "none");
            tooltip.style("display", "none");
            tooltipDots.style("display", "none");
        }
        function mousemove() {
            var xMouse = d3.mouse(this)[0];
            var yMouse = d3.mouse(this)[1];
            var i = d3.bisect(timeScales, xMouse, 1);
            var di = series2[i-1];
            focus.attr("transform", "translate(" + x(di.key) + ",0)");
            var xTooltip = x(di.key);
            if (xTooltip > 500) {
                xTooltip = xTooltip - 170;
            }
            tooltip.attr("transform", "translate(" + xTooltip + ","+yMouse+")");
            tooltipTitle.text(di.key);
            tooltipDots
                .attr("cx", x(di.key))
                .attr("cy", function(d, j) {
                    if (typeof(di.values[j]) !== 'undefined') {
                        return y(+di.values[j].qtd/di.values[j].sum);
                    } else {
                        return height*2;
                    }
                })
                .attr("fill", function(d, j) {
                    if (typeof(di.values[j]) !== 'undefined') {
                        return z(di.values[j].status);
                    } else {
                        return "#fff";
                    }
                });
            tooltipTips.text(function(d, j) {
                if (typeof(di.values[j]) !== 'undefined') {
                    return capitalizeFirstLetter(di.values[j].status)+ ": "+di.values[j].qtd;
                } else {
                    return "";
                }
            })
            .style("color", function(d, j) {
                if (typeof(di.values[j]) !== 'undefined') {
                    return z(di.values[j].status);
                } else {
                    return "#fff";
                }
            });
        }
    
        function capitalizeFirstLetter(s) {
            return s.charAt(0).toUpperCase() + s.slice(1).toLowerCase();
        }
    }
    
    d3.json("/api/atendimentoPedidosPorAnoETipo", draw);
    })();
    
    (function(){
    var _lodash = _.noConflict();
    var unidadesFederativas = [{"ID": "0","Sigla": "ÓrgãosFederais","Nome": "Órgãos Federais"},{"ID": "1","Sigla": "AC","Nome": "Acre"}, {"ID": "2","Sigla": "AL","Nome": "Alagoas"}, {"ID": "3","Sigla": "AM","Nome": "Amazonas"}, {"ID": "4","Sigla": "AP","Nome": "Amapá"}, {"ID": "5","Sigla": "BA","Nome": "Bahia"}, {"ID": "6","Sigla": "CE","Nome": "Ceará"}, {"ID": "7","Sigla": "DF","Nome": "Distrito Federal"}, {"ID": "8","Sigla": "ES","Nome": "Espírito Santo"}, {"ID": "9","Sigla": "GO","Nome": "Goiás"}, {"ID": "10","Sigla": "MA","Nome": "Maranhão"}, {"ID": "11","Sigla": "MG","Nome": "Minas Gerais"}, {"ID": "12","Sigla": "MS","Nome": "Mato Grosso do Sul"}, {"ID": "13","Sigla": "MT","Nome": "Mato Grosso"}, {"ID": "14","Sigla": "PA","Nome": "Pará"}, {"ID": "15","Sigla": "PB","Nome": "Paraíba"}, {"ID": "16","Sigla": "PE","Nome": "Pernambuco"}, {"ID": "17","Sigla": "PI","Nome": "Piauí"}, {"ID": "18","Sigla": "PR","Nome": "Paraná"}, {"ID": "19","Sigla": "RJ","Nome": "Rio de Janeiro"}, {"ID": "20","Sigla": "RN","Nome": "Rio Grande do Norte"}, {"ID": "21","Sigla": "RO","Nome": "Rondônia"}, {"ID": "22","Sigla": "RR","Nome": "Roraima"}, {"ID": "23","Sigla": "RS","Nome": "Rio Grande do Sul"}, {"ID": "24","Sigla": "SC","Nome": "Santa Catarina"}, {"ID": "25","Sigla": "SE","Nome": "Sergipe"}, {"ID": "26","Sigla": "SP","Nome": "São Paulo"}, {"ID": "27","Sigla": "TO","Nome": "Tocantins"}];
    var
        marginB = {top: 0, right: 0, bottom: 0, left: 0},
        viewBoxB = {width: 600, height: 460},
        widthB = viewBoxB.width - marginB.left - marginB.right,
        heightB = viewBoxB.height - marginB.top - marginB.bottom,
        dotB = {minRadius: 3, maxRadius: 30},
        svgB = d3.select("#chart-pedidos-uf-mapa").append('svg')
            .attr("version", "1.1")
            .attr("viewBox", "0 0 "+viewBoxB.width+" "+viewBoxB.height)
            .attr("width", "100%"),
        gB = svgB.append("g").attr("transform", "translate(" + marginB.left + "," + marginB.top + ")"),
        projection = d3.geoAlbers()
            .center([-44, -15])
            .rotate([0, 0])
            .parallels([0, 0])
            .scale(700),
        map = d3.geoPath().projection(projection);
    
    var mapScale = d3.scaleLinear().range([dotB.minRadius, dotB.maxRadius]).domain([0, 1]);
    var
        filter_tipo = "Respondido",
        filter_nivel = "--",
        filter_poder = "--",
        order_by = "perc";
    
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
        marginC = {top: 20, right: 60, bottom: 20, left: 90},
        viewBoxC = {width: 400, height: 460},
        widthC = viewBoxC.width - marginC.left - marginC.right,
        heightC = viewBoxC.height - marginC.top - marginC.bottom,
        dotC = {minRadius: 1, maxRadius: 35},
        svgC = d3.select("#chart-pedidos-uf-barras").append('svg')
            .attr("version", "1.1")
            .attr("viewBox", "0 0 "+viewBoxC.width+" "+viewBoxC.height)
            .attr("width", "100%"),
        gC = svgC.append("g").attr("transform", "translate(" + marginC.left + "," + marginC.top + ")"),
        xC = d3.scaleLinear().range([0, widthC]),
        yC = d3.scaleBand().range([heightC, 0]).paddingInner(0.05);
    
    function drawMap(error, br) {
        if (error) throw error;
        var ufs = topojson.feature(br, br.objects.br);
    
        d3.json("/api/pedidosPorUFPoderENivel", function drawMapData(error, data) {
            if (error) throw error;
    
            var seriesMap = d3.nest()
                .key(function(d) { return d.sigla; })
                .sortKeys(d3.descending)
                .entries(data);
            var seriesMapDomain = d3.nest()
                .rollup(function(l) { return { "max": d3.max(l, function(ld) { return ld.qtd; }), "min": d3.min(l, function(ld) { return ld.qtd; }), "sum": d3.sum(l, function(ld) { return ld.qtd; }) } })
                .entries(data);
            var seriesSum = d3.nest()
                .key(function(d) { return d.sigla; })
                .rollup(function(l) { return { "sum": d3.sum(l, function(ld) { return ld.qtd; }) } })
                .entries(data);
    
            // var features = _lodash.map(ufs.features, function(item) {
            //     return _lodash.extend(item, _lodash.find(seriesMap, { key: item.id }));
            // });
    
            gB.selectAll(".chart-uf")
                .data(ufs.features)
                .enter().append("path")
                    .attr("class", "chart-uf")
                    .attr("d", map);
    
            var mapDots = gB.selectAll(".chart-uf-dot")
                .data(ufs.features)
                .enter().append("circle")
                    .attr("id", function(d) { return d.id; })
                    .attr("class", "chart-uf-dot")
                    .attr("r", 0)
                    .style("opacity", 0.5)
                    .attr("transform", function(d) { return "translate(" + map.centroid(d) + ")"; });
    
            var gBars = gC.append("g").attr("class", "chart-bars");
    
            gC.append("g")
              .attr("class", "axis axis-x")
              .attr("transform", "translate(0," + heightC + ")")
              .call(d3.axisBottom(xC).ticks(2, ".1%"));
            var yAxis = gC.append("g")
                .attr("class", "axis axis-y")
                .call(d3.axisLeft(yC));
    
            d3.select("#filter-tipo").on("change", function() {
                filter_tipo = this.value;
                filter();
            });
            d3.select("#filter-nivel").on("change", function() {
                filter_nivel = this.value;
                filter();
            });
            d3.select("#filter-poder").on("change", function() {
                filter_poder = this.value;
                filter();
            });
            d3.selectAll(".order-by").on("change", function() {
                order_by = this.value;
                filter();
            });
    
            function setInfo(title, qtd, sum) {
              var preposition = '';
              if (filter_nivel === "Municipal" && (filter_poder === "Executivo" || filter_poder === "Legislativo" || filter_poder === "Tribunal de Contas")) {
                d3.select("#chart-pedidos-uf-footer").style("display", null);
              } else {
                d3.select("#chart-pedidos-uf-footer").style("display", "none");
              }
              if (filter_nivel === "Municipal" && filter_poder == "Ministério Público") {
                  d3.select("#chart-info-uf").style("opacity", 0);
                  d3.select("#chart-info-all").style("display", "none");
                  d3.select("#chart-info-error").style("display", null);
                  d3.select("#chart-info-error").html("Não há Ministério Público<br>no nível municipal.");
                  return;
              }
              if (filter_nivel === "Municipal" && filter_poder == "Judiciário") {
                  d3.select("#chart-info-uf").style("opacity", 0);
                  d3.select("#chart-info-all").style("display", "none");
                  d3.select("#chart-info-error").style("display", null);
                  d3.select("#chart-info-error").html("Não há Poder Judiciário<br>no nível municipal.");
                  return;
              }
    
              d3.select("#chart-info-uf").style("opacity", 1);
              d3.select("#chart-info-all").style("display", null);
              d3.select("#chart-info-error").style("display", "none");
              d3.select("#chart-info-uf").text(title);
              if (filter_nivel === "--") {
                  d3.select("#chart-info-nivel-w").style("display", "none");
                  preposition = 'No';
              } else {
                  d3.select("#chart-info-nivel-w").style("display", null);
                  preposition = 'no';
              }
              if (filter_poder === "--") {
                  d3.select("#chart-info-poder-w").style("display", "none");
              } else {
                  d3.select("#chart-info-poder-w").style("display", null);
              }
              d3.select("#chart-info-tipo").text(filter_tipo.toLowerCase()+"s");
              d3.select("#chart-info-nivel").text(filter_nivel.toLowerCase());
              d3.select("#chart-info-poder-prep").text(preposition);
              d3.select("#chart-info-poder").text(capitalizeFirstLetter(filter_poder));
              d3.select("#chart-info-qtd").text(qtd);
              d3.select("#chart-info-perc").text(d3.format(".1%")(qtd/sum));
              d3.select("#chart-pedidos-uf-info").style("display", null);
              return;
            }
    
            function capitalizeFirstLetter(s) {
                return s.charAt(0).toUpperCase() + s.slice(1).toLowerCase();
            }

            // Consolida os Dados por Estado
            var ufsData = data
                .map(el => el.SiglaUf)
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

                // - Totais Gerais
                totais.Respondidos = totais.Respondidos + respondidos;
                totais.NaoRespondidos = totais.NaoRespondidos + naoRespondidos;
                totais.Total = totais.Total + el.Total;
            });

            // Perc. Total Geral
            if(  totais.Respondidos > 0) {  totais.PercRespondidos = (( totais.Respondidos/totais.Total)); }
            else if(totais.Respondidos == 0 &&  totais.NaoRespondidos > 0) { totais.PercRespondidos = 0; }
            else if(totais.Respondidos == 0 &&  totais.NaoRespondidos == 0) { totais.PercRespondidos = 1; }
            setMapInfo("Brasil", totais.PercRespondidos, totais.Respondidos);

            // Altera a Cor dos Estados de Acordo com a Porcentagem
            gB.selectAll(".chart-uf")
                    .data(ufs.features)
                    .enter().append("path")
                    .attr("class", "chart-uf")
                    .attr("d", map)
                    .attr("fill", function (d) {
                        var sigla = d.id;
                        var procura = data.filter(el => el.SiglaUf == sigla);
                        return procura.length == 0 ? colorScale(0) : colorScale(procura[0].PercRespondidos);
                    })
                    // Efeito Hover
                    .style("opacity", .85)
                    .style("stroke", "transparent")
                    //  Legenda Geral do Filtro
                    .on("mouseover", function(d) {
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
                        var procura = data.filter(el => el.SiglaUf == sigla);

                        setMapInfo(_lodash.find(unidadesFederativas, { Sigla: sigla}).Nome,
                                procura[0].PercRespondidos, procura[0].Respondido);
                    })
                    .on("mouseout", function(d) {
                        d3.selectAll(".chart-uf")
                        .transition()
                        .duration(200)
                        .style("opacity", .85);

                        d3.select(this)
                            .transition()
                            .duration(200)
                            .style("stroke", "transparent");

                        setMapInfo("Brasil", totais.PercRespondidos, totais.Respondidos);
                    });

            drawBarras(data);
            $("#chart-pedidos-uf-info").fadeIn();
        }


        function setMapInfo(title, perc, total) {
            $("#chart-info-uf").html(title);
            $("#chart-info-qtd").html(total);
            $("#chart-info-perc").html((perc * 100).toFixed(1));
        }

        d3.json("/assets/data/br.json", drawMap);
    }
    
    d3.json("/assets/data/br.json", drawMap);
    })();
    
    (function(){
    var
        margin = {top: 80, right: 50, bottom: 30, left: 50},
        viewBox = {width: 860, height: 420},
        width = viewBox.width - margin.left - margin.right,
        height = viewBox.height - margin.top - margin.bottom,
        dot = {radius: 3},
        svg = d3.select("#chart-tempo-resposta").append('svg')
            .attr("version", "1.1")
            .attr("viewBox", "0 0 "+viewBox.width+" "+viewBox.height)
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
            console.log("total")
            console.log(total)
            y.domain([0, Math.ceil(d3.max(series, function(d) { return d.value/total; }) * 10) / 10]);
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
                    tooltip.attr("transform", "translate("+x(d.key)+", "+(y(d.value/total)+10)+")")
                    if (d.key == "mais de 40") {
                        tooltipTitle.html(d.key+" dias")
                    } else {
                        tooltipTitle.html("De "+d.key+" dias")
                    }
                    tooltipBody.html("<p class='chart-tip'>"+d.value+" pedidos</p><p>"+d3.format(".0%")(d.value/total)+" do total</p>");
                    tooltip.style("display", null);
                })
                .on("mouseout", function(d) {
                    tooltip.style("display", "none");
                });
            g.selectAll(".chart-bar")
                .transition()
                .duration(function(d, i) { return i*100; })
                .attr("y", function(d) { return y(d.value/total); })
                .attr("height", function(d) { return height - y(d.value/total); });
        }
        filter();
    }
    
    d3.json("/api/pedidosTempoMedioDeTramitacao", draw);
    })();
    
    (function(){
    var
        margin = {top: 0, right: 0, bottom: 0, left: 0},
        viewBox = {width: 520, height: 160},
        width = viewBox.width - margin.left - margin.right,
        height = viewBox.height - margin.top - margin.bottom,
        dot = {radius: 40},
        text = {padding: 10},
        svg = d3.select("#chart-taxa-reversao").append('svg')
            .attr("version", "1.1")
            .attr("viewBox", "0 0 "+viewBox.width+" "+viewBox.height)
            .attr("width", "100%"),
        clip = svg.append("defs").append("clipPath").attr("id", "circles-clip-path"),
        g = svg.append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");
    var
        x = d3.scaleBand().rangeRound([0, width]).paddingOuter(0.5),
        y = d3.scaleLinear().range([0, dot.radius*2]);
    function draw(error, data) {
        if (error) throw error;
        var nulldata = [
            {Interacao: "4", Status: "Nenhum", Qtd: 0},
            {Interacao: "5", Status: "Nenhum", Qtd: 0},
            {Interacao: "6", Status: "Nenhum", Qtd: 0},
            {Interacao: "7", Status: "Nenhum", Qtd: 0},
            {Interacao: "8", Status: "Nenhum", Qtd: 0},
            {Interacao: "9", Status: "Nenhum", Qtd: 0},
            {Interacao: "10", Status: "Nenhum", Qtd: 0},
            {Interacao: "11", Status: "Nenhum", Qtd: 0}
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
            .rollup(function(leaves) { return {"sum": d3.sum(leaves, function(l) { return +l.Qtd; }) } })
            .entries(dividend);
        divisor = d3.nest()
            .key(function(d) { return d.Interacao; })
            .rollup(function(leaves) { return {"sum": d3.sum(leaves, function(l) { return +l.Qtd; }) } })
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
                .attr("cx", function(d) { return x(d.instancia)+dot.radius; })
                .attr("cy", height*0.5)
                .attr("r", dot.radius);
    
        var gCircles = g.selectAll(".chart-circle")
            .data(series)
            .enter().append("g")
                .attr("class", "chart-circle");
        gCircles.append("text")
            .attr("x", function(d) { return x(d.instancia)+dot.radius; })
            .attr("y", (height*0.5) - dot.radius - text.padding)
            .attr("fill", "#000000")
            .attr("font-size", "8px")
            .attr("text-anchor", "middle")
            .text(function(d) { return d.instancia; });
        gCircles.append("text")
            .attr("x", function(d) { return x(d.instancia)+dot.radius; })
            .attr("y", (height*0.5) + dot.radius + text.padding)
            .attr("fill", "#000000")
            .attr("font-size", "8px")
            .attr("text-anchor", "middle")
            .attr("alignment-baseline", "hanging")
            .text(function(d) { return d.dividend+" pedidos"; });
        gCircles.append("circle")
            .attr("cx", function(d) { return x(d.instancia)+dot.radius; })
            .attr("cy", height*0.5)
            .attr("r", dot.radius)
            .attr("fill", "#edf0f5")
            .attr("stroke", "#e1e1e1")
            .attr("stroke-width", 2);
        gCircles.append("rect")
            .attr("x", function(d) { return x(d.instancia); })
            .attr("y", function(d) {
                if (d.divisor > 0) {
                    return (height*0.5+dot.radius)-y(d.dividend/d.divisor);
                }
            })
            .attr("width", dot.radius*2)
            .attr("height", function(d) {
                if (d.divisor > 0) {
                    return y(d.dividend/d.divisor);
                }
                return y(0);
            })
            .attr("fill", "#FFA401")
            .attr("clip-path", "url(#circles-clip-path)");
        gCircles.append("text")
            .attr("x", function(d) { return x(d.instancia)+dot.radius; })
            .attr("y", function(d) {
                if (d.divisor > 0) {
                    if (d.dividend/d.divisor > 0.2 || d.dividend/d.divisor < 0.8) {
                        return (height*0.5+dot.radius)-y(d.dividend/d.divisor)-(text.padding*0.4);
                    }
                }
                return height*0.5;
             })
            .attr("fill", "#000000")
            .attr("font-size", "8px")
            .attr("text-anchor", "middle")
            .attr("alignment-baseline", "middle")
            .text(function(d) {
                if (d.divisor > 0) {
                    return d3.format(".1f")((d.dividend/d.divisor)*100)+"%";
                }
                return "0%";
            });
    
    }
    d3.json("/api/taxaDeReversao", draw);
    })();
    