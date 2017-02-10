<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','debug');
cr_logic();

ui_sp('о->од');


set_time_limit(0);


    $sql="Update db_person set `delo_name`=REPLACE(delo_name,'лод-','ло-')";
    $rr=mysql_query($sql) or debug($sql,mysql_error());

ui_efs();
ui_ep();