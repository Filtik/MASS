<?php

connectmoul();
$msgav = 0;

if (configis('moulserver') == 1)
{
	$ergmoul = pg_query('SELECT * FROM vault."Nodes" WHERE "String64_1" = \''.configis('msgtitel').'\' ORDER BY "ModifyTime" DESC');
}
elseif (configis('moulserver') == 2)
{
	$ergmoul = pg_query("SELECT * FROM textnote WHERE title = '".configis('msgtitel')."' ORDER BY modifytime DESC");
}

connectalcugs();
$ergalcugs = mysql_query("SELECT * FROM vault WHERE str_1 = '".configis('msgtitel')."'".connectalcugs()." ORDER BY mod_time DESC");

echo '<p align="center"><u><b><font size="4" face="Felix Titling">Public Message</font></b></u></p>
	<p align="center"><font size="2">If you create a new textnode with the title "'.configis('msgtitel').'" in your game, the message will appear directly here.</font></p>
	<div align="center">
        <table cellspacing="1" border="1" width="100%">
        <tr>
            <td align="center"><b><font size="4">From</font></b></td>
            <td width="80" align="center"><b><font size="4">Time</font></b></td>
            <td align="center"><b><font size="4">Text</font></b></td> 
        </tr>';

if ((pg_num_rows($ergmoul) > 0) or (mysql_num_rows($ergalcugs) > 0))
{
	$msgwho = array();
	$msgtime = array();
	$msgowner = array();
	$msgtext = array();

    while($rowmoul = pg_fetch_object($ergmoul))
    {
		if (configis('moulserver') == 1)
		{
			$idxis = pg_fetch_object(pg_query('SELECT * FROM vault."NodeRefs" WHERE "ChildIdx" = '.$rowmoul->idx.''));
			$frageplayer = 'SELECT * FROM auth."Players" WHERE "PlayerIdx" = '.$idxis->OwnerIdx.'';
			$modtimeold = date('Y-m-d H:i:s',$rowmoul->ModifyTime);
			$modtime = $rowmoul->ModifyTime;
			$text = $rowmoul->Text_1;
		}
		elseif (configis('moulserver') == 2)
		{
			$frageplayer = "SELECT * FROM playerinfo WHERE creatorid = '".$rowmoul->creatorid."'";
			$modtimeold = $rowmoul->modifytime;
			$modtime = strtotime($rowmoul->modifytime);
			$text = $rowmoul->value;
		}
		if ($modtimeold > date('Y-m-d H:i:s', strtotime('-'.configis('msgold').'')))
		{
			$ergplayer = pg_query($frageplayer);
			while($row2 = pg_fetch_object($ergplayer))
			{
				if (configis('moulserver') == 1)
				{
					$name = $row2->PlayerName;
				}
				elseif (configis('moulserver') == 2)
				{
					$name = $row2->name;
				}
				array_push($msgwho, "MOUL");
				array_push($msgtime, substr($modtime, 0, 10));
				array_push($msgowner, $name);
				array_push($msgtext, $text);
			}
		}
	}
    while($rowalcugs = mysql_fetch_object($ergalcugs))
    {
		if (date('Y-m-d H:i:s',$rowalcugs->mod_time) > date('Y-m-d H:i:s', strtotime('-'.configis('msgold').'')))
		{
			connectalcugs();
			$frageplayer = "SELECT * FROM vault WHERE idx = '".$rowalcugs->owner."'";
			$ergplayer = mysql_query($frageplayer);
			while($row2 = mysql_fetch_object($ergplayer))
			{
				array_push($msgwho, "tPots");
				array_push($msgtime, substr($rowalcugs->mod_time, 0, 10));
				array_push($msgowner, $row2->lstr_1);
				array_push($msgtext, $rowalcugs->blob_1);
			}
		}
	}
	array_multisort($msgtime, SORT_DESC, $msgwho, $msgowner, $msgtext);

	for ($x=0; $x < configis('msgmax'); $x++)
	{
		if ($msgwho[$x] != "")
		{
			$msgav = 1;
			echo '
				<tr>
					<td align="left">'.$msgowner[$x].'<br><font size="2">('.$msgwho[$x].')</font></td>
					<td align="center">'.date('Y-m-d',$msgtime[$x]).'<br>'.date('H:i:s',$msgtime[$x]).'</td>
					<td align="left">'.$msgtext[$x].'</td>
				</tr>';
		}
	}
	if ($msgav == 0)
	{
		echo '<tr><td align="center" colspan="3">Messages to old for Displaying</td></tr>';
	}
}
else
{
	echo '<tr><td align="center" colspan="3">No Messages</td></tr>';
}
    echo '</table></div>';

?>