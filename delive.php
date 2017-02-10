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

$sql="SELECT * FROM `db_person`";
$r=mysql_query($sql) or debug($sql,mysql_error());
ui_sfs();
while($p=mysql_fetch_assoc($r))
{
    ui_rep_row();
    $live_addr=ui_addr_calc($p);
    ui_rep_td_l($live_addr);
    ui_end_row();
    $sql="Update db_person set `live_addr`='$live_addr' WHERE `id`=${p['id']}";
    $rr=mysql_query($sql) or debug($sql,mysql_error());
}
ui_efs();
ui_ep();
