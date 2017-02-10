<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','person.rakeup');
cr_logic();

ui_sp('Переданные дела');
$uid=cr_userid();
$user_id=db_kv('db_users','id','realname');
$sql="SELECT * FROM `db_pipeline` WHERE `acceptor_id`='$uid' ORDER BY `id_pipeline` DESC";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sfs('','w100');
ui_rep_row();
    ui_rep_th('#');
    ui_rep_th('От');
    ui_rep_th('Дело');
    ui_rep_th('Просмотр');
    ui_rep_th('Дата');
ui_end_row();

while($l=  mysql_fetch_object($r))
{
    ui_rep_row();
    ui_rep_th($l->id_pipeline);
    ui_rep_td((isset($user_id[$l->sender_id]))?$user_id[$l->sender_id]:'');
    ui_rep_td($l->delo_name);
    ui_rep_td("<a href=\"view.php?id=$l->person_id\" target=\"_blank\">Просмотр</a>");
    ui_rep_td($l->ts);
    ui_end_row();
}
ui_efs();
ui_ep();