$(document).ready(function(){

	getGoal();
	$("#weight_val").val(1);
 $("#weight_slider").slider({min:1,max:96,step:1,
 	slide: function(event,ui){
 		var lbs = Math.floor(ui.value / 16);
 		var oz = ui.value - (lbs * 16);
 		$("#weight_val").val(ui.value);
 		$("#weight_value").text(lbs + ' lb(s) and ' + oz + ' oz');
 	}
 });
});