$(document).ready(function(){

$("button.read").click(function(e){
	e.preventDefault();

           var id = parseInt($(this).attr('id'));
           $.ajax({
            type: "POST",
            data: id ,
            dataType: "json",
            url: "../../activityread/" + id,
            success: function(data)
            {
            	console.log('Read!');
            }
})
})

});