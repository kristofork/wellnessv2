<?php

function convertTimeIso($datetime)
{
    $newdatetime = new DateTime($datetime);
    return $newdatetime->format(DateTime::ISO8601);
}

/* Convert 00:00:00 to total amount of seconds */
function hoursToSeconds ($hour) { // $hour must be a string type: "HH:mm:ss"
    $parse = array();
    if (!preg_match ('#^(?<hours>[\d]{2}):(?<mins>[\d]{2}):(?<secs>[\d]{2})$#',$hour,$parse)) {
         // Throw error, exception, etc
         throw new RuntimeException ("Hour Format not valid");
    }

         return (int) $parse['hours'] * 3600 + (int) $parse['mins'] * 60 + (int) $parse['secs'];     
}

/* Convert the seconds to a string */
function secondsToString ($time){
        if (empty($time))
        {
            return 0;
        }
    	if(60 < $time && $time <= 3600){
    		return round($time/60,0).' minutes';
    	}
    	if(3600 < $time && $time <= 86400){
    		return round($time/3600,0).' hours';
    	}
}

/* Round off to the tenths place */
function percentageRound ( $milestone, $usertime)
{
   return round (($usertime / $milestone ) * 100, 1);
}

/* Count days for deadlines */
function deadlineCount( $today, $deadline)
{
    $start = strtotime($today);
    $end = strtotime($deadline);
    $timeDiff = abs($end - $start);
    $numberDays = $timeDiff/86400;
    return intval($numberDays);
}

function ounceToPounds($ounce){
    if( empty($ounce))
    {
        return 0 . 'oz';
    }
    if($ounce < 16)
    {
        return $ounce . 'oz';
    }
    if( $ounce >= 16)
    {
        $oz = ( $ounce % 16);
        $lb = round( $ounce / 16,0);
        if ($oz == 0)
        {
            return $lb . ' lb(s)';
        }
        return $lb . 'lb(s) ' . $oz . 'oz'; 
    }
}

function currentyear(){
    if (date('m') >= 1 && date('m')<= 5) {
        $varStart = (date("Y-m-d",mktime(0,0,0,06,01,date("Y")-1)));
        $varEnd = (date("Y-m-d", mktime(0,0,0,05, 31, date("Y"))));
    }
    else{
        $varStart = (date("Y-m-d",mktime(0,0,0,06,01, date("Y"))));
        $varEnd = (date("Y-m-d", mktime(0,0,0,05, 31, date("Y") + 1)));
    }
    return array ('start' => $varStart, 'end' => $varEnd);
}

?>
