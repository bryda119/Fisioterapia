<?php
    function displayDays($days = array()) {

        // 1: Create periods and group them in arrays with starting and ending days
        $periods = array();
    
        $periodIndex = 0;
    
        $previousDay = -1;
        $nextDay = -1;
    
        foreach($days as $placeInList => $currentDay) {     
            // If previous day and next day (in $days list) exist, get them.
            if ($placeInList > 0) {
                $previousDay = $days[$placeInList-1];
            }
            if ($placeInList < sizeof($days)-1) {
                $nextDay = $days[$placeInList+1];
            }
    
            if ($currentDay-1 != $previousDay) {
            // Doesn't follow directly (in week) previous day seen (in our list) = starting a new period
                $periodIndex++;
                $periods[$periodIndex] = array($currentDay);
            } elseif ($currentDay+1 != $nextDay) {
            // Follows directly previous day, and isn't followed directly (in week) by next day (in our list) = ending the period       
                $periods[$periodIndex][] = $currentDay;
                $periodIndex++;
            }
        }
        $periods = array_values($periods);
    
    
        // Arrived here, your days are grouped differently in bidimentional array.
        // print_r($periods); // If you want to see the new array's structure
    
        // 2: Display periods as we want.
        $text = '';
        foreach($periods as $key => $period) {
            if ($key > 0) {
            // Not first period
                if ($key < sizeof($periods)-1) {
                // Not last period either
                    $text .= ', ';
                } else {
                // Last period
                    $text .= ' and ';
                }
            }
    
            if (!empty($period[1])) {
            // Period has starting and ending days
                $text .= jddayofweek($period[0]-1, 1).' - '.jddayofweek($period[1]-1, 1);
            } else {
            // Period consists in only one day
                $text .= jddayofweek($period[0]-1, 1);
            }
        }
    
        echo $text.'<br />';
    }

        $sql = "SELECT * FROM system_details";
        $query_run = mysqli_query($conn,$sql);

        $row = mysqli_fetch_array($query_run);
        $me = $row['days'];
        $me_array = explode(',',$me);
        // echo $me_array;
        
        displayDays($me_array);

        
?>