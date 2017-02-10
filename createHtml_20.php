<?php
include 'config.php';
include 'core/db.php';
$sql="SELECT `date`,`time`,`fields`,`id` FROM `db_cron_config` ORDER BY date, time";
$res=mysql_query($sql);
$str="<!DOCTYPE html>
<HTML xmlns='http://www.w3.org/1999/xhtml'>
<HEAD>
<TITLE>Контрольные цифры</TITLE>
</HEAD>
<BODY>
<style>
table.plan{width:auto!important;margin-bottom:100px!important;}
table.plan th{ border:1px solid #aaa!important;}



</style><div class='cont'>";
 if(mysql_numrows($res)>=1){

	while($arr=mysql_fetch_row($res)){
		if($arr[0]==date("Y-m-d") && $arr[1]==date("H")){
			
			

			if($arr[2]=="budget"){
				echo date("Y-m-d:H")."  Start crone budget    ";
				$str.="<div class='budget' ><a href='#paid'>Платное</a><a name ='budget'></a><br><H1>Бюджет</h1>";
				$str.=file_get_contents('http://pktest.bsmu.by/discrete_echo.php?fc=1');
				$str.=file_get_contents('http://pktest.bsmu.by/discrete_echo.php?fc=2');
				$str.=file_get_contents('http://pktest.bsmu.by/discrete_echo.php?fc=3');
				$str.=file_get_contents('http://pktest.bsmu.by/discrete_echo.php?fc=4');
				$str.=file_get_contents('http://pktest.bsmu.by/discrete_echo.php?fc=5');
				$str.=file_get_contents('http://pktest.bsmu.by/discrete_echo.php?fc=6');
		
				$str.="</div><hr style='margin-top:100px;'><div class='paid' ><a href='#budget'>Бюджет</a><a name ='paid'></a><br><H1>Платное</h1>";
				$str.=file_get_contents('http://pktest.bsmu.by/discrete_echo.php?type=2');
				$str.="</div></div></BODY></HTML>";
				if(!is_dir("/var/www/html/statichtml_ts")) mkdir("/var/www/html/statichtml_ts", 0755);     
				$file="/var/www/html/statichtml_ts/budget_".date("m-d-y--H-i-s").".html";    
				$fp = fopen($file, 'w+');
				fwrite($fp, $str);
				fclose($fp); 
				if(!is_dir("/var/www/html/statichtml")) mkdir("/var/www/html/statichtml", 0755);
				$file="/var/www/html/statichtml/budget.html";    
				$fp = fopen($file, 'w+');
				fwrite($fp, $str);
				fclose($fp); 
				$typeb=$arr[2];
				$idb=$arr[3];

			}

			if($arr[2]=="paid"){
				echo date("Y-m-d:H")."  Start crone paid    ";
				$str.="<H1>Платное</h1>".file_get_contents('http://pktest.bsmu.by/discrete_echo.php?type=2');
				$str.="</BODY></HTML>";
				if(!is_dir("/var/www/html/statichtml_ts")) mkdir("/var/www/html/statichtml_ts", 0755);     
				$file="/var/www/html/statichtml_ts/budget_".date("m-d-y--H-i-s").".html";    
				$fp = fopen($file, 'w+');
				fwrite($fp, $str);
				fclose($fp); 
				if(!is_dir("/var/www/html/statichtml")) mkdir("/var/www/html/statichtml", 0755); 
				$file="/var/www/html/statichtml/paid.html";    
				$fp = fopen($file, 'w+');
				fwrite($fp, $str);
				fclose($fp); 
				$typep=$arr[2];
				$idp=$arr[3];

			}

		}
	}

}


if (isset($typep) && $typep=='paid'){
	$sqlb="UPDATE `db_cron_config` SET `status`='OK' WHERE `id`=".$idp;
	$res=mysql_query($sqlb); 
	
	$ftp_server="ftp.adella.neolocation.net"; 
	$ftp_user_name="bsmuby"; 
	$ftp_user_pass="FQF3wnB2tXwK"; 
	$source_file = '/var/www/html/statichtml/paid.html';
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


if (isset($typeb) && $typeb=='budget'){
	$sqlb="UPDATE `db_cron_config` SET `status`='OK' WHERE `id`=".$idb;
	$res=mysql_query($sqlb); 
	
	$ftp_server="ftp.adella.neolocation.net"; 
	$ftp_user_name="bsmuby"; 
	$ftp_user_pass="FQF3wnB2tXwK"; 
	$source_file = '/var/www/html/statichtml/budget.html';
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


