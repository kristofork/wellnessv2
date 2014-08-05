jQuery(document).ready(function() {
    jQuery("abbr.timeago").timeago();
});

$(document).ready(function() {

    $('#escapingBallG').hide(); // Hide the spinner
    $('img#teamUserPic').tooltip();
    $('.activityLikeImg img').tooltip({
        placement: "top"
    });
    $('.moreNames span').tooltip({
        placement: "bottom"
    });
    $('#team-progress').tooltip();
    $('.like-heart').tooltip({
        placement: "right"
    });

    // Navigation - return page to the top
    $("a[href='#top']").click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        return false;
    });

    var config = {
        over: cardover,
        out: cardout,
        interval: 200,
        timeout: 200,
    };
    //Hovercard code
    $('span[rel="hovercard"]').hoverIntent(config);

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

                $('.hovercard').html('<span id="hovercard-bg"><img id="bg" class="bg" src="../assets/img/site/bg/bg-02.jpg"><img class="img-circle" id="profileImg" src=' + data.pic + '></span><h3>' + eval('data.userFirst') + ' ' + eval('data.userLast') + '</h3>' + '<div id="memberDate" class="col-md-offset-4 col-md-2"><span class="glyphicon glyphicon-calendar"></span><span>' + data.year + '</span></div><div id="memberDate" class="col-md-offset-1 col-md-2"><span class="glyphicon glyphicon-time"></span><span>' + data.time + '</span></div><div id="memberDate" class="col-md-offset-1 col-md-2"><span class="glyphicon glyphicon-stats"></span><span>' + data.activities + '</span></div><span id="label">' + data.title + '</span><span id="points">205/1000</span><div id="progress"><div class="bar" id = "reward_1" style="width:10%">10%</div></div>');

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

    // Applaud
    $(".applaud").bind('oanimationend animationend webkitAnimationEnd', function(event) {
        var id = parseInt($(this).attr('id'));
        $.ajax({
            type: "POST",
            data: id,
            dataType: "json",
            url: "applaud/" + id,
            success: function(data) {
                // Extracts data from array
                imgpath = data.pic;
                countnum = data.newCount;
                // create the html img for the user
                var userimg = '<img id="likeUserPic" src="../' + imgpath + '">';
                $("#" + id + ".applaud").hide(); // Takes away applaud spinner
                if ($("#" + id + ".activityLikeImg").length == 0) // if div does NOT exist
                {
                    $("li#" + id).after("<div class='likecount' id=" + id + "></div><div class='activityLikeImg' id=" + id + "></div>");
                }
                // Update animation of new like count
                $("#" + id + ".likecount").fadeOut('slow', function() {
                    $("#" + id + ".likecount").html(countnum);
                    $("#" + id + ".likecount").fadeIn('slow');
                });
                // Slide in user img from right to left.
                $(userimg).hide().css({
                    "margin-left": "100%"
                }).appendTo("#" + id + ".activityLikeImg").show().animate({
                    "margin-left": "0%"
                }, 1500, "easeOutBounce");
            }
        });
        $(this).unbind('oanimationend animationend webkitAnimationEnd');
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
// Converts seconds to time format -  00:00
function secondsToTime(sec) {
    var h = Math.floor(sec / 3600); //Get whole hours
    sec -= h * 3600;
    var m = Math.floor(sec / 60); //Get remaining minutes
    sec -= m * 60;
    return h + ":" + (m < 10 ? '0' + m : m); //zero padding on minutes and seconds
}

// Condense applaud names
function ApplaudMoreNames($id) {
    for (var i = 0, l = moreNamesList.length; i < l; i++) {
        var orginTitle = $("#" + $id + ".moreNames span").attr("title");
        $("#" + $id + ".moreNames span").attr("title", orginTitle + moreNamesList[i] + ", ");
    }
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
    var weekTime = $(".time-list span#week").text();
    var weekSeconds = timeToSeconds(weekTime);
    var dayTime = $(".time-list span#day").text();
    var daySeconds = timeToSeconds(dayTime);
    var weekMax = (28800 - weekSeconds) / 60;
    var dayMax = (7200 - daySeconds) / 60;
    var weekValue = secondsToTime(28800 - weekSeconds);
    if (daySeconds == 7200 && weekSeconds == 28800) { // Day and week limits are reached
        $('button#submit[type="submit"]').attr('disabled', 'disabled');
        $("span#week, span#day").css("color", "red");
        $("#time_slider").slider("option", "disabled", true);
    } else if (daySeconds >= 7200) { // Day limit is reached
        $('button#submit[type="submit"]').attr('disabled', 'disabled');
        $("span#day").css("color", "red");
        $("#time_slider").slider("option", "disabled", true);
    } else if (weekSeconds >= 28800) // Week limit is reached
    {
        $('button#submit[type="submit"]').attr('disabled', 'disabled');
        $("span#week, span#day").css("color", "red");
        $("#time_slider").slider("option", "disabled", true);
    } else {
        if (weekMax < dayMax) {
            newMax = weekMax;
        } else {
            newMax = dayMax;
        }
        $("#time_slider").slider({
            max: newMax
        });
        $("#time_val").attr('value', "00:15:00");
        $("#time_value").text("00:15:00");
        $('button#submit[type="submit"]').removeAttr('disabled');
        $("#time_slider").slider("option", "disabled", false);
        $("span#week, span#day").css("color", "rgb(85, 253, 85)");
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