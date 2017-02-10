<?php







/*define('PAGE_SEC', 'report.discrete');*/


$sql="INSERT INTO `afx`.`db_fixation` VALUES (0,NOW(),NOW())";
$r=mysql_query($sql) or die(mysql_error());
$fixation_id=mysql_insert_id();

$sql="INSERT INTO `afx`.`db_fixed_target`
    (`faculty`,`time_form_id`,`edu_form`,`target`,`target_type`,`target_cell`,`region_cell`,`total`,`delo_name`,`person_id`,`fixation_id`,`state_id`)
    SELECT
    `faculty`,`time_form_id`,`edu_form`,`target`,`target_type`,`target_cell`,`region_cell`,`total`,`delo_name`,`id`,'$fixation_id',`state_id`
    FROM `db_person` WHERE `state_id`>0;
    ";

$r=mysql_query($sql) or debug($sql,  mysql_error());

