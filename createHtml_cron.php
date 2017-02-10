<?php
chdir(dirname(__FILE__));

include 'config.php';
include 'core/db.php';
include 'core/ui.php';

$isCron = isCron();

	if ($isCron) {
		include 'autofixation.php';
	if(!is_dir("/var/www/html/statichtml")) mkdir("/var/www/html/statichtml", 0755); 
		$file="/var/www/html/statichtml/".date("m-d-y-H-i-s").".html";
		$fp = fopen($file, 'w+');
		fwrite($fp, file_get_contents("http://pktest.bsmu.by/createHtml2.php?MODE=DISPLAY"));
		fclose($fp); 
		uploadToSite($file);
}



function isCron(){
$isCr = false;
$arr = Array();
mysql_select_db("admx");
$sql="SELECT `date`,`time`,`fields`,`id`,`status` FROM `db_cron_config` ORDER BY date, time";
$res=mysql_query($sql);
$r2 = $res;
 if(mysql_numrows($res)>=1)
	while($arr=mysql_fetch_row($r2))
		if($arr[0]==date("Y-m-d") && $arr[1]==date("H"))
{
			$isCr = true;
			$sqlb="UPDATE `db_cron_config` SET `status`='OK' WHERE `id`=".$arr[3];
			$res=mysql_query($sqlb);
}
return $isCr;
}

function uploadToSite($source_file)
{
	$ftp_server="ftt"; 
	$ftp_user_name="y"; 
	$ftp_user_pass="K"; 
//	$source_file = '/var/www/html/statichtml/ttt.html';
	$destination_file = '/htdocs/pk/index.html'; 
	$conn_id = ftp_connect($ftp_server); 
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
	if ((!$conn_id) || (!$login_result)) { 
        	echo "FTP connection has failed!";
	        echo "Attempted to connect to $ftp_server for user $ftp_user_name"; 
        	die; 
	} else {
        	echo "Connected to $ftp_server, for user $ftp_user_name";
	}
	ftp_pasv($conn_id, true);
	$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY); 
	if (!$upload) { 
        	echo "FTP upload has failed!";
	} else {
        	echo "Uploaded $source_file to $ftp_server as $destination_file";
	}
	ftp_close($conn_id);
	echo "Connection close"; 
}
?>