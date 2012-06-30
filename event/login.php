<?php
session_start();

function connectmoul()
{
	include '../config/config.php';
	$dbpg = pg_connect('host='.$moulhost.' port='.$moulport.' dbname='.$mouldb.' user='.$mouluser.' password='.$moulpassword.'');
}

connectmoul();

$passhash = '../set/compute_auth_hash';

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
	if (preg_match("/@/", $_POST['username']))
	{
		$isuser = $_POST['username'];
		$ispass = $_POST['password'];
		$hash = exec("$passhash $isuser $ispass");
	}
	else
	{
		$hash = sha1($_POST['password']);
	}
	
	$query = pg_query("SELECT * FROM accounts WHERE name = '".strtolower($_POST['username'])."'");
	$result = pg_fetch_array($query) or die($intest = '<p align="center">Sorry, the eMail-Address is not exist!<br /><a href="login.php">back</a></p>');
	
	$avafrag = pg_num_rows(pg_query("SELECT * FROM player WHERE creatoracctid = '".$result['id']."'"));
	
	if($hash != $result['hash'])
	{
		$intest = '<p align="center">Sorry, your password is wrong!</p>';
	}
	elseif ($result['banned'] == "t")
	{
		$intest = '<p align="center">Sorry, your Account is not Activatet or BANNED!<br /><br>Please notify a ADMIN or a MOD in the Forum</p>';
	}
	elseif ($avafrag == 0)
	{
		$intest = '<p align="center">Her Account, has no Avatars.<br /><br /><br /><b><font face="Felix Titling">ACCESS DENIED</font></p>';
	}
	else
	{
		$user = $result['name'];
		$_SESSION['eventuser'] = $user;
		echo '<meta http-equiv="refresh" content="1; URL=index.php">';
		$intest = '<p align="center">LogIn successfully! :-)</p>';
	}
}
}

echo'
	<body text="#FFFFFF" bgcolor="#000000">
	<form action="'.$PHP_SELF.'" method="post"><br>
		<div align="center">
		<u><b><font size="7">TOC-Event<br>
		</font><i><font size="7">Registration form</font></i></b></u><p>&nbsp;</p>
		<table border="0">
			<tr>
				<td>Name:</td>
				<td> <input type="text" name="username" size="24" class="input"'; if($_POST['username'] != "" ) {echo ' value="'.$_POST['username'].'"';} echo'></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td> <input type="password" name="password" size="24" class="input"></td>
			</tr>
			<tr>
				<td colspan="2">
				<table border="0" width="100%">
					<tr>
						<td width="50%" align="center"><p><input type="submit" name="submit" value="Login" class="button"></td>
						<td width="50%" align="center"><p><a href="http://the-open-cave.net"><input type="button" name="quit" value="Quit" class="button"></a></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</div>
	</form>
	<br><br><p align="center">'.$intest.'</p>
';

?>
