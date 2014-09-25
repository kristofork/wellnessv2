$(document).ready(function() {

    $("#points_hidden").attr('value', '2');

    $(".intensity label.btn").click(function(e) {
        e.preventDefault();
        /* Points summary */
        var sliderTime = $("#time_value").text();
        var intensity = $(this).children('input').val();
        $('.intensity input#hiddenintensity').val(intensity);
        var points = 0;

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

    })
});
