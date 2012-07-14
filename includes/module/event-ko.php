<?php

echo '
<script src="includes/scripts/event-ko.js" type="text/javascript"></script>

<div style="position: absolute; margin: 5px 5px 5px 5px;">
';

connectmass();

$playername = array();
$playercolor = array();

$ergebnis = mysql_query("SELECT * FROM event_ko");
$players = mysql_num_rows($ergebnis);

$maxteams = $players;

$hoehe = $maxteams-1;
$teamnum = 1;
$breite = log($maxteams,10)/log(2,10);

function eintrag($zeile,$potenz)
{
	for ($i=0;$i<=$zeile;$i++)
	{
		$beginn = bcpow(2,$potenz);
		$resume = $beginn*2;
		$zeileis = $beginn+($resume*$i);
		
		if ($zeile == $zeileis)
		{
			break;
		}
	}
	return $zeileis;
}

$round = array(1 => "round1win", "round2win", "round3win", "round4win", "round5win");
$nameround = array(1 => 0, 0, 0, 0, 0, 0, 0);
$tableround = array(1 => array(0 => 0), array(0 => 0), array(0 => 0), array(0 => 0), array(0 => 0), array(0 => 0), array(0 => 0));
$tableroundbreak = array(1 => array(0 => 0), array(0 => 0), array(0 => 0), array(0 => 0), array(0 => 0), array(0 => 0), array(0 => 0));
$scripts = array();
$scriptnum = array();

for ($zeile=1;$zeile<=$hoehe;$zeile++)
{
	for ($spalte=1;$spalte<=$breite;$spalte++)
	{
		$potenz = $spalte-1;
		$isidnumtable = $zeile+($spalte*100);
		$isidnumtablebreak = $zeile+($spalte*1000);
		array_push($tableround[$spalte], $isidnumtable);
		array_push($tableroundbreak[$spalte], $isidnumtablebreak);
		if ( $zeile == eintrag($zeile,$potenz))
		{
			if ($spalte != 1)
			{
					echo '
						<div style="visibility: hidden; z-index: 101; position: absolute;" id="'.$isidnumtablebreak.'">

							<table cellpadding="0" cellspacing="0" border="0" style="height: 100%;">

								<tr>

									<td height="1"><img src="img/event/binding_end.gif" border="0" alt="" height="1"></td>

								</tr>

								<tr style="background-image: url(img/event/binding_spacer.gif);">

									<td><img src="img/event/binding_mid.gif" border="0" alt="" height="1"></td>

								</tr>

								<tr>

									<td height="1"><img src="img/event/binding_end.gif" border="0" alt="" height="1"></td>

								</tr>

							</table>

						</div>
';
			}
			
		echo '<div class="node" style="visibility: hidden; z-index: 100; position:absolute;background-color: #EFEFEF; border: 1px solid #999999; width: 115px; height: auto;" id="'.$isidnumtable.'">
';
			
			echo '<table cellpadding="0" cellspacing="1" border="0" class="node" style="width: 115px;">';
			for ($print=1;$print<=2;$print++)
			{
			if ($potenz == 0)
			{
				$erg = mysql_query("SELECT name,color FROM event_ko");
					print '<tr><td bgcolor="'.mysql_result($erg, $nameround[$potenz], 1).'">'.mysql_result($erg, $nameround[$potenz]).'</td></tr>';
					$nameround[$potenz] ++;
			}
			elseif ($potenz > 0)
			{
				$roundis = $round[$potenz];
				$erg = mysql_query("SELECT name,color FROM event_ko WHERE ".$roundis." = true");
				if(mysql_num_rows($erg) > 0)
				{
					if (mysql_result($erg, $nameround[$potenz]) == "")
					{
						print "<tr><td>WAITING...</td></tr>";
					}
					else
					{
						print '<tr><td bgcolor="'.mysql_result($erg, $nameround[$potenz], 1).'">'.mysql_result($erg, $nameround[$potenz]).'</td></tr>';
						$nameround[$potenz] ++;
					}
				}
				else
				{
					print "<tr><td>----</td></tr>";
				}
			}
			}
			
			echo '</table>';
		echo '</div>
';
		}
	}
}

for ($zeile=1;$zeile<=$hoehe;$zeile++)
{
	for ($spalte=1;$spalte<=$breite;$spalte++)
	{
		$potenz = $spalte-1;
		if ( $zeile == eintrag($zeile,$potenz))
		{
			$beginn = bcpow(2,$potenz);
			$resume = $beginn*2;
			$zeileis = $beginn/2;
			if ($potenz == 0)
			{
				$numvor = $zeile-$resume;
				$oldistableid = $tableround[$spalte][$numvor];
				$scriptis = '<script type="text/javascript">setTimeout("replace_node_v(\''.$oldistableid.'\',\''.$tableround[$spalte][$zeile].'\')",100);</script>';
			}
			elseif ($potenz > 0)
			{
				$is = $zeile+$zeileis;
				$numvor = $zeile-$zeileis;
				$oldistableid = $tableround[$potenz][$numvor];
				$scriptis = '<script type="text/javascript">setTimeout("replace_node(\''.$oldistableid.'\',\''.$tableround[$spalte][$zeile].'\',\''.$tableround[$potenz][$is].'\',\''.$tableroundbreak[$spalte][$zeile].'\')",200);</script>';
			}
				array_push($scripts, $scriptis);
				$scriptnumis = $oldistableid;
				array_push($scriptnum, $scriptnumis);
		}
	}
}
array_multisort($scripts, $scriptnum);
for ($zeile=1;$zeile<=count($scripts);$zeile++)
{
	list($key, $val) = each($scripts);
	echo ''.$val.'
';
}

#print_r ($tableround);

?>