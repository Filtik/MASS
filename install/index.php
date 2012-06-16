<?php

echo '<p align="center"><u><font size="7">MASS<br>
Installation</font></u></p>
<hr>';

if ($_SERVER["QUERY_STRING"] == '')
{
	header('Location: ?State=CHECK&CHECK=1');
}
if ($_GET['State'] == 'CHECK')
{
	if ($_GET['CHECK'] == 1)
	{
		chdir('../config');
		$filename = ''.getcwd().'/config.php';
		if (file_exists($filename))
		{
			header('Location: ?State=ERROR&ERROR=1');
		}
		else
		{
			header('Location: ?State=1');
		}
	}
	elseif ($_GET['CHECK'] == 2)
	{
		chdir('../config');
		$filename = ''.getcwd().'/config.php';
		if (substr(sprintf('%o', fileperms(getcwd())), -3) == 777)
		{
			header('Location: ?State=2');
		}
		else
		{
			header('Location: ?State=ERROR&ERROR=2');
		}
	}
}
if ($_GET['State'] == 'ERROR')
{
	if ($_GET['ERROR'] == 1)
	{
		echo '
			<p align="center"><u><b><font style="font-size: 50pt" color="#FF0000">ERROR</font></b></u></p>
			<p align="center">A MASS installation is already in place. Delete the config.php in config folder.</p>
			';
	}
	elseif ($_GET['ERROR'] == 2)
	{
		echo '
			<p align="center"><u><b><font style="font-size: 50pt" color="#FF0000">ERROR</font></b></u></p>
			<p align="center">The "config" folder is not writable, please set it to chmod 777.</p>
			';
	}
}

if ($_GET['State'] == 1)
{
	echo '
		<p align="center">Welcome to Mass Installation</p>
		<p align="center">&nbsp;</p>
		<p align="center"><a href="?State=CHECK&CHECK=2"><input type="button" value="begin with the installation" name="begin"></a></p>
		';
}
elseif ($_GET['State'] == 2)
{
	echo '<p align="center">&nbsp;</p>
<table border="0" width="100%">
	<tr>
		<td width="25%" align="center" valign="top">&nbsp;</td>
		<td width="75%"><form method="POST" action="?State=3">
<div align="center">
	<table border="1" style="border-collapse: collapse">
		<tr>
			<td width="150">
			<p align="center"><u><b>MASS<br>
			(and Alcugs)</b></u></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Serveradress:<br>
			<input type="text" name="massalcugshost" size="20" value="localhost"></td>
		</tr>
		<tr>
			<td>User:<br>
			<input type="text" name="massalcugsuser" size="20"></td>
		</tr>
		<tr>
			<td>Password:<br>
			<input type="text" name="massalcugspassword" size="20"></td>
		</tr>
		<tr>
			<td><b>MASS</b> Database Name:<br>
			<input type="text" name="massdb" size="20"></td>
		</tr>
		<tr>
			<td><b>Alcugs</b> Database Name:<br>
			<input type="text" name="alcugsdb" size="20"></td>
		</tr>
	</table>
</div><hr width="200">
	<div align="center">
	<table border="1" style="border-collapse: collapse">
		<tr>
			<td width="150">
			<p align="center"><u><b>MOUL</b></u></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Serveradress:<br>
				<input type="text" name="moulhost" size="20" value="localhost"></td>
		</tr>
		<tr>
			<td>Port:<br>
			<input type="text" name="moulport" size="20" value="5432"></td>
		</tr>
		<tr>
			<td>User:<br>
			<input type="text" name="mouluser" size="20"></td>
		</tr>
		<tr>
			<td>Password:<br>
			<input type="text" name="moulpassword" size="20"></td>
		</tr>
		<tr>
			<td>Database Name:<br>
			<input type="text" name="mouldb" size="20"></td>
		</tr>
	</table>
	</div>
<p align="center"><input type="reset" value="Reset" name="Reset">
<input type="submit" value="Submit" name="Submit"></p>
</form>
</td>
	</tr>
</table>

';
}
elseif ($_GET['State'] == 3)
{
	echo '<p align="center">Information to be written!</p>';
	chdir('../config');
	$filename = ''.getcwd().'/config.php';
	if (file_exists($filename))
	{
		echo '<meta http-equiv="refresh" content="0; URL=?State=ERROR&ERROR=1">';
	}
	else
	{
		include 'include/ftext.php';
		$handle = @fopen($filename, "x+");
		if ($handle)
		{
			@fwrite ($handle, $ftext);
			@fclose ($handle);
			include 'include/sql.php';
		}
		else
		{
			header('Location: ?State=ERROR&ERROR=2');
		}
		
	}
	chmod($filename, 0777);
	echo '<meta http-equiv="refresh" content="0; URL=?State=4">';
}
elseif ($_GET['State'] == 4)
{
	echo '
	<p align="center">Information has been described.</p>
		<p align="center">Please delete the &quot;install&quot; folder to continue</p>
		<p align="center">&nbsp;</p>
		<p align="center"><a href="../">continue</a></p>';
}

?>