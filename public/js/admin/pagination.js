$(function() {

// Start of Pagination Script
    function getPaginationSelectedPage(url) {
        var chunks = url.split('?');
        var baseUrl = chunks[0];
        var querystr = chunks[1].split('&');
        var pg = 1;
        for (i in querystr) {
            var qs = querystr[i].split('=');
            if (qs[0] == 'page') {
                pg = qs[1];
                break;
            }
        }
        return pg;
    }
    $('#users').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var pg = getPaginationSelectedPage($(this).attr('href'));

        $.ajax({
            url: '/admin/ajax/user',
            data: { page: pg },
            success: function(data) {
                $('#users').html(data);
                $("html, body").animate({ scrollTop: 0 }, "fast");
            }
        });
    });

    $('#teams').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var pg = getPaginationSelectedPage($(this).attr('href'));

        $.ajax({
            url: '/admin/ajax/team',
            data: { page: pg },
            success: function(data) {
                $('#teams').html(data);
                $("html, body").animate({ scrollTop: 0 }, "fast");
            }
        });
    });
    $('#rewards').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var pg = getPaginationSelectedPage($(this).attr('href'));

        $.ajax({
            url: '/admin/ajax/reward',
            data: { page: pg },
            success: function(data) {
                $('#rewards').html(data);
                $("html, body").animate({ scrollTop: 0 }, "fast");
            }
        });
    });

    $('#users').load('/admin/ajax/user?page=1');
    $('#teams').load('/admin/ajax/team?page=1');
    $('#rewards').load('/admin/ajax/reward?page=1');

    // End of Pagination Script
    
    // Nav-Tab History with hash links
      var hash = window.location.hash;
      hash && $('ul.nav a[href="' + hash + '"]').tab('show');

      $('#dash-nav .tabs a').click(function (e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop();
        window.location.hash = this.hash;
        $('html,body').scrollTop(scrollmem);
      });
    // End of Nav-Tab History

    // Reward Filter
    $('.reward-type input[type=radio]').on('change', function(e) {
        var value = $("input[name='filter']:checked").val()
        $.get( "/admin/reward-filter/" + value, function( data ) {
          $('#rewards').html(data);
        });
    });
    
});