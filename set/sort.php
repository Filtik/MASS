<?php

$fragsort = mysql_query("SELECT * FROM displays WHERE display = '".$_SERVER["QUERY_STRING"]."'");
$zahlsort = mysql_num_rows($fragsort);

for ($a = 1; $a <= $zahlsort; $a++)
{	
	mysql_select_db ($dbname);
	$fragsort2 = mysql_query("SELECT * FROM displays WHERE display = '".$_SERVER["QUERY_STRING"]."' AND position = '".$a."'");
	$rowsort = mysql_fetch_object($fragsort2);
	
	$querystring = $rowsort->sel;
	
	if (($querystring == "online") or ($querystring == "online-full"))
	{ $querystringres = 'online-'.$displayset.''; }
	else
	{ $querystringres = ''.$rowsort->sel.''; }
	
	include ''.$querystringres.'.php';
}

?>