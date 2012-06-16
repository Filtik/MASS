<?php

$frag = mysql_query("SELECT * FROM config WHERE name = 'reload'");
$erg = mysql_fetch_object($frag);

echo '<meta http-equiv="refresh" content="'.$erg->params.';">';

?>