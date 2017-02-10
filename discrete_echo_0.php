<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/libreport.php';
include 'autofixation.php';
$dt = date('H:i');
$dd = date('d.m.Y');


//cr_logic();

$fc = isset($_GET['fc']) ? (int) $_GET['fc'] : 1;
$type = isset($_GET['type']) ? (int) $_GET['type'] : 1;

//-------------------------------------------------------------------------------------
mysql_select_db("afx");
$sql="SELECT `id_fixation` FROM `db_fixation` ORDER BY `id_fixation` DESC LIMIT 1";
$AUTOFIXATION = mysql_result(mysql_query($sql),0);
mysql_select_db("admx");

if ($type==3){
echo '<h2>Подготовительное отделение</h2>'. file_get_contents('http://pktest.bsmu.by/discrete.php?fc=7&raw=on');
$str="<table><tr><th>По собеседованию</th>";
//$sql="SELECT COUNT(  `total` ) FROM  `db_person` WHERE  `target` =7 AND  `faculty` =7";
$sql="SELECT COUNT(  `total` ) FROM  `db_person`;
$str.="<th>".mysql_result( mysql_query($sql),0)."</th></tr></table>";
$str.='<script type="text/javascript" src="http://www.bsmu.by/scripts/jquery.min.js"></script>';
$str.='<script type="text/javascript">$(document).ready(function(){$("p").remove();});
$(".rep_th").each(function(){
if($(this).html()=="Целевой"){$(this).css("display","none")};
if($(this).html()=="0"){$(this).css("display","none")};
});



</script>';

echo  $str;

}




