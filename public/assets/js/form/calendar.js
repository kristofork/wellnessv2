function minDate(){
    var startDay   = 01;
    var startMonth = 06;
    var startYear;
    var endDay     = 31;
    var endMonth   = 05;
    var endYear;
    var cDate      = new Date();
    var cMonth     = cDate.getMonth();
    var cYear      = cDate.getFullYear();

    if (cMonth >= 0 && cMonth <= 4){
        startYear = cYear - 1;
        endYear   = cYear;
        }
    else{
    startYear = cYear;
    endYear   = cYear + 1;
    }
var startDateFinal = startYear + "," + startMonth + "," + startDay;
    return startDateFinal;
}

$(document).ready(function($) {
    $( "#datepicker, #datepicker-running" ).datepicker({
        inline: true,
        dateFormat: 'yy-mm-dd',
        altField: '#activity_datepicker',
        altFormat: 'yy-mm-dd',
        minDate: new Date(minDate()),
        maxDate: new Date(),
        beforeSend: function(){
            $('#escapingBallG').show(); // Show the spinner
        },
        complete: function(){
              $('#escapingBallG').hide(); // Hide the spinner
        },
        onSelect: function(dateText, inst){
            var theDate = new Date(Date.parse($(this).datepicker('getDate')));
            var dateSelected = $.datepicker.formatDate('yy-mm-dd', theDate);
            var dateFormatted = $.datepicker.formatDate('MM d, yy', theDate); // Ex. November 11, 2013
            $("#date_value").text(dateFormatted);
            $.ajax({
                type: "GET",
                url: "activitycheck/" + dateSelected,
                success: function(result){
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

});