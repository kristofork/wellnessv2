// Type Filter
$('.activity-type input[type=radio]').on('change', function(e) {
    // disable the buttons
    $('.activity-type label.btn').attr('disabled','disabled');
    // set variable to the number that is loaded. Default is 10
    var loaded = $(this).attr('num_loaded');
    // Change the value from a string to a int
    var loaded = parseInt(loaded);

    NProgress.configure({ showSpinner: false, speed: 600 });
    NProgress.start();// Show the spinner  ;   
    
    var value = $("input[name='filter']:checked").val()
    $.get("/activity-filter/" + value, function(data) {
        
        $('.recentActivity').find('*').not('.recentheader, .recentheader *').remove(); // remove all activities from feed
        
    }).done(function(data){
        
    
        var userid = data.user;

        setTimeout(function () {
        NProgress.done();
            
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
                    }, 800);
                });

                // We need to refresh the list so that the JQM styles are applied
                //$('#actlist').listview('refresh');
            }); // end of for each
            $('.activity-type label.btn').removeAttr('disabled'); // enable buttons
        }, 1000); // End of timeout
            $(this.parentNode).addClass('active'); // mark button active
            jQuery("abbr.timeago").timeago();
            initHoverCard();
            // Since the ajax call was successful we set the loaded variable + 10
            // So next time the user clicks the loadmore button we call for results from 11-20
            loaded += 10;
            // check to see if the array is empty
            var empty = $.isEmptyObject(data);
            if (empty == true) {
                // Remove the button if the array is empty
                $('li#more').remove();
            } 
            else{
                //move button to the end of the list
                $('li#more').appendTo($('ul.recentActivity'));
                // Set the num_loaded attribute to the new value
                $('li#more').attr('num_loaded', loaded);
            }
        
    });
});