<?php 


if ($moulserver == 1)
{
	$abfrage = 'SELECT * FROM vault."Nodes" WHERE "NodeType" = 23 AND "Int32_1" = 1 ORDER BY "String64_1", "IString64_1"';
}
elseif ($moulserver == 2)
{
	$abfrage = "SELECT * FROM playerinfo WHERE online = 1 ORDER BY string64_1, name";
}

$ergebnis = pg_query($abfrage);

$isonavatargroupnum = 0;
$isonavatargroup = 0;

if(pg_num_rows($ergebnis) > 0) 
{ 
    echo '<p align="center">';

mysql_select_db ($dbname);
	$avafrag = mysql_query("SELECT * FROM groups WHERE category = '".$displayset."'");
	$rowava = mysql_fetch_object($avafrag);
	
	for ($i = 1; $i <= mysql_num_rows($avafrag); $i++)
	{
		$isonavatargroup = 0;
		$i = $i;
		$ergebnis2 = pg_query($abfrage);
		while($row2 = pg_fetch_object($ergebnis2))
		{
		
		if ($moulserver == 1)
		{$name = $row2->IString64_1;}
		elseif ($moulserver == 2)
		{$name = $row2->name;}
		
			$avafound = preg_split("/[\s]*[,][\s]*/", $rowava->avatar);
			
			if(in_array($name, $avafound))
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

while($row = pg_fetch_object($ergebnis))
    {
	
	if ($moulserver == 1)
	{
		$name = $row->IString64_1;
		$ageis = $row->String64_1;
		$ki = $row->CreatorIdx;
	}
	elseif ($moulserver == 2)
	{
		$name = $row->name;
		$ageis = $row->string64_1;
		$ki = $row->ki;
	}
	
	switch($ageis)
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
                $agename = $ageis;
                break;
		}
		
    echo '<tr>';
		
		if(in_array($name, $avafound))
		{
			echo '<td width="150" align="left"><font color="'.$rowava->color.'">';
			
			if ($avatargroupimg == 1)
			{
				echo '<img border="0" src="../img/toc-new.png" width="16" height="16">';
			}
			
			echo ''.$name.'</font></td>';
		}
		else
		{
			echo '<td width="150" align="left">'.$name.'</td>';
		}
		
		if ($querystring == "online-full")
		{ 
		echo '<td width="50" align="right">'.$ki.'</td>';
		
		if($row->string64_1 == 'Hood')
		{
			$fragmem = "SELECT * FROM ageinfo A, playerinfo P WHERE P.ki = ".$ki." AND A.uuid_1 = P.uuid_1 AND A.string64_3 = 'Hood'";
			$ergmem = pg_query($fragmem);
			while($hood = pg_fetch_object($ergmem))
				echo '<td width="200" align="left">'.$hood->text_1.'</td></tr>';
		}
		elseif($row->string64_1 == 'Bevin')
		{
			$fragmem = "SELECT * FROM ageinfo A, playerinfo P WHERE P.ki = ".$ki." AND A.uuid_1 = P.uuid_1 AND A.string64_3 = 'Bevin'";
			$ergmem = pg_query($fragmem);
			while($bevin = pg_fetch_object($ergmem))
				echo '<td width="200" align="left">'.$bevin->string64_4.'('.$bevin->int32_1.')</td></tr>';
		}
		else
		{
			echo '<td width="200" align="left">'.$agename.'</td></tr>';
        }
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