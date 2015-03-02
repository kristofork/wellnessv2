        $(function () {
            $('ul.top-users').load('/topusers');
            $('ul.recentActivity').load('/activity-minifeed', function () {
                jQuery("abbr.timeago").timeago();

                // hide all quotes except the first
                $('ul.recentActivity li').hide().eq(0).show();

                var pause = 6000;
                var motion = 500;

                var quotes = $('ul.recentActivity li');
                var count = quotes.length;
                var i = 0;

                setTimeout(transition, pause);

                function transition() {
                    quotes.eq(i).slideUp(500);

                    if (++i >= count) {
                        i = 0;
                    }

                    quotes.eq(i).animate({
                        opacity: 'toggle',
                        top: '0px'
                    }, 500);

                    setTimeout(transition, pause);
                }


            });
        });