<?php

// Custom Macro for {{ HTML::image_link() }}

HTML::macro('image_link', function($url = '', $img='img/', $alt='', $param = false, $active=true, $ssl=false)
{
    $url = $ssl==true ? URL::to_secure($url) : URL::to($url);  
    $img = HTML::image($img,$alt);
    $link = $active==true ? HTML::link($url, '#', $param) : $img;
    $link = str_replace('#',$img,$link);
    return $link;
}); 