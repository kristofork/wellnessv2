@extends('layouts.master')

@section('content')
<div class="main-row">
        <div id="container" class="col-md-12" style="height:300px;"></div>
        <!-- Start of Recent Activity (middle column) -->
        <div class="col-md-8" id="welcome_recent_activity">
            <h2>Recent Activity</h2>
            <ul class="recentActivity">

                @foreach($activities as $activity)
                <?php
                    $moreNamesArray = NULL;
                    $liked = NULL; // Set to default to NULL
                    $activeId = $activity->id;
                    $likeids = Activity::find($activity->id)->likeCount; // Query the amount of total likes
                        if ($likeids != 0)  // Prevents error for activities with no 'likes' in the Activity_like table
                            $liked = DB::table('activity_likes')->where('user_id',Auth::user()->id)->where('act_id',$activity->id)->pluck('user_id');  // Query to check if the currently logged in user liked the activity. 
                 ?>

                    <li id="{{$activeId}}">

                    <div class="activityBox">
                        <?php $badges = DB::table('badge_user')->join('badges', 'badges.id', '=', 'badge_user.badge_id')->where('user_id', $activity->users_id)->get(array('badges.name', 'badges.desc', 'badges.image')) ?>

                        @if ($activity->type == "time")
                            <div class="recentActivityDesc">
                                <div class="profilePicContainer"> 
                                    <span rel="hovercard" data-url="{{$activity->users_id}}">
                                        <div class="hovercard"></div>
                                    {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}}
                                    </span>
                                </div>
                                <div class="recentActivityName">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                                @foreach($badges as $badge)
                                    {{HTML::image($badge->image . "-sm.png", 'test', array('class'=> 'badge-small', 'title'=> $badge->name));}}
                                @endforeach

                                <div class="recentActivityText">Logged {{ secondsToString(hoursToSeconds($activity->activity_time )) }} of <strong>{{ $activity->activity_name }} </strong></div>
                            </div>
                            @elseif ($activity->type == "read")
                            <div class="recentActivityDesc">
                                    <div class="profilePicContainer"> 
                                        {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}} 
                                    </div>
                                <div class="recentActivityName">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                                @foreach($badges as $badge)
                                    {{HTML::image($badge->image . "-sm.png", 'test', array('class'=> 'badge-small', 'title'=> $badge->name));}}
                                @endforeach
                                <div class="recentActivityText">Read <strong>{{ $activity->activity_name }} </strong></div>
                            </div>
                            @else
                            <div class="recentActivityDesc">
                                <div class="profilePicContainer"> 
                                    {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}} 
                                </div>
                                <div class="recentActivityName">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                                @foreach($badges as $badge)
                                    {{HTML::image($badge->image . "-sm.png", 'test', array('class'=> 'badge-small', 'title'=> $badge->name));}}
                                @endforeach                    
                                <div class="recentActivityText">Lost {{ ounceToPounds($activity->goal_num ) }} last week towards their <strong>{{ $activity->activity_name }} goal </strong></div>
                            </div>
                            @endif
                            
                            <div class="timeContainer"><abbr class="timeago" title="{{ convertTimeIso($activity->created_at) }}">&nbsp;</abbr></div>
                            <div class="activityIcon">
                                @if ($activity->type == "time")
                                {{HTML::image("/assets/img/badges/timeActivity.png", "Time Activty");}} 
                                @elseif ($activity->type == "read")
                                {{HTML::image("/assets/img/badges/readActivity.png", "Read Activty");}}
                                @else
                                {{HTML::image("/assets/img/badges/goalActivity.png", "Goal Activty");}}
                                @endif
                            </div>

                            @if($likeids > 0) <!-- Conditional: If no likes, skip to like button -->
                                <div class="activityLikeImg" id="{{ $activity->id }}">
                                <span class="glyphicon glyphicon-heart" style="color:#FF5566"></span>
                                <span>{{ $activity->likeCount }}</span>

                                </div>
                            @endif
                        <!--Conditional: User cannot like own activities and cannot like activities more than once -->
                        @if(Auth::user()->username != $activity->username &&  $liked == NULL)

                        <!-- Begin of test spinner -->

                          <div class="applaud" id='{{ $activity->id}}'>
                            <div class="ui-spinner">
                              <span class="side side-left">
                                <span class="fill"></span>
                              </span>
                              <span class="side side-right">
                                <span class="fill"></span>
                              </span>
                            </div>
                          </div>
                        <!-- End of test spinner -->


                        @else

                    

                        @endif
                    </div> <!-- End Activitybox-->
                </li>
                <hr class="activityHR" />
                @endforeach
            </ul>
        </div>

        <!-- Start of Sidebar Right -->
    <div style="width:31%; float:left; margin-top:15px;">
        <div id="donutChart" class="sidebar-nav well well-small"> 

        </div>
        <div class=" sidebar-nav well well-small">
            <ul class="nav nav-list">
                <li class="nav-header">Favorite Activities</li>

                @foreach ($fav_activities as $favs)
                <li>{{ $favs->activity_name }} </li>
                @endforeach

            </ul>
            <div style="clear: both"></div>
        </div>        
        <div class="sidebar-right">
            <h4 id="sidebar-heading">Reward Progress</h4>
            <div class="sidebar-padding">
                @foreach($rewards as $reward)
                @if(sizeof($rewards) < 1)
                    <div class="progress-item col-md-12">
                        <div style="font-size:60px; text-align:center">1</div> <br/>
                        <span>{{deadlineCount( date("Y/m/d") ,$reward->deadline)}} days left!</span>
                        <div class="progress">
                            <div class="bar" id = "reward" style="width: {{ percentageRound($reward1->milestone, $user->userTotalHrs); }}%"> {{ percentageRound($reward->milestone, $user->userTotalHrs); }}%</div>
                        </div>
                    </div>
                @else
                    <div class="progress-item col-md-6">
                        <div style="font-size:60px; text-align:center">{{$reward->id}}</div> <br/>
                        <span>{{deadlineCount( date("Y/m/d") ,$reward->deadline)}} days left!</span>
                        <div class="progress">
                            <div class="bar" id = "reward" style="width: {{ percentageRound($reward->milestone, $user->userTotalHrs); }}%"> {{ percentageRound($reward->milestone, $user->userTotalHrs); }}%</div>
                        </div>
                    </div>                
                @endif
                @endforeach


            </div>
                <div style="clear: both"></div> 
        </div>
    </div>
    <!-- End of Sidebar Right-->

</div>
{{ HTML::script('assets/js/progressbars.js')}}
{{ HTML::script('assets/js/jquery.hoverIntent.minified.js')}}
{{ HTML::script('assets/js/highcharts/highcharts.js')}}
{{ HTML::script('assets/js/highcharts/modules/exporting.js')}}

        <script>
        //Ajax User Activity
function activityChart() {
    $.ajax({
        type: "GET",
        url: "/user-activity",
        success: function(json) {
            chart = new Highcharts.Chart({
                credits: {
                    enabled: false
                },
                chart: {
                    renderTo: 'container',
                    type: 'line',
                    marginRight: 130,
                    marginBottom: 25
                },
                title: {
                    text: 'Activity Time',
                    x: -20 //center
                },
                subtitle: {
                    text: '',
                    x: -20
                },
                xAxis: {
                    categories: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May']
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Hours'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.series.name + '</b><br/>' +
                            this.x + ': ' + this.y;
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -10,
                    y: 100,
                    borderWidth: 0
                },
                series: json
            });
        }
    });
// Start of theme    
    // Load the fonts
Highcharts.createElement('link', {
   href: 'http://fonts.googleapis.com/css?family=Hind',
   rel: 'stylesheet',
   type: 'text/css'
}, null, document.getElementsByTagName('head')[0]);

Highcharts.theme = {
   colors: ["#2b908f", "#90ee7e", "#f45b5b", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
   chart: {
      backgroundColor: {
         linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
         stops: [
            [0, '#2a2a2b'],
            [1, '#3e3e40']
         ]
      },
      style: {
         fontFamily: "'Unica One', sans-serif"
      },
      plotBorderColor: '#606063'
   },
   title: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase',
         fontSize: '20px'
      }
   },
   subtitle: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase'
      }
   },
   xAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      title: {
         style: {
            color: '#A0A0A3'

         }
      }
   },
   yAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      tickWidth: 1,
      title: {
         style: {
            color: '#A0A0A3'
         }
      }
   },
   tooltip: {
      backgroundColor: 'rgba(0, 0, 0, 0.85)',
      style: {
         color: '#F0F0F0'
      }
   },
   plotOptions: {
      series: {
         dataLabels: {
            color: '#B0B0B3'
         },
         marker: {
            lineColor: '#333'
         }
      },
      boxplot: {
         fillColor: '#505053'
      },
      candlestick: {
         lineColor: 'white'
      },
      errorbar: {
         color: 'white'
      }
   },
   legend: {
      itemStyle: {
         color: '#E0E0E3'
      },
      itemHoverStyle: {
         color: '#FFF'
      },
      itemHiddenStyle: {
         color: '#606063'
      }
   },
   credits: {
      style: {
         color: '#666'
      }
   },
   labels: {
      style: {
         color: '#707073'
      }
   },

   drilldown: {
      activeAxisLabelStyle: {
         color: '#F0F0F3'
      },
      activeDataLabelStyle: {
         color: '#F0F0F3'
      }
   },

   navigation: {
      buttonOptions: {
         symbolStroke: '#DDDDDD',
         theme: {
            fill: '#505053'
         }
      }
   },

   // scroll charts
   rangeSelector: {
      buttonTheme: {
         fill: '#505053',
         stroke: '#000000',
         style: {
            color: '#CCC'
         },
         states: {
            hover: {
               fill: '#707073',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            },
            select: {
               fill: '#000003',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            }
         }
      },
      inputBoxBorderColor: '#505053',
      inputStyle: {
         backgroundColor: '#333',
         color: 'silver'
      },
      labelStyle: {
         color: 'silver'
      }
   },

   navigator: {
      handles: {
         backgroundColor: '#666',
         borderColor: '#AAA'
      },
      outlineColor: '#CCC',
      maskFill: 'rgba(255,255,255,0.1)',
      series: {
         color: '#7798BF',
         lineColor: '#A6C7ED'
      },
      xAxis: {
         gridLineColor: '#505053'
      }
   },

   scrollbar: {
      barBackgroundColor: '#808083',
      barBorderColor: '#808083',
      buttonArrowColor: '#CCC',
      buttonBackgroundColor: '#606063',
      buttonBorderColor: '#606063',
      rifleColor: '#FFF',
      trackBackgroundColor: '#404043',
      trackBorderColor: '#404043'
   },

   // special colors for some of the
   legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
   background2: '#505053',
   dataLabelsColor: '#B0B0B3',
   textColor: '#C0C0C0',
   contrastTextColor: '#F0F0F3',
   maskColor: 'rgba(255,255,255,0.3)'
};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);

}
        activityChart();
        </script>
@stop