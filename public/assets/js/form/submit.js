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
                $('.bouncywrap').show(); // Show the spinner  ;   
            },
            complete: function () {
                // Hide the spinner
            },
            success: function (result) {
                setTimeout(function () {
                    $('.bouncywrap').hide();
                    if (result.success == true) {
                        var d = new Date();
                        var n = d.toISOString();
                        html = "<li class='activityItem'><div class='activityBox'>";
                        html += "<div class='recentActivityDesc'>";
                        html += "<div class='profilePicContainer'><span rel='hovercard' data-url='190'><div class='hovercard'></div><img id='profilePic' src='" + result.userpic + "' /></span></div>";
                        html += "<div class='recentActivityName'>" + result.firstname + " " + result.lastname.charAt(0) + "." + "</div>";
                        html += "<div class='recentActivityText'>Logged " + result.acttime + " of <strong>" + result.actname + "</strong> </div></div>";
                        html += "<div class='activityStatsContainer'>";
                        html += "<div class='timeContainer'><span class='glyphicon glyphicon-time' style='color:#55ffb6'></span> <abbr class='timeago' title='" + n + "'></abbr></div>";
                        html += "</div>"; // End of the activityStatsContainer
                        html += "<div class='activityIcon'><img src='/assets/img/badges/timeActivity.png' /></div>";
                        html += " </div></li><hr class='activityHR' />";

                        $(html).prependTo('ul.recentActivity').hide().slideDown("slow", function () {
                            $("li.activityItem, img#ajaximg").animate({
                                opacity: "1"
                            }, 600);
                        });

                        // Call Timeago
                        jQuery("abbr.timeago").timeago();
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
                            html = "<div class='alert alert-error' id='log_list' style='display: none'>";
                            html += "<button type='button' class='close' data-dismiss='alert'>x</button>";
                            html += "<ul class='log_errors'>";
                            html += "<li>" + value + "</li></ul></div>";
                            $("#activity_form.sidebar-nav").after(html);
                            $("#log_list").show().effect('shake');
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