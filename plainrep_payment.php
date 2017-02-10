<?php

function get_content($host,$path,$port=80)
{
 $fp = fsockopen($host, $port, $errno, $errstr, 30); 
 if(!$fp) 
  { 
   echo "Error: $errstr ($errno)\n"; 
   return '';
  } 

 fputs($fp, "GET $path HTTP/1.0\r\n"); 
 fputs($fp, "Host: $host\r\n"); 
 //fputs($fp, "Referer: http://".$host."/\r\n"); 
 //fputs($fp, "User Agent: Mozilla/4.0 (compatible; MSIE 5.0; Windows 98; DigExt)\r\n"); 
 fputs($fp, "Connection: close\r\n\r\n"); 
 $buf=""; 
 while(!feof($fp)) 
  { 
     $buf.=fgets($fp, 4096); 
  } 
 fclose($fp); 
 return $buf; 
}

$fid= isset($_REQUEST['fid']) ? $_REQUEST['fid'] : 0;

$hour=Date("H");


if ($hour<12)
  $hour = 9;
  else if ($hour<15)
    $hour = 12;
    else if ($hour<18)
      $hour=15;
        else 
          $hour=18;

$day = Date("d");
$mon = Date("m");

//$day = 23;
//$mon = 7;
//$hour = 19;

$url = '/rep_payment.php?fid='.$fid.'&hour='.$hour.'&day='.$day.'&mon='.$mon;
//echo $url;
$content = get_content('/rep_payment.php?fid='.$fid.'&hour='.$hour.'&day='.$day.'&mon='.$mon);
preg_match('/<!-- START TABLE -->.*<!-- END TABLE -->/imsU',$content,$matches);

//$str='<TEXTAREA cols=20 rows=10>'.$content.'</TEXTAREA>';//matches[0];
$str=$matches[0];
?>
<style type="text/css">

th {
        font-size: 9pt;
	background-color:#f9fdfb;
	color:#444444;
  /*  border-top: 1px solid #aaaaaa;  */
  /*  border-left: 1px solid #aaaaaa; */
	border:0.5pt solid #aaaaaa;
}

 .stat {  
       font-size: 9pt;
       text-align: center;
    /*   border-top: 1px solid #aaaaaa; */
    /*   border-left: 1px solid #aaaaaa; */
	border: 0.5pt solid #aaaaaa;
       font-weight: normal;
}
.ender {
        border-bottom: 1px solid #aaaaaa;
}
table {
	border-collapse:collapse;
}

</style>
<!-- <h3><marquee style="color:red;height:20;width:500" scrollamount="500" scrolldelay="500">Приём документов начинается с 16 июля.</marquee></h3>-->
<!--<p style="font-size:14pt;color:red;font-weight:bold;">Абитуриенты, участвующие в конкурсе без испытаний, не делятся на городской и сельский конкурс, а отнимаются до подсчёта пропорции мест.</p>-->
<?php
/*
if($fid==1)
{
print '<p style="font-size:14pt;font-weight:bold;">По международному соглашению, для белорусов зарубежья выделено 1 место на лечебном факультете.</p>';
}
if($fid==3)
{
print '<p style="font-size:14pt;font-weight:bold;">По международному соглашению, для белорусов зарубежья выделено 1 место на педиатрическом факультете.</p>';
}
if($fid==4)
{
print '<p style="font-size:14pt;font-weight:bold;">По международному соглашению, для белорусов зарубежья выделено 1 место на стоматологическом факультете.</p>';
}*/ 

  echo($str);
?>