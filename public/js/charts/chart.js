function teamChart() {
    $.ajax({
        type: "GET",
        url: "/team-donut",
        success: function(json) {
            // Create the chart
            chart = new Highcharts.Chart({
                credits: {
                    enabled: false
                },
                chart: {
                    renderTo: 'donutChart',
                    type: 'pie'
                },
                title: {
                    text: 'Team Performance'
                },
                yAxis: {
                    title: {
                        text: 'Total percent of activity'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer'
                    }
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.point.name + '</b>: ' + this.y + ' %';
                    }
                },
                series: [{
                    name: 'Team Members',
                    data: json,
                    size: '60%',
                    innerSize: '30%',
                    showInLegend: true,
                    dataLabels: {
                        enabled: true
                    }
                }]
            });
        }
    })
}

function activityChart() {
var url = window.location.href.split('/');
d3.xhr("/user-activity/" + url[4], function(data) {
data = JSON.parse(data.responseText);
    
console.log(data);
    
var color = d3.scale.category10();
      
var margin = {top: 20,right: 10, bottom: 0, left: 30}, // 20 20 10 30
width = 630,
height = 250;

//630
//250
    
var monthNum = d3.time.format("%b");

data.forEach(function(kv) {
        kv.forEach(function(d){ 
        d.month_number = d3.time.format("%m").parse("" + (+d.month_number));
        d.month_number = monthNum(d.month_number);    
        d.time = +d.time;
        });
});

var div = d3.select("body").append("div").attr("class", "tooltip").attr('id','chart-tooltip')
	    .style("opacity", 0);
    
    var y = d3.scale.linear()
        .domain([0, 40])
        .range([height, 0]);
    var yAxis = d3.svg.axis()
        .scale(y)
        .orient("left")
        
        .innerTickSize(-width)
        .outerTickSize(0)
        .tickPadding(10);
        

    var x = d3.scale.ordinal()
        .domain(['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May'])
        .rangePoints([0, width]);

    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom")
        .innerTickSize(-height)
        .outerTickSize(0)
        .tickPadding(10);

    var line = d3.svg.line()
        
        .x(function(d) { return x(d.month_number); })
        .y(function(d) { return y(d.time); });


    var svg = d3.select("#chart-container")
        .append("svg")
        .attr('preserveAspectRatio','xMinYMin meet')
        .attr('viewBox','0 0 700 300' )
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
    
    var title = svg.append("text")
        .attr("x", (width / 2))
        .attr("y", 0 - (margin.top / 2))
        .attr("text-anchor","middle")
        .style("font-size", "1.3em")
        .style("text-decoration", "underline")
        .text("Time: Current Year vs Last Year");
        

    svg.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height + ")")
        .call(xAxis);
    
    svg.append("g")
        .attr("class", "y axis")
        .call(yAxis);

    var lines = svg.selectAll(".line")
        .data(data);
    
    var linesEnter = lines.enter().append("g")
        .attr("class", "time")
        .attr("id", function(d) {return d.name});

    
    var series = linesEnter.append("path")
        .attr("class", "line")
        .attr("d", line)
        .attr("stroke-width", 2)
        .style("stroke",function(d) { return color(d[0].name); });
    
    
    linesEnter.append("g").selectAll(".dot")
        .data(function(d) {return d})
        .enter().append('circle')
        .style("stroke", function (d) {return color(this.parentNode.__data__[0].name) })
        .attr('class', 'datapoint')
        .on("mouseover", function (d) {
            div.transition().duration(100).style("opacity",.9);
            div.html(this.parentNode.__data__[0].name + " Year <br />" + d.time + " hrs").style("left", (d3.event.pageX) + "px").style("top", (d3.event.pageY - 28) + "px").attr('r', 8);
                d3.select(this).attr('r', 8)
        })
        .on("mouseout", function (d) {
	        div.transition().duration(100).style("opacity", 0)
	        d3.select(this).attr('r', 5);
	    })
        .attr("r", 3.5)
        .attr("fill", "white").attr("fill-opacity",.5)
        .attr("cx", function(d) { return x(d.month_number);  })
        .attr("cy", function(d,i) { return y(d.time) });
    
    linesEnter.append("text")
    .attr("class", "names")
    .datum(function(d) { return {name: d[0].name, time: d[0].time, month_number: d[d.length -1].month_number }; })
    .attr("transform", function(d) { return "translate(" + x(d.month_number) + "," + y(d.time) + ")"; })
    .attr("x", 4)
    .text(function(d) {return d.name});


    var totalLength = series.node().getTotalLength();
    series
        .attr("stroke-dasharray", totalLength + " " + totalLength)
        .attr("stroke-dashoffset", totalLength)
        .transition()
        .duration(2000)
        .ease("linear")
        .attr("stroke-dashoffset", 0);
});
}

function weightChart(){
    function make_x_axis() {        
        return d3.svg.axis()
            .scale(x)
             .orient("bottom")
             .ticks(5)
    }

    function make_y_axis() {        
        return d3.svg.axis()
            .scale(y)
            .orient("left")
            .ticks(5)
    }


    var margin = {top: 5,right: 30, bottom: 5, left: 40},
    width = 630,
    height = 250;
    
    var parseDate = d3.time.format("%Y-%m-%d").parse;
    
    var div = d3.select("body").append("div").attr("class", "tooltip")
	    .style("opacity", 0);
    
    //var parseYMD = d3.time.format("%m/%d/%Y");
    
    var x = d3.time.scale()
        .range([0,width - 10]);
    
    var y = d3.scale.linear()
        .range([height, 0]);
    
    var xAxis = d3.svg.axis()
        .scale(x)
        .ticks(d3.time.days, 1)
        .tickFormat(d3.time.format("%m/%d"))
        .orient("bottom");
    
    var yAxis = d3.svg.axis()
        .scale(y)
        .ticks(5)
        .orient("left");
    
    var weightLine = d3.svg.line()
        .x(function(d) {return x(d.goal_date); })
        .y(function(d) {return y(d.weight); });

    var svg = d3.select("#chart-weight")
        .append("svg")
        .attr('preserveAspectRatio','xMinYMin')
        .attr('viewBox','0 0 700 300' )
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
    
    
    var url = window.location.href.split('/');
    
    d3.xhr("/user-weight/" + url[4], function(data) {
    data = JSON.parse(data.responseText); 
    
    data.forEach(function(d) {
       d.goal_date = d3.time.format("%Y-%m-%d").parse(d.goal_date);
       d.weight = +d.weight;
    });


    x.domain(d3.extent(data, function(d) { return d.goal_date; }));
    y.domain([data[data.length-1].goalline - 10,d3.max(data, function(d){ return d.weight; })]).nice();
    console.log( data[0].weight + 5);
    svg.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0, " + height + ")")
        .call(xAxis)
    .selectAll("text")  
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", ".15em")
            .attr("transform", function(d) {
                return "rotate(-65)" 
                });
        
    
    svg.append("g")
        .attr("class", "y axis")
        .call(yAxis)
    .append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin.left)
        .attr("x", 0 - (height / 2))
        .attr("dy", ".71em")
        .style("text-anchor", "middle")
        .text("Weight (lbs)");
        

    svg.append("g")         
        .attr("class", "x grid")
        .attr("transform", "translate(0," + height + ")")
        .call(make_x_axis()
            .tickSize(-height, 0, 0)
            .tickFormat("")
             )

    svg.append("g")         
        .attr("class", "y grid")
        .call(make_y_axis()
            .tickSize(-width + 10, 0, 0)
            .tickFormat("")
             )        
    
    svg.append("path")
        .datum(data)
        .attr("class", "line")
        .attr("stroke-width", 2)
        .style("stroke","#7de0ae")
        .attr("d", weightLine);

    var goalline = svg.selectAll(".goalline")
        .data(data);
        
    goalline.enter().append( "line" )
      .style("stroke-dasharray", "3,3")
      .style("stroke", "#f2c864")
      .attr("x1", x( x.domain()[0] ) )
      .attr("x2", x( x.domain()[1] ) )
      .attr("y1", function(d) { return y(d.goalline); })
      .attr("y2", function(d) { return y(d.goalline); });
                
        var points = svg.selectAll('.point').data(data);
        
        var pointsEnter = points
        .enter()
        .append("svg:circle")
        .style("stroke","#7de0ae")
        .on("mouseover", function (d) {
            div.transition().duration(100).style("opacity",.9);
            div.html(" Weight <br />" + d.weight + " lbs").style("left", (d3.event.pageX) + "px").style("top", (d3.event.pageY - 28) + "px").attr('r', 8);
                d3.select(this).attr('r', 8)
        })
        .on("mouseout", function (d) {
	        div.transition().duration(100).style("opacity", 0)
	        d3.select(this).attr('r', 5);
	    })
        .attr("fill", "white").attr("fill-opacity",.5)
        .attr('r', '3.5')
        .attr('cx', function(d) { return x(d.goal_date)})
        .attr('cy', function(d) { return y(d.weight) });

        
});       


function updateChart(){
        var url = window.location.href.split('/');
    d3.xhr("/user-weight/" + url[4], function(data) {
    data = JSON.parse(data.responseText); 
    data.forEach(function(d) {
       d.goal_date = d3.time.format("%Y-%m-%d").parse(d.goal_date);
       d.weight = +d.weight;
    });
    
        
    x.domain(d3.extent(data, function(d) { return d.goal_date; }));
    y.domain([data[data.length-1].goalline - 10,d3.max(data, function(d){ return d.weight; })]).nice();
        
    svg.select("g.y.grid")
            .call(make_y_axis()
            .tickSize(-width + 10, 0, 0)
            .tickFormat("")
             );
    svg.select("g.x.grid")
        .call(make_x_axis()
            .tickSize(-height, 0, 0)
            .tickFormat("")
             );
        
    var svg2 = d3.select("#chart-weight").transition();
    
        svg2.select(".line")
            .duration(750)
            .attr("d", weightLine(data));
    var circles = svg.selectAll("circle")
            .data(data);
        circles.transition()
            .attr('cx', function(d) { return x(d.goal_date)})
            .attr('cy', function(d) { return y(d.weight) });
        
        circles.enter()
            .append("svg:circle")
            .style("stroke","#7de0ae")
            .on("mouseover", function (d) {
                div.transition().duration(100).style("opacity",.9);
                div.html(" Weight <br />" + d.weight + " lbs").style("left", (d3.event.pageX) + "px").style("top", (d3.event.pageY - 28) + "px").attr('r', 8);
                    d3.select(this).attr('r', 8)
            })
            .on("mouseout", function (d) {
                div.transition().duration(100).style("opacity", 0)
                d3.select(this).attr('r', 5);
            })
            .attr("fill", "white").attr("fill-opacity",.5)
            .attr('r', '3.5')
            .attr('cx', function(d) { return x(d.goal_date)})
            .attr('cy', function(d) { return y(d.weight) });
        svg2.select(".x.axis")
            .duration(750)
            .call(xAxis)
            .selectAll("text")  
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", ".15em")
            .attr("transform", function(d) {
                return "rotate(-65)" 
                });
        svg2.select(".y.axis")
            .duration(750)
            .call(yAxis);
    });
} 
    weightChart.updateChart = updateChart;
}
