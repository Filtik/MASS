<?php

function connectmass()
{
	include 'config/config.php';
	$dbmysql = mysql_connect($massalcugshost, $massalcugsuser, $massalcugspassword);
	mysql_select_db($massdb);
}
function connectmoul()
{
	include 'config/config.php';
	$dbpg = pg_connect('host='.$moulhost.' port='.$moulport.' dbname='.$mouldb.' user='.$mouluser.' password='.$moulpassword.'');
}
function connectalcugs()
{
	include 'config/config.php';
	$dbmysql2 = mysql_connect($massalcugshost, $massalcugsuser, $massalcugspassword);
	mysql_select_db ($alcugsdb);
}

function serveronmoul($ip)
{
	if (! $sock = @fsockopen($ip, 14617, $num, $error, 1))
	{
		return false;
	}
	else
	{
		return true;
		fclose($sock);
	}
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

function configis($name)
{
	connectmass();
	$frag = mysql_query("SELECT * FROM config WHERE name = '".$name."'");
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