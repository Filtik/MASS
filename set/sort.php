<?php

connectmass();
$fragsort = mysql_query("SELECT * FROM displays WHERE display = '".$_SERVER["QUERY_STRING"]."'");
$zahlsort = mysql_num_rows($fragsort);

$modulpath = 'includes/module/';

$fragback = mysql_query("SELECT * FROM modul WHERE num = '".$_SERVER["QUERY_STRING"]."'");
$coloris = mysql_fetch_object($fragback);

echo '<body bgcolor="'.$coloris->backcolor.'" text="'.$coloris->fontcolor.'">';

for ($a = 1; $a <= $zahlsort; $a++)
{	
	mysql_select_db ($massdb);
	$fragsort2 = mysql_query("SELECT * FROM displays WHERE display = '".$_SERVER["QUERY_STRING"]."' AND position = '".$a."'");
	$rowsort = mysql_fetch_object($fragsort2);
	
	$querystring = $rowsort->sel;
	
	if (($querystring == "online") or ($querystring == "online-full"))
	{ $querystringres = 'online-'.$displayset.''; }
	else
	{ $querystringres = ''.$rowsort->sel.''; }
	
	include ''.$modulpath.''.$querystringres.'.php';
}

echo '</body>';

?>