<?php

connectmass();
$iam = $_SERVER["QUERY_STRING"];
if (is_numeric($iam) == TRUE)
{
	$tosort = mysql_fetch_object(mysql_query("SELECT * FROM modul WHERE num = '".$_SERVER["QUERY_STRING"]."'"));
	$zahlsort = mysql_fetch_object(mysql_query("SELECT * FROM displays WHERE display = '".$_SERVER["QUERY_STRING"]."' ORDER BY position DESC"));
	$coloris = mysql_fetch_object(mysql_query("SELECT * FROM modul WHERE num = '".$_SERVER["QUERY_STRING"]."'"));
}
else
{
	$tosort = mysql_fetch_object(mysql_query("SELECT * FROM modul WHERE name = '".$_SERVER["QUERY_STRING"]."'"));
	$zahlsort = mysql_fetch_object(mysql_query("SELECT * FROM displays WHERE display = '".$tosort->num."' ORDER BY position DESC"));
	$coloris = mysql_fetch_object(mysql_query("SELECT * FROM modul WHERE name = '".$_SERVER["QUERY_STRING"]."'"));
}

$modulpath = 'includes/module/';

echo '<body bgcolor="'.$coloris->backcolor.'" text="'.$coloris->fontcolor.'">';

for ($a = 1; $a <= $zahlsort->position; $a++)
{
	connectmass();
	$fragsort2 = mysql_query("SELECT * FROM displays WHERE display = '".$tosort->num."' AND position = '".$a."'");
	$rowsort = mysql_fetch_object($fragsort2);
	
	$querystring = $rowsort->sel;
	
	if (($querystring == "online") or ($querystring == "online-full"))
	{ $querystringres = 'online-'.$displayset.''; }
	elseif ($querystring == "msg")
	{ $querystringres = 'msg-'.$displayset.''; }
	elseif ($querystring == "")
	{ $querystringres = 'clear'; }
	else
	{ $querystringres = ''.$rowsort->sel.''; }
	
	include ''.$modulpath.''.$querystringres.'.php';
}

echo '</body>';

mysql_close();
if ($displayset == "moul")
{
	pg_close();
}

?>