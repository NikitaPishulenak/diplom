<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','debug');
cr_logic();

ui_sp('Приёмная комиссия');


set_time_limit(0);

$sql="SELECT * FROM `db_person` where state_id=0";
$r=mysql_query($sql) or debug($sql,mysql_error());
ui_sfs('Запуленные');
while($l=mysql_fetch_object($r))
{
    ui_rep_row();
    ui_rep_th('#');
    ui_rep_td($l->delo_name);
    ui_rep_td($l->surname);
    ui_rep_td($l->faculty);
    ui_end_row();
}
ui_efs();
ui_ep();