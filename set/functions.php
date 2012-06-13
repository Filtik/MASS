<?php

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