<?php

session_start();

require_once('../config/config.php');

$intest = "";

if(isset($_POST['submit']))
{
if(!$_POST['username'] || $_POST['username'] == "")
{
$intest = '<p align="center"><font color="#000000">Please enter a eMail-Address</font></p>';
}
elseif(!$_POST['password'] || $_POST['password'] == "")
{
$intest = '<p align="center"><font color="#000000">Please enter a Password</font></p>';
}
else
{
	$db = mysql_connect($tpotshost, $tpotsuser, $tpotspass);
	mysql_select_db ($dbname);

	$isuser = $_POST['username'];
	$ispass = $_POST['password'];
	$hash = sha1("$isuser$ispass");
	
	$query = mysql_query("SELECT * FROM accounts WHERE name = '".$_POST['username']."'");
	$result = mysql_fetch_array($query) or die($intest = '<p align="center">Sorry, the Account is not exist!<br /><a href="login.php">back</a></p>');
	
	if($hash != $result['password'])
	{
		$intest = '<p align="center"><font color="#000000">Sorry, the Password is fail!</font></p>';
	}
	else
	{
		$user = $_POST['username'];
		$_SESSION['user'] = $user;
		$_SESSION['style'] = $_POST['style'];
		echo '<meta http-equiv="refresh" content="1; URL=index.php">';
		$intest = '<p align="center"><font color="#000000">LogIn successfully! :-)</p>';
	}
}
}

echo'

<p align="center"><b><u><font size="6">Interface Overlay<br>
Admin Security</font></u></b></p>
<hr>
<p align="center">&nbsp;</p>


	<form action="'.$PHP_SELF.'" method="post"><br>
		<div align="center">
		<table border="0" cellpadding="2">

			<tr>
				<td width="180">User:</td>
				<td><input type="text" name="username" size="24" class="input"'; if($_POST['username'] != "" ) {echo ' value="'.$_POST['username'].'"';} echo'></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td height="0" valign="top"><input type="password" name="password" size="24" class="input"></td>
			</tr>
			<tr>
				<td colspan="2"><p align="center">'.$intest.'</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
				<table border="0" width="100%">
					<tr>
						<td width="50%" align="center">
						<p>
						<input type="submit" name="submit" value="Login" class="button"></td>
						<td width="50%" align="center"><p><a href="http://the-open-cave.net"><input type="button" name="quit" value="Quit" class="button"></a></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</div>
	</form>
';

?>
