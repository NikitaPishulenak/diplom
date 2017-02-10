<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/libreport.php';
include 'autofixation.php';
$dt = date('H:i');
$dd = date('d.m.Y');


//cr_logic();


//-------------------------------------------------------------------------------------
mysql_select_db("afx");
$sql="SELECT `id_fixation` FROM `db_fixation` ORDER BY `id_fixation` DESC LIMIT 1";
$AUTOFIXATION = mysql_result(mysql_query($sql),0);
$AUTOFIXATION=8;//////////////////////////////////////////РЈР‘Р РђРўР¬!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!





/******************************
Функция вывода из базы данных статистики


$afx-номер выборки
$faculty-факультет
$paid-выбор бюджет или платное(1)
$target-выбор целевое или нет(1)
$vnekonk-выбор вне конкурса(1) или нет
$ball-бал выборки


******************************/ 
$faculty=1;
$afx=8;
$ball=331;

function select_ball($afx,$faculty,$paid,$target,$vnekonk,$ball){
if (isset($paid) && $paid==1){}
if (isset($target) && $target==1){}
if (isset($vnekonk) && $vnekonk==1){}

$sql="SELECT COUNT(`total`) FROM `db_fixed_target` WHERE `fixation_id`=".$afx." AND `target`=3 AND `target_type`=1 AND `target_cell`=0  AND `faculty` =".$faculty." AND `total`=".$ball;
$resalt= mysql_result(mysql_query($sql),0);

return $resalt;
}
$d=0;
for($i=400;$i>1;$i--)
{
$d+=select_ball(8,1,0,0,0,$i);
}
echo $d."<br>";
?>