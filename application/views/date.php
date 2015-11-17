<?php

//Code written by purpledesign.in Jan 2014
function dateDiff($start,$end)
{
  $mydate= $end;
  $theDiff="";
  //echo $mydate;//2014-06-06 21:35:55
  $datetime1 = date_create($start);
  $datetime2 = date_create($mydate);
  $interval = date_diff($datetime1, $datetime2);
  //echo $interval->format('%s Seconds %i Minutes %h Hours %d days %m Months %y Year    Ago')."<br>";
  $min=$interval->format('%i');
  $sec=$interval->format('%s');
  $hour=$interval->format('%h');
  $mon=$interval->format('%m');
  $day=$interval->format('%d');
  $year=$interval->format('%y');
  if($interval->format('%i%h%d%m%y')=="00000")
  {
    //echo $interval->format('%i%h%d%m%y')."<br>";
    return $sec." Seconds";

  } 

else if($interval->format('%h%d%m%y')=="0000"){
   return $min." Minutes";
   }


else if($interval->format('%d%m%y')=="000"){
   return $hour." Hours";
   }


else if($interval->format('%m%y')=="00"){
   return $day." Days";
   }

else if($interval->format('%y')=="0"){
   return $mon." Months";
   }

else{
   return $year." Years";
   }

}
?>