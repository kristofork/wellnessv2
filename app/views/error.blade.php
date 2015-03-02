<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wellness: ERROR</title>
</head>
<style>
    #container li {
    background: url(../img/browser_master.png) no-repeat top left;
    list-style: none;
    display: inline-block;

}
#container li.browsers-sprite-ch{ background-position: 0 0 !important; width: 64px; height: 64px; } 
#container li.browsers-sprite-ff{ background-position: 0 -114px; width: 64px; height: 64px; } 
#container li.browsers-sprite-ie{ background-position: 0 -228px; width: 64px; height: 64px; } 
#container li.browsers-sprite-o{ background-position: 0 -342px; width: 64px; height: 64px; } 
#container li.browsers-sprite-sa{ background-position: 0 -456px; width: 64px; height: 64px; } 
    </style>
<body style="width:100%; height:100%; background-color:#fbfbfb;">
            <!-- if browser does not meet the minimum req -->
            <h2>ERROR: Bad IE</h2>

            <p>Sorry! Internet Explorer 9 and below are not supported. Please upgrade your browser or use one of the supported browsers listed below. Sorry for any inconvenience!</p>

          <div id="container">
              <li class="browsers-sprite-ch" data-toggle="tooltip" data-placement="top" title="Chrome v.31 and up"></li>
              <li class="browsers-sprite-ff" data-toggle="tooltip" data-placement="top" title="FireFox v.34 and up"></li>
              <li class="browsers-sprite-ie" data-toggle="tooltip" data-placement="top" title="Internet Explorer v.10 and up"></li>
              <li class="browsers-sprite-o" data-toggle="tooltip" data-placement="top" title="Opera v.26 and up"></li>
              <li class="browsers-sprite-sa" data-toggle="tooltip" data-placement="top" title="Safari v.7 and up"></li>
          </div>
            
</body>
</html>