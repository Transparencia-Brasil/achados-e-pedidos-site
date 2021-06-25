
//Grafico classificações de atendimento por ano
(function () {
    var
        margin = { top: 20, right: 50, bottom: 30, left: 50 },
        viewBox = { width: 860, height: 400 },
        width = viewBox.width - margin.left - margin.right,
        height = viewBox.height - margin.top - margin.bottom,
        dot = { radius: 3 },
        svg = d3.select("#chart-atendimento").append('svg')
            .attr("version", "1.1")
            .attr("viewBox", "0 0 " + viewBox.width + " " + viewBox.height)
            .attr("width", "100%"),
        g = svg.append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    var x = d3.scaleBand().rangeRound([0, width]).padding(1),
        y = d3.scaleLinear().range([height, 0]),
        z = d3.scaleOrdinal(["#ffa401", "#FA0F54", "#969696", "#B27D5C"]);

    var line = d3.line()
        .x(function (d) { return x(d.ano); })
        .y(function (d) { return y(+d.qtd / d.sum); });

    function draw(error, data) {
        console.log(data);
        // List of subgroups = header of the csv files = soil condition here
        // var subgroups = data.columns.slice(1)
        var subgroups = d3.map(data, function (d) { return (d.status) }).keys()
        console.log(subgroups);
        //["Nitrogen", "normal", "stress"]
        //[Não respondido, Respondido]

        var subgroupsWithValues = [];
        var r = [];
        var count = 0;
        data.forEach(function(item) {
            r[item.status] = item.qtd;
            // console.log(r)
            if (count++ == 1) {
                r["ano"] = item.ano;
                console.log("count")
                subgroupsWithValues.push(r);
                r = [];
                count = 0;
            }    
        });
        
        // List of groups = species here = value of the first column called group -> I show them on the X axis
        // var groups = d3.map(data, function (d) { return (d.group) }).keys()
        var groups = d3.map(data, function (d) { return (d.ano) }).keys()
        //(4) ["banana", "poacee", "sorgho", "triticum"] 
        // [2021,2020,2019,2018]
        // Add X axis
        var x = d3.scaleBand()
            .domain(groups)
            .range([0, width])
            .padding([0.2])
        svg.append("g")
            .attr("transform", "translate(0," + height + ")")
            .call(d3.axisBottom(x).tickSizeOuter(0));

        // Add Y axis
        var y = d3.scaleLinear()
            .domain([0, 60])
            .range([height, 0]);
        svg.append("g")
            .call(d3.axisLeft(y));

        // color palette = one color per subgroup
        var color = d3.scaleOrdinal()
            .domain(subgroups)
            .range(['#F9A521', '#D81755'])

        //stack the data? --> stack per subgroup
        var stackedData = d3.stack()
            .keys(subgroups)
            (subgroupsWithValues)
        console.log(stackedData);
        // ----------------
        // Create a tooltip
        // ----------------
        var tooltip = d3.select("#my_dataviz")
            .append("div")
            .style("opacity", 0)
            .attr("class", "tooltip")
            .style("background-color", "white")
            .style("border", "solid")
            .style("border-width", "1px")
            .style("border-radius", "5px")
            .style("padding", "10px")

        // Three function that change the tooltip when user hover / move / leave a cell
        var mouseover = function (d) {
            var subgroupName = d3.select(this.parentNode).datum().key;
            var subgroupValue = d.data[subgroupName];
            tooltip
                .html("subgroup: " + subgroupName + "<br>" + "Value: " + subgroupValue)
                .style("opacity", 1)
        }
        var mousemove = function (d) {
            tooltip
                .style("left", (d3.mouse(this)[0] + 90) + "px") // It is important to put the +90: other wise the tooltip is exactly where the point is an it creates a weird effect
                .style("top", (d3.mouse(this)[1]) + "px")
        }
        var mouseleave = function (d) {
            tooltip
                .style("opacity", 0)
        }

        // Show the bars
        svg.append("g")
            .selectAll("g")
            // Enter in the stack data = loop key per key = group per group
            .data(stackedData)
            .enter().append("g")
            .attr("fill", function (d) { console.log(d.key) 
                return color(d.key); })
            .selectAll("rect")
            // enter a second time = loop subgroup per subgroup to add all rectangles
            .data(function (d) { return d; })
            .enter().append("rect")
            .attr("x", function (d) { return x(d.data.ano); })
            .attr("y", function (d) { console.log(d) 
                return y(d[1]); })
            .attr("height", function (d) { console.log(d[0] + " - " + d[1]) 
            return y(d[0]) - y(d[1]); })
            .attr("width", x.bandwidth())
            .attr("stroke", "grey")
            .on("mouseover", mouseover)
            .on("mousemove", mousemove)
            .on("mouseleave", mouseleave)
    }
    d3.json("/api/atendimentoPedidosPorAnoETipo", draw);
    // d3.csv("https://raw.githubusercontent.com/holtzy/D3-graph-gallery/master/DATA/data_stacked.csv", draw);
})();
//FIM Grafico classificações de atendimento por ano












//Grafico classificações de atendimento por ano
(function () {
    var
        margin = { top: 20, right: 50, bottom: 30, left: 50 },
        viewBox = { width: 860, height: 400 },
        width = viewBox.width - margin.left - margin.right,
        height = viewBox.height - margin.top - margin.bottom,
        dot = { radius: 3 },
        svg = d3.select("#chart-atendimento").append('svg')
            .attr("version", "1.1")
            .attr("viewBox", "0 0 " + viewBox.width + " " + viewBox.height)
            .attr("width", "100%"),
        g = svg.append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    var parseTime = d3.timeParse("%Y");

    var x = d3.scaleBand().rangeRound([0, width]).padding(1),
        y = d3.scaleLinear().range([height, 0]),
        z = d3.scaleOrdinal(["#ffa401", "#FA0F54", "#969696", "#B27D5C"]);

    var line = d3.line()
        .x(function (d) { return x(d.ano); })
        .y(function (d) { return y(+d.qtd / d.sum); });

    function draw(error, data) {
        if (error) throw error;

        var series = d3.nest().key(function (d) { return d.status; }).sortKeys(d3.ascending).entries(data);
        var series2 = d3.nest().key(function (d) { return d.ano; }).sortValues(function (a, b) { return b.qtd - a.qtd; }).entries(data);

        x.domain(data.map(function (d) { return d.ano; }));
        // y.domain([d3.min(data, function(d) { return +d.qtd }), d3.max(data, function(d) { return +d.qtd })]);
        z.domain(series.map(function (d) { return d.key; }));

        series2 = _.map(series2, function (item) {
            var sum = d3.sum(item.values, function (d) { return +d.qtd; });
            item.values.forEach(function (v) {
                v.sum = sum;
            });
            return item;
        });

        g.append("g")
            .attr("class", "chart-axis chart-axis--x")
            .attr("transform", "translate(0," + height + ")")
            .call(d3.axisBottom(x));

        g.append("g")
            .attr("class", "chart-axis chart-axis--y")
            .call(d3.axisLeft(y).tickFormat(d3.format(".0%")));

        var focus = g.append('g')
            .attr('class', 'focus')
            .style('display', 'none');
        var focus2 = g.append('g')
            .attr('class', 'focus');
        focus.append('line')
            .attr('class', 'chart-hover-line')
            .attr('y1', 0)
            .attr('y2', height);

        var serie = g.selectAll(".series")
            .data(series)
            .enter().append("g")
            .attr("class", "series");

        serie.append("path")
            .attr("class", "chart-line")
            .attr("d", function (d) { return line(d.values); })
            .style("stroke", function (d) { return z(d.key); })
            .attr("opacity", 0)
            .transition(500)
            .attr("opacity", 1);

        serie
            .selectAll("circle.line")
            .data(function (d) { return d.values })
            .enter()
            .append("circle")
            .attr("class", "chart-dot")
            .attr("cx", function (d) { return x(d.ano); })
            .attr("cy", function (d) { return y(+d.qtd / d.sum); })
            .attr("stroke", function (d) { return z(d.status) })
            .attr("r", 0)
            .transition(500)
            .attr("r", dot.radius);

        var tooltip = svg.append("foreignObject")
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
            .attr("r", dot.radius * 3)
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

        var timeScales = d3.map(data, function (d) { return x(d.ano); }).keys();

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
            var di = series2[i - 1];
            focus.attr("transform", "translate(" + x(di.key) + ",0)");
            var xTooltip = x(di.key);
            if (xTooltip > 500) {
                xTooltip = xTooltip - 170;
            }
            tooltip.attr("transform", "translate(" + xTooltip + "," + yMouse + ")");
            tooltipTitle.text(di.key);
            tooltipDots
                .attr("cx", x(di.key))
                .attr("cy", function (d, j) {
                    if (typeof (di.values[j]) !== 'undefined') {
                        return y(+di.values[j].qtd / di.values[j].sum);
                    } else {
                        return height * 2;
                    }
                })
                .attr("fill", function (d, j) {
                    if (typeof (di.values[j]) !== 'undefined') {
                        return z(di.values[j].status);
                    } else {
                        return "#fff";
                    }
                });
            tooltipTips.text(function (d, j) {
                if (typeof (di.values[j]) !== 'undefined') {
                    return capitalizeFirstLetter(di.values[j].status) + ": " + di.values[j].qtd;
                } else {
                    return "";
                }
            })
                .style("color", function (d, j) {
                    if (typeof (di.values[j]) !== 'undefined') {
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
//FIM Grafico classificações de atendimento por ano
(function () {
    var _lodash = _.noConflict();
    var unidadesFederativas = [{ "ID": "0", "Sigla": "ÓrgãosFederais", "Nome": "Órgãos Federais" }, { "ID": "1", "Sigla": "AC", "Nome": "Acre" }, { "ID": "2", "Sigla": "AL", "Nome": "Alagoas" }, { "ID": "3", "Sigla": "AM", "Nome": "Amazonas" }, { "ID": "4", "Sigla": "AP", "Nome": "Amapá" }, { "ID": "5", "Sigla": "BA", "Nome": "Bahia" }, { "ID": "6", "Sigla": "CE", "Nome": "Ceará" }, { "ID": "7", "Sigla": "DF", "Nome": "Distrito Federal" }, { "ID": "8", "Sigla": "ES", "Nome": "Espírito Santo" }, { "ID": "9", "Sigla": "GO", "Nome": "Goiás" }, { "ID": "10", "Sigla": "MA", "Nome": "Maranhão" }, { "ID": "11", "Sigla": "MG", "Nome": "Minas Gerais" }, { "ID": "12", "Sigla": "MS", "Nome": "Mato Grosso do Sul" }, { "ID": "13", "Sigla": "MT", "Nome": "Mato Grosso" }, { "ID": "14", "Sigla": "PA", "Nome": "Pará" }, { "ID": "15", "Sigla": "PB", "Nome": "Paraíba" }, { "ID": "16", "Sigla": "PE", "Nome": "Pernambuco" }, { "ID": "17", "Sigla": "PI", "Nome": "Piauí" }, { "ID": "18", "Sigla": "PR", "Nome": "Paraná" }, { "ID": "19", "Sigla": "RJ", "Nome": "Rio de Janeiro" }, { "ID": "20", "Sigla": "RN", "Nome": "Rio Grande do Norte" }, { "ID": "21", "Sigla": "RO", "Nome": "Rondônia" }, { "ID": "22", "Sigla": "RR", "Nome": "Roraima" }, { "ID": "23", "Sigla": "RS", "Nome": "Rio Grande do Sul" }, { "ID": "24", "Sigla": "SC", "Nome": "Santa Catarina" }, { "ID": "25", "Sigla": "SE", "Nome": "Sergipe" }, { "ID": "26", "Sigla": "SP", "Nome": "São Paulo" }, { "ID": "27", "Sigla": "TO", "Nome": "Tocantins" }];
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
        projection = d3.geoMercator()
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
        marginC = { top: 20, right: 60, bottom: 20, left: 90 },
        viewBoxC = { width: 400, height: 460 },
        widthC = viewBoxC.width - marginC.left - marginC.right,
        heightC = viewBoxC.height - marginC.top - marginC.bottom,
        dotC = { minRadius: 1, maxRadius: 35 },
        svgC = d3.select("#chart-pedidos-uf-barras").append('svg')
            .attr("version", "1.1")
            .attr("viewBox", "0 0 " + viewBoxC.width + " " + viewBoxC.height)
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
                .key(function (d) { return d.sigla; })
                .sortKeys(d3.descending)
                .entries(data);
            var seriesMapDomain = d3.nest()
                .rollup(function (l) { return { "max": d3.max(l, function (ld) { return ld.qtd; }), "min": d3.min(l, function (ld) { return ld.qtd; }), "sum": d3.sum(l, function (ld) { return ld.qtd; }) } })
                .entries(data);
            var seriesSum = d3.nest()
                .key(function (d) { return d.sigla; })
                .rollup(function (l) { return { "sum": d3.sum(l, function (ld) { return ld.qtd; }) } })
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
                .attr("id", function (d) { return d.id; })
                .attr("class", "chart-uf-dot")
                .attr("r", 0)
                .style("opacity", 0.5)
                .attr("transform", function (d) { return "translate(" + map.centroid(d) + ")"; });

            var gBars = gC.append("g").attr("class", "chart-bars");

            gC.append("g")
                .attr("class", "axis axis-x")
                .attr("transform", "translate(0," + heightC + ")")
                .call(d3.axisBottom(xC).ticks(2, ".1%"));
            var yAxis = gC.append("g")
                .attr("class", "axis axis-y")
                .call(d3.axisLeft(yC));

            d3.select("#filter-tipo").on("change", function () {
                filter_tipo = this.value;
                filter();
            });
            d3.select("#filter-nivel").on("change", function () {
                filter_nivel = this.value;
                filter();
            });
            d3.select("#filter-poder").on("change", function () {
                filter_poder = this.value;
                filter();
            });
            d3.selectAll(".order-by").on("change", function () {
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
                d3.select("#chart-info-tipo").text(filter_tipo.toLowerCase() + "s");
                d3.select("#chart-info-nivel").text(filter_nivel.toLowerCase());
                d3.select("#chart-info-poder-prep").text(preposition);
                d3.select("#chart-info-poder").text(capitalizeFirstLetter(filter_poder));
                d3.select("#chart-info-qtd").text(qtd);
                d3.select("#chart-info-perc").text(d3.format(".1%")(qtd / sum));
                d3.select("#chart-pedidos-uf-info").style("display", null);
                return;
            }

            function capitalizeFirstLetter(s) {
                return s.charAt(0).toUpperCase() + s.slice(1).toLowerCase();
            }

            function filter() {
                var entries = _lodash.filter(data, function (d) { return (filter_tipo !== "--") ? d.status == filter_tipo : true });
                entries = _lodash.filter(entries, function (d) { return (filter_nivel !== "--") ? d.nivel == filter_nivel : true });
                entries = _lodash.filter(entries, function (d) { return (filter_poder !== "--") ? d.poder == filter_poder : true });
                entriesGroup = d3.nest()
                    .key(function (d) { return d.sigla; })
                    .rollup(function (l) { return { "sum": d3.sum(l, function (ld) { return ld.qtd; }) } })
                    .entries(entries);
                if (order_by == "uf") {
                    entriesGroup.sort(function (a, b) {
                        return d3.descending(a.key, b.key);
                    });
                } else {
                    entriesGroup.sort(function (a, b) {
                        var sA = _lodash.find(seriesSum, { key: a.key });
                        var sB = _lodash.find(seriesSum, { key: b.key });
                        return (b.value.sum / sB.value.sum) - (a.value.sum / sA.value.sum);
                    });
                }
                var entriesGroupSum = d3.sum(entries, function (d) { return d.qtd; });
                setInfo("Brasil", entriesGroupSum, seriesMapDomain.sum);

                yC.domain(entriesGroup.map(function (d) { return d.key }));
                yAxis.call(d3.axisLeft(yC));

                gBars.selectAll(".chart-bar").remove();
                gBars.selectAll(".chart-bar-text").remove();
                var bars = gBars.selectAll(".chart-bar")
                    .data(entriesGroup)
                    .enter().append("rect")
                    .attr("id", function (d) { return "bar-" + d.key; })
                    .attr("class", "chart-bar")
                    .attr("x", 0)
                    .attr("y", function (d) { return yC(d.key); })
                    .attr("height", yC.bandwidth())
                    .attr("width", 0)
                    .attr("opacity", 0.5);
                var texts = gBars.selectAll(".chart-bar-text")
                    .data(entriesGroup)
                    .enter().append("text")
                    .attr("id", function (d) { return "bar-text-" + d.key; })
                    .attr("class", "chart-bar-text")
                    .attr("x", function (d) {
                        var s = _lodash.find(seriesSum, { key: d.key });
                        return xC(d.value.sum / s.value.sum) + 5;
                    })
                    .attr("y", function (d) { return yC(d.key) + (yC.bandwidth() * 0.5); })
                    .attr("dy", "0.5em")
                    .style("opacity", 0)
                    .text(function (d) { return d.value.sum + " pedidos"; });

                gB.selectAll(".chart-uf-dot").attr("r", 0);
                entriesGroup.forEach(function (e) {
                    var s = _lodash.find(seriesSum, { key: e.key });
                    if (s.value.sum > 0) {
                        d3.select("#" + e.key).transition(500).attr("r", mapScale(e.value.sum / s.value.sum));
                        d3.select("#bar-" + e.key).transition(500).attr("width", xC(e.value.sum / s.value.sum));
                        d3.select("#" + e.key)
                            .on("mouseover", function (d) {
                                d3.select(this).style("opacity", 1);
                                d3.select("#bar-" + e.key).style("opacity", 1);
                                d3.select("#bar-text-" + e.key).style("opacity", 1);
                                setInfo(_lodash.find(unidadesFederativas, { Sigla: e.key }).Nome, e.value.sum, s.value.sum);
                            })
                            .on("mouseout", function (d) {
                                d3.select(this).style("opacity", 0.5);
                                d3.select("#bar-" + e.key).style("opacity", 0.5);
                                d3.select("#bar-text-" + e.key).style("opacity", 0);
                                setInfo("Brasil", entriesGroupSum, seriesMapDomain.sum);
                            });
                        d3.select("#bar-" + e.key)
                            .on("mouseover", function (d) {
                                d3.select(this).style("opacity", 1);
                                d3.select("#" + e.key).style("opacity", 1);
                                d3.select("#bar-text-" + e.key).style("opacity", 1);
                                if (d.key == "Órgãos Federais") {
                                    var title = "Órgãos Federais"
                                } else {
                                    var title = _lodash.find(unidadesFederativas, { Sigla: e.key }).Nome
                                }
                                setInfo(title, e.value.sum, s.value.sum);
                            })
                            .on("mouseout", function (d) {
                                d3.select(this).style("opacity", 0.5);
                                d3.select("#" + e.key).style("opacity", 0.5);
                                d3.select("#bar-text-" + e.key).style("opacity", 0);
                                setInfo("Brasil", entriesGroupSum, seriesMapDomain.sum);
                            });
                    }
                });
            }
            filter();
        });
    }

    d3.json("/assets/data/br.json", drawMap);
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

    d3.json("/api/pedidosTempoMedioDeTramitacao", draw);
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
    d3.json("/api/taxaDeReversao", draw);
})();
