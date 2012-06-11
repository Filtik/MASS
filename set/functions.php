<?php

######################
######################

function available($table, $from)
{
	$frag = mysql_query("SELECT * FROM ".$table." ORDER BY num DESC");
	$erg = mysql_fetch_object($frag);
	
	if ($erg->num == 0)
	{
		return 1;
	}
	else
	{
		for($x=1; $x-1 <= $erg->num; $x++)
		{
			$frag2 = mysql_query("SELECT * FROM ".$table." WHERE ".$from." = '".$x."'");
			$erg2 = mysql_num_rows($frag2);
			
			if ($erg2 == 0)
			{
				return $x;
				break;
			}			
		}
	}
}


function sqlwhere($table, $from, $where, $rueck)
{
	$frag = mysql_query("SELECT * FROM ".$table." WHERE ".$from." = '".$where."'");
	if(mysql_num_rows($frag) > 1)
	{
		for($e=1; $e <= mysql_num_rows($frag); $e++)
		{
			$erg = mysql_fetch_object($frag);
			$return .= $erg->$rueck;

			if ($e != mysql_num_rows($frag))
			{
				$return .= ', ';
			}
		}
	}
	else
	{
		$erg = mysql_fetch_object($frag);
		$return = $erg->$rueck;
	}
	return $return;
}
function sqlrows($table, $from, $where, $rueck)
{
	if ($where == '')
	{
		$frag = mysql_query("SELECT * FROM ".$table." WHERE ".$from." = '".$where."'");
		$erg = mysql_num_rows($frag);
	}
	else
	{
		$frag = mysql_query("SELECT * FROM ".$table."");
		$erg = mysql_num_rows($frag);
	}
	
	$return = $erg->$rueck;

	return $return;

}
function sqlaccounts($table)
{
	$frag = mysql_query("SELECT * FROM ".$table."");
	
	$tohood = newboxes0001;
	$header = myHeader0001;

	
	while($row = mysql_fetch_object($frag))
	{
		$accdelete = "accdelete".$row->num."";
		$accnum = "accnum".$row->num."";
		$accname = "accname".$row->num."";
		$accpass = "accpass".$row->num."";
		
		echo '
			<tr>
				<td align="center"><input type="text" name="T1" size="1" value="'.$row->num.'" disabled></td>
				<td align="center">'.$row->name.'</td>
				<td align="center">				<table border="0" width="100%">
					<tr>
						<td width="33%" align="center">&nbsp;</td>
						<td width="33%" align="center"><a id="'.$header.'" href="javascript:showonlyone('; echo"'".$tohood."'"; echo');" ><input type="button" value="Show"></a><div name="newboxes" id="'.$tohood.'" style="display: none">
							<form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=CHANGE&CHANGE='.$accpass.'&SAVE"><input type="text" name="'.$accpass.'" value="'.$row->password.'" size="50"></div></td>
						<td width="33%" align="center">
							<div name="newboxes" id="'.$tohood.'" style="display: none"><input type="submit" value="Change" name="B2"></form></div>
							<form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=DELETE&DELETE='.$accdelete.'&SAVE"><input type="submit" value="DELETE" name="B1"></form></td>
					</tr>
				</table>
				</td>
			</tr>';
		$tohood ++;
		$header ++;
	}
}
function accountset($name, $pw)
{
		print $pw;
		$table = "accounts";
		$pwis = sha1(''.$name.''.$pw.'');
		$insert = "INSERT INTO ".$table." values (".available(''.$table.'', 'num').", '".$name."', '".$pwis."')";
	
	if ($_GET['action'] == "DELETE")
	{
		$num = substr($_GET['DELETE'], -1);
		$delete = "DELETE FROM ".$table." WHERE num = '".$num."'";
		mysql_query($delete) or die (mysql_error());
	}
	elseif ($_GET['action'] == "CHANGE")
	{
		if ($_GET['CHANGE'] != "")
		{
			$num = substr($_GET['CHANGE'], -1);
			$sel = mysql_fetch_object(mysql_query("SELECT * FROM ".$table." WHERE num = '".$num."'"));
			$name = $sel->name;
			$pwis = sha1(''.$name.''.$pw.'');
			
			$update = "UPDATE ".$table." SET password = '".$pwis."' WHERE num = '".$num."'";
			mysql_query($update) or die (mysql_error());
			print $update;
		}
	}
	elseif ($_GET['action'] == "NEW")
	{
		mysql_query($insert) or die (mysql_error());
	}
}

function group_list($arrayfrag)
{	
	if ($arrayfrag == "groupmoul")
	{
		$first = 'moul';
	}
	elseif ($arrayfrag == "grouptpots")
	{
		$first = 'tpots';
	}
	
	$frag = mysql_query("SELECT * FROM groups WHERE category = '".$first."'");
	
	while($rows = mysql_fetch_object($frag))
	{
	
		$groupdelete = "groupdelete".$rows->num."";
		$groupnum = "groupnum".$rows->num."";
		$groupname = "groupname".$rows->num."";
		$groupcolor = "groupcolor".$rows->num."";
		$groupavatar = "groupavatar".$rows->num."";
		
		echo '
		<tr>
			<td width="25%">
				<table border="0" width="100%">
					<tr>
						<td width="75%"><input type="text" name="'.$groupnum.'" size="2" value="'.$rows->num.'" disabled></td>
						<td width="25%"><p align="right"><a href="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=DELETE&DELETE='.$groupdelete.'&SAVE"><input type="submit" value="DELETE" name="'.$groupdelete.'"></a></td>
					</tr>
				</table>
				</td>
				<td width="25%">
				<table border="0" width="100%">
					<tr><form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=RENAME&RENAME='.$groupname.'&SAVE">
						<td width="25%"><input type="text" name="'.$groupname.'" size="20" value="'.$rows->name.'"></td>
						<td width="75%"><p align="right"><input type="submit" value="Change Name" name="B2"></td>
						</form></tr>
					</table>
				</td>
				<td bgcolor="'.$rows->color.'" width="25%">
				<table border="0" width="100%">
					<tr><form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=COLOR&COLOR='.$groupcolor.'&SAVE">
						<td width="50%"><input type="text" name="'.$groupcolor.'" size="20" value="'.$rows->color.'"></td>
						<td width="50%"><p align="right"><input type="submit" value="Change Color" name="B3"></td>
					</form></tr>
				</table>
				</td>
				<td width="25%">
				<table border="0" width="100%">
					<tr><form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=AVATAR&AVATAR='.$groupavatar.'&SAVE">
						<td width="75%"><textarea rows="5" name="'.$groupavatar.'" cols="30">'.$rows->avatar.'</textarea></td>
						<td width="25%"><input type="submit" value="SAVE" name="T1"></a></td>
					</form></tr>
				</table>
			</td>
		</tr>
	';
	}
}
######################
######################

function serveron($pid)
{
     // create our system command
	$cmd = "ps -e | grep -w ".$pid."";
 
     // run the system command and assign output to a variable ($output)
	exec($cmd, $output, $result);
 
     // check the number of lines that were returned
	if(count($output) >= 1){
		// the process is still alive
		return true;
	}
 
	// the process is dead
	return false;
}

function moulserver($name)
{
	require ('../config/config.php');
	
	if ($name == "dirtsand")
	{
		if ($moulserver == 1)
		{
			return "checked";
		}
		else
		{
			return "";
		}
	}
	elseif ($name == "moss")
	{
		if ($moulserver == 2)
		{
			return "checked";
		}
		else
		{
			return "";
		}
	}
}

function onoffind($name)
{
	require ('../config/config.php');
	
	if ($name == "moulonoff")
	{
		$check = $moulonoff;
	}
	elseif ($name == "tpotsonoff")
	{
		$check = $tpotsonoff;
	}
	
	if ($check == 1)
	{
		return "checked";
	}
	else
	{
		return "";
	}
}

function list_array($arrayfrag)
{
	require ('../config/displayset.php');
	
	if ($arrayfrag == "displaymoul")
	{
		$array = $displaymoul;
	}
	elseif ($arrayfrag == "displaytpots")
	{
		$array = $displaytpots;
	}
	
    for($x=0; $x < count($array); $x++)
    {
        $inhalt .= $array[$x]. ", " ;
    }
    return $inhalt;
}

function DSEND($display, $position, $select)
{
	$fragdis = mysql_query("SELECT * FROM displays WHERE display = '".$display."'");
	if(mysql_num_rows($fragdis) > 0)
	{		
		$fragpos = mysql_query("SELECT * FROM displays WHERE display = '".$display."' AND position = '".$position."'");
		if(mysql_num_rows($fragpos) > 0)
		{
			$selrow = mysql_fetch_object($fragpos);
			
			if ($select == "DELETE")
			{
				$update = "DELETE FROM displays WHERE display = '".$display."' AND position = '".$position."'";
				mysql_query($update) or die (mysql_error());
			}
			else
			{
				if ($selrow->select != $select)
				{
					$update = "UPDATE displays SET sel = '".$select."' WHERE display = '".$display."' AND position = '".$position."'";
					mysql_query($update) or die (mysql_error());
				}
			}
		}
		else
		{			
			if($select != "DELETE")
			{
				mysql_query("INSERT INTO displays values (".available('displays', 'num').", '$display', '$position', '$select')") or die (mysql_error());
			}
		}		
	}
}

function addmodul($game)
{
			echo '
			<tr>
				<td width="50%"><p align="right">Modul #</td>
				<td width="50%">Modul Name</td>
			</tr>';
			
		$fragdis = mysql_query("SELECT * FROM modul WHERE type = '".$game."' ORDER BY num ASC");
		if(mysql_num_rows($fragdis) > 0)
		{
			
		while($row = mysql_fetch_object($fragdis))
		{
		
		$displaydelete = "displaydelete".$row->num."";
		$displaynum = "displaynum".$row->num."";
		$displayname = "displayname".$row->num."";
		
			echo '
			<tr>
				<td width="50%">
				<table border="0" width="100%">
					<tr>
						<td width="75%"><a href="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=DELETE&DELETE='.$displaydelete.'&SAVE"><input type="submit" value="DELETE" name="'.$displaydelete.'"></a></td>
						<td width="25%"><p align="right"><input type="text" name="'.$displaynum.'" size="2" value="'.$row->num.'" disabled></td>
					</tr>
				</table>
				</td>
				<td width="50%">
				<table border="0" width="100%">
					<tr><form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=RENAME&RENAME='.$displayname.'&SAVE">
						<td width="25%"><input type="text" name="'.$displayname.'" size="20" value="'.$row->name.'"></td>
						<td width="75%"><p align="right"><input type="submit" value="Change Name" name="B3"></td>
					</form></tr>
				</table>
				</td>
			</tr>
			';				
		}
		}
		else
		{
			echo '<tr><td colspan="2"><p align="center">No Display available</p></td></tr>';
		}
}

function modulvar($change)
{
	if ($_GET['Set'] == "Modul")
	{
		$table = "modul";
		$insertmoul = "INSERT INTO ".$table." values (".available(''.$table.'', 'num').", 'moul', 'newtpots".$table."')";
		$inserttpots = "INSERT INTO ".$table." values (".available(''.$table.'', 'num').", 'tpots', 'newtpots".$table."')";
	}
	elseif ($_GET['Set'] == "Group")
	{
		$table = "groups";
		$insertmoul = "INSERT INTO ".$table." values (".available(''.$table.'', 'num').", 'moul', 'newtpots".$table."', 'black', 'Please insert here the Avatars')";
		$inserttpots = "INSERT INTO ".$table." values (".available(''.$table.'', 'num').", 'tpots', 'newtpots".$table."', 'black', 'Please insert here the Avatars')";
	}
	
	if ($_GET['action'] == "DELETE")
	{
		$num = substr($_GET['DELETE'], -1);
		$delete = "DELETE FROM ".$table." WHERE num = '".$num."'";
		mysql_query($delete) or die (mysql_error());
	}
	elseif ($_GET['action'] == "RENAME")
	{
		if ($_GET['RENAME'] != "")
		{
			$num = substr($_GET['RENAME'], -1);
			$update = "UPDATE ".$table." SET name = '".$change."' WHERE num = '".$num."'";
			mysql_query($update) or die (mysql_error());
			print $name;
			print $num;
		}
	}
	elseif ($_GET['action'] == "COLOR")
	{
		if ($_GET['COLOR'] != "")
		{
			$num = substr($_GET['COLOR'], -1);
			$update = "UPDATE ".$table." SET color = '".$change."' WHERE num = '".$num."'";
			mysql_query($update) or die (mysql_error());
			print $name;
			print $num;
		}
	}
	elseif ($_GET['action'] == "AVATAR")
	{
		if ($_GET['AVATAR'] != "")
		{
			$num = substr($_GET['AVATAR'], -1);
			$update = "UPDATE ".$table." SET avatar = '".$change."' WHERE num = '".$num."'";
			mysql_query($update) or die (mysql_error());
			print $name;
			print $num;
		}
	}
	elseif ($_GET['action'] == "NEW")
	{
		if ($_GET['NEW'] == "moul")
		{
			mysql_query($insertmoul) or die (mysql_error());
		}
		elseif ($_GET['NEW'] == "tpots")
		{
			mysql_query($inserttpots) or die (mysql_error());
		}
	}

}


?>