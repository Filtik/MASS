<html>

<?php

function list_array_display()
{
	
$category = "displayinsertdisplay";

echo '<script type="text/javascript">
function fillCategory(){';

$frag = mysql_query("SELECT * FROM modul");
	
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

function list_array_position()
{
include ('includes/modulesset.php');
	
$selectname = "displayinsertselect";
$firsttabel = "displayinsertdisplay";
$posiname = "displayinsertposition";

echo '<script type="text/javascript">
function array_position(){
removeAllOptions(document.drop_list.'.$posiname.')
removeAllOptions(document.drop_list.'.$selectname.')
addOption(document.drop_list.'.$selectname.', "", "Select a Position");;';

$frag = mysql_query("SELECT * FROM modul");

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

function list_array_select()
{
include ('includes/modulesset.php');
	
$selectname = "displayinsertselect";
$posiname = "displayinsertposition";

echo '<script type="text/javascript">
function array_select(){
removeAllOptions(document.drop_list.'.$selectname.');';

$frag = mysql_query("SELECT * FROM modul");

$row = mysql_fetch_object($frag);

$posimax = mysql_num_rows(mysql_query("SELECT * FROM displays ORDER BY position DESC"));
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