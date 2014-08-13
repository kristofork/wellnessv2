function newActivityCheck(last){

    $.ajax({
        type: "GET",
        url: "newactivities/" + last,
        success: function(result) {
        	console.log('success');
        	console.log(result);
        	$("span#badge-data.badge").html(result);
        }
    });

}

setInterval(function(){newActivityCheck('2014-08-07 14:08:10')}, 60000);