function teamChart() {
    $.ajax({
        type: "GET",
        url: "/team-donut",
        success: function(json) {
            // Create the chart
            chart = new Highcharts.Chart({
                credits:{
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
    $.ajax({
        type: "GET",
        url: "/user-activity/" + url[4],
        success: function(json) {
            chart = new Highcharts.Chart({
                credits: {
                    enabled: false
                },
                chart: {
                    renderTo: 'container',
                    type: 'line',
                    marginRight: 130,
                    marginBottom: 25
                },
                title: {
                    text: 'Activity Time',
                    x: -20 //center
                },
                subtitle: {
                    text: '',
                    x: -20
                },
                xAxis: {
                    categories: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May']
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Hours'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.series.name + '</b><br/>' +
                            this.x + ': ' + this.y;
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -10,
                    y: 100,
                    borderWidth: 0
                },
                series: json
            });
        }
    });
    }