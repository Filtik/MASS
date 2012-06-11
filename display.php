<?php

include ('config/config.php');

$dbconn = mysql_connect($tpotshost, $tpotsuser, $tpotspass);
mysql_select_db ($dbname);
$fragdisplay = mysql_query("SELECT * FROM modul WHERE num = '".$_SERVER["QUERY_STRING"]."'");
$rowdis = mysql_fetch_object($fragdisplay);

if ($rowdis->type == "moul")
{
	$db = pg_connect('host='.$moulhost.' port='.$moulport.' dbname='.$mouldb.' user='.$mouluser.' password='.$moulpass.'');
	$displayset = "moul";
}
elseif ($rowdis->type == "tpots")
{
	$db = mysql_connect($tpotshost, $tpotsuser, $tpotspass);
	$displayset = "tpots";
}

include ('set/includes.php');

?>