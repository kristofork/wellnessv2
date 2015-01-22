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
    
var color = d3.scale.category10();
      
var margin = {top: 20,right: 20, bottom: 30, left: 30},
width = 450,
height = 150;

    
var monthNum = d3.time.format("%b");

data.forEach(function(kv) {
        kv.forEach(function(d){ 
        d.month_number = d3.time.format("%m").parse("" + (+d.month_number));
        d.month_number = monthNum(d.month_number);    
        d.time = +d.time;
        });
});

var div = d3.select("body").append("div").attr("class", "tooltip")
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
        .attr('preserveAspectRatio','xMinYMin')
        .attr('viewBox','0 0 500 200' )
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
    
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
        .attr("cx", function(d) {
            return x(d.month_number);
        })
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
