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
                        text: 'Total percent market share'
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
                    name: 'Browsers',
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