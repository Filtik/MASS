<?php

if ($displayset == "moul")
{
if (moulserver() == 1)
{
	$players = pg_query('SELECT * FROM vault."Nodes" WHERE "NodeType" = 23');
	$mtime = 'ModifyTime';
	$newgeb = pg_query('SELECT * FROM auth."Players" ORDER BY "idx" DESC');
	$erghood = pg_query('SELECT * FROM vault."Nodes" WHERE "String64_2" = \'Neighborhood\' ORDER BY "CreateTime" DESC');
	$name = 'PlayerName';
}
elseif (moulserver() == 2)
{
	$players = pg_query("SELECT modifytime FROM playerinfo");
	$mtime = 'modifytime';
	$newgeb = pg_query("SELECT * FROM player ORDER BY nodeid DESC");
	$erghood = pg_query("SELECT * FROM ageinfo WHERE string64_2 = 'Neighborhood' ORDER BY createtime DESC");
	$name = 'name';
}
}
elseif ($displayset == "tpots")
{
	connectalcugs();
	$players = mysql_query("SELECT * FROM vault WHERE type = 23");
	$mtime = 'mod_time';
	$newgeb = mysql_query("SELECT * FROM vault WHERE type = 23 ORDER BY idx DESC");
	$name = 'lstr_1';
}

$today = 0;
$yesterday = 0;
$week = 0;
$month = 0;
$year = 0;

$weekdays = array(
	date('Y-m-d', strtotime(date('o-\\WW-1'))),
	date('Y-m-d', strtotime(date('o-\\WW-2'))),
	date('Y-m-d', strtotime(date('o-\\WW-3'))),
	date('Y-m-d', strtotime(date('o-\\WW-4'))),
	date('Y-m-d', strtotime(date('o-\\WW-5'))),
	date('Y-m-d', strtotime(date('o-\\WW-6'))),
	date('Y-m-d', strtotime(date('o-\\WW-7')))
	);

$todayis = date("Y-m-d");
$yesterdayis = date("Y-m-d", strtotime('- 1 day'));
$weekis = $weekdays;
$monthis = date("Y-m");
$yearis = date("Y");

#### Today

if ($displayset == "moul")
{
	$playersdateis = pg_fetch_object;
	$row = pg_fetch_object($newgeb);
}
elseif ($displayset == "tpots")
{
	$playersdateis = mysql_fetch_object;
	$row = mysql_fetch_object($newgeb);
}

while($playersdate = $playersdateis($players))
{

if ($displayset == "moul")
{
	if (moulserver() == 1)
	{
		$playersonlydate = date("Y-m-d", $playersdate->$mtime);
	}
	elseif (moulserver() == 2)
	{
		$playersonlydate = substr($playersdate->$mtime, 0, 10);
	}
}
else
{
	$playersonlydate = date("Y-m-d", $playersdate->$mtime);
}

if ($todayis == $playersonlydate)
{
	$today ++;
}
#### Yesterday
if ($yesterdayis == $playersonlydate)
{
	$yesterday ++;
}
#### This Week
if (in_array(substr($playersonlydate, 0, 10), $weekdays))
{
	$week ++;
}
#### This Month
if ($monthis == substr($playersonlydate, 0, 7))
{
	$month ++;
}
#### This Year
if ($yearis == substr($playersonlydate, 0, 4))
{
	$year ++;
}
}

echo '
<table border="0" width="100%">
	<tr>
		<td>
		<p align="center">
		<u><b><font face="Felix Titling">Online Players<br>Statistics</font></b></u></p>
		<div align="center">
	<table border="0" width="100%">
		<tr>
			<td width="110">Today:</td>
			<td align="right"><b>'.$today.'</b></td>
		</tr>
		<tr>
			<td>Yesterday:</td>
			<td align="right"><b>'.$yesterday.'</b></td>
		</tr>
		<tr>
			<td>This Week:</td>
			<td align="right"><b>'.$week.'</b></td>
		</tr>
		<tr>
			<td>This Month:</td>
			<td align="right"><b>'.$month.'</b></td>
		</tr>
		<tr>
			<td>This Year:</td>
			<td align="right"><b>'.$year.'</b></td>
		</tr>
		<tr>
			<td>Newest Member:</td>
			<td align="right"><b>'.$row->$name.'</b></td>
		</tr>';

		if ($displayset == "moul")
		{
		echo '
		<tr>
			<td>Newest Hood:</td>
			<td align="right">
';

$hood = pg_fetch_object($erghood);
if (moulserver() == 1)
{
	if($hood->Int32_1 == 0)
	{
		echo '<b>'.$hood->Text_1.'</b>';
	}
	else
	{
		echo '<b>'.$hood->String64_4.'('.$hood->Int32_1.')</b>';
	}
}
elseif (moulserver() == 2)
{
	if($hood->int32_1 == 0)
	{
		echo '<b>'.$hood->text_1.'</b>';
	}
	else
	{
		echo '<b>'.$hood->string64_4.'('.$hood->int32_1.')</b>';
	}
}
echo '</td>
		</tr>';
		}
		echo '
	</table>
</div></td>
	</tr>
</table>
';


?>