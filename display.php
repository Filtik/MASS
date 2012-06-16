<?php

include ('set/functions.php');

connectmass();
$fragdisplay = mysql_query("SELECT * FROM modul WHERE num = '".$_SERVER["QUERY_STRING"]."'");
$rowdis = mysql_fetch_object($fragdisplay);

if ($rowdis->type == "moul")
{
	connectmoul();
	$displayset = "moul";
}
elseif ($rowdis->type == "tpots")
{
	connectalcugs();
	$displayset = "tpots";
}

include ('set/sort.php');

?>