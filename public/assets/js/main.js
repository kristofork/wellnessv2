/* Initializers */


function initDash() {
    $(document).ready(function () {
        // initialize the timeago plugin
        $("abbr.timeago").timeago();
        /* Tooltip */
        $('.like-heart').tooltip({
            placement: "right"
        });
        $('div#container-flair span').tooltip({
            placement: "bottom"
        });
        $("span.flair").tooltip();
        /* HoverCard  */
            initHoverCard(); 
        /* Like System */
            Like();
        /* Activity Filter */
            ActivityFilter();   
        /* Activity Hover */
            ActivityHover();
        /* Activity Pagination */
            ActivityPagination();
    }); // End of $(document).ready()
}

function initProfile() {
    $(document).ready(function () {
        // initialize the timeago plugin
        $("abbr.timeago").timeago();
        $('div#container-flair span').tooltip({
            placement: "bottom"
        });
        $("span.flair").tooltip();
        /* HoverCard  */
            initHoverCard(); 
        /* Like System */
            Like();
        /* Activity Filter */
            ActivityFilter();   
            $(".activity-type").find("label.active").removeClass('active');
            $(".activity-type").find("input[value='Team']").parent().addClass('active');
        /* Activity Hover */
            ActivityHover();
        /* Activity Pagination */
            ActivityPagination();
        /* Activity Chart */
            activityChart();
    }); // End of $(document).ready()
}

function initLog() {
    $(document).ready(function () {
        // Initalize the date limits for time.
        datelimits();
        /* Tooltip */
        $("#day, #week, #date_value, div.intensity, #points, #reward.bar").tooltip();
        /* Log Form */
        logForm();
    }); // End of $(document).ready()
}

function initBadge() {
    $(document).ready(function () {
        /* Tooltip */
        $("span#badge-info-button").tooltip();

    }); // End of $(document).ready()
}