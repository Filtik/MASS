<?php

mysql_select_db("alcugs_vault");
$ergebnis = mysql_query("SELECT * FROM vault WHERE str_1 = 'TOCPublic' ORDER BY mod_time DESC LIMIT 10");


echo '<p align="center"><u><b><font size="4" face="Felix Titling">Public tPots Message</font></b></u></p>
	<p align="center"><font size="2">If you create a new textnode with the title "TOCPublic" in your game, the message will appear directly here.</font></p>
	<div align="center">
        <table cellspacing="1" border="1" width="100%">
        <tr>
            <td align="center"><b><font size="4">From</font></b></td>
            <td width="80" align="center"><b><font size="4">Time</font></b></td>
            <td align="center"><b><font size="4">Text</font></b></td> 
        </tr>';

if(mysql_num_rows($ergebnis) > 0) 
{
    while($row = mysql_fetch_object($ergebnis))
    {
		if (date('Y-m-d H:i:s',$row->mod_time) > date('Y-m-d H:i:s', strtotime('-3 months')))
		{
			$frageplayer = "SELECT * FROM vault WHERE idx = '".$row->owner."'";
			$ergplayer = mysql_query($frageplayer);
			while($row2 = mysql_fetch_object($ergplayer))
				echo '
					<tr>
						<td align="left">'.$row2->lstr_1.'</td>
						<td align="center">'.date('Y-m-d',$row->mod_time).'<br>'.date('H:i:s',$row->mod_time).'</td>
						<td align="left">'.$row->blob_1.'</td>
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