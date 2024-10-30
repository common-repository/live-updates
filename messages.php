<?php
/******************************************
Messages.php
Part of the Live Updates Plugin by Fov
Plugin version:1.0.0
File version: 1.01
******************************************/

//Dont forget to put the location of your config file
// This will probably be
// /home/USER/pubic_html/wp-config.php  - on a cPanel server or:
// /var/www/vhosts/DOMAIN.EXT/httpdocs/wp-config.php  - on a Plesk server

$config_loc ="CHANGE_ME";

//Thats all you need to edit





//DO NOT EDIT BELOW HERE!!!






header('Cache-Control: no-cache');
header('Pragma: no-cache');
header('Expires: ' . gmdate(DATE_RFC1123, time()-1));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
</head>
<body>

<?php

require_once $config_loc;

//db calls
$link = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME,$link);

//query message	
$res = @mysql_query("SELECT message FROM " . $table_prefix . "liveupdates ORDER BY id DESC LIMIT 1", $link);

//print it
while($row = mysql_fetch_array( $res)) {
	echo $row['message'];
	}
	
?>



</body>
</html>
