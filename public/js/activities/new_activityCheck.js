function newActivityCheck(last) {

    $.ajax({
        type: "GET",
        url: "newactivities/" + last,
        success: function(result) {
            console.log('success');
            console.log(result);
            if (result != 0) {
                $("span#badge-data.badge").html(result);
                $("span#badge-data").removeClass('hidden');
            }
        }
    });

}

function convertIso8601(last) {
    // Function which takes a 1 or 2-digit number and returns
    // it as a two-character string, padded with
    // an extra leading zero, if necessary.
    function pad(number) {
        var r = String(number);
        if (r.length === 1) {
            r = '0' + r;
        }
        return r;
    }
    var d = new Date(last);
    var year = d.getFullYear();
    var hr = d.getHours();;
    var min = d.getMinutes();
    var sec = d.getSeconds();
    var month = pad(d.getMonth() + 1);
    var date = pad(d.getDate());
    return year + "-" + month + "-" + date + " " + hr + ":" + min + ":" + sec;
}

setInterval(function() {
    var last = $("ul.recentActivity li").first().find("abbr").attr("title");
    last = convertIso8601(last);
    console.log(last);
    newActivityCheck(last);
}, 60000);
