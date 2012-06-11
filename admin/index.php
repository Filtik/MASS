<?php

session_start();

if($_SESSION['user'] == "") {
	header("location:login.php");
	die;
}

require ('../config/config.php');
require ('../set/functions.php');
include ('ddl-list.php');

echo '
<div align="center">
<p align="center"><b><u><font size="6">Interface Overlay<br>
Admin Security</font></u></b></p>
<hr>
<table border="1" width="95%">
	<tr>
		<td width="250" align="center" valign="top"><b><font size="5"><a href="?">Home</a></font></b><hr>
		<p><a href="?Set=Accounts">Accounts</a></p>
		<p><a href="?Set=General">General Settings</a></p>
		<p><a href="?Set=Modul">Modul Settings</a><br>
		<a href="?Set=Display">Display Settings</a></p>
		<p><a href="?Set=Group">Group Settings</a></p>
		<hr>
		<p><a href="logout.php">LOGOUT</a></td>
		<td align="center" valign="top">

';

$db = mysql_connect($tpotshost, $tpotsuser, $tpotspass);
mysql_select_db ($dbname);

?>

<html>
<script type="text/javascript">
function showonlyone(thechosenone) {
      var newboxes = document.getElementsByTagName("div");
            for(var x=0; x<newboxes.length; x++) {
                  name = newboxes[x].getAttribute("name");
                  if (name == 'newboxes') {
                        if (newboxes[x].id == thechosenone) {
                        newboxes[x].style.display = 'block';
                  }
                  else {
                        newboxes[x].style.display = 'none';
                  }
            }
      }
}
</script>
</html>

<?php

if ($_GET['Set'] == 'Accounts')
{
	
	echo '
<p align="center"><b><font size="7">Accounts</font></b></p>
<hr>
<div align="center">
<table border="1" width="95%">
	<tr>
		<td align="center" width="100">Account<br>
		No.</td>
		<td align="center" width="50%">Account</td>
		<td align="center" width="50%">Password</td>
	</tr>';
	
	sqlaccounts('accounts');
	
	echo '
			<tr><form method="POST" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=NEW&SAVE">
				<td align="center" width="50">new</td>
				<td align="center"><input type="text" name="AccNewName" size="20"></td>
				<td align="center">
				<table border="0" width="100%">
					<tr>
						<td width="100%"><input type="text" name="AccNewPW" size="20"></td>
						<td><p align="right"><input type="submit" value="New Account" name="newaccount"></td>
					</tr>
				</table>
				</td>
			</form></tr>
	</table>
</div>';
	
	if (isset($_GET['SAVE']))
	{
		$name = "";
		$pw = "";
		
		if ($_GET['action'] == "NEW")
		{
			$name = $_POST["AccNewName"];
			$pw = $_POST["AccNewPW"];
		}
		elseif ($_GET['action'] == "CHANGE")
		{
			if ($_GET['CHANGE'] != "")
			{
				$post = $_GET['CHANGE'];				
				$pw = $_POST[''.$post.''];
			}
		}
		
		accountset($name, $pw);
		echo '<meta http-equiv="refresh" content="0; URL=index.php?Set=Accounts">';
	}
}

?>

<?php

if ($_GET['Set'] == 'General')
{
	
	echo '
<p align="center">Database Connections</p>
<div align="center">
	<table border="1" width="90%">
		<tr>
			<td align="center" width="50%">MOUL<hr>
			<table border="1" width="100%">
				<tr>
					<td width="50%">Host: <font size="1">(Standard: localhost)</font></td>
					<td width="50%"><input type="text" name="moulhost" size="20" value="'.$moulhost.'"></td>
				</tr>
				<tr>
					<td width="50%">Port: <font size="1">(Standard: 5432)</font></td>
					<td width="50%">
					<!--webbot bot="Validation" s-data-type="Integer" s-number-separators="x" --><input type="text" name="moulport" size="20" value="'.$moulport.'"></td>
				</tr>
				<tr>
					<td width="50%">User:</td>
					<td width="50%"><input type="text" name="mouluser" size="20" value="'.$mouluser.'"></td>
				</tr>
				<tr>
					<td width="50%">Password:</td>
					<td width="50%"><input type="password" name="moulpass" size="20" value="'.$moulpass.'"></td>
				</tr>
				<tr>
					<td width="50%">Database Name:</td>
					<td width="50%"><input type="text" name="mouldb" size="20" value="'.$mouldb.'"></td>
				</tr>
			</table>
			</td>
			<td align="center" width="50%" valign="top">TPOTS<hr>
			<table border="1" width="100%">
				<tr>
					<td width="50%">Host: <font size="1">(Standard: localhost)</font></td>
					<td width="50%"><input type="text" name="tpotshost" size="20" value="'.$tpotshost.'"></td>
				</tr>
				<tr>
					<td width="50%">User:</td>
					<td width="50%"><input type="text" name="tpotsuser" size="20" value="'.$tpotsuser.'"></td>
				</tr>
				<tr>
					<td width="50%">Password:</td>
					<td width="50%"><input type="password" name="tpotspass" size="20" value="'.$tpotspass.'"></td>
				</tr>
				<tr>
					<td width="50%">Database Name: <font size="1">(VAULT)</font></td>
					<td width="50%"><input type="text" name="tpotsdb" size="20" value="'.$tpotsdb.'"></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td align="center" width="50%">MOUL-Server:
				<p><input type="radio" name="moulserver" value="1" '.moulserver(dirtsand).'>dirtsand
				<input type="radio" name="moulserver" value="2" '.moulserver(moss).'>moss</p>
			</td>
			<td align="center" width="50%">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" width="50%">&nbsp;</td>
			<td align="center" width="50%">&nbsp;</td>
		</tr>
	</table>
</div>';
	
}

?>

<?php

if ($_GET['Set'] == 'Modul')
{
	
	echo '
<p align="center"><u><b><font size="5">Modul Settings</font></b></u></p>
<hr>
<table border="1" width="100%">
	<tr>
		<td align="center" width="50%">
		MOUL</td>
		<td align="center" width="50%">
		TPOTS</td>
	</tr>
	<tr>
		<td align="center" width="50%">
		<table border="1" width="100%">';
		addmodul("moul");
		echo '
		</table>
		<p><a href="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=NEW&NEW=moul&SAVE"><input type="submit" value="New MOUL Modul" name="newmoulmodul"></a></td>
		<td align="center" width="50%">
		<table border="1" width="100%">';
		addmodul("tpots");
		echo '
		</table>
		<p><a href="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=NEW&NEW=tpots&SAVE"><input type="submit" value="New TPOTS Modul" name="newtpotsmodul"></a></td>
	</tr>
</table>
';

if (isset($_GET['SAVE']))
{
	$post = $_GET['RENAME'];
	$name = $_POST[''.$post.''];
	modulvar($name);
	echo '<meta http-equiv="refresh" content="0; URL=index.php?Set=Modul">';
}

}

?>

<?php

if ($_GET['Set'] == 'Display')
{
	
	echo '
	<div align="center">
	<table border="0" width="100%">
		<tr>
			<td align="center" width="50%"><a href="?Set=Display&Display=MOUL">MOUL<br>
			Displays</a></td>
			<td align="center" width="50%"><a href="?Set=Display&Display=TPOTS">TPOTS<br>
			Displays</a></td>
		</tr>
	</table>
	</div>
	<hr>
	';
	
	if ($_GET['Display'] == 'MOUL')
	{
	
		echo '
		
		<html>
	<body onload="fillCategory();">
		
<FORM name="drop_list" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&SAVE" method="POST" >
<p align="center"><u><font size="5"><b>Display Settings<br>
MOUL</font></b></u></p>
<hr>
<table border="1" width="100%">
	<tr>
		<td colspan="2" align="center" width="50%">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" width="50%">MOUL Display Setting<br>&nbsp;<table border="1" width="100%">
			<tr>
				<td width="25%">Display</td>
				<td width="25%">Position</td>
				<td>Select</td>
			</tr>
			<tr>
				<td width="25%">
					<select size="10" name="mouldisplayinsertdisplay" id="mouldisplayinsertdisplay" onChange="array_position();">'.list_array_display("displaymoul").'</select>
				</td>
				<td width="25%">
					<select size="10" name="mouldisplayinsertposition" onChange="array_select();">'.list_array_position("displaymoul").'<option value="">Select a Display</option></select>
				</td>
				<td>
					<select size="10" name="mouldisplayinsertselect">'.list_array_select("displaymoul").'<option value="">Select a Display</option></select>
				</td>
			</tr>
		</table>
			<p align="center"><input type="submit" value="Absenden" name="B1"></p>
		</td>
	</tr>
</table>
</form>

</body>
</html>
';

	if (isset($_GET["SAVE"]))
	{
		$display = $_POST["mouldisplayinsertdisplay"];
		$position = $_POST["mouldisplayinsertposition"];
		$select = $_POST["mouldisplayinsertselect"];
		
		DSEND($display, $position, $select);
		echo '<meta http-equiv="refresh" content="0; URL=index.php?Set=Display&Display=MOUL">';
	}
	
	}
##########
##########
	if ($_GET['Display'] == 'TPOTS')
	{
	
		echo '
		
	<body onload="fillCategory();">
		
<FORM name="drop_list" action="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&SAVE" method="POST">
<p align="center"><u><font size="5"><b>Display Settings<br>
TPOTS</font></b></u></p>
<hr>
<table border="1" width="100%">
	<tr>
		<td colspan="2" align="center" width="50%">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" width="50%">
		TPOTS Display Setting<br>
&nbsp;<table border="1" width="100%">
			<tr>
				<td width="25%">Display</td>
				<td width="25%">Position</td>
				<td>Select</td>
			</tr>
			<tr>
				<td width="25%">
					<select size="10" name="tpotsdisplayinsertdisplay" id="tpotsdisplayinsertdisplay" onChange="array_position();">'.list_array_display("displaytpots").'</select>
				</td>
				<td width="25%">
					<select size="10" name="tpotsdisplayinsertposition" onChange="array_select();">'.list_array_position("displaytpots").'<option value="">Select a Display</option></select>
				</td>
				<td>
					<select size="10" name="tpotsdisplayinsertselect">'.list_array_select("displaytpots").'<option value="">Select a Display</option></select>
				</td>
			</tr>
		</table>
			<p align="center"><input type="submit" value="Absenden" name="Submit"></p>
		</td>
	</tr>
</table>
</form>

</body>
		
		';
		
		
	if (isset($_GET["SAVE"]))
	{
		$display = $_POST["tpotsdisplayinsertdisplay"];
		$position = $_POST["tpotsdisplayinsertposition"];
		$select = $_POST["tpotsdisplayinsertselect"];
		
		DSEND($display, $position, $select);
		echo '<meta http-equiv="refresh" content="0; URL=index.php?Set=Display&Display=TPOTS">';
	}
	
	}
}

?>

<?php

if ($_GET['Set'] == 'Group')
{
	
	echo '
	<div align="center">
	<table border="0" width="100%">
		<tr>
			<td align="center" width="50%"><a href="?Set=Group&Group=MOUL">MOUL<br>
			Group</a></td>
			<td align="center" width="50%"><a href="?Set=Group&Group=TPOTS">TPOTS<br>
			Group</a></td>
		</tr>
	</table>
	</div>
	<hr>
	';
	
	
	if ($_GET['Group'] == 'MOUL')
	{
		echo '
				
<p align="center"><u><font size="5"><b>Group Settings<br>MOUL</font></b></u></p>
<hr>
<table border="1" width="100%">
	<tr>
		<td colspan="2" align="center" width="50%">Number of Groups<br>
		<input type="text" name="maxtpotsgroups" size="2" value="'.$moulgroups.'"></td>
	</tr>
	<tr>
		<td align="center" width="50%">MOUL Group Setting<br>&nbsp;<table border="1" width="100%">
			<tr>
				<td width="25%">Group No.</td>
				<td width="25%">Group Name:</td>
				<td width="25%">Group Color:</td>
				<td width="25%">Group Avatars:</td>
			</tr>';
			group_list("groupmoul");
		echo '
		</table>
		<p><a href="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=NEW&NEW=moul&SAVE"><input type="submit" value="New MOUL Group" name="newmoulgroup"></a></td>
		</td>
	</tr>
</table>

';

	if (isset($_GET['SAVE']))
	{
		if ($_GET['action'] == "RENAME")
		{
			if ($_GET['RENAME'] != "")
			{
				$num = substr($_GET['RENAME'], -1);
				print $num;
				$post = $_GET['RENAME'];
				$name = $_POST[''.$post.''];
			}
		}
		elseif ($_GET['action'] == "COLOR")
		{
			if ($_GET['COLOR'] != "")
			{
				$num = substr($_GET['COLOR'], -1);
				print $num;
				$post = $_GET['COLOR'];
				$name = $_POST[''.$post.''];
			}
		}
		elseif ($_GET['action'] == "AVATAR")
		{
			if ($_GET['AVATAR'] != "")
			{
				$num = substr($_GET['AVATAR'], -1);
				print $num;
				$post = $_GET['AVATAR'];
				$name = $_POST[''.$post.''];
			}
		}
		
		modulvar($name);
		echo '<meta http-equiv="refresh" content="0; URL=index.php?Set=Group&Group=MOUL">';
	}
	}
##########
##########
	if ($_GET['Group'] == 'TPOTS')
	{
		echo '
		
<p align="center"><u><font size="5"><b>Group Settings<br>TPOTS</font></b></u></p>
<hr>
<table border="1" width="100%">
	<tr>
		<td colspan="2" align="center" width="50%">Number of Groups<br></td>
	</tr>
	<tr>
		<td align="center" width="50%">TPOTS Group Setting<br>&nbsp;<table border="1" width="100%">
			<tr>
				<td width="25%">Group No.</td>
				<td width="25%">Group Name:</td>
				<td width="25%">Group Color:</td>
				<td width="25%">Group Avatars:</td>
			</tr>';
			group_list('grouptpots');
		echo '
		</table>
		<p><a href="'.$_SERVER['PATH_INFO'].'?'.$_SERVER["QUERY_STRING"].'&action=NEW&NEW=tpots&SAVE"><input type="submit" value="New TPOTS Group" name="newtpotsgroup"></a></td>
		</td>
	</tr>
</table>
		
		';
	
	if (isset($_GET['SAVE']))
	{
		if ($_GET['action'] == "RENAME")
		{
			if ($_GET['RENAME'] != "")
			{
				$num = substr($_GET['RENAME'], -1);
				print $num;
				$post = $_GET['RENAME'];
				$name = $_POST[''.$post.''];
			}
		}
		elseif ($_GET['action'] == "COLOR")
		{
			if ($_GET['COLOR'] != "")
			{
				$num = substr($_GET['COLOR'], -1);
				print $num;
				$post = $_GET['COLOR'];
				$name = $_POST[''.$post.''];
			}
		}
		elseif ($_GET['action'] == "AVATAR")
		{
			if ($_GET['AVATAR'] != "")
			{
				$num = substr($_GET['AVATAR'], -1);
				print $num;
				$post = $_GET['AVATAR'];
				$name = $_POST[''.$post.''];
			}
		}
		
		modulvar($name);
		echo '<meta http-equiv="refresh" content="0; URL=index.php?Set=Group&Group=TPOTS">';
	}
	}
}

?>

<?php

echo '</td>
	</tr>
</table>
</div>';


?>
