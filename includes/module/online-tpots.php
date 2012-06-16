<?php 

connectalcugs();
$abplayer = "SELECT * FROM vault WHERE int_1 = 1 AND type = 23";
$ergebnis = mysql_query($abplayer);

$isonavatargroup = 0;

connectmass();
if(mysql_num_rows($ergebnis) > 0)
{ 
    echo '<p align="center">';

	$avafrag = mysql_query("SELECT * FROM groups WHERE category = '".$displayset."'");

	if(mysql_num_rows($avafrag) > 0)
	{
	while ($rowava = mysql_fetch_object($avafrag))
	{
		$avafound = preg_split("/[\s]*[,][\s]*/", $rowava->avatar);

		connectalcugs();
		$ergebnis2 = mysql_query($abplayer);
		while($row2 = mysql_fetch_object($ergebnis2))
		{
			if(in_array($row2->lstr_1, $avafound))
			{
				$isonavatargroup ++;
			}
		}
		if ($isonavatargroup > 0)
		{
			connectmass();
			$groupfrag = mysql_query("SELECT * FROM groups WHERE category = '".$displayset."' AND num = '".$rowava->num."'");
			$rowgroup = mysql_fetch_object($groupfrag);
			echo '<font color="'.$rowgroup->color.'">'.$rowgroup->name.'</font> ';
		}
	}
	}

	echo '</p>
		<div align="center">
		<table cellspacing="1" border="2"> 
        <tr> 
            <td width="150" align="center"><b><font size="4">Name</font></b></td>';
			if ($querystring == "online-full")
			{
				echo '
				<td width="50" align="center"><b><font size="4">KI #</font></b></td> 
				<td width="150" align="center"><b><font size="4">Age</font></b></td>';
			}
			echo '
        </tr>'; 

while($row = mysql_fetch_object($ergebnis))
    {
	switch($row->str_1)
        {
            case "Personal":
                $agename = "Relto";
                break;
            case "Garrison":
                $agename = "Gahreesen";
                break;
            case "Gira":
                $agename = "Eder Gira";
                break;
            case "GreatZero":
                $agename = "Great Zero";
                break;
            case "city":
                $agename = "Ae´gura";
                break;
            case "Ercana":
                $agename = "Er'cana";
                break;
            case "ErcanaCitySilo":
                $agename = "Er'cana City Silo";
                break;
            case "PelletBahroCave":
                $agename = "Pellet Bahro Cave";
                break;
            default:
                $agename = $row->str_1;
                break;
		}
		
    echo '<tr>';
		
		if(mysql_num_rows($avafrag) > 0)
		{
			connectmass();
			$isonavatargrouplist = 0;
			$avafrag2 = mysql_query("SELECT * FROM groups WHERE category = '".$displayset."'");
			while ($rowava2 = mysql_fetch_object($avafrag2))
			{
			for ($i = 1; $i <= mysql_num_rows($avafrag2); $i++)
			{
				$avafound2 = preg_split("/[\s]*[,][\s]*/", $rowava2->avatar);

				if(in_array($row->lstr_1, $avafound2))
				{
					$isonavatargrouplist ++;
					$num = $rowava2->num;
				}
			}
			}
			if ($isonavatargrouplist > 0)
			{
				$groupfrag2 = mysql_query("SELECT * FROM groups WHERE category = '".$displayset."' AND num = '".$num."'");
				$rowgroup2 = mysql_fetch_object($groupfrag2);

				echo '<td width="150" align="left"><font color="'.$rowgroup2->color.'">';
			
				if ($avatargroupimg == 1)
				{
					echo '<img border="0" src="../img/toc-new.png" width="16" height="16">';
				}
				echo ''.$row->lstr_1.'</font></td>';
			}
			else
			{
				echo '<td width="150" align="left">'.$row->lstr_1.'</td>';
			}
		}
		else
		{
			echo '<td width="150" align="left">'.$row->lstr_1.'</td>';
		}

		if ($querystring == "online-full")
		{ 
			echo '<td width="50" align="right">'.$row->owner.'</td>';
			echo '<td width="150" align="left">'.$agename.'</td></tr>';
		}
}
    echo '</table> </div>'; 
} 
else 
{ 
    echo ' 
    <div align="center">
		<table cellspacing="1" border="2"> 
        <tr> 
            <td width="150" align="center"><b><font size="4">Name</font></b></td>';
			if ($querystring == "online-full")
			{
				echo '
				<td width="50" align="center"><b><font size="4">KI #</font></b></td> 
				<td width="150" align="center"><b><font size="4">Age</font></b></td>';
				$colspan = 3;
			} else { $colspan = 1; }
			echo '
        </tr> 
        <tr> 
            <td align="center" colspan="'.$colspan.'"><i><b><font color="#FF0000"><u>All Players Offline</u></font></b></i></td> </tr>
    </table> </div>

'; 
}

?>