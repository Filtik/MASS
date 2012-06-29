<?php

######################
######################

function connectmass()
{
	include '../config/config.php';
	$db = mysql_connect($massalcugshost, $massalcugsuser, $massalcugspassword);
	mysql_select_db ($massdb);
}

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


function settingsquery($name)
{
	$frag = mysql_query("SELECT * FROM config WHERE name = '".$name."'");
	$erg = mysql_fetch_object($frag);

	return $erg->params;
}
function generalset()
{
	for ($x=1; $x < count($_POST); $x++)
	{
		list($key, $val) = each($_POST);

		$frag = mysql_query("SELECT * FROM config WHERE name = '".$key."'");

		if (mysql_num_rows($frag) == 0)
		{
			$insert = "INSERT INTO config values (".available('config', 'num').", '".$key."', '".$val."')";
			mysql_query($insert);
		}
		else
		{
			$update = "UPDATE config SET params = '".$val."' WHERE name = '".$key."'";
			mysql_query($update);
		}
	}
}


function sqlaccounts($table)
{
	$frag = mysql_query("SELECT * FROM ".$table." ORDER BY num ASC");

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
							<div name="newboxes" id="'.$tohood.'" style="display: none"><input type="submit" value="Change" name="B2"></form></div>';
							if ($row->num != 0) { echo '<form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=DELETE&DELETE='.$accdelete.'&SAVE"><input type="submit" value="DELETE" name="B1"></form>'; } echo'</td>
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
		}
	}
	elseif ($_GET['action'] == "NEW")
	{
		mysql_query($insert) or die (mysql_error());
	}
}

function serveron($pid)
{
	$cmd = "ps -e | grep -w ".$pid."";

	exec($cmd, $output, $result);

	if(count($output) >= 1){
		return true;
	}
	return false;
}

function moulserver($name)
{
	$frag = mysql_query("SELECT * FROM config WHERE name = 'moulserver'");
	$erg = mysql_fetch_object($frag);

	if ($name == "dirtsand")
	{
		if ($erg->params == 1) { return "checked"; }
		else { return ""; }
	}
	elseif ($name == "moss")
	{
		if ($erg->params == 2) { return "checked"; }
		else { return ""; }
	}
}

######################
######################

function DSEND($display, $position, $select)
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
			if(($select != "DELETE") or ($select != ""))
			{
				mysql_query("INSERT INTO displays values (".available('displays', 'num').", '$display', '$position', '$select')") or die (mysql_error());
			}
		}
}

function group_list($game)
{
	echo '	<tr>
				<td width="25%">Group No.</td>
				<td width="25%">Group Pic:</td>
				<td width="25%">Group Name:</td>
				<td width="25%">Group Color:</td>
				<td width="25%">Group Avatars:</td>
			</tr>';
	$frag = mysql_query("SELECT * FROM groups WHERE category = '".$game."' ORDER BY num ASC");

	while($rows = mysql_fetch_object($frag))
	{
		$picpath = '../img/group/';
		$groupdelete = "groupdelete".$rows->num."";
		$groupnum = "groupnum".$rows->num."";
		$groupname = "groupname".$rows->num."";
		$grouppic = "grouppic".$rows->num."";
		$groupcolor = "groupcolor".$rows->num."";
		$groupavatar = "groupavatar".$rows->num."";

		echo '
		<tr>
			<td>
				<table border="0" width="100%">
					<tr>
						<td align="center"><input type="text" name="'.$groupnum.'" size="2" value="'.$rows->num.'" disabled></td>
					</tr>
					<tr>
						<td align="center"><a href="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=DELETE&DELETE='.$groupdelete.'&SAVE"><input type="submit" value="DELETE" name="'.$groupdelete.'"></a></td>
					</tr>
				</table>
				</td>
				<td>
				<table border="0" width="100%">
					<tr>
						<td align="center">'; if ($rows->pic != ""){ echo'<p><img border="0" src="'.$picpath.''.$rows->pic.'" width="20" height="20"></p>'; } echo'</td>
					</tr>
					<tr><form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=PIC&PIC='.$grouppic.'&SAVE">
						<td align="center"><input type="text" name="'.$grouppic.'" size="10" value="'.$rows->pic.'"></td>
						</tr>
					<tr>
						<td align="center"><input type="submit" value="Change Pic" name="B2"></td>
					</form></tr>
				</table>
				</td>
				<td>
				<table border="0" width="100%">
					<tr><form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=RENAME&RENAME='.$groupname.'&SAVE">
						<td align="center"><input type="text" name="'.$groupname.'" size="10" value="'.$rows->name.'"></td>
						</tr>
					<tr>
						<td align="center"><input type="submit" value="Change Name" name="B2"></td>
					</form></tr>
				</table>
				</td>
				<td>
				<table border="0" width="100%">
					<tr><form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=COLOR&COLOR='.$groupcolor.'&SAVE">
						<td align="center"><p><font color="'.$rows->color.'">TEST</font></p></td>
					</tr>
					<tr>
						<td align="center" bgcolor="'.$rows->color.'"><input type="text" name="'.$groupcolor.'" size="5" value="'.$rows->color.'"></td>
					</tr>
					<tr>
						<td align="center"><input type="submit" value="Change Color" name="B3"></td>
					</form></tr>
				</table>
				</td>
				<td>
				<table border="0" width="100%">
					<tr><form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=AVATAR&AVATAR='.$groupavatar.'&SAVE">
						<td align="center"><textarea rows="5" name="'.$groupavatar.'" cols="30">'.$rows->avatar.'</textarea></td>
					</tr>
					<tr>
						<td align="center"><input type="submit" value="SAVE" name="T1"></a></td>
					</form></tr>
				</table>
			</td>
		</tr>
	';
	}
}

function addmodul($game)
{
	echo '	<tr>
				<td width="25%">Modul No.</td>
				<td width="25%">Backcolor</td>
				<td width="25%">Fontcolor</td>
				<td width="25%">Name</td>
			</tr>';

		$fragdis = mysql_query("SELECT * FROM modul WHERE type = '".$game."' ORDER BY num ASC");
		if(mysql_num_rows($fragdis) > 0)
		{
		while($row = mysql_fetch_object($fragdis))
		{
		$moduldelete = "moduldelete".$row->num."";
		$modulnum = "modulnum".$row->num."";
		$modulname = "modulname".$row->num."";
		$modulbackcolor = "modulbackcolor".$row->num."";
		$modulfontcolor = "modulfontcolor".$row->num."";
		
			echo '
			<tr>
				<td width="25%">
				<table border="0" width="100%">
					<tr>
						<td align="center"><input type="text" name="'.$modulnum.'" size="2" value="'.$row->num.'" disabled></td>
					</tr>
					<tr>
						<td align="center"><a href="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=DELETE&DELETE='.$moduldelete.'&SAVE"><input type="submit" value="DELETE" name="'.$moduldelete.'"></a></td>
					</tr>
				</table>
				</td>
				<td width="25%">
				<table border="0" width="100%">
					<tr><form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=BCOLOR&BCOLOR='.$modulbackcolor.'&SAVE">
						<td align="center"><p><font color="'.$row->fontcolor.'"><span style="background-color: '.$row->backcolor.'">TEST</span></font></p></td>
					</tr>
					<tr>
						<td align="center" bgcolor="'.$row->backcolor.'"><input type="text" name="'.$modulbackcolor.'" size="5" value="'.$row->backcolor.'"></td>
					</tr>
					<tr>
						<td align="center"><input type="submit" value="Change Backcolor" name="B1"></td>
					</form></tr>
				</table>
				</td>
				<td width="25%">
				<table border="0" width="100%">
					<tr><form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=FCOLOR&FCOLOR='.$modulfontcolor.'&SAVE">
						<td align="center"><p><font color="'.$row->fontcolor.'"><span style="background-color: '.$row->backcolor.'">TEST</span></font></p></td>
					</tr>
					<tr>
						<td align="center" bgcolor="'.$row->fontcolor.'"><input type="text" name="'.$modulfontcolor.'" size="5" value="'.$row->fontcolor.'"></td>
					</tr>
					<tr>
						<td align="center"><input type="submit" value="Change Fontcolor" name="B2"></td>
					</form></tr>
				</table>
				</td>
				<td width="25%">
				<table border="0" width="100%">
					<tr><form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=RENAME&RENAME='.$modulname.'&SAVE">
						<td align="center"><input type="text" name="'.$modulname.'" size="10" value="'.$row->name.'"></td>
					</tr>
					<tr>
						<td align="center"><input type="submit" value="Change Name" name="B3"></td>
					</form></tr>
				</table>
				</td>
			</tr>
			';				
		}
		}
		else
		{
			echo '<tr><td colspan="4"><p align="center">No Display available</p></td></tr>';
		}
}

function modulvar($change)
{
	if ($_GET['Set'] == "Modul")
	{
		$table = "modul";
		$insertmoul = "INSERT INTO ".$table." values (".available(''.$table.'', 'num').", 'moul', 'newmoul".$table."', 'white', 'black')";
		$inserttpots = "INSERT INTO ".$table." values (".available(''.$table.'', 'num').", 'tpots', 'newtpots".$table."', 'white', 'black')";
	}
	elseif ($_GET['Set'] == "Group")
	{
		$table = "groups";
		$insertmoul = "INSERT INTO ".$table." values (".available(''.$table.'', 'num').", 'moul', '', 'newmoul".$table."', 'black', 'example, system, Avatar')";
		$inserttpots = "INSERT INTO ".$table." values (".available(''.$table.'', 'num').", 'tpots', '', 'newtpots".$table."', 'black', 'example, system, Avatar')";
	}
	
	if ($_GET['action'] == "DELETE")
	{
		$num = substr($_GET['DELETE'], 11);
		$delete = "DELETE FROM ".$table." WHERE num = '".$num."'";
		mysql_query($delete) or die (mysql_error());

		$whodelete = substr($_GET['DELETE'], 11);
		if ($whodelete == 'moduldelete')
		{
			$delete2 = "DELETE FROM displays WHERE display = '".$num."'";
			mysql_query($delete2) or die (mysql_error());
		}
	}
	elseif ($_GET['action'] == "RENAME")
	{
		if ($_GET['RENAME'] != "")
		{
			$num = substr($_GET['RENAME'], 9);
			$update = "UPDATE ".$table." SET name = '".$change."' WHERE num = '".$num."'";
			mysql_query($update) or die (mysql_error());
		}
	}
	elseif ($_GET['action'] == "PIC")
	{
		if ($_GET['PIC'] != "")
		{
			$num = substr($_GET['PIC'], 8);
			$update = "UPDATE ".$table." SET pic = '".$change."' WHERE num = '".$num."'";
			mysql_query($update) or die (mysql_error());
		}
	}
	elseif ($_GET['action'] == "COLOR")
	{
		if ($_GET['COLOR'] != "")
		{
			$num = substr($_GET['COLOR'], 10);
			$update = "UPDATE ".$table." SET color = '".$change."' WHERE num = '".$num."'";
			mysql_query($update) or die (mysql_error());
		}
	}
	elseif ($_GET['action'] == "BCOLOR")
	{
		if ($_GET['BCOLOR'] != "")
		{
			$num = substr($_GET['BCOLOR'], 14);
			$update = "UPDATE ".$table." SET backcolor = '".$change."' WHERE num = '".$num."'";
			mysql_query($update) or die (mysql_error());
		}
	}
	elseif ($_GET['action'] == "FCOLOR")
	{
		if ($_GET['FCOLOR'] != "")
		{
			$num = substr($_GET['FCOLOR'], 14);
			$update = "UPDATE ".$table." SET fontcolor = '".$change."' WHERE num = '".$num."'";
			mysql_query($update) or die (mysql_error());
		}
	}
	elseif ($_GET['action'] == "AVATAR")
	{
		if ($_GET['AVATAR'] != "")
		{
			$num = substr($_GET['AVATAR'], 11);
			$update = "UPDATE ".$table." SET avatar = '".$change."' WHERE num = '".$num."'";
			mysql_query($update) or die (mysql_error());
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