<?php

$serverison = 0;

if ($displayset == "moul")
{
$serverisonmax = 1;
	if (serveronmoul($_SERVER['SERVER_NAME']) == 1)
	{
		$serverison ++;
	}
}
elseif ($displayset == "tpots")
{
$serverisonmax = 4;
	if (serveron(alcugs_auth) == 1)
	{
		$serverison ++;
	}
	if (serveron(alcugs_lobby) == 1)
	{
		$serverison ++;
	}
	if (serveron(alcugs_tracking) == 1)
	{
		$serverison ++;
	}
	if (serveron(alcugs_vault) == 1)
	{
		$serverison ++;
	}
}

if ($serverison == 0)
{
	echo '<p align="center"><font size="4">'.strtoupper($displayset).': <img src="img/online/red.gif" border="0" alt="Login" align="top" width="20" height="20" /></font></p>';
}
elseif ($serverison == $serverisonmax)
{
	echo '<p align="center"><font size="4">'.strtoupper($displayset).': <img src="img/online/green.gif" border="0" alt="Login2" align="top" width="20" height="20" /></font></p>';
}

?>