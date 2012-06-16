<?php

if (moulserver() == 1)
{
	$ergmoul = pg_query("SELECT * FROM textnote WHERE title = 'TOCPublic' ORDER BY modifytime DESC LIMIT 10");
}
elseif (moulserver() == 2)
{
	$ergmoul = pg_query("SELECT * FROM textnote WHERE title = 'TOCPublic' ORDER BY modifytime DESC LIMIT 10");
}

$ergalcugs = mysql_query("SELECT * FROM vault WHERE str_1 = 'TOCPublic' ORDER BY mod_time DESC LIMIT 10");

echo '<p align="center"><u><b><font size="4" face="Felix Titling">Public Message</font></b></u></p>
	<p align="center"><font size="2">If you create a new textnode with the title "TOCPublic" in your game, the message will appear directly here.</font></p>
	<div align="center">
        <table cellspacing="1" border="1" width="100%">
        <tr>
            <td align="center"><b><font size="4">From</font></b></td>
            <td width="80" align="center"><b><font size="4">Time</font></b></td>
            <td align="center"><b><font size="4">Text</font></b></td> 
        </tr>';

if(pg_num_rows($ergebnis) > 0)
{
    while($row = pg_fetch_object($ergebnis))
    {
		if (substr($row->modifytime, 0, 19) > date('Y-m-d H:i:s', strtotime('-3 months')))
		{
			$frageplayer = "SELECT * FROM playerinfo WHERE creatorid = '".$row->creatorid."'";
			$ergplayer = pg_query($frageplayer);
			while($row2 = pg_fetch_object($ergplayer))
				echo '
					<tr>
						<td align="left">'.$row2->name.'</td>
						<td align="center">'.substr($row->modifytime, 0, 10).'<br>'.substr($row->modifytime, 11, 8).'</td>
						<td align="left">'.$row->value.'</td>
					</tr>';
		}
	}
}
else
{
	echo '<tr><td align="center" colspan="3">No Messages</td></tr>';
}
    echo '</table></div>';
?>