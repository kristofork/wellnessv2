jQuery(document).ready(function() {
    jQuery("abbr.timeago").timeago();
});

$(document).ready(function() {
    $('.bouncywrap').hide();
    // Tooltips
    $('.activityLikeImg img').tooltip({placement: "top"});
    $('.moreNames span,span.flair').tooltip({placement: "bottom"});
    $('.like-heart').tooltip({placement: "right"});
    $("#day, #week, #date_value, div.intensity, #points, img#teamUserPic, #team-progress, span.flair").tooltip();

    // Navigation - return page to the top
    $("a[href='#top']").click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        return false;
    });

    //Hovercard code
    $('span[rel="hovercard"]').hoverIntent({
        over: cardover,
        out: cardout,
        interval: 200,
        timeout: 200,
    });
    function cardover(e) {
        $(this).children(".hovercard").fadeIn("slow");
        x = $(this).data('url');
        $.ajax({
            type: "GET",
            data: x,
            dataType: "json",
            url: "/hovercard/" + x,
            success: function(data) {
                var createdDate = new Date(data.created_at.date.replace(/-/g, "/"));
                var joined = createdDate.getFullYear();
                $('.hovercard').html('<span class="hovercard-bg"><img id="team-bg" src="../assets/img/teams/blur2.png"><img class="img-circle" id="profileImg" src=/' + data.pic + '></span><div class="row-centered" style="top:92px; position:relative"><h4 class="col-md-12">' + eval('data.userFirst') + ' ' + eval('data.userLast') + '</h4></div>' + '<div class="row-centered" style="top:80px; position:relative"><div id="memberDate" class="col-md-3"><div class="glyphicon glyphicon-calendar"></div><div>' + data.year + '</div></div><div id="memberDate" class="col-md-3"><div class="glyphicon glyphicon-time"></div><div>' + data.time + '</div></div><div id="memberDate" class="col-md-3"><div class="glyphicon glyphicon-stats"></div><div>' + data.activities + '</div></div><div id="memberDate" class="col-md-3"><div id="glyph-hover-points" class="glyphicons vcard"></div><div><span id="progress"><div class="bar" id="team-reward" style="width: 10%">10%</div></span></div></div></div><!-- End of Row-->');
                    
            }
        });
    }
    function cardout(e) {
        $(this).children(".hovercard").hide();
    }


    // Activity Feed Hover 
    $('.recentActivity li').hoverIntent(function() {
            $(this).children('div.timeContainer').animate({
                'color': 'rgba(255, 152, 0, 0.4)'
            }, 350, false);
            $(this).find('.activityIcon img').animate({
                'background-color': 'rgba(255, 152, 0, 0.4)'
            }, 350, false);
        },
        function() {
            $(this).children('div.timeContainer').animate({
                'color': 'rgba(255, 255, 255, 0.34)'
            }, 350, false);
            $(this).find('.activityIcon img').animate({
                'background-color': 'rgba(0, 0, 0, 0)'
            }, 350, false);
        });

    // Like System
    $(".like-heart").on('click', function(event) { // likeClass onClick 
        var id = parseInt($(this).attr('id'));      // get id from this activity
        $.ajax({                                    // create  ajax request to post with id from activity
            type: "POST",
            data: id,
            dataType: "json",
            url: "applaud/" + id,
            success: function(data) {
                // Extracts data from array
                countnum = data.newCount;         // Still need the updated count 
                $("#" + id + ".like-heart").hide(); // Takes away applaud spinner - (KEEP) to remove like button
                console.log($("#" + id + ".activityLikeImg").length);
                if ($("#" + id + ".activityLikeImg").length == 0)
                {
                    $("li#" + id + " .activityStatsContainer").append("<div class='activityLikeImg'><span class='glyphicon glyphicon-heart' style='color:#FF5566'></span><span class='like-count'></span></div>");
                }
                // Update animation of new like count   (Keep) 
                $("#" + id + " .like-count").fadeOut('slow', function() {
                    $("#" + id + " .like-count").html("&nbsp;"+countnum);
                    $("#" + id + " .like-count").fadeIn('slow');
                });
                var userCount = $("div#glyph-text.likes").data('count');
                userCount = userCount + 1;
                $("div#glyph-text.likes").data('count',userCount);
                $("div#glyph-text.likes").html(userCount);
            },
            error: function(data){
            console.log(data.responseText);
        }
        });
        return false;
    });
    
    
    
    
    
    // Initalize the date limits for time.
    datelimits();
    // Browser limitations
    checkIE();
}); // End of $(document).ready()


/* Setup Application functions */
// Converts time to seconds
function timeToSeconds(time) {
    time = time.split(/:/);
    return time[0] * 3600 + time[1] * 60;
}

function secToString(sec) {
    if (sec.length === 0) {
        return 0;
    }
    if (60 < sec && sec <= 3600) {
        return Math.floor(sec / 60) + ' minutes';
    }
    if (3600 < sec && sec <= 86400) {
        return Math.floor(sec / 3600) + ' hours';
    }
}

// Converts seconds to time format -  00:00
function secondsToTime(sec) {
    var h = Math.floor(sec / 3600); //Get whole hours
    sec -= h * 3600;
    var m = Math.floor(sec / 60); //Get remaining minutes
    sec -= m * 60;
    return h + ":" + (m < 10 ? '0' + m : m); //zero padding on minutes and seconds
}



// Ajax to grab team info after a member was clicked.
$("a.navProfileLink").click(function(e) {
    e.preventDefault();
    var id = $(this).parent().attr("id");
    console.log(id);
    $.ajax({
        type: "GET",
        url: "user-info/" + id,
        success: function(result) {
            console.log('Success');
        }
    })

    var chart = new CanvasJS.Chart("chartContainer", {
        height: 250,
        title: {
            text: "Team Donut Chart"
        },
        data: [{
            type: "doughnut",
            dataPoints: [{
                y: 53.37,
                indexLabel: "Glenn"
            }, {
                y: 35.0,
                indexLabel: "Greg"
            }, {
                y: 7,
                indexLabel: "Bill"
            }, {
                y: 2,
                indexLabel: "Jennifer"
            }, {
                y: 5,
                indexLabel: "Others"
            }]
        }]
    });

    chart.render();

});

// Ajax to grab current amount of time for the day and week
function getTime(dateSelected) {
    $.ajax({
        type: "GET",
        url: "activitycheck/" + dateSelected,
        success: function(result) {
            var weekSecToMin = secondsToTime(result.weektotal[0].weekTotal);
            var daySecToMin = secondsToTime(result.daytotal[0].DayTotal);
            $("span#day").text(daySecToMin);
            $("span#week").text(weekSecToMin);
            datelimits();
        }
    });
}

//Ajax to check if user submitted a goal this week
function getGoal() {
    $.ajax({
        type: "GET",
        url: "goal/check",
        success: function(result) {
            if (result.message != "") {
                $('button#goalsubmit[type="submit"]').attr('disabled', 'disabled');
                $("#weight_slider").slider("disable");

            }
        }
    });
}


// Week and Day Restrictions
function datelimits() {
    var weekTime = $(".logDataCol span#week").text();
    var weekSeconds = timeToSeconds(weekTime);
    var dayTime = $(".logDataCol span#day").text();
    var daySeconds = timeToSeconds(dayTime);
    var weekMax = (28800 - weekSeconds) / 60;
    var dayMax = (7200 - daySeconds) / 60;
    var weekValue = secondsToTime(28800 - weekSeconds);
    if (daySeconds == 7200 && weekSeconds == 28800) { // Day and week limits are reached
        $('button#submitact[type="submit"]').attr('disabled', 'disabled');
        $("span#week, span#day").css("color", "#f27264");
        $("#time_slider2").slider("option", "disabled", true);
    } else if (daySeconds >= 7200) { // Day limit is reached
        $('button#submitact[type="submit"]').attr('disabled', 'disabled');
        $("span#day").css("color", "#f27264");
        $("#time_slider2").slider("option", "disabled", true);
    } else if (weekSeconds >= 28800) // Week limit is reached
    {
        $('button#submitact[type="submit"]').attr('disabled', 'disabled');
        $("span#week, span#day").css("color", "#f27264");
        $("#time_slider2").slider("option", "disabled", true);
    } else {
        if (weekMax < dayMax) {
            newMax = weekMax;
        } else {
            newMax = dayMax;
        }
        $("#time_slider2").slider({
            max: newMax
        });
        $("#time_slider2").slider("pips");
        $("#time_val").attr('value', "00:15:00");
        $("#time_value").text("00:15:00");
        $('button#submitact[type="submit"]').removeAttr('disabled');
        $("#time_slider2").slider("option", "disabled", false);
        $("span#week, span#day").css("color", "#7de0ae");
    }
}
//IE Check
function checkIE() {
    var oldIE = false;
    if ($('html').is('.badIE')) {
        oldIE = true;
    }
    if (oldIE) {
        $('#browser').modal('show');
        $('.browser-icon').tooltip();
        $('input#loginBtn[type="submit"]').attr('disabled', 'disabled');
    }
}
