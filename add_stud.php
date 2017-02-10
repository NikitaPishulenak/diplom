<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/libreport.php';

if( isset($_GET['id'])){
	if( isset($_GET['type']) && $_GET['type']=="add"){
	
	$sql = "SELECT  `target_type` ,  `target_cell` ,  `region_cell` ,  `edu_form` ,  `target`,`time_form_id` FROM  `db_person` WHERE  `id` =".$_GET['id'];
	$result= mysql_query($sql);
	while ($row = mysql_fetch_assoc($result)) {
		$line['target']=$row['target'];
		$line['target_type']=$row['target_type'];
		$line['target_cell']=$row['target_cell'];
		$line['region_cell']=$row['region_cell'];
		$line['edu_form']=$row['edu_form'];
		$line['time_form_id']=$row['time_form_id'];
	}
	echo "Zachislili";
	$sql= "update db_person set `out_time_form_id`=".$line['time_form_id'].",`out_target`=".$line['target'].", `out_edu_form`=".$line['edu_form'].", out_target_type=".$line['target_type'].",out_target_cell=".$line['target_cell'].",out_region_cell=".$line['region_cell'].",student_id=1 WHERE id=".$_GET['id'];
	mysql_query($sql);
	
	}

	if( isset($_GET['type']) && $_GET['type']=="kill"){
	
	$sql= "update db_person set `out_target`=0,`out_time_form_id`=0, `out_edu_form`=0, out_target_type=0,out_target_cell=0,out_region_cell=0,student_id=0 WHERE id=".$_GET['id'];
	mysql_query($sql);
	echo "Uze otchislili!?";
	
	}





} 




//$sql= "update db_person set out_time_form_id=1,out_edu_form=1,out_target=1,out_target_type=$l->target_type,out_target_cell=$l->target_cell,out_region_cell=$l->region_cell,student_id=1 WHERE id=$l->person_id";
//$sql = "SELECT `delo_name`,`target_type`,`id_ball_temp`,`total`,`target_cell`,`region_cell`,`person_id` FROM `db_ball_temp` WHERE `faculty`='$k' AND `time_form_id`=1 AND `edu_form`=1 AND `target`=1 AND// //`target_cell`='$kk' AND `region_cell`='$kkk' ORDER BY `total` DESC";