<?php

function connectmass()
{
	include 'config/config.php';
	$db = mysql_connect($massalcugshost, $massalcugsuser, $massalcugspassword);
	mysql_select_db($massdb);
}
function connectmoul()
{
	include 'config/config.php';
	$db = pg_connect('host='.$moulhost.' port='.$moulport.' dbname='.$mouldb.' user='.$mouluser.' password='.$moulpassword.'');
}
function connectalcugs()
{
	include 'config/config.php';
	$db = mysql_connect($massalcugshost, $massalcugsuser, $massalcugspassword);
	mysql_select_db ($alcugsdb);
}

function serveron($pid)
{
	$cmd = "ps -e | grep -w ".$pid."";
	
	exec($cmd, $output, $result);
	
	if(count($output) >= 1){
		return true;
	}
	return false;
}

function moulserver()
{
	$frag = mysql_query("SELECT * FROM config WHERE name = 'moulserver'");
	$erg = mysql_fetch_object($frag);
	
	return $erg->params;
}

function onoffind($name)
{
	require ('../config/config.php');
	
	if ($name == "moulonoff")
	{
		$check = $moulonoff;
	}
	elseif ($name == "tpotsonoff")
	{
		$check = $tpotsonoff;
	}
	
	if ($check == 1)
	{
		return "checked";
	}
	else
	{
		return "";
	}
}

?>