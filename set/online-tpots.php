<?php 

require ('config/avatar.php');

mysql_select_db ($tpotsdb);
$abplayer = "SELECT * FROM vault WHERE int_1 = 1 AND type = 23";
$ergebnis = mysql_query($abplayer);

$isonavatargroup = 0;

if(mysql_num_rows($ergebnis) > 0) 
{ 
    echo '<p align="center">';

mysql_select_db ($dbname);
	$avafrag = mysql_query("SELECT * FROM groups WHERE category = '".$displayset."'");
	$rowava = mysql_fetch_object($avafrag);
	
	for ($i = 1; $i <= mysql_num_rows($avafrag); $i++)
	{
		$isonavatargroup = 0;
		$i = $i;
mysql_select_db ($tpotsdb);
		$ergebnis2 = mysql_query($abplayer);
		while($row2 = mysql_fetch_object($ergebnis2))
		{
			$avafound = preg_split("/[\s]*[,][\s]*/", $rowava->avatar);
			
			if(in_array($row2->lstr_1, $avafound))
			{
				$isonavatargroup ++;
			}
		}
		$isonavatargroupnum = $i;
		if ($isonavatargroup > 0)
		{
			echo '<font color="'.$rowava->color.'">'.$rowava->name.'</font> ';
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
				<td width="200" align="center"><b><font size="4">Age</font></b></td>';
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
		
		if(in_array($row->lstr_1, $avafound))
		{
			echo '<td width="150" align="left"><font color="'.$rowava->color.'">';
			
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
		
		if ($querystring == "online-full")
		{ 
			echo '<td width="50" align="right">'.$row->owner.'</td>';
		
			echo '<td width="200" align="left">'.$agename.'</td></tr>';
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
$time = date("H:i:s");
$date = date("M d, Y");
echo
'
<div align="center">'.$time.'<br>'
.$date.'</div>';

?>