<?php

session_start();

if($_SESSION['eventuser'] == "") 
{
	header("location:login.php");
	die;
}

function connectmass()
{
	include '../config/config.php';
	$dbmysql = mysql_connect($massalcugshost, $massalcugsuser, $massalcugspassword);
	mysql_select_db($massdb);
}
function connectmoul()
{
	include '../config/config.php';
	$dbpg = pg_connect('host='.$moulhost.' port='.$moulport.' dbname='.$mouldb.' user='.$mouluser.' password='.$moulpassword.'');
}

echo '
<body text="#FFFFFF" bgcolor="#000000">';

connectmass();
connectmoul();

if(isset($_POST['submit']))
{
	$eventavatar = $_POST['eventavatar'];
	$eventcolor = $_POST['eventcolor'];
	$table = "event";
	
	$isuserfrag = "SELECT * FROM accounts WHERE name = '".$_SESSION['eventuser']."'";
	$isuser = pg_query($isuserfrag);
	$isuserrow = pg_fetch_object($isuser);
	
	$isavatarfrag = "SELECT * FROM ".$table." WHERE moulid = '".$isuserrow->id."'";
	$isavatar = mysql_query($isavatarfrag);

	
	if (mysql_num_rows($isavatar) == 0)
	{
		$inserttpots = "INSERT INTO ".$table." values ('', '".$isuserrow->id."', '".$eventavatar."', '".$eventcolor."', now())";
		mysql_query($inserttpots) or die (mysql_error());
	}
	else
	{
		$updatetpots = "UPDATE ".$table." SET name = '".$eventavatar."', color = '".$eventcolor."' WHERE moulid = '".$isuserrow->id."'";
		mysql_query($updatetpots) or die (mysql_error());
	}
	
	
	echo '<meta http-equiv="refresh" content="5; URL=http://mass.the-open-cave.net/display.php?wall-event-moul">';
	echo '<p align="center">Your Player is inserted</p>';
	session_destroy();
}
else
{

echo '
<div align="center">
		<u><b><font size="7">TOC-Event<br>
		</font><i><font size="7">Registration form</font></i></b></u><hr>

		<p>Please Select a Avatar for Playing</p>
		<p>&nbsp;</p>
		</div>
<form method="POST" action="'.$PHP_SELF.'">
	<div align="center">
		<table border="0">
			<tr>
				<td>Name:</td>
				<td><select size="1" name="eventavatar">';
				$ergebnis = pg_query("SELECT * FROM accounts WHERE name = '".$_SESSION['eventuser']."'");
				while($row = pg_fetch_object($ergebnis))
				{
					$abfragespieler = "SELECT * FROM player WHERE creatoracctid = '".$row->id."' ORDER BY nodeid";
					$spieler = pg_query($abfragespieler);
					if(pg_num_rows($spieler) > 0)
					{
						while($avatar = pg_fetch_object($spieler))
						{
							$onavatarfrag = "SELECT * FROM event WHERE moulid = '".$row->id."' AND name = '".$avatar->name."'";
							$onavatar = mysql_query($onavatarfrag);
							if (mysql_num_rows($onavatar) != 0)
							{
								echo '
									<option selected>'.$avatar->name.'</option>
								';
							}
							else
							{
								echo '
									<option>'.$avatar->name.'</option>
								';
							}
						}
					}
				}
				echo '
					</select>
				</td>
			</tr>
			<tr>
				<td>Color:</td>
				<td><select size="1" name="eventcolor">
					<option selected>no preference</option>
					<option>violet</option>
					<option>yellow</option>
					</select>
				</td>
			</tr>
		</table>
	</div>
	<p align="center">
	<input type="submit" value="Submit" name="submit"></p>
</form>
'.$row->id.'
';

}

?>
