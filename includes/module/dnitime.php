<?php
$gtime = time();

$kMST = 25200;
$kOneHour = 3600;
$kOneDay = 86400;

$dtime = $gtime - $kMST;
#$utime = time($dtime);
## check for daylight savings time in New Mexico and adjust
if ( date('n') >= 4 && date('n') < 11 )
{
		$dstStart = mktime(2,0,0,4,1,date("Y"));
		$dstStartsun = strtotime("sunday",mktime(2,0,0,4,1,date("Y")));
		$dstStartsec = $dstStartsun - $dstStart;
		$dstStartinsec = ceil($dstStartsec/(60*60*24));
		// find first Sunday after 4/1 (first sunday of April)
		$days_to_go_sunday_april = 7 - $dstStartinsec;
		if ($days_to_go_sunday_april == 7)
			$days_to_go_sunday_april = 0;
		$dstStartSecs = $dstStart + $days_to_go_sunday_april * $kOneDay;

		$dstEnd = mktime(1,0,0,10,25,date("Y"));
		$dstEndsun = strtotime("sunday",mktime(1,0,0,10,25,date("Y")));
		$dstEndsec = $dstStartsun - $dstStart;
		$dstEndinsec = ceil($dstStartsec/(60*60*24));
		// find first sunday after 10/25 (last sunday of Oct.)
		$days_to_go_sunday_okt = 7 - $dstEndinsec;
		if ($days_to_go_sunday_okt == 7)
			$days_to_go_sunday_okt = 0;
		$dstEndSecs = $dstEnd + $days_to_go_sunday_okt * $kOneDay;

		if ( $dtime > $dstStartSecs && $dtime < $dstEndSecs )
			// add hour for daylight savings time
			$dtime += $kOneHour;
}

$dtime = $dtime;
$dnitime = gmdate('H:i',$dtime);
$dnidate = date('Y.m.d',$dtime);

echo '<p align="center">'.$dnitime.'<br>'.$dnidate.'</p>';

?>