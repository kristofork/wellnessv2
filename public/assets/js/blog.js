$(document).ready(function(){

$("button.read").click(function(e){
	e.preventDefault();
    console.log("click");

           var id = parseInt($(this).attr('id'));
           $.ajax({
            type: "POST",
            data: id ,
            dataType: "json",
            url: "../../activityread/" + id,
            success: function(data)
            {
            	console.log('Read!');
                $("button.read").hide();
                
                var html ="<div id='dash-side-right' class='alert alert-custom'>";
                    html+="<button type='button' class='close' data-dismiss='alert'>x</button>";
                    html+="<p>Blog post read!</p>";
                    html+="</div>";
                $('div.main-container').append(html);
                
            }
})
})

});