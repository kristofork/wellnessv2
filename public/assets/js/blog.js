$(document).ready(function(){

$("button.read").click(function(e){
	e.preventDefault();

           var id = parseInt($(this).attr('id'));
           $.ajax({
            type: "POST",
            data: id ,
            dataType: "json",
            url: "../../activityread/" + id,
            success: function(result)
            {
                $("button.read").hide();
            	if(result.badge){
                $('div#modal-badge-data').html("<h4>"+result.name+"</h4><img src='/assets/img/badges/" + result.image + "'> <p>Level "+ result.lvl +" - " +result.name+"</p><p>"+ result.desc +"</p>");
                $('#badgeModal').modal({show:true});
                }else{
                var html ="<div id='dash-side-right' class='alert alert-custom'>";
                    html+="<button type='button' class='close' data-dismiss='alert'>x</button>";
                    html+="<p>Blog post read!</p>";
                    html+="</div>";
                $('div.main-container').append(html);
                }
                
            }
})
})

});