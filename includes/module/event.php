<?php

$ergebnis = mysql_query("SELECT * FROM event");

echo '
<div align="center">
		<u><b><font size="7">TOC-Event<br>
		</font><i><font size="7">List of Participants</font></i></b></u><hr>';
		
echo '	<p align="center">Please click on the button to sign up for the event and log in with your TOC MOUL account + password.</p>
		<p align="center"><a href="event"><input type="button" value="Sign up" name="su"></a></p>
';
echo '<table border="1" cellpadding="3" cellspacing="1">
		<tr>
			<td><b>Number #</b></td>
			<td><b>Name</b></td>
			<td><b>Team (Color)</b></td>
			<td><b>Join Time</b></td>
		</tr>';

if(mysql_num_rows($ergebnis) > 0)
{
	$num = 1;
	while ($row = mysql_fetch_object($ergebnis))
	{
		echo '
			<tr>
				<td>'.$num.'</td>
				<td>'.$row->name.'</td>
				<td>'.$row->color.'</td>
				<td>'.$row->creattime.'</td>
			</tr>
		';
		$num ++;
	}
	echo '
			</table>
		</div>
	';
}
else
{
	echo '
		<td colspan="4"><p align="center"><i><b><font color="#FF0000" size="4">No Player in the list</font></b></i></td>
	';
}


?>