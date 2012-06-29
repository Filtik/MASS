<?php

include ('set/functions.php');

connectmass();
$iam = $_SERVER["QUERY_STRING"];
if (is_numeric($iam) == TRUE)
{
	$fragdisplay = mysql_query("SELECT * FROM modul WHERE num = '".$_SERVER["QUERY_STRING"]."'");
	$rowdis = mysql_fetch_object($fragdisplay);
}
else
{
	$fragdisplay = mysql_query("SELECT * FROM modul WHERE name = '".$_SERVER["QUERY_STRING"]."'");
	$rowdis = mysql_fetch_object($fragdisplay);
}

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