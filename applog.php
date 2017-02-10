<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','control.applog');
cr_logic();

ui_sp('Лог Приложения');
$user_id=db_kv('db_users','id','realname');
$sql="SELECT * FROM `db_applog` ORDER BY `id_applog` DESC LIMIT 20";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sfs('','w100');
$i=1;

while($l=  mysql_fetch_object($r))
{
    $rn=ui_sap($user_id,$l->user_id);
    ui_rep_row();
    ui_rep_th($i++);
    ui_rep_td($l->ts);
    ui_rep_td($rn);
    ui_rep_td("<a href=\"$l->uri\">$l->action_name</a>");
    ui_rep_td_r($l->ipaddr);
    ui_end_row();
}
ui_efs();
ui_ep();