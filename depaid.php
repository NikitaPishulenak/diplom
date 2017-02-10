<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libtargethistory.php';

define('PAGE_SEC','index');
cr_logic();

set_time_limit(0);

if(!empty ($_POST))
{

    
    $sql="SELECT * FROM `db_person` WHERE `student_id`=0 AND `state_id`=1 AND `time_form_id`=1 AND `edu_form`=1 AND `dual_mode_set`=1";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $uid= cr_userid();
    while($l=mysql_fetch_object($r))
    {
        th_close($l->id, 2);
        $reg['faculty']         = $l->faculty;
        $reg['time_form_id']    = $l->time_form_id;
        $reg['edu_form']        = 2;
        $reg['target']          = 3;
        $reg['target_type']     = 0;
        $reg['target_cell']     = 0;
        $reg['region_cell']     = 0;
        $reg['total']           = $l->total;
        th_create($l->id, 2, $reg);
        $sql="UPDATE `db_person` set `edu_form`=2, target=3, target_type=0,target_cell=0,region_cell=0 where id=$l->id";
        $rr=mysql_query($sql) or debug($sql,  mysql_error());
    }
    ui_redirect('depaid.php');
}

ui_sp('Перевод с +В/Б.');
ui_sf();
ui_sfs();
ui_hidden('', '1', '0');
ui_sc('Перевести');
ui_efs();
ui_ef0();
ui_ep();