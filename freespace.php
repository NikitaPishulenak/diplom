<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';


cr_logic();


ui_sdlg('Места');

$qu_arr= db_kv('db_queue', 'id_queue', 'name');

$sql="SELECT queue_id,sum(`id_queue_list`) sum FROM `db_queue_list` WHERE `closed`=0 order by `queue_id`";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sfs('','w100');
while($l=  mysql_fetch_object($r))
{
    ui_rep_row();
    ui_rep_th(ui_sap($qu_arr,$l->queue_id));
    ui_rep_td($l->sum);
    ui_end_row();
}
ui_efs();
ui_edlg();