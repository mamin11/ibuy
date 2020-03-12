<?php
    function getDiff($f){
        
        // Declare and define two dates 
    $date1 = strtotime("2020-01-11 15:45:00"); 
    $current = date("Y-m-d H:i:s");//"2018-09-21 10:44:01"
    $date2 = strtotime(date(" H:i:s")); 
    $duration = $f;
    
    if($date2 < $duration){
    // Difference between two dates 
    $diff = abs($date2 - $duration); 
    
    
    // To get the year divide the difference date by  total seconds in a year (365*60*60*24) 
    $years = floor($diff / (365*60*60*24)); 
    
    
    // To get the month, subtract it with years and divide the difference date by  total seconds in a month (30*60*60*24) 
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
    
    
    // To get the day , subtract it with years and months and divide the difference date by  total seconds in a days (60*60*24) 
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
    
    
    // To get the hour, subtract it with years, months & seconds and divide the difference date by total seconds in a hours (60*60) 
    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60)); 
    
    
    // To get the minutes, subtract it with years, months, seconds and hours and divide the difference date by total seconds i.e. 60 
    $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
    
    
    // To get the minutes, subtract years, months, seconds, hours and minutes 
    $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60)); 
    
    // Print the result 
    // printf("-----------------------------  %d hours, "
    //     . "%d minutes, %d seconds",  $hours, $minutes, $seconds); 
        $timeDifference = $hours . ' hours :' . $minutes . ' minutes :'. $seconds. ' seconds';
        // return $timeDifference;
        echo $timeDifference;
                
    } else {
        echo  '  CLOSED';
    }
    }