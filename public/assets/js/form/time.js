$(document).ready(function($) {
    $("#time_val").attr('value', '00:15:00');
    var p = {
        0: "00:15:00"
    };
    function SummaryTime(ui){
            var hours = Math.floor(ui.value / 60);
            var minutes = ui.value - (hours * 60);
            if (minutes == 0) minutes = '00';
            if (hours.length == 1) hours = '0' + hours;
            if (minutes.length == 1) minutes = '0' + minutes;
            $("#time_val").val('0' + hours + ':' + minutes + ':00');
            $("#time_value").text('0' + hours + ':' + minutes + ':00');
    }
    function SummaryPoints(){
                    /* Points summary */
            var sliderTime = $("#time_value").text();
            var intensity = $(".btn-group label.active").children('input').attr("value");
            var points = 2;
            switch (sliderTime) {
                case "00:15:00":
                    points = 1 * intensity;
                    break;
                case "00:30:00":
                    points = 2 * intensity;
                    break;
                case "00:45:00":
                    points = 3 * intensity;
                    break;
                case "01:00:00":
                    points = 4 * intensity;
                    break;
                case "01:15:00":
                    points = 5 * intensity;
                    break;
                case "01:30:00":
                    points = 6 * intensity;
                    break;
                case "01:45:00":
                    points = 7 * intensity;
                    break;
                case "02:00:00":
                    points = 8 * intensity;
                    break;
                default:
                    points = 0;
                    break;
            }
            $("#points_value").text(points);
            $("#points_hidden").val(points);
    }

    $("#time_slider").slider({
        min: 15,
        max: 120,
        step: 15,
        change: function(event, ui) {
            SummaryTime(ui);
            SummaryPoints();
        },
        slide: function(event, ui) {
            SummaryTime(ui);
            SummaryPoints();
        }
    });
    $("#time_slider").slider("pips").slider("float");

});