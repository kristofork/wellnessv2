$(document).ready(function () {

    // Submit Activity AJAX
    $("button#submitact").click(function (e) {
        e.preventDefault();
        var actdate = $("#activity_datepicker").prop('value');
        var acttime = $("#time_val").val();
        var actintensity = $("#hiddenintensity").val();
        var actname = $("#activity_text_input").prop('value');
        var actpts = $("#points_hidden").prop('value');
        var type = "time";
        var dataString = 'actdate=' + actdate + '&acttime=' + acttime + '&actintensity=' + actintensity + '&factpt=' + actpts + '&actname=' + actname + '&type=' + type;
        var now = jQuery.timeago(new Date());

        $.ajax({
            type: "POST",
            url: "activity/" + dataString,
            data: dataString,
            cache: false,
            dataType: "json",
            beforeSend: function () {
                // Disable the submit button
                $('button#submitact').prop('disabled', true);
                NProgress.configure({ showSpinner: false });
                NProgress.start();// Show the spinner  ;   
            },
            complete: function () {
                // Hide the spinner
            },
            success: function (result) {
                setTimeout(function () {
                    NProgress.done();
                    if (result.success == true) {
                        if(result.badge){
                            weightChart.updateChart();
                            $('.popover-markup>.trigger').popover('hide');
                            $('div#modal-badge-data').html("<h4>"+result.name+"</h4><img src='/assets/img/badges/" + result.image + "'> <p>Level "+ result.lvl +" : " +result.goal+" lbs</p>");
                        $('#badgeModal').modal({show:true});
                        }
                        console.log('Success!');
                        // Update the Time for the day and week with limits
                        getTime(actdate);
                        // Reset the form
                        $("#activity_datepicker").datepicker('setDate', new Date());
                        $("span#date_value").replaceWith("Today");
                        $("input#activity_text_input").val("");
                        $("#time_slider2").slider("value", $("#time_slider2").slider("option", "min"));
                        $("span#time_value").text("00:15:00");
                        $("#time_val").val("00:15:00");
                        $(".intensity").find(".active").removeClass("active");
                        $(".intensity label.moderate").addClass("active");
                        $("input#hiddenintensity").val("2");
                        $("input#points_hidden").val("2");
                        $("span#points_value").text("2");
                        // enable the submit button
                        $('button#submitact').prop('disabled', false);
                    } else {
                        $.each(result, function (index, value) {
                                
                            html = "<div id='dash-side-right' class='alert alert-custom'>";
                            html += "<button type='button' class='close' data-dismiss='alert'>x</button>";
                            html += "<ul class='log_errors'>";
                            html += "<li>" + value + "</li></ul></div>";
                            $("div.headbar").after(html);

                        })
                    }
                }, 5000); // End of timeout
            }
        });
    })



    
    $("button#goalsubmit").click(function (e) {
        e.preventDefault();
        var oz = $("#weight_val").val();
        var dataString = 'progress=' + oz;

        $.ajax({
            type: "POST",
            url: "goal/update_progress",
            data: dataString,
            cache: false,
            dataType: "json",

            success: function (result) {
                $('button#goalsubmit[type="submit"]').attr('disabled', 'disabled');
                $("#weight_slider").slider("disable");
            }
        })

    })

});