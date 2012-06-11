<html>

<?php

function list_array_display($arrayfrag)
{
	
if ($arrayfrag == "displaymoul")
{
	$array = 'moul';
	$category = "mouldisplayinsertdisplay";
}
elseif ($arrayfrag == "displaytpots")
{
	$array = 'tpots';
	$category = "tpotsdisplayinsertdisplay";
}

echo '<script type="text/javascript">
function fillCategory(){';

$frag = mysql_query("SELECT * FROM modul WHERE type = '".$array."'");
	
while($row = mysql_fetch_object($frag))
{
	$displayname = ''.$row->num.'';
	
	if ($row->name != '')
	{
		$displayname = ''.$row->num.' - '.$row->name.'';
	}
	$inhalt .= 'addOption(document.drop_list.'.$category.', '.$row->num.', "'.$displayname.'");' ;
}

echo ''.$inhalt.'}</script>';

}

###############

function list_array_position($arrayfrag)
{
include ('../config/globalsetting.php');
	
if ($arrayfrag == "displaymoul")
{
	$selectname = "mouldisplayinsertselect";
	$firsttabel = "mouldisplayinsertdisplay";
	$array = 'moul';
	$posiname = "mouldisplayinsertposition";
}
elseif ($arrayfrag == "displaytpots")
{
	$selectname = "tpotsdisplayinsertselect";
	$firsttabel = "tpotsdisplayinsertdisplay";
	$array = 'tpots';
	$posiname = "tpotsdisplayinsertposition";
}

echo '<script type="text/javascript">
function array_position(){
removeAllOptions(document.drop_list.'.$posiname.')
removeAllOptions(document.drop_list.'.$selectname.')
addOption(document.drop_list.'.$selectname.', "", "Select a Position");;';

$frag = mysql_query("SELECT * FROM modul WHERE type = '".$array."'");

while($row = mysql_fetch_object($frag))
{
	$inhalt .= 'if(document.drop_list.'.$firsttabel.'.value == "'.$row->num.'"){' ;
	
	$posimax = mysql_num_rows(mysql_query("SELECT * FROM displays WHERE display = '".$row->num."' ORDER BY position DESC"));
	$posimax ++;
	
	for($t=1; $t <= $posimax; $t++)
	{
		$posionis = mysql_fetch_object(mysql_query("SELECT * FROM displays WHERE display = '".$row->num."' AND position = ".$t.""));
		
		$getname = ''.$displayinsertnames[$posionis->sel].'';
		
		if ($getname == "") { $getname = "NOT SETTET"; }
		
		$inhalt .= 'addOption(document.drop_list.'.$posiname.', '.$t.', "'.$t.' - '.$getname.'");' ;
		
	}
	
	$inhalt .= '}';
}

echo ''.$inhalt.'}</script>';

}

##############

function list_array_select($arrayfrag)
{
include ('../config/globalsetting.php');
	
if ($arrayfrag == "displaymoul")
{
	$selectname = "mouldisplayinsertselect";
	$array = 'moul';
	$posiname = "mouldisplayinsertposition";
}
elseif ($arrayfrag == "displaytpots")
{
	$selectname = "tpotsdisplayinsertselect";
	$array = 'tpots';
	$posiname = "tpotsdisplayinsertposition";
}

echo '<script type="text/javascript">
function array_select(){
removeAllOptions(document.drop_list.'.$selectname.');';

$frag = mysql_query("SELECT * FROM modul WHERE type = '".$array."'");

$row = mysql_fetch_object($frag);

$posimax = mysql_num_rows(mysql_query("SELECT * FROM displays WHERE display = '".$row->num."'"));
$posimax ++;

for($x=1; $x <= $posimax; $x++)
{
	$inhalt .= 'if(document.drop_list.'.$posiname.'.value == "'.$x.'"){' ;
	
	for($t=1; $t <= count($displayinsertnames); $t++)
	{
		list($key, $val) = each($displayinsertnames);
		
		$inhalt .= 'addOption(document.drop_list.'.$selectname.', "'.$key.'", "'.$val.'");' ;
	}
	
	reset($displayinsertnames);
	
	$inhalt .= '}';

}

echo ''.$inhalt.'}</script>';

}

	
echo '
<script type="text/javascript">
function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
}


function addOption(selectbox, value, text )
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;
			
	selectbox.options.add(optn);

}

';


?>

</script>
</html>