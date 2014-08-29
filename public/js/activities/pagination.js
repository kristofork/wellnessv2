// When the load more button is clicked 
	$('#more').on("click", function(e) {
		e.stopPropagation();
		e.preventDefault();
		// set variable to the number that is loaded. Default is 10
		var loaded = $(this).attr('num_loaded');
		// Change the value from a string to a int
		var loaded = parseInt(loaded);
		//Construct AJAX call
		$.ajax({
			url:'activities_pag/' + loaded,
			type:'get',
			success: function(data){	// When returning a successful ajax GET run
				// Loop through the data array and add to the end of the ul
				$.each(data, function(item,val){
					console.log(val);
					var d = new Date(val.created_at.replace(/-/g,"/"));
					var n = d.toISOString();
					
					var html = "<li>";
						html +="<div class='activityBox'>"
					    html +="<div class='recentActivityDesc'>";
						html +="<div class='profilePicContainer'>";
						html +="<span rel='hovercard' data-url="+val.user_id+"><div class='hovercard'></div>";
						html +="<img id='profilePic' src="+ val.pic + " /></span></div>";
		                html +="<div class='recentActivityName'>"+ val.first_name +" "+ val.last_name.charAt(0) +". </div>";
		                html +="<div class='recentActivityText'>Logged "+ secToString(timeToSeconds(val.activity_time))+" of <strong>"+ val.activity_name+" </strong></div></div>";
		                html +="<div class='timeContainer'><span class='glyphicon glyphicon-time'></span><abbr class='timeago' title='"+ n +"'>&nbsp;</abbr></div>";
		                if(val.type == "time")
		                {
		                	html += "<div class='activityIcon'><img src='/assets/img/badges/timeActivity.png'/></div>";
		                }
		                else if(val.type == "read")
		                {
		                	html += "<div class='activityIcon'><img src='/assets/img/badges/readActivity.png'/></div>"
		                }
		                else
		                {
		                	html += "<div class='activityIcon'><img src='/assets/img/badges/goalActivity.png'/></div>"
		                }
						html +="</div></li><hr class='activityHR' />";
					    $(html).appendTo('ul.recentActivity').hide().slideDown("slow", function()
					    {
                        	$("li.activityItem, img#ajaximg").animate({opacity: "1"}, 600);
						});

						// We need to refresh the list so that the JQM styles are applied
					//$('#actlist').listview('refresh');
				}); // end of for each
				jQuery("abbr.timeago").timeago();
					// Since the ajax call was successful we set the loaded variable + 10
					// So next time the user clicks the loadmore button we call for results from 11-20
					loaded+=10;
					// check to see if the array is empty
					var empty = $.isEmptyObject(data);
					if (empty == true){
						// Remove the button if the array is empty
						$('li#more').remove();
					}else{
						//move button to the end of the list
					$('li#more').appendTo($('ul.recentActivity'));
						// Set the num_loaded attribute to the new value
					$('li#more').attr('num_loaded',loaded);
					}
			} // End of success event
		});	
	});