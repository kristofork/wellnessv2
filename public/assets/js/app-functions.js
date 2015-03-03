/*global $ */
// initialize Fullpage plugin  
function initFullPage() {
    $('#fullpage').fullpage({
        sectionsColor: ['#fff', '#ccdcff', '#7BAABE', 'whitesmoke', '#ccddff'],
        resize: false,
        anchors: ['home', 'login'],
        navigation: true,
        navigationTooltips: ['Welcome', 'Login']
    });
}


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
    var h, m;
    h = Math.floor(sec / 3600); //Get whole hours
    sec -= h * 3600;
    m = Math.floor(sec / 60); //Get remaining minutes
    sec -= m * 60;
    return h + ":" + (m < 10 ? '0' + m : m); //zero padding on minutes and seconds
}



// Ajax to grab team info after a member was clicked.
$("a.navProfileLink").click(function (e) {
    e.preventDefault();
    var id = $(this).parent().attr("id");
    $.ajax({
        type: "GET",
        url: "user-info/" + id,
        success: function (result) {

        }
    });
});

// Week and Day Restrictions
function datelimits() {
    var weekTime, weekSeconds, dayTime, daySeconds, weekMax, dayMax, weekValue, newMax;
    weekTime = $(".logDataCol span#week").text();
    weekSeconds = timeToSeconds(weekTime);
    dayTime = $(".logDataCol span#day").text();
    daySeconds = timeToSeconds(dayTime);
    weekMax = (28800 - weekSeconds) / 60;
    dayMax = (7200 - daySeconds) / 60;
    weekValue = secondsToTime(28800 - weekSeconds);
    if (daySeconds === 7200 && weekSeconds === 28800) { // Day and week limits are reached
        $('button#submitact[type="submit"]').attr('disabled', 'disabled');
        $("span#week, span#day").css("color", "#f27264");
        $("#time_slider2").slider("option", "disabled", true);
    } else if (daySeconds >= 7200) { // Day limit is reached
        $('button#submitact[type="submit"]').attr('disabled', 'disabled');
        $("span#day").css("color", "#f27264");
        $("#time_slider2").slider("option", "disabled", true);
    } else if (weekSeconds >= 28800) { // Week limit is reached
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

// Ajax to grab current amount of time for the day and week
function getTime(dateSelected) {
    $.ajax({
        type: "GET",
        url: "/activitycheck/" + dateSelected,
        success: function (result) {
            var weekSecToMin, daySecToMin;
            weekSecToMin = secondsToTime(result.weektotal[0].weekTotal);
            daySecToMin = secondsToTime(result.daytotal[0].DayTotal);
            $("span#day").text(daySecToMin);
            $("span#week").text(weekSecToMin);
            datelimits();
        }
    });
}

//get goal start date for goal datepicker
function goalStartDate() {
    var that = this;
    $.ajax({
        type: "GET",
        url: "/goal/start_date",
        success: function (result) {
            var date, year, month, day, startday, target;
            date = new Date(result.date);
            year = date.getFullYear();
            month = date.getMonth() + 1;
            day = date.getDate() + 1;
            startday = year + "," + month + "," + day;
            target = $(that.document).find(".hasDatepicker");
            $(target).datepicker('option', {
                minDate: new Date(startday)
            });
        }
    });
}

//IE Check
function checkIE() {
    var oldIE = false;
    if ($('html').is('.badIE')) {
        oldIE = true;
    }
    if (oldIE) {
        window.location.replace("/error");
    }
}

// check weight activity

function checkWeight(dateSelected) {
    $.ajax({
        type: "GET",
        url: "/weightcheck/" + dateSelected,
        success: function (result) {
            if (result.length !== 0) {
                $("button#weight_submit").prop("disabled", true);
            } else {
                $("button#weight_submit").prop("disabled", false);
            }
        }

    });
}

//Hovercard code
function cardover(e) {
    $(this).children(".hovercard").fadeIn("slow");
    var x = $(this).data('url');
    $.ajax({
        type: "GET",
        data: x,
        dataType: "json",
        url: "/hovercard/" + x,
        success: function (data) {
            var createdDate, joined;
            createdDate = new Date(data.created_at.date.replace(/-/g, "/"));
            joined = createdDate.getFullYear();
            $('.hovercard').html('<span class="hovercard-bg"><img id="team-bg" src="../assets/img/teams/blur2.png"><img class="img-circle" id="profileImg" src=' + data.pic + '></span><div class="row-centered" style="top:92px; position:relative"><h4 class="col-md-12">' + data.userFirst + ' ' + data.userLast + '</h4></div>' + '<div class="row-centered" style="top:80px; position:relative"><div id="memberDate" class="col-md-3"><div class="glyphicon glyphicon-calendar"></div><div>' + data.year + '</div></div><div id="memberDate" class="col-md-3"><div class="glyphicon glyphicon-time"></div><div>' + data.time + '</div></div><div id="memberDate" class="col-md-3"><div class="glyphicon glyphicon-stats"></div><div>' + data.activities + '</div></div><div id="memberDate" class="col-md-3"><div id="glyph-hover-points" class="glyphicons glyphicons-star"></div><div><span id="progress"><div class="bar" id="team-reward" style="width: 10%">10%</div></span></div></div></div><!-- End of Row-->');

        }
    });
}

function cardout(e) {
    $(this).children(".hovercard").hide();
}
// initialize hovercard
function initHoverCard() {

    $('span[rel="hovercard"]').hoverIntent({
        over: cardover,
        out: cardout,
        interval: 200,
        timeout: 200
    });
}

// Forms

/* Log Form */
function logForm() {
    // Text Input
    var predefinedActs = [
            "Hiking",
            "Yoga",
            "Zumba",
            "P90X",
            "Kick Boxing",
            "Swimming",
            "Yard Work",
            "Walk Dog",
            "Gardening",
            "Weight Training",
            "Elliptical",
            "Calisthenics",
            "Disc Golf",
            "Jogging",
            "Basketball"
        ];

    $("#activity_text_input").autocomplete({
        source: predefinedActs
    });


    // Intensity
    $("#points_hidden").attr('value', '2');

    $(".intensity label.btn").click(function (e) {
        $(this).addClass("current").siblings().removeClass("active");
        e.preventDefault();
        /* Points summary */
        var sliderTime, intensity, points;
        sliderTime = $("#time_value").text();
        intensity = $(this).children('input').val();
        $('.intensity input#hiddenintensity').val(intensity);
        points = 0;

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

    });


    // date picker helper

    function minDate() {
        var startDay, startMonth, startYear, endDay, endMonth, endYear, cDate, cMonth, cYear;
        startDay = 01;
        startMonth = 06;
        startYear = 0;
        endDay = 31;
        endMonth = 05;
        endYear = 0;
        cDate = new Date();
        cMonth = cDate.getMonth();
        cYear = cDate.getFullYear();
        if (cMonth >= 0 && cMonth <= 4) {
            startYear = cYear - 1;
            endYear = cYear;
        } else {
            startYear = cYear;
            endYear = cYear + 1;
        }
        var startDateFinal = startYear + "," + startMonth + "," + startDay;
        return startDateFinal;
        }
        /* Datepicker for logging */
    $("#activity_datepicker").datepicker({
        showOn: "button",
        buttonImage: "../assets/img/site/calendar-blk.png",
        buttonImageOnly: true,
        dateFormat: 'yy-mm-dd',
        altField: '#activity_datepicker',
        altFormat: 'yy-mm-dd',
        minDate: new Date(minDate()),
        maxDate: new Date(),
        beforeSend: function () {

        },
        complete: function () {

        },
        onSelect: function (dateText, inst) {
            var theDate, dateSelected, dateFormatted;
            theDate = new Date(Date.parse($(this).datepicker('getDate')));
            dateSelected = $.datepicker.formatDate('yy-mm-dd', theDate);
            dateFormatted = $.datepicker.formatDate('MM d, yy', theDate); // Ex. November 11, 2013
            $("#date_value").text(dateFormatted);
            // Reset slider back to starting position
            $("#time_slider2").slider({
                value: 15
            });
            $.ajax({
                type: "GET",
                url: "activitycheck/" + dateSelected,
                success: function (result) {
                    var weekSecToMin = secondsToTime(result.weektotal[0].weekTotal);
                    var daySecToMin = secondsToTime(result.daytotal[0].DayTotal);
                    $("span#day").text(daySecToMin);
                    $("span#week").text(weekSecToMin);
                    datelimits();
                }
            });
        }
    });

    var currentdate = $("#activity_datepicker").datepicker('setDate', new Date());

    // Onload grab Current day and week numbers.
    var dateSelected = $("#activity_datepicker").prop('value');
    getTime(dateSelected);


    /* Form: Time */

    function SummaryTime(ui) {
        var hours = Math.floor(ui.value / 60);
        var minutes = ui.value - (hours * 60);
        if (minutes === 0) minutes = '00';
        if (hours.length === 1) hours = '0' + hours;
        if (minutes.length === 1) minutes = '0' + minutes;
        $("#time_val").val('0' + hours + ':' + minutes + ':00');
        $("#time_value").text('0' + hours + ':' + minutes + ':00');
    }

    function SummaryPoints() {
        var sliderTime, intensity, points;
        /* Points summary */
        sliderTime = $("#time_value").text();
        intensity = $(".btn-group-xs label.active").children('input').attr("value");
        points = 2;
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
    $("#time_slider2").slider({
        min: 15,
        max: 120,
        step: 15,
        change: function (event, ui) {
            SummaryTime(ui);
            SummaryPoints();
        },
        slide: function (event, ui) {
            SummaryTime(ui);
            SummaryPoints();
        }
    });

    $("#time_slider2").slider("pips");


    // Submit Activity AJAX
    $("button#submitact").click(function (e) {
        e.preventDefault();
        var actdate, acttime, actintensity, actname, actpts, type, dataString, now;
        actdate = $("#activity_datepicker").prop('value');
        acttime = $("#time_val").val();
        actintensity = $("#hiddenintensity").val();
        actname = $("#activity_text_input").prop('value');
        actpts = $("#points_hidden").prop('value');
        type = "time";
        dataString = 'actdate=' + actdate + '&acttime=' + acttime + '&actintensity=' + actintensity + '&factpt=' + actpts + '&actname=' + actname + '&type=' + type;
        now = jQuery.timeago(new Date());

        $.ajax({
            type: "POST",
            url: "activity/" + dataString,
            data: dataString,
            cache: false,
            dataType: "json",
            beforeSend: function () {
                // Disable the submit button
                $('button#submitact').prop('disabled', true);
                NProgress.configure({
                    showSpinner: false
                });
                NProgress.start(); // Show the spinner  ;   
            },
            complete: function () {
                // Hide the spinner
            },
            success: function (result) {
                setTimeout(function () {
                    NProgress.done();
                    if (result.success === true) {
                        // if user earned badge
                        if (result.badge) {
                            $('div#modal-badge-data').html("<h4>" + result.name + "</h4><img src='/assets/img/badges/" + result.image + "'> <p>Level " + result.lvl + " : " + result.goal + " hrs</p>");
                            $('#badgeModal').modal({
                                show: true
                            });
                        }
                        // Update the Time for the day and week with limits
                        getTime(actdate);
                        // Reset the form
                        $("#activity_datepicker").datepicker('setDate', new Date());
                        $("span#date_value").text("Today");
                        $("input#activity_text_input").val("");
                        $("#time_slider2").slider("value", $("#time_slider2").slider("option", "min"));
                        $("span#time_value").text("00:15:00");
                        $("#time_val").val("00:15:00");
                        $(".intensity").find(".active").removeClass("active");
                        $(".intensity label.moderate").addClass("active");
                        $("input#hiddenintensity").val("2");
                        $("input#points_hidden").val("2");
                        $("span#points_value").text("2");
                        // Onload grab Current day and week numbers.
                        var dateSelected = $("#activity_datepicker").prop('value');
                        getTime(dateSelected);
                        // enable the submit button
                        $('button#submitact').prop('disabled', false);
                    } else {
                        $.each(result, function (index, value) {
                            var html;
                            html = "<div id='dash-side-right' class='alert alert-custom'>";
                            html += "<button type='button' class='close' data-dismiss='alert'>x</button>";
                            html += "<ul class='log_errors'>";
                            html += "<li>" + value + "</li></ul></div>";
                            $("div.headbar").after(html);
                        });
                    }
                }, 5000); // End of timeout
            }
        });
    });
/*   END OF LOG FORM    */
    
}

function ActivityFilter() {


    // Type Filter (User, Team, Everyone)
$('div.activity-type label.btn').on('click', function (e) {
    //e.preventDefault();

    var loaded, value;
    // disable the buttons
    $('.activity-type label.btn').attr('disabled', 'disabled');
    // set variable to the number that is loaded. Default is 10
    loaded = $(this).attr('num_loaded');
    // Change the value from a string to a int
    loaded = parseInt(loaded, 10);

    NProgress.configure({
        showSpinner: false,
        speed: 400
    });
    NProgress.start(); // Show the spinner  ;   

    value = $(this).find("input").val();
    $.get("/activity-filter/" + value, function (data) {

        $('.recentActivity').find('*').not('.recentheader, .recentheader *').remove(); // remove all activities from feed

    }).done(function (data) {
        
        var userid = data.user;

        setTimeout(function () {
            NProgress.done();

            // Loop through the data array and add to the end of the ul
            $.each(data.activities, function (item, val) {
                var userdata, d, n, html;
                userdata = val.user;
                d = new Date(val.created_at.replace(/-/g, "/"));
                n = d.toISOString();

                html = "<div id='recent_activity_container' class='col-md-8 col-sm-11 col-centered' >";
                html += "<li id='" + val.id + "'>";
                html += "<div class='activityBox'>";
                html += "<div class='recentActivityDesc'>";
                html += "<div class='profilePicContainer'>";
                html += "<span rel='hovercard' data-url=" + val.user_id + "><div class='hovercard'></div>";
                html += "<img id='profilePic' src=/" + userdata.pic + " /></span></div>";
                html += "<div class='recentActivityName'>" + userdata.first_name + " " + userdata.last_name.charAt(0) + ". </div>";
                // if Badge

                if (val.user.badgeuser.length > 0) {
                    var badge_data = val.user.badgeuser[0];
                    html += "<div id='container-flair'>";
                    html += "<span class='sprite-flair_" + badge_data.type + "_" + badge_data.lvl + "' title='" + badge_data.desc + "'></span>";
                    html += "</div>";
                    $("div#container-flair span").tooltip({
                        placement: "bottom"
                    });

                }

                if (val.type === "time") {
                    html += "<div class='recentActivityText'>Logged " + secToString(timeToSeconds(val.activity_time)) + " of <strong>" + val.activity_name + " </strong></div></div>";
                } else if (val.type === "read") {
                    html += "<div class='recentActivityText'>Read <a href='/blog'>" + val.activity_name + " </a></div></div>";
                } else {
                    html += "<div class='recentActivityText'>" + val.activity_name + "</div></div>";
                }

                html += "<div class='activityStatsContainer'>";
                html += "<div class='timeContainer'><span class='glyphicon glyphicon-time'></span><abbr class='timeago' title='" + n + "'>&nbsp;</abbr></div>";
                if (userid !== val.user_id && val.likes.length === 0) {
                    html += "<div class='toLikeImg'>";
                    html += "<div class='glyphicon glyphicon-heart like-heart' id='" + val.id + "' title='Click to like!'></div>";
                    html += "</div>";
                } else {
                    html += "<div class='activityLikeImg' id='" + val.id + "'>";
                    html += "<span class='glyphicon glyphicon-heart' style='color:#F563A1'></span>";
                    html += "<span class='like-count'>&nbsp;" + val.likeCount + "</span>";
                    html += "</div>";
                }
                html += "";
                html += "</div>";
                if (val.type === "time") {
                    html += "<div class='activityIcon'><img src='/assets/img/badges/timeActivity.png'/></div>";
                } else if (val.type === "read") {
                    html += "<div class='activityIcon'><img src='/assets/img/badges/readActivity.png'/></div>";
                } else {
                    html += "<div class='activityIcon'><img src='/assets/img/badges/goalActivity.png'/></div>";
                }
                html += "</div></li></div>";

                $(html).appendTo('ul.recentActivity').hide().slideDown("slow", function () {
                    $("li.activityItem, img#ajaximg").animate({
                        opacity: "1"
                    }, 800);
                });

                // We need to refresh the list so that the JQM styles are applied
                //$('#actlist').listview('refresh');
            }); // end of for each
            $('.activity-type label.btn').removeAttr('disabled'); // enable buttons
        }, 1000); // End of timeout


        jQuery("abbr.timeago").timeago();
        initHoverCard();
        // Since the ajax call was successful we set the loaded variable + 10
        // So next time the user clicks the loadmore button we call for results from 11-20
        loaded += 10;
        // check to see if the array is empty
        var empty = $.isEmptyObject(data);
        if (empty === true) {
            // Remove the button if the array is empty
            $('li#more').remove();
        } else {
            //move button to the end of the list
            $('li#more').appendTo($('ul.recentActivity'));
            // Set the num_loaded attribute to the new value
            $('li#more').attr('num_loaded', loaded);
        }

    });
});
}

    /* Like System */
function Like() {
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
                $("#" + id + ".like-heart").hide(); // remove like button
                console.log($("#" + id + ".activityLikeImg").length);
                if ($("#" + id + ".activityLikeImg").length == 0)
                {
                    $("li#" + id + " .activityStatsContainer").append("<div class='activityLikeImg'><span class='glyphicon glyphicon-heart' style='color:#FF5566'></span><span class='like-count'></span></div>");
                }
                // Update animation of new like count 
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
}

function ActivityHover() {
    /* Activity Feed Hover */
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

}

function weightChallengeDataEntry() {    
    
/* Popover for challengebar */
var tmp = $.fn.popover.Constructor.prototype.show;
$.fn.popover.Constructor.prototype.show = function () {
  tmp.call(this);
  if (this.options.callback) {
    this.options.callback();
  }
}
    $('.popover-markup>.trigger').popover({
    html: true,
    title: function () {
        return $(this).parent().find('.head').html();
    },
    content: function () {
        return $(this).parent().find('.content').html();
    },
    callback: function() {
        
       $("button#weight_submit").click(function(e) {
       e.preventDefault();
            
        var date = $("#weight_datepicker").prop('value'); // get date
        var weight = $("input#weight").prop('value');     // get weight
        var regexp = /^\d{2,3}(\.\d{1})?$/;               // xxx.x or xx.x            
        var testFormat = regexp.test(weight);             // test the format
           
        if(date == "" || weight == "" || testFormat === false)  // validate data
        {
            alert("Please enter a valid weight and date");
            return;
        }else {
        var dataString = {date: date, weight: weight};
        
        $.ajax({
            type: "POST",
            url:"/goalstore/" + dataString,
            data: dataString,
            cache: false,
            dataType: "json",
            success: function(result) {
                if(result.badge){
                    weightChart.updateChart();
                    $('.popover-markup>.trigger').popover('hide');
                    $('div#modal-badge-data').html("<h4>"+result.name+"</h4><img src='/assets/img/badges/" + result.image + "'> <p>Level "+ result.lvl +" : " +result.goal+" lbs</p>");
                $('#badgeModal').modal({show:true});
                }
                weightChart.updateChart();
                $('.popover-markup>.trigger').popover('hide');
                $('span#weight_data').text(result.weight_lost);
            },
            error: function(error){
                console.log(error);
            }
        })
       }
    });

    $('#weight_datepicker').datepicker({
        showOn: "button",
        buttonImage: "../assets/img/site/calendar-blk.png",
        buttonImageOnly: true,
        dateFormat: 'yy-mm-dd',
        altField: '#weight_datepicker',
        altFormat: 'yy-mm-dd',
        defaultDate: new Date(),

        maxDate: new Date(),
        onSelect: function(dateText, inst) {
            var theDate = new Date(Date.parse($(this).datepicker('getDate')));
            var dateSelected = $.datepicker.formatDate('yy-mm-dd', theDate);
            var dateFormatted = $.datepicker.formatDate('MM d, yy', theDate); // Ex. November 11, 2013
            $("#date_value").text(dateFormatted);
            checkWeight(dateSelected);
        }
        
    });

   $('#weight_datepicker').datepicker('setDate', new Date());
        var today = $('#weight_datepicker').prop('value');
    checkWeight(today);
    goalStartDate();
  } // end of popover callback
}).click(function (e) {
        e.preventDefault();
 });
    /* End of popover */
}

/* Pagination */
function ActivityPagination() {
    // When the load more button is clicked 
$('li#more.load-more').on("click", function(e) {
    e.stopPropagation();
    e.preventDefault();
    // get the current selected filter
    var type = $('.activity-type label.active input').attr('value');
    // set variable to the number that is loaded. Default is 10
    var loaded = $(this).attr('num_loaded');
    // Change the value from a string to a int
    var loaded = parseInt(loaded);
    //Construct AJAX call
    $.ajax({
        url: '/activities_pag/',
        data: {
            filter: type,
            load: loaded
        },
        dataType: 'json',
        type: 'post',
        success: function(data) { // When returning a successful ajax GET run
            var userid = data.userid;

            // Loop through the data array and add to the end of the ul
            $.each(data.activities, function(item, val) {

                var userdata = val.user;
                var d = new Date(val.created_at.replace(/-/g, "/"));
                var n = d.toISOString();

                var html ="<div id='recent_activity_container' class='col-md-8 col-sm-11 col-centered' >" ;
                html += "<li id='"+ val.id+"'>";
                html += "<div class='activityBox'>";
                html += "<div class='recentActivityDesc'>";
                html += "<div class='profilePicContainer'>";
                html += "<span rel='hovercard' data-url=" + val.user_id + "><div class='hovercard'></div>";
                html += "<img id='profilePic' src=" + userdata.pic + " /></span></div>";
                html += "<div class='recentActivityName'>" + userdata.first_name + " " + userdata.last_name.charAt(0) + ". </div>";
                // if Badge
                
                if (val.user.badgeuser.length > 0)
                {
                    var badge_data = val.user.badgeuser[0];
                    html += "<div id='container-flair'>";
                    html += "<span class='sprite-flair_"+ badge_data.type+"_"+badge_data.lvl+"' title='"+badge_data.desc+"'></span>";
                    html += "</div>";
                    $("div#container-flair span").tooltip({placement:"bottom"});
                    
                }
                
                if (val.type == "time") {
                html += "<div class='recentActivityText'>Logged " + secToString(timeToSeconds(val.activity_time)) + " of <strong>" + val.activity_name + " </strong></div></div>";
                } else if (val.type == "read"){
                html += "<div class='recentActivityText'>Read <a href='/blog'>" + val.activity_name + " </a></div></div>";
                }
                else{
                    html += "<div class='recentActivityText'>" + val.activity_name + "</div></div>";
                }
                
                html += "<div class='activityStatsContainer'>";
                html += "<div class='timeContainer'><span class='glyphicon glyphicon-time'></span><abbr class='timeago' title='" + n + "'>&nbsp;</abbr></div>";
                if(userid != val.user_id && val.likes.length == 0 ){
                    html += "<div class='toLikeImg'>";
                    html += "<div class='glyphicon glyphicon-heart like-heart' id='"+val.id+"' title='Click to like!'></div>";
                    html += "</div>";
                }
                else{
                    html +="<div class='activityLikeImg' id='"+val.id+"'>";
                    html +="<span class='glyphicon glyphicon-heart' style='color:#F563A1'></span>";
                    html +="<span class='like-count'>&nbsp;"+ val.likeCount+"</span>";
                    html +="</div>";
                }
                html += "";
                html += "</div>";
                if (val.type == "time") {
                    html += "<div class='activityIcon'><img src='/assets/img/badges/timeActivity.png'/></div>";
                } else if (val.type == "read") {
                    html += "<div class='activityIcon'><img src='/assets/img/badges/readActivity.png'/></div>"
                } else {
                    html += "<div class='activityIcon'><img src='/assets/img/badges/goalActivity.png'/></div>"
                }
                html += "</div></li></div>";
                
                $(html).appendTo('ul.recentActivity').hide().slideDown("slow", function() {
                    $("li.activityItem, img#ajaximg").animate({
                        opacity: "1"
                    }, 600);
                });

                // We need to refresh the list so that the JQM styles are applied
                //$('#actlist').listview('refresh');
            }); // end of for each
            $("abbr.timeago").timeago();
            initHoverCard();
            // Since the ajax call was successful we set the loaded variable + 10
            // So next time the user clicks the loadmore button we call for results from 11-20
            loaded += 10;
            // check to see if the array is empty
            var empty = $.isEmptyObject(data);
            if (empty == true) {
                // Remove the button if the array is empty
                $('li#more').remove();
            } else {
                //move button to the end of the list
                $('li#more').appendTo($('ul.recentActivity'));
                // Set the num_loaded attribute to the new value
                $('li#more').attr('num_loaded', loaded);
            }
        } // End of success event
    });
});

}

/*****      Charts      *****/
// Shows activity time log this year versus last.
function activityChart() {
var url = window.location.href.split('/');
d3.xhr("/user-activity/" + url[4], function(data) {
data = JSON.parse(data.responseText);
    
console.log(data.length);
var color = d3.scale.category10();
      
var margin = {top: 20,right: 20, bottom: 30, left: 30},
width = 630,
height = 250;

    
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
        .attr('preserveAspectRatio','xMinYMin')
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

    if(data[0].length > 0 ) // only draw the lines if data for current year exsists.
{
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
}
});
}

// Weight Challenge chart
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

// Updates weight chart

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